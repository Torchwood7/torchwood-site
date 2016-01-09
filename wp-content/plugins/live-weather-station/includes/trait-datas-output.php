<?php

/**
 * Outputing / shortcoding functionalities for Live Weather Station plugin
 *
 * @since      1.0.0
 * @package    Live_Weather_Station
 * @subpackage Live_Weather_Station/includes
 * @author     Pierre Lannoy <https://pierre.lannoy.fr/>
 */

require_once(LWS_INCLUDES_DIR.'trait-unit-description.php');
require_once(LWS_INCLUDES_DIR.'trait-type-description.php');
require_once(LWS_INCLUDES_DIR.'trait-datetime-conversion.php');
require_once(LWS_INCLUDES_DIR.'trait-unit-conversion.php');
require_once(LWS_INCLUDES_DIR.'trait-datas-query.php');

trait Datas_Output {
    
    use Unit_Description, Type_Description, Datetime_Conversion, Unit_Conversion, Datas_Query;

    private $unit_espace = '&nbsp;';

    /**
     * Get value for LCD panel shortcodes.
     *
     * @return  string  $attributes The value queryed by the shortcode.
     * @since    1.0.0
     * @access   public
     */
    public function lcd_shortcodes($attributes) {
        $_attributes = shortcode_atts( array('device_id' => '','module_id' => '','measure_type' => '','design' => '','size' => '','speed' => ''), $attributes );
        $fingerprint = uniqid('', true);
        $uniq = 'lcd'.substr ($fingerprint, count($fingerprint)-6, 80);
        $name = $this->get_station_name($_attributes['device_id']);
        $scalable='false';
        if ($_attributes['size'] == 'scalable') {
            $_attributes['size'] = 'small';
            $scalable='true';
        }
        if (is_array($name)) {
            return __(LWS_PLUGIN_NAME, 'live-weather-station').' - '.$name['condition']['message'];
        }
        $name = substr($name, 0, 20);
        wp_enqueue_script( 'lws-lcd.js' );
        $result  = '<div id="'.$uniq.'"></div>'.PHP_EOL;
        $result .= '<script language="javascript" type="text/javascript">'.PHP_EOL;
        $result .= '  jQuery(document).ready(function($) {'.PHP_EOL;
        $result .= '    var c'.$uniq.' = new lws_lcd.LCDPanel({'.PHP_EOL;
        $result .= '                    id              : "id'.$uniq.'",'.PHP_EOL;
        $result .= '                    parentId        : "'.$uniq.'",'.PHP_EOL;
        $result .= '                    upperCenterText : "'.$name.'",'.PHP_EOL;
        $result .= '                    qDevice         : "'.$_attributes['device_id'].'",'.PHP_EOL;
        $result .= '                    qModule         : "'.$_attributes['module_id'].'",'.PHP_EOL;
        $result .= '                    qMeasure        : "'.$_attributes['measure_type'].'",'.PHP_EOL;
        $result .= '                    design          : "'.$_attributes['design'].'",'.PHP_EOL;
        $result .= '                    size            : "'.$_attributes['size'].'",'.PHP_EOL;
        $result .= '                    scalable        : '.(string)$scalable.','.PHP_EOL;
        $result .= '                    cycleSpeed      : "'.$_attributes['speed'].'"'.PHP_EOL;
        $result .= '    });'.PHP_EOL;
        $result .= '  });'.PHP_EOL;
        $result .= '</script>'.PHP_EOL;
        return $result;
    }

    /**
     * Get value for textual shortcodes.
     *
     * @return  string  $attributes The value queryed by the shortcode.
     * @since    1.0.0
     * @access   public
     */
    public function textual_shortcodes($attributes) {
        $_attributes = shortcode_atts( array('device_id' => '','module_id' => '','measure_type' => '','element' => '','format' => ''), $attributes );
        $_result = $this->get_specific_datas($_attributes);
        $err = __('Malformed shortcode. Please verify it!', 'live-weather-station') ;
        if (empty($_result)) {
            return $err;
        }
        $tz = '';
        if (($_attributes['format'] == 'local-date') || ($_attributes['format'] == 'local-time')) {
            $_att = shortcode_atts( array('device_id' => '','module_id' => '','measure_type' => '','element' => '','format' => ''), $attributes );
            $_att['module_id'] = $_attributes['device_id'];
            $_att['measure_type'] = 'loc_timezone';
            $_att['element'] = 'measure_value';
            $tz = $this->get_specific_datas($_att)['result'][$_att['measure_type']];
        }
        $result = $_result['result'][$_attributes['measure_type']];
        $module_type = $_result['module_type'];
        switch ($_attributes['format']) {
            case 'raw':
                break;
            case 'type-formated':
                switch ($_attributes['element']) {
                    case 'module_type':
                        $result = $this->get_module_type($result);
                        break;
                    case 'measure_type':
                        $result = $this->get_measurement_type($result);
                        break;
                    default:
                        $result = $err ;
                }
                break;
            case 'local-date':
                try {
                    if ($_attributes['element'] == 'measure_timestamp') {
                        $result = $this->get_date_from_mysql_utc($result, $tz) ;
                    }
                    if ($_attributes['element'] == 'measure_value') {
                        $result = $this->get_date_from_utc($result, $tz) ;
                    }
                }
                catch(Exception $ex) {
                    $result = $err ;
                }
                break;
            case 'local-time':
                try {
                    if ($_attributes['element'] == 'measure_timestamp') {
                        $result = $this->get_time_from_mysql_utc($result, $tz) ;
                    }
                    if ($_attributes['element'] == 'measure_value') {
                        $result = $this->get_time_from_utc($result, $tz) ;
                    }
                }
                catch(Exception $ex) {
                    $result = $err ;
                }
                break;
            case 'local-diff':
                try {
                    if ($_attributes['element'] == 'measure_timestamp') {
                        $result = $this->get_time_diff_from_mysql_utc($result) ;
                    }
                    if ($_attributes['element'] == 'measure_value') {
                        $result = $this->get_time_diff_from_utc($result) ;
                    }
                }
                catch(Exception $ex) {
                    $result = $err ;
                }
                break;
            case 'plain-text':
                switch ($_attributes['measure_type']) {
                    case 'windangle':
                    case 'gustangle':
                    case 'windangle_max':
                    case 'windangle_day_max':
                    case 'windangle_hour_max':
                        $result = $this->get_angle_full_text($result);
                        break;
                    default:
                        $result = $this->output_value($result, $_attributes['measure_type'], false, true, $module_type);
                }
                break;
            case 'short-text':
                switch ($_attributes['measure_type']) {
                    case 'windangle':
                    case 'gustangle':
                    case 'windangle_max':
                    case 'windangle_day_max':
                    case 'windangle_hour_max':
                        $result = $this->get_angle_text($result);
                        break;
                    default:
                        $result = $err ;
                }
                break;
            case 'computed':
            case 'computed-unit':
                $test = '';
                switch ($_attributes['measure_type']) {
                    case 'dew_point':
                        if (!$this->is_valid_dew_point($_result['result']['temperature_ref'])) {
                            $test = __('N/A', 'live-weather-station') ;
                        }
                        break;
                    case 'frost_point':
                        if (!$this->is_valid_frost_point($_result['result']['temperature_ref'])) {
                            $test = __('N/A', 'live-weather-station') ;
                        }
                        break;
                    case 'heat_index':
                        if (!$this->is_valid_heat_index($_result['result']['temperature_ref'], $_result['result']['humidity_ref'], $_result['result']['dew_point'])) {
                            $test = __('N/A', 'live-weather-station') ;
                        }
                        break;
                    case 'humidex':
                        if (!$this->is_valid_humidex($_result['result']['temperature_ref'], $_result['result']['humidity_ref'], $_result['result']['dew_point'])) {
                            $test = __('N/A', 'live-weather-station') ;
                        }
                        break;
                    case 'wind_chill':
                        if (!$this->is_valid_wind_chill($_result['result']['temperature_ref'], $result)) {
                            $test = __('N/A', 'live-weather-station') ;
                        }
                        break;
                }
                if ($test == '') {
                    $unit = ($_attributes['format']=='computed-unit');
                    $result = $this->output_value( $result, $_attributes['measure_type'], $unit, false, $module_type);
                }
                else {
                    $result = $test;
                }
                if ($result == '') {
                    $result = $err ;
                }
                break;
            case 'computed-wgs84':
                $result = $this->output_coordinate( $result, $_attributes['measure_type'], 1);
                break;
            case 'computed-wgs84-unit':
                $result = $this->output_coordinate( $result, $_attributes['measure_type'], 2);
                break;
            case 'computed-dms':
                $result = $this->output_coordinate( $result, $_attributes['measure_type'], 3);
                break;
            case 'computed-dms-short':
                $result = $this->output_coordinate( $result, $_attributes['measure_type'], 6);
                break;
            case 'computed-dms-cardinal-start':
                $result = $this->output_coordinate( $result, $_attributes['measure_type'], 4);
                break;
            case 'computed-dms-cardinal-end':
                $result = $this->output_coordinate( $result, $_attributes['measure_type'], 5);
                break;
            default:
                $result = esc_html($result);
        }
        return $result;
    }

    /**
     * Output a value with user's unit.
     *
     * @param   mixed       $value          The value to output.
     * @param   string      $type           The type of the value.
     * @param   boolean     $unit           Optional. Display unit.
     * @param   boolean     $textual        Optional. Display textual value.
     * @param   string      $module_type    Optional. The type of the module.
     * @param   string      $tz             Optional. The timezone.
     * @return  string      The value outputed with the right unit.
     * @since    1.0.0
     * @access   protected
     */
    protected function output_value($value, $type, $unit=false , $textual=false, $module_type='NAMain', $tz='') {
        $result = $value;
        switch (strtolower($type)) {
            case 'battery':
                $result = $this->get_battery_percentage($value, $module_type);
                $result .= ($unit ? $this->unit_espace.$this->get_battery_unit() : '');
                if ($textual) {
                    $result = $this->get_battery_level_text($value, $module_type);
                }
                break;
            case 'signal':
                $result = $this->get_signal_percentage($value, $module_type);
                $result .= ($unit ? $this->unit_espace.$this->get_signal_unit() : '');
                if ($textual) {
                    $result = $this->get_signal_level_text($value, $module_type);
                }
                break;
            case 'co2':
                $result = $this->get_co2($value);
                $result .= ($unit ? $this->unit_espace.$this->get_co2_unit() : '');
                break;
            case 'humidity':
            case 'humidity_ref':
                $result = $this->get_humidity($value);
                $result .= ($unit ? $this->unit_espace.$this->get_humidity_unit() : '');
                break;
            case 'cloudiness':
                $result = $this->get_cloudiness($value);
                $result .= ($unit ? $this->unit_espace.$this->get_cloudiness_unit() : '');
                break;
            case 'noise':
                $result = $this->get_noise($value);
                $result .= ($unit ? $this->unit_espace.$this->get_noise_unit() : '');
                break;
            case 'rain':
            case 'rain_hour_aggregated':
            case 'rain_day_aggregated':
                $result = $this->get_rain($value);
                $result .= ($unit ? $this->unit_espace.$this->get_rain_unit() : '');
                break;
            case 'snow':
                $ref = 0;
                $result = $this->get_snow($value);
                $result .= ($unit ? $this->unit_espace.$this->get_snow_unit($ref) : '');
                break;
            case 'windangle':
            case 'gustangle':
            case 'windangle_max':
            case 'windangle_day_max':
            case 'windangle_hour_max':
                $result = $this->get_wind_angle($value);
                $result .= ($unit ? $this->unit_espace.$this->get_wind_angle_unit() : '');
                break;
            case 'windstrength':
            case 'guststrength':
            case 'windstrength_max':
            case 'windstrength_day_max':
            case 'windstrength_hour_max':
            case 'wind_ref':
                $ref = get_option('live_weather_station_settings')[2] ;
                $result = $this->get_wind_speed($value, $ref);
                $result .= ($unit ? $this->unit_espace.$this->get_wind_speed_unit($ref) : '');
                break;
            case 'pressure':
                $ref = get_option('live_weather_station_settings')[1] ;
                $result = $this->get_pressure($value, $ref);
                $result .= ($unit ? $this->unit_espace.$this->get_pressure_unit($ref) : '');
                break;
            case 'temperature':
            case 'temperature_min':
            case 'temperature_max':
            case 'temperature_ref':
            case 'dew_point':
            case 'frost_point':
                $ref = get_option('live_weather_station_settings')[0] ;
                $result = $this->get_temperature($value, $ref);
                $result .= ($unit ? $this->unit_espace.$this->get_temperature_unit($ref) : '');
                break;
            case 'heat_index':
            case 'humidex':
            case 'wind_chill':
                $ref = get_option('live_weather_station_settings')[0] ;
                $result = round($this->get_temperature($value, $ref));
                break;
            case 'loc_altitude':
            case 'cloud_ceiling':
                $ref = get_option('live_weather_station_settings')[4] ;
                $result = $this->get_altitude($value, $ref);
                $result .= ($unit ? $this->unit_espace.$this->get_altitude_unit($ref) : '');
                break;
            case 'temperature_trend':
            case 'pressure_trend':
                $result = $value;
                if ($textual) {
                    $result = $this->get_trend_text($value);
                }
                break;
            case 'sunrise':
            case 'sunset':
                $result = $value;
                if ($unit) {
                    $result = $this->get_rise_set_short_from_utc($value, $tz);
                }
                if ($textual) {
                    $result = $this->get_rise_set_long_from_utc($value, $tz);
                }
                break;
            case 'moonrise':
            case 'moonset':
                $result = $value;
                if ($unit) {
                    $result = $this->get_rise_set_short_from_utc($value, $tz, true);
                }
                if ($textual) {
                    $result = $this->get_rise_set_long_from_utc($value, $tz);
                }
                break;
            case 'moon_illumination':
                $result = $this->get_moon_illumination($value);
                $result .= ($unit ? $this->unit_espace.$this->get_moon_illumination_unit() : '');
                break;
            case 'moon_diameter':
            case 'sun_diameter':
                $result = $this->get_degree_diameter($value);
                $result .= ($unit ? $this->unit_espace.$this->get_degree_diameter_unit() : '');
                break;
            case 'moon_distance':
            case 'sun_distance':
                $ref = get_option('live_weather_station_settings')[5] ;
                $result = $this->get_distance_from_kilometers($value, $ref);
                $result .= ($unit ? $this->unit_espace.$this->get_distance_unit($ref) : '');
                break;
            case 'moon_phase':
                $result = $value;
                if ($unit || $textual) {
                    $result = $this->get_moon_phase_text($value);
                }
                break;
            case 'moon_age':
                $result = $value;
                if ($unit || $textual) {
                    $result = $this->get_age_from_days($value);
                }
                break;
            case 'loc_timezone':
            case 'timezone':
                $result = $value;
                if ($unit || $textual) {
                    $result = $this->output_timezone($value);
                }
                break;
        }
        return $result;
    }

    /**
     * Output a latitude or longitude with user's unit.
     *
     * @param   mixed       $value          The value to output.
     * @param   string      $type           The type of the value.
     * @param   integer     $mode           Optional. The mode in wich to output:
     *                                          1: Geodetic system WGS 84
     *                                          2: Geodetic system WGS 84 with unit
     *                                          3: DMS
     *                                          4: DMS starting with cardinal
     *                                          5: DMS ending with cardinal
     * @return  string      The value outputed with the right unit.
     * @since    1.1.0
     * @access   protected
     */
    protected function output_coordinate($value, $type, $mode=0) {
        switch ($mode) {
            case 1:
                $result = $value;
                break;
            case 2:
                $result = $value.'°';
                break;
            case 3:
            case 4:
            case 5:
            case 6:
                $abs = abs($value);
                $floor = floor($abs);
                $deg = (integer)$floor;
                $min = (integer)floor(($abs-$deg)*60);
                $min_alt = round(($abs-$deg)*60, 1);
                $sec = round(($abs-$deg-($min/60))*3600,1);
                $result = $deg.'° '.$min.'\' '.$sec.'"';
                $result_alt = $deg.'° '.$min_alt.'\' ';
                $fix = ($value >= 0 ? '' : '-') ;
                if ($type=='loc_longitude' && $mode != 3) {
                    if ($fix == '') {
                        $fix = $this->get_angle_text(90) ;
                    }
                    else {
                        $fix = $this->get_angle_text(270) ;
                    }
                }
                if ($type=='loc_latitude' && $mode != 3) {
                    if ($fix == '') {
                        $fix = $this->get_angle_text(0) ;
                    }
                    else {
                        $fix = $this->get_angle_text(180) ;
                    }
                }
                if ($mode == 3) {
                    $result = $fix.$result;
                }
                if ($mode == 4) {
                    $result = $fix.' '.$result;
                }
                if ($mode == 5) {
                    $result = $result.' '.$fix;
                }
                if ($mode == 6) {
                    $result = $result_alt.' '.$fix;
                }
                break;
            default:
                $result = $value;
        }
        return $result;
    }

    /**
     * Indicates if alarm is on.
     *
     * @param   mixed       $value          The value to test.
     * @param   string      $type           The type of the value.
     * @return  boolean     True if alarm is on, false otherwise.
     * @since    1.0.0
     * @access   protected
     */
    protected function is_alarm_on($value, $type) {
        $result = false;
        switch (strtolower($type)) {
            case 'co2':
                $result = ($value > 1000);
                break;
            case 'humidity':
                $result = ($value > 75);
                if (!$result) {
                    $result = ($value < 25);
                }
                break;
            case 'noise':
                $result = ($value > 55);
                break;
            case 'rain':
                $result = ($value > 2);
                break;
            case 'rain_hour_aggregated':
                $result = ($value > 5);
                break;
            case 'rain_day_aggregated':
                $result = ($value > 10);
                break;
            case 'windstrength':
            case 'guststrength':
            case 'windstrength_max':
                $result = ($value > 70);
                break;
            /*case 'pressure':
                $result = ($value > 75);
                if (!$result) {
                    $result = ($value < 25);
                }
            break;*/
            case 'temperature':
                $result = ($value > 40);
                if (!$result) {
                    $result = ($value < 0);
                }
            case 'heat_index':
                $result = ($value > 39);
                break;
            case 'humidex':
                $result = ($value > 44);
                break;
        }
        return $result;
    }

    /**
     * Outputs the right unit.
     *
     * @param   string  $type   The type of the value.
     * @param   integer $force_ref  Optional. Forces the ref unit.
     * @return  array   The value of the right unit and its complement.
     * @since    1.0.0
     * @access   protected
     */
    protected function output_unit($type, $force_ref=0) {
        $result = array('unit'=>'', 'comp'=>'');
        switch ($type) {
            case 'loc_altitude':
            case 'cloud_ceiling':
                $ref = get_option('live_weather_station_settings')[4] ;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_altitude_unit($ref) ;
                break;
            case 'battery':
                $ref = 0;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_battery_unit($ref) ;
                break;
            case 'signal':
                $ref = 0;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_signal_unit($ref) ;
                break;
            case 'co2':
                $ref = 0;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_co2_unit($ref) ;
                break;
            case 'humidity':
            case 'humidity_ref':
            $ref = 0;
            if ($force_ref != 0) {
                $ref = $force_ref;
            }
                $result['unit'] = $this->get_humidity_unit($ref) ;
                break;
            case 'cloudiness':
                $ref = 0;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_cloudiness_unit($ref) ;
                break;
            case 'noise':
                $ref = 0;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_noise_unit($ref) ;
                break;
            case 'rain':
                $ref = 0;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_rain_unit($ref) ;
                break;
            case 'snow':
                $ref = 0;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_snow_unit($ref) ;
                break;
            case 'rain_hour_aggregated':
                $result['comp'] = __('lst hr', 'live-weather-station') ;
                $result['unit'] = $this->get_rain_unit() ;
                break;
            case 'rain_day_aggregated':
                $result['comp'] = __('today', 'live-weather-station') ;
                $result['unit'] = $this->get_rain_unit() ;
                break;
            case 'windangle':
            case 'windangle_max':
            case 'windangle_day_max':
            case 'windangle_hour_max':
                $ref = 0;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_wind_angle_unit($ref);
                break;
            case 'gustangle':
                $result['comp'] = __('gust', 'live-weather-station') ;
                $result['unit'] = $this->get_wind_angle_unit();
                break;
            case 'windstrength':
            case 'windstrength_max':
            case 'windstrength_day_max':
            case 'windstrength_hour_max':
                $ref = get_option('live_weather_station_settings')[2] ;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_wind_speed_unit($ref);
                break;
            case 'guststrength':
                $result['comp'] = __('gust', 'live-weather-station') ;
                $ref = get_option('live_weather_station_settings')[2] ;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_wind_speed_unit($ref);
                break;
            case 'pressure':
                $ref = get_option('live_weather_station_settings')[1] ;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_pressure_unit($ref);
                break;
            case 'temperature':
            case 'temperature_min':
            case 'temperature_max':
            case 'temperature_ref':
            case 'dew_point':
            case 'frost_point':
            case 'wind_chill':
                $ref = get_option('live_weather_station_settings')[0] ;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_temperature_unit($ref);
                break;
            case 'moon_illumination':
                $ref = 0;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_moon_illumination_unit($ref);
                break;
            case 'moon_diameter':
            case 'sun_diameter':
                $ref = 0;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_degree_diameter_unit($ref);
                break;
            case 'moon_distance':
            case 'sun_distance':
                $ref = get_option('live_weather_station_settings')[5] ;
                if ($force_ref != 0) {
                    $ref = $force_ref;
                }
                $result['unit'] = $this->get_distance_unit($ref);
                break;
        }
        return $result;
    }

    /**
     * Get a human readable time zone.
     *
     * @param   string  $timezone  Standardized timezone string
     * @return  array  A human readable time zone.
     * @since    2.0.0
     */
    private function output_timezone($timezone) {
        $result = str_replace('/', ' / ', $timezone);
        $result = str_replace('_', ' ', $result);
        $result = str_replace('DU', ' d\'U', $result);
        return $result;
    }

    /**
     * Outputs the abbreviation of a measure type.
     *
     * @param   string  $type   The type of the value.
     * @return  string   The value of the abreviation.
     * @since    1.0.0
     * @access   protected
     */
    protected function output_abbreviation($type) {
        $result = '';
        switch ($type) {
            case 'co2':
                $result = __('co2', 'live-weather-station') ;
                break;
            case 'humidity':
                $result = __('humidity', 'live-weather-station') ;
                break;
            case 'noise':
                $result = __('noise', 'live-weather-station') ;
                break;
            case 'rain':
            case 'rain_hour_aggregated':
            case 'rain_day_aggregated':
                $result = __('rain', 'live-weather-station') ;
                break;
            case 'snow':
                $result = __('snow', 'live-weather-station') ;
                break;
            case 'windangle':
            case 'windangle_max':
            case 'gustangle':
            case 'windstrength':
            case 'windstrength_max':
            case 'guststrength':
                $result = __('wind', 'live-weather-station') ;
                break;
            case 'pressure':
                $result = __('atm pressure', 'live-weather-station') ;
                break;
            case 'dew_point':
                $result = __('dew point', 'live-weather-station') ;
                break;
            case 'frost_point':
                $result = __('frost point', 'live-weather-station') ;
                break;
            case 'heat_index':
                $result = __('heat-index', 'live-weather-station') ;
                break;
            case 'humidex':
                $result = __('humidex', 'live-weather-station') ;
                break;
            case 'wind_chill':
                $result = __('wind chill', 'live-weather-station') ;
                break;
            case 'cloud_ceiling':
                $result = __('cloud base', 'live-weather-station') ;
                break;
            case 'cloudiness':
                $result = __('cloudiness', 'live-weather-station') ;
                break;
            case 'temperature':
            case 'temperature_min':
            case 'temperature_max':
            $result = __('temperature', 'live-weather-station') ;
            break;
        }
        return $result;
    }

    /**
     * Get the full country name of an ISO-2 country code.
     *
     * @param   string   $value    The ISO-2 country code.
     * @return  string  The full country name.
     * @since    2.0.0
     */
    protected function get_country_name($value) {
        return Locale::getDisplayRegion('-'.$value, get_locale());
    }

    /**
     * Get an array containing country names associated with their ISO-2 codes.
     *
     * @return  array  An associative array with names and codes.
     * @since    2.0.0
     */
    protected function get_country_names() {

        function compareASCII($a, $b) {
            $at = iconv('UTF-8', 'ASCII//TRANSLIT', $a);
            $bt = iconv('UTF-8', 'ASCII//TRANSLIT', $b);
            return strcmp(strtoupper($at), strtoupper($bt));
        }

        $result = [];
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $continue = array('BU', 'DY', 'EU', 'HV', 'FX', 'NH', 'QO', 'RH', 'TP', 'YU', 'ZR', 'ZZ');
        $locale = get_locale();
        for ($i=0; $i<26; $i++) {
            for ($j=0; $j<26; $j++) {
                $s = $letters[$i].$letters[$j];
                if (in_array($s, $continue)) {
                    continue;
                }
                $t = Locale::getDisplayRegion('-'.$s, $locale);
                if ($s != $t) {
                    $result[$s] = ucfirst($t);
                }
            }
        }
        $save_locale = setlocale(LC_ALL,'');
        setlocale(LC_ALL, $locale);
        uasort($result, 'compareASCII');
        setlocale(LC_ALL, $save_locale);
        return $result;
    }

    /**
     * Get the battery level in human readable text.
     *
     * @param   integer   $value    The value of the battery.
     * @param   string  $type   The type of the module.
     * @return  string  The battery level in human readable text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_battery_level_text($value, $type) {
        $level = $this->get_battery_level($value, $type);
        switch ($level) {
            case 4:
                $result = __('Very low', 'live-weather-station') ;
                break;
            case 3:
                $result = __('Low', 'live-weather-station') ;
                break;
            case 2:
                $result = __('Medium', 'live-weather-station') ;
                break;
            case 1:
                $result = __('High', 'live-weather-station') ;
                break;
            case 0:
                $result = __('Full', 'live-weather-station') ;
                break;
            case -1:
                $result = __('AC Power', 'live-weather-station') ;
                break;
            default:
                $result = __('Unknown Power State', 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get the wind angle in readable text (i.e. N-NW, S, ...).
     *
     * @deprecated 1.1.0 Angle "translation" is not specific to wind.
     * @see get_angle_text
     *
     * @param   integer   $value    The value of the angle.
     * @return  string  The wind angle in readable text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_windangle_text($value) {
        if ($value < 0) {
            $value = $value + 360;
        }
        $val = round(($value / 22.5) + 0.5);
        $dir = array();
        $dir[] = __('N', 'live-weather-station') ;
        $dir[] = __('N-NE', 'live-weather-station') ;
        $dir[] = __('NE', 'live-weather-station') ; 
        $dir[] = __('E-NE', 'live-weather-station') ;
        $dir[] = __('E', 'live-weather-station') ; 
        $dir[] = __('E-SE', 'live-weather-station') ;
        $dir[] = __('SE', 'live-weather-station') ; 
        $dir[] = __('S-SE', 'live-weather-station') ;
        $dir[] = __('S', 'live-weather-station') ; 
        $dir[] = __('S-SW', 'live-weather-station') ;
        $dir[] = __('SW', 'live-weather-station') ; 
        $dir[] = __('W-SW', 'live-weather-station') ;
        $dir[] = __('W', 'live-weather-station') ; 
        $dir[] = __('W-NW', 'live-weather-station') ;
        $dir[] = __('NW', 'live-weather-station') ; 
        $dir[] = __('N-NW', 'live-weather-station') ;
        return $dir[$val % 16];
    }

    /**
     * Get an angle in readable text (i.e. N-NW, S, ...).
     *
     * @param   integer   $value    The value of the angle.
     * @return  string  The wind angle in readable text.
     * @since    1.1.0
     * @access   protected
     */
    protected function get_angle_text($value) {
        $val = round((($value%360) / 22.5) + 0.4);
        $dir = array();
        $dir[] = __('N', 'live-weather-station') ;
        $dir[] = __('N-NE', 'live-weather-station') ;
        $dir[] = __('NE', 'live-weather-station') ;
        $dir[] = __('E-NE', 'live-weather-station') ;
        $dir[] = __('E', 'live-weather-station') ;
        $dir[] = __('E-SE', 'live-weather-station') ;
        $dir[] = __('SE', 'live-weather-station') ;
        $dir[] = __('S-SE', 'live-weather-station') ;
        $dir[] = __('S', 'live-weather-station') ;
        $dir[] = __('S-SW', 'live-weather-station') ;
        $dir[] = __('SW', 'live-weather-station') ;
        $dir[] = __('W-SW', 'live-weather-station') ;
        $dir[] = __('W', 'live-weather-station') ;
        $dir[] = __('W-NW', 'live-weather-station') ;
        $dir[] = __('NW', 'live-weather-station') ;
        $dir[] = __('N-NW', 'live-weather-station') ;
        $dir[] = __('N', 'live-weather-station') ;
        return $dir[$val];
    }

    /**
     * Get an angle in readable full text (i.e. North-Northwest, South, ...).
     *
     * @param   integer   $value    The value of the angle.
     * @return  string  The wind angle in readable text.
     * @since    1.2.2
     * @access   protected
     */
    protected function get_angle_full_text($value) {
        $val = round((($value%360) / 22.5) + 0.4);
        $dir = array();
        $dir[] = __('North', 'live-weather-station') ;
        $dir[] = __('North-Northeast', 'live-weather-station') ;
        $dir[] = __('Northeast', 'live-weather-station') ;
        $dir[] = __('East-Northeast', 'live-weather-station') ;
        $dir[] = __('East', 'live-weather-station') ;
        $dir[] = __('East-Southeast', 'live-weather-station') ;
        $dir[] = __('Southeast', 'live-weather-station') ;
        $dir[] = __('South-Southeast', 'live-weather-station') ;
        $dir[] = __('South', 'live-weather-station') ;
        $dir[] = __('South-Southwest', 'live-weather-station') ;
        $dir[] = __('Southwest', 'live-weather-station') ;
        $dir[] = __('West-Southwest', 'live-weather-station') ;
        $dir[] = __('West', 'live-weather-station') ;
        $dir[] = __('West-Northwest', 'live-weather-station') ;
        $dir[] = __('Northwest', 'live-weather-station') ;
        $dir[] = __('North-Northwest', 'live-weather-station') ;
        $dir[] = __('North', 'live-weather-station') ;
        return $dir[$val];
    }

    /**
     * Get the battery level in lcd readable type.
     *
     * @param   integer   $value    The value of the battery.
     * @param   string  $type   The type of the module.
     * @return  string  The battery level in lcd readable text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_battery_lcd_level_text($value, $type) {
        if ($value == -1) {
            return 'full';
        }
        $pct = $this->get_battery_percentage($value, $type);
        $result = 'full';
        if ($pct < 70) {
            $result = 'twothirds';
        }
        if ($pct < 40) {
            $result = 'onethird';
        }
        if ($pct < 10) {
            $result = 'empty';
        }
        return $result;
    }

    /**
     * Get the signal level in human readable text.
     *
     * @param   integer $value  The value of the battery.
     * @param   string  $type   The type of the module.
     * @return  string  The signal level in human readable text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_signal_level_text($value, $type) {
        if ($type =='NAMain') {
            $result = $this->get_wifi_level_text($value);
        }
        else {
            $result = $this->get_rf_level_text($value) ;
        }
        return $result;
    }
    
    /**
     * Get the RF level in human readable text.
     *
     * @param   integer $value  The value of the RF.
     * @return  string  The RF level in human readable text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_rf_level_text($value) {
        $level = $this->get_rf_level($value);
        switch ($level) {
            case 3:
                $result = __('Full', 'live-weather-station') ;
                break;
            case 2:
                $result = __('High', 'live-weather-station') ;
                break;
            case 1:
                $result = __('Medium', 'live-weather-station') ;
                break;
            case 0:
                $result = __('Very low', 'live-weather-station') ;
                break;
            default:
                $result = __('No RF Signal', 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get the signal level in lcd readable type.
     *
     * @param   integer   $value    The value of the signal.
     * @param   string  $type   The type of the module.
     * @return  float  The signal level in lcd readable value.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_signal_lcd_level_text($value, $type) {
        if ($value == -1) {
            return 0;
        }
        $pct = $this->get_signal_percentage($value, $type);
        $result = ((float)$pct)/100;
        return $result;
    }

    /**
     * Get the wifi level in human readable text.
     *
     * @param   integer $value  The value of the wifi.
     * @return  string   The wifi level in human readable text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_wifi_level_text($value) {
        $level = $this->get_wifi_level($value);
        switch ($level) {
            case 2:
                $result = __('High', 'live-weather-station') ;
                break;
            case 1:
                $result = __('Medium', 'live-weather-station') ;
                break;
            case 0:
                $result = __('Very low', 'live-weather-station') ;
                break;
            default:
                $result = __('No WiFi Signal', 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get the trend in human readable text.
     *
     * @param   integer $value  The value of the trend.
     * @return  string   The trend level in human readable text.
     * @since    1.1.0
     * @access   protected
     */
    protected function get_trend_text($value) {
        switch (strtolower($value)) {
            case 'up':
                $result = __('Rising', 'live-weather-station') ;
                break;
            case 'down':
                $result = __('Falling', 'live-weather-station') ;
                break;
            default:
                $result = __('Stable', 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get the moon phase in human readable text.
     *
     * @param   integer $value  The decimal value of the moon phase.
     * @return  string   The moon phase in human readable text.
     * @since    2.0.0
     */
    protected function get_moon_phase_text($value) {
        $names = array( __('New Moon', 'live-weather-station'),
                        __('Waxing Crescent', 'live-weather-station'),
                        __('First Quarter', 'live-weather-station'),
                        __('Waxing Gibbous', 'live-weather-station'),
                        __('Full Moon', 'live-weather-station'),
                        __('Waning Gibbous', 'live-weather-station'),
                        __('Third Quarter', 'live-weather-station'),
                        __('Waning Crescent', 'live-weather-station'),
                        __('New Moon', 'live-weather-station'));
        return $names[(int)floor(($value + 0.0625) * 8)];
    }

    /**
     * Get the icon moon phase id.
     *
     * @param   integer $value  The decimal value of the moon phase.
     * @return  string   The moon phase in human readable text.
     * @since    2.0.0
     */
    protected function get_moon_phase_icon($value) {
        $id = array('new',
                    'waxing-crescent-1',
                    'waxing-crescent-2',
                    'waxing-crescent-3',
                    'waxing-crescent-4',
                    'waxing-crescent-5',
                    'waxing-crescent-6',
                    'first-quarter',
                    'waxing-gibbous-1',
                    'waxing-gibbous-2',
                    'waxing-gibbous-3',
                    'waxing-gibbous-4',
                    'waxing-gibbous-5',
                    'waxing-gibbous-6',
                    'full',
                    'waning-gibbous-1',
                    'waning-gibbous-2',
                    'waning-gibbous-3',
                    'waning-gibbous-4',
                    'waning-gibbous-5',
                    'waning-gibbous-6',
                    'third-quarter',
                    'waning-crescent-1',
                    'waning-crescent-2',
                    'waning-crescent-3',
                    'waning-crescent-4',
                    'waning-crescent-5',
                    'waning-crescent-6',
                    'new');
        return $id[(int)floor(($value + 0.01786) * 28)];
    }

    /**
     * Format the selected datas for widget usage.
     *
     * @param   array   $datas  An array containing the selected datas.
     * @return  array   An array containing the formated datas, ready to be read by widgets.
     * @since    1.0.0
     * @access   protected
     */
    protected function format_widget_datas($datas) {
        $result = array();
        $err = 0 ;
        $ts = 0;
        $msg = __('Successful operation', 'live-weather-station');
        if (count($datas)==0) {
            $err = 3 ;
            $msg = __('Database contains inconsistent datas', 'live-weather-station');
        }
        else {
            $result['name'] = $datas[0]['device_name'];
            $key = '';
            $sub = array();
            foreach ($datas as $data) {
                if ($data['module_id'] != $key) {
                    if (!empty($sub)) {
                        $result['modules'][$key] = $sub;
                    }
                    $key = $data['module_id'];
                    $sub = array();
                    $sub['name'] = $data['module_name'];
                    $sub['type'] = $data['module_type'];
                    $sub['datas'] = array();
                }
                $ssub = array();
                $ssub['value'] = $this->output_value($data['measure_value'], $data['measure_type'], false, false, $data['module_type']);
                $ssub['unit'] = $this->output_unit($data['measure_type']);
                $sub_ts = strtotime ($data['measure_timestamp']);
                if ($sub_ts>$ts) {$ts=$sub_ts;}
                /*$ssub['timestamp'] = array(
                    'timestamp' => $sub_ts,
                    'ago' => $this->get_time_diff_from_utc($sub_ts),
                    'date' => $this->get_date_from_utc($sub_ts),
                    'time' => $this->get_time_from_utc($sub_ts)
                );*/
                $sub['datas'][$data['measure_type']] = $ssub;
            }
            if (!empty($sub)) {
                $result['modules'][$key] = $sub;
            }
        }
        $result['condition'] = array('value' => $err, 'message' =>$msg);
        $result['timestamp'] = $ts;
        /*$result['timestamp'] = array(
            'timestamp' => $ts,
            'ago' => $this->get_time_diff_from_utc($ts),
            'date' => $this->get_date_from_utc($ts),
            'time' => $this->get_time_from_utc($ts)
        );*/
        return $result;
    }

    /**
     * Says if value must be shown.
     *
     * @param   $measure_type               string  The type of value.
     * @param   $aggregated                  boolean  Display is in aggregated mode.
     * @param   $outdoor                    boolean  Display is in outdoor mode.
     * @param   $computed                   boolean  Display is in computed mode.
     * @return  boolean     True if the value must be shown, false otherwise.
     * @since    2.0.0
     */
    private function is_value_ok ($measure_type, $aggregated, $outdoor, $computed) {
        $result = false;
        switch ($measure_type) {
            case 'co2':
            case 'noise':
                $result = $aggregated && !$outdoor;
                break;
            case 'cloudiness':
            case 'pressure':
            case 'humidity':
            case 'temperature':
            case 'snow':
            case 'rain':
            case 'rain_hour_aggregated':
            case 'rain_day_aggregated':
            case 'windstrength':
            case 'windangle':
            case 'guststrength':
            case 'gustangle':
                $result = $aggregated || $outdoor;
                break;
            case 'dew_point':
            case 'frost_point':
            case 'wind_chill':
            case 'heat_index':
            case 'cloud_ceiling':
                $result = $computed && $outdoor;
                break;
        }
        return $result;
    }

    /**
     * Format the selected datas for lcd usage.
     *
     * @param   array   $datas  An array containing the selected datas.
     * @param   string   $measure_type  The measure type(s) to include.
     * @param   boolean   $computed  Includes computed measures too.
     * @return  array   An array containing the formated datas, ready to be displayed by lcd controls.
     * @since    1.0.0
     * @access   protected
     */
    protected function format_lcd_datas($datas, $measure_type, $computed=false) {
        $save_locale = setlocale(LC_ALL,'');
        setlocale(LC_ALL, get_locale());
        $result = array();
        $response = array ();
        $battery = array();
        $signal = array();
        $min = array();
        $max = array();
        $values = array();
        $value_types = array ('humidity' => 'NAModule1', 'rain' => 'NAModule3', 'windangle' => 'NAModule2', 'windstrength' => 'NAModule2', 'pressure' => 'NAMain', 'temperature' => 'NAModule1');
        $temperature_trend = array();
        $pressure_trend = array();
        $err = 0;
        $aggregated = ($measure_type == 'aggregated');
        $outdoor = ($measure_type == 'outdoor');
        $dew_point = 0;
        $has_dew_point = false;
        $temp_ref = 0;
        $has_temp_ref = false;
        $hum_ref = 0;
        $has_hum_ref = false;
        $wind_ref = 0;
        $has_wind_ref = false;
        $temperature_test = 0;
        $msg = __('Successful operation', 'live-weather-station');
        if (count($datas)==0) {
            $err = 3 ;
            $msg = __('Database contains inconsistent datas', 'live-weather-station');
        }
        else {
            foreach ($datas as $data) {
                if ($data['measure_type'] == 'battery') {
                    $battery[$data['module_id']] = $this->get_battery_lcd_level_text($data['measure_value'], $data['module_type']);
                }
                if ($data['measure_type'] == 'signal') {
                    $signal[$data['module_id']] = $this->get_signal_lcd_level_text($data['measure_value'], $data['module_type']);
                }
                if ($data['measure_type'] == 'temperature_max') {
                    $max[$data['module_id']] = $this->output_value($data['measure_value'], $data['measure_type']);
                }
                if ($data['measure_type'] == 'temperature_min') {
                    $min[$data['module_id']] = $this->output_value($data['measure_value'], $data['measure_type']);
                }
                if ($data['measure_type'] == 'temperature_trend') {
                    $temperature_trend[$data['module_id']] = ($data['measure_value'] == 'stable' ? 'steady' : $data['measure_value']);
                }
                if ($data['measure_type'] == 'pressure_trend') {
                    $pressure_trend[$data['module_id']] = ($data['measure_value'] == 'stable' ? 'steady' : $data['measure_value']);
                }
                if ($data['measure_type'] == 'dew_point') {
                    $dew_point = $data['measure_value'];
                    $has_dew_point = true;
                }
                if ($data['measure_type'] == 'temperature_ref') {
                    $temp_ref = $data['measure_value'];
                    $has_temp_ref = true;
                }
                if ($data['measure_type'] == 'wind_ref') {
                    $wind_ref = $data['measure_value'];
                    $has_wind_ref = true;
                }
                if ($data['measure_type'] == 'humidity_ref') {
                    $hum_ref = $data['measure_value'];
                    $has_hum_ref = true;
                }
                if (array_key_exists($data['measure_type'], $value_types) && $value_types[$data['measure_type']] == $data['module_type']) {
                    $values[$data['measure_type']] = $data['measure_value'] ;
                }
            }
            if ($has_temp_ref ) {
                $temperature_test = $temp_ref;
            }
            elseif (array_key_exists('temperature', $values)) {
                $temperature_test = $values['temperature'];
            }
            foreach ($datas as $data) {
                $unit = $this->output_unit($data['measure_type']);
                $measure = array ();
                $measure['min'] = 0;
                $measure['max'] = 0;
                $measure['value'] = $this->output_value($data['measure_value'], $data['measure_type']);
                $measure['unit'] = $unit['unit'];
                $measure['decimals'] = 1;
                $measure['sub_unit'] = $unit['comp'];
                $measure['show_sub_unit'] = ($unit['comp']!='');
                $measure['show_min_max'] = false;
                if ($outdoor || ($data['module_name'][0] == '[' && $aggregated && $outdoor)) {
                    $measure['title'] = iconv('UTF-8','ASCII//TRANSLIT',__('O/DR', 'live-weather-station') . ':' .$this->output_abbreviation($data['measure_type']));
                }
                else {
                    if ($data['module_name'][0] == '[') {
                        $measure['title'] = iconv('UTF-8','ASCII//TRANSLIT',__('O/DR', 'live-weather-station') . ':' .$this->output_abbreviation($data['measure_type']));
                    }
                    else {
                        $measure['title'] = iconv('UTF-8', 'ASCII//TRANSLIT', $data['module_name']);
                    }
                }
                if (array_key_exists($data['module_id'], $battery)) {
                    $measure['battery'] = $battery[$data['module_id']];
                }
                else {
                    $measure['battery'] = $this->get_battery_lcd_level_text(-1, 'none');
                }
                $measure['trend'] = '';
                $measure['show_trend'] = false;
                $measure['show_alarm'] = $this->is_alarm_on($data['measure_value'], $data['measure_type']);
                if (array_key_exists($data['module_id'], $signal)) {
                    $measure['signal'] = $signal[$data['module_id']];
                }
                else {
                    $measure['signal'] = $this->get_signal_lcd_level_text(-1, 'none');
                }
                if (($data['measure_type'] == $measure_type) || (($data['measure_type'] != $measure_type) && $this->is_value_ok($data['measure_type'], $aggregated, $outdoor, $computed))) {
                    switch ($data['measure_type']) {
                        case 'co2':
                        case 'noise':
                        case 'guststrength':
                            $response[] = $measure;
                            break;
                        case 'gustangle':
                            $measure['sub_unit'] = $this->get_angle_text($data['measure_value']);
                            $measure['show_sub_unit'] = true;
                            $response[] = $measure;
                            break;

                        case 'dew_point':
                            if ($has_temp_ref && $this->is_valid_dew_point($temp_ref)) {
                                $response[] = $measure;
                            }
                            break;
                        case 'frost_point':
                            if ($has_temp_ref && $this->is_valid_frost_point($temp_ref)) {
                                $response[] = $measure;
                            }
                            break;
                        case 'wind_chill':
                            if ($has_temp_ref && $has_wind_ref && $this->is_valid_wind_chill($temp_ref, $wind_ref)) {
                                $response[] = $measure;
                            }
                            break;
                        case 'heat_index':
                            if ($has_temp_ref && $has_hum_ref && $has_dew_point && $this->is_valid_heat_index($temp_ref, $hum_ref, $dew_point)) {
                                $response[] = $measure;
                            }
                            break;
                        case 'humidex':
                            if ($has_temp_ref && $has_hum_ref && $has_dew_point && $this->is_valid_humidex($temp_ref, $hum_ref, $dew_point)) {
                                $response[] = $measure;
                            }
                            break;
                        case 'cloud_ceiling':
                            if ($has_temp_ref && $has_dew_point) {
                                $response[] = $measure;
                            }
                            break;
                        case 'cloudiness':
                            if (!$outdoor) {
                                $measure['sub_unit'] = __('clouds', 'live-weather-station');
                                $measure['show_sub_unit'] = true;
                            }
                            $response[] = $measure;
                            break;
                        case 'humidity':
                            if (($data['measure_type'] == $measure_type) || ($data['measure_type'] != $measure_type && $aggregated)) {
                                $response[] = $measure;
                            }
                            if ($outdoor && $data['module_type'] == 'NAModule1') {
                                $response[] = $measure;
                            }
                            if ($outdoor && $data['module_type'] == 'NACurrent' && !array_key_exists($data['measure_type'], $values)) {
                                $response[] = $measure;
                            }
                            break;
                        case 'pressure':
                            if (array_key_exists($data['module_id'], $pressure_trend)) {
                                $measure['trend'] = $pressure_trend[$data['module_id']];
                                $measure['show_trend'] = true;
                            }
                            if (($data['measure_type'] == $measure_type) || ($data['measure_type'] != $measure_type && $aggregated)) {
                                $response[] = $measure;
                            }
                            if ($outdoor && $data['module_type'] == 'NAMain') {
                                $response[] = $measure;
                            }
                            if ($outdoor && $data['module_type'] == 'NACurrent' && !array_key_exists($data['measure_type'], $values)) {
                                $response[] = $measure;
                            }
                            break;
                        case 'temperature':
                            if (array_key_exists($data['module_id'], $temperature_trend)) {
                                $measure['trend'] = $temperature_trend[$data['module_id']];
                                $measure['show_trend'] = true;
                            }
                            if (array_key_exists($data['module_id'], $min) && array_key_exists($data['module_id'], $max)) {
                                $measure['min'] = $min[$data['module_id']];
                                $measure['max'] = $max[$data['module_id']];
                                $measure['show_min_max'] = true;
                            }
                            if (($data['measure_type'] == $measure_type) || ($data['measure_type'] != $measure_type && $aggregated)) {
                                $response[] = $measure;
                            }
                            if ($outdoor && $data['module_type'] == 'NAModule1') {
                                $response[] = $measure;
                            }
                            if ($outdoor && $data['module_type'] == 'NACurrent' && !array_key_exists($data['measure_type'], $values)) {
                                $response[] = $measure;
                            }
                            break;
                        case 'rain':
                            if (($data['measure_type'] == $measure_type) || ($data['measure_type'] != $measure_type && $aggregated)) {
                                if ($this->is_valid_rain($temperature_test)) {
                                    $response[] = $measure;
                                }
                            }
                            if ($outdoor && $data['module_type'] == 'NAModule3') {
                                if ($this->is_valid_rain($temperature_test)) {
                                    $response[] = $measure;
                                }
                            }
                            if ($outdoor && $data['module_type'] == 'NACurrent' && !array_key_exists($data['measure_type'], $values)) {
                                if ($this->is_valid_rain($temperature_test)) {
                                    $response[] = $measure;
                                }
                            }
                            break;
                        case 'rain_hour_aggregated':
                        case 'rain_day_aggregated':
                            if ($this->is_valid_rain($temperature_test)) {
                                $response[] = $measure;
                            }
                            break;
                        case 'snow':
                            if ($this->is_valid_snow($temperature_test)) {
                                $response[] = $measure;
                            }
                            break;
                        case 'windangle':
                        case 'windstrength':
                            if ($data['measure_type'] == 'windangle') {
                                $measure['sub_unit'] = $this->get_angle_text($data['measure_value']);
                                $measure['show_sub_unit'] = true;
                            }
                            if (($data['measure_type'] == $measure_type) || ($data['measure_type'] != $measure_type && $aggregated)) {
                                $response[] = $measure;
                            }
                            if ($outdoor && $data['module_type'] == 'NAModule2') {
                                $response[] = $measure;
                            }
                            if ($outdoor && $data['module_type'] == 'NACurrent' && !array_key_exists($data['measure_type'], $values)) {
                                $response[] = $measure;
                            }
                            break;
                    }
                }
            }
        }
        if (count($response)==0) {
            $err = 4 ;
            $msg = __('All data have been filtered: nothing to show', 'live-weather-station');
        }
        $result['condition'] = array('value' => $err, 'message' =>$msg);
        $result['datas'] = $response;
        setlocale(LC_ALL, $save_locale);
        return $result;
    }

    /**
     * Indicates if rain is valid (i.e. must be displayed).
     *
     * @param   integer   $temp_ref      Reference temperature in celcius degrees.
     * @return  boolean   True if rain is valid, false otherwise.
     * @since    2.0.0
     */
    protected function is_valid_rain($temp_ref) {
        $result = false;
        if ($temp_ref >= 0) {
            $result = true;
        }
        return $result;
    }

    /**
     * Indicates if snow is valid (i.e. must be displayed).
     *
     * @param   integer   $temp_ref      Reference temperature in celcius degrees.
     * @return  boolean   True if snow is valid, false otherwise.
     * @since    2.0.0
     */
    protected function is_valid_snow($temp_ref) {
        $result = false;
        if ($temp_ref < 3) {
            $result = true;
        }
        return $result;
    }

    /**
     * Indicates if dew point is valid (i.e. must be displayed).
     *
     * @param   integer   $temp_ref      Reference temperature in celcius degrees (reference = as it was at compute time).
     * @return  boolean   True if dew point is valid, false otherwise.
     * @since    1.1.0
     */
    protected function is_valid_dew_point($temp_ref) {
        $result = false;
        if ($temp_ref >= 0) {
            $result = true;
        }
        return $result;
    }

    /**
     * Indicates if frost point is valid (i.e. must be displayed).
     *
     * @param   integer   $temp_ref      Reference temperature in celcius degrees (reference = as it was at compute time).
     * @return  boolean   True if frost point is valid, false otherwise.
     * @since    1.1.0
     */
    protected function is_valid_frost_point($temp_ref) {
        $result = false;
        if ($temp_ref < 0) {
            $result = true;
        }
        return $result;
    }

    /**
     * Indicates if wind chill is valid (i.e. must be displayed).
     *
     * @param   float   $temp_ref      Reference temperature in celcius degrees (reference = as it was at compute time).
     * @param   float   $wind_chill     The wind chill value
     * @return  boolean   True if wind chill is valid, false otherwise.
     * @since    1.1.0
     */
    protected function is_valid_wind_chill($temp_ref, $wind_chill=-200) {
        $result = false;
        if ($temp_ref < 10 && $temp_ref > $wind_chill) {
            $result = true;
        }
        return $result;
    }

    /**
     * Indicates if heat index is valid (i.e. must be displayed).
     *
     * @param   integer   $temp_ref      Reference temperature in celcius degrees (reference = as it was at compute time).
     * @param   integer   $hum_ref      Reference humidity in % (reference = as it was at compute time).
     * @param   integer   $dew_ref      Reference dew point in celcius degrees (reference = as it was at compute time).
     * @return  boolean   True if heat index is valid, false otherwise.
     * @since    1.1.0
     */
    protected function is_valid_heat_index($temp_ref, $hum_ref, $dew_ref) {
        $result = false;
        if ( ($temp_ref >= 27) && ($hum_ref>=40) && ($dew_ref>=12)) {
            $result = true;
        }
        return $result;
    }

    /**
     * Indicates if humidex is valid (i.e. must be displayed).
     *
     * @param   integer   $temp_ref      Reference temperature in celcius degrees (reference = as it was at compute time).
     * @param   integer   $hum_ref      Reference humidity in % (reference = as it was at compute time).
     * @param   integer   $dew_ref      Reference dew point in celcius degrees (reference = as it was at compute time).
     * @return  boolean   True if humidex is valid, false otherwise.
     * @since    1.1.0
     */
    protected function is_valid_humidex($temp_ref, $hum_ref, $dew_ref) {
        $result = false;
        if ( ($temp_ref >= 15) && ($hum_ref>=20) && ($dew_ref>=10)) {
            $result = true;
        }
        return $result;
    }
}
