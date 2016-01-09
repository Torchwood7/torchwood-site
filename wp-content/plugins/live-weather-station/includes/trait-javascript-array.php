<?php
/**
 * Javascript array generation functionalities for Live Weather Station plugin
 *
 * @since      1.0.0
 * @package    Live_Weather_Station
 * @subpackage Live_Weather_Station/includes
 * @author     Pierre Lannoy <https://pierre.lannoy.fr/>
 */

require_once(LWS_INCLUDES_DIR. 'trait-unit-description.php');

trait Javascript_Array {

use Type_Description;
    
    /**
     * Get device IDs formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available device IDs formats.
     * @since    1.0.0
     * @access   private
     */
    private function get_td_device_id_format($sample) {
        $result = array();
        $result[0] = array (__('Raw value', 'live-weather-station'), 'raw', $sample[0]);
        return $result;
    }

    /**
     * Get device names formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available device names formats.
     *  @since    1.0.0
     * @access   private
     */
    private function get_td_device_name_format($sample) {
        $result = array();
        $result[0] = array (__('As-is', 'live-weather-station'), 'escaped', $sample[0]);
        return $result;
    }

    /**
     * Get module IDs formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available module IDs formats.
     * @since    1.0.0
     * @access   private
     */
    private function get_td_module_id_format($sample) {
        $result = array();
        $result[0] = array (__('Raw value', 'live-weather-station'), 'raw', $sample[0]);
        return $result;
    }

    /**
     * Get module types formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available module types formats.
     * @since    1.0.0
     * @access   private
     */
    private function get_td_module_type_format($sample) {
        $result = array();
        $result[0] = array (__('Raw value', 'live-weather-station'), 'raw', $sample[0]);
        $result[1] = array (__('Formated value', 'live-weather-station'), 'type-formated', $sample[1]);
        return $result;
    }

    /**
     * Get module names formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available module names formats.
     * @since    1.0.0
     * @access   private
     */
    private function get_td_module_name_format($sample) {
        $result = array();
        $result[0] = array (__('As-is', 'live-weather-station'), 'escaped', $sample[0]);
        return $result;
    }

    /**
     * Get times formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available times formats.
     * @since    1.0.0
     * @access   private
     */
    private function get_td_time_format($sample) {
        $result = array();
        $result[0] = array (__('UTC timestamp', 'live-weather-station'), 'raw', $sample[0]);
        $result[1] = array (__('Formated local date', 'live-weather-station'), 'local-date', $sample[1]);
        $result[2] = array (__('Formated local time', 'live-weather-station'), 'local-time', $sample[2]);
        $result[3] = array (__('Elapsed or remaining approximative time', 'live-weather-station'), 'local-diff', $sample[3]);
        return $result;
    }

    /**
     * Get measure types formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available measure types formats.
     * @since    1.0.0
     * @access   private
     */
    private function get_td_measure_type_format($sample) {
        $result = array();
        $result[0] = array (__('Raw value', 'live-weather-station'), 'raw', $sample[0]);
        $result[1] = array (__('Formated value', 'live-weather-station'), 'type-formated', $sample[1]);
        return $result;
    }

    /**
     * Get values formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available values formats.
     * @since    1.0.0
     * @access   private
     */
    private function get_td_value_format($sample) {
        $result = array();
        $result[0] = array (__('Raw value', 'live-weather-station'), 'raw', $sample[0]);
        $result[1] = array (__('Converted value', 'live-weather-station'), 'computed', $sample[1]);
        $result[2] = array (__('Converted value with unit', 'live-weather-station'), 'computed-unit', $sample[2]);
        return $result;
    }

    /**
     * Get simple values formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available values formats.
     * @since    1.1.0
     * @access   private
     */
    private function get_td_simple_value_format($sample) {
        $result = array();
        $result[0] = array (__('Raw value', 'live-weather-station'), 'raw', $sample[0]);
        $result[1] = array (__('Converted value', 'live-weather-station'), 'computed', $sample[1]);
        return $result;
    }

    /**
     * Get values battery and signal formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available values formats for battery and signal.
     * @since    1.0.0
     * @access   private
     */
    private function get_td_special_value_format($sample) {
        $result = array();
        $result[0] = array (__('Raw value', 'live-weather-station'), 'raw', $sample[0]);
        $result[1] = array (__('Converted value', 'live-weather-station'), 'computed', $sample[1]);
        $result[2] = array (__('Converted value with unit', 'live-weather-station'), 'computed-unit', $sample[2]);
        $result[3] = array (__('Plain text', 'live-weather-station'), 'plain-text', $sample[3]);
        return $result;
    }

    /**
     * Get wid angle formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available values formats for wind angle.
     * @since    2.0.0
     * @access   private
     */
    private function get_td_wind_value_format($sample) {
        $result = array();
        $result[0] = array (__('Raw value', 'live-weather-station'), 'raw', $sample[0]);
        $result[1] = array (__('Converted value', 'live-weather-station'), 'computed', $sample[1]);
        $result[2] = array (__('Converted value with unit', 'live-weather-station'), 'computed-unit', $sample[2]);
        $result[3] = array (__('Abbreviation', 'live-weather-station'), 'short-text', $sample[3]);
        $result[4] = array (__('Plain text', 'live-weather-station'), 'plain-text', $sample[4]);
        return $result;
    }

    /**
     * Get aggregated values formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available values formats for aggregated.
     * @since    1.0.0
     * @access   private
     */
    private function get_td_aggregated_value_format($sample) {
        $result = array();
        $result[0] = array (__('Raw value', 'live-weather-station'), 'raw', $sample[0]);
        return $result;
    }

    /**
     * Get firmware values formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available values formats for firmware.
     * @since    1.1.0
     * @access   private
     */
    private function get_td_firmware_value_format($sample) {
        $result = array();
        $result[0] = array (__('Raw value', 'live-weather-station'), 'raw', $sample[0]);
        return $result;
    }

    /**
     * Get values coordinates formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available values formats for coordinates.
     * @since    1.1.0
     * @access   private
     */
    private function get_td_coordinate_value_format($sample) {
        $result = array();
        $result[0] = array (__('Raw value', 'live-weather-station'), 'raw', $sample[0]);
        $result[1] = array (__('Geodetic system WGS 84', 'live-weather-station'), 'computed-wgs84', $sample[1]);
        $result[2] = array (__('Geodetic system WGS 84 with unit', 'live-weather-station'), 'computed-wgs84-unit', $sample[2]);
        $result[3] = array (__('DMS', 'live-weather-station'), 'computed-dms', $sample[3]);
        $result[4] = array (__('DMS starting with cardinal', 'live-weather-station'), 'computed-dms-cardinal-start', $sample[4]);
        $result[5] = array (__('DMS ending with cardinal', 'live-weather-station'), 'computed-dms-cardinal-end', $sample[5]);
        return $result;
    }

    /**
     * Get trend formats for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @return  array   An array containing the available trends formats.
     * @since    1.1.0
     * @access   private
     */
    private function get_td_trend_format($sample) {
        $result = array();
        $result[0] = array (__('Raw value', 'live-weather-station'), 'raw', $sample[0]);
        $result[1] = array (__('Plain text', 'live-weather-station'), 'plain-text', $sample[1]);
        return $result;
    }

    /**
     * Get elements for javascript.
     *
     * @param   array   $module An array containing a module sample data.
     * @return  array   An array containing the available elements.
     * @since    1.0.0
     * @access   private
     */
    private function get_td_elements($sample,$ts,$mtype,$mvalue) {
        $result = array();
        $result[] = array(__('Station ID', 'live-weather-station'), 'device_id', $this->get_td_device_id_format(array($sample['device_id'])));
        $result[] = array(__('Station name', 'live-weather-station'), 'device_name', $this->get_td_device_name_format(array($sample['device_name'])));
        $result[] = array(__('Module ID', 'live-weather-station'), 'module_id', $this->get_td_module_id_format(array($sample['module_id'])));
        $result[] = array(__('Module type', 'live-weather-station'), 'module_type', $this->get_td_module_type_format(array($sample['module_type'],$this->get_module_type($sample['module_type']))));
        $result[] = array(__('Module name', 'live-weather-station'), 'module_name', $this->get_td_module_name_format(array($sample['module_name'])));
        $result[] = array(__('Measurement timestamp', 'live-weather-station'), 'measure_timestamp', $this->get_td_time_format(array($ts, $this->get_date_from_utc($ts, $sample['place']['timezone']), $this->get_time_from_utc($ts, $sample['place']['timezone']), $this->get_time_diff_from_utc($ts))));
        $result[] = array(__('Measurement type', 'live-weather-station'), 'measure_type', $this->get_td_measure_type_format(array($mtype,$this->get_measurement_type($mtype))));
        switch ($mtype) {
            case 'battery':
            case 'signal':
                $result[] = array(__('Measurement value', 'live-weather-station'), 'measure_value', $this->get_td_special_value_format(array($mvalue, $this->output_value($mvalue, $mtype, false, false, $sample['module_type']), $this->output_value($mvalue, $mtype, true, false, $sample['module_type']), $this->output_value($mvalue, $mtype, false, true, $sample['module_type']))));
                break;
            case 'temperature_trend':
            case 'pressure_trend':
            case 'moon_age':
            case 'moon_phase':
            case 'loc_timezone':
                $result[] = array(__('Measurement value', 'live-weather-station'), 'measure_value', $this->get_td_trend_format(array($mvalue, $this->output_value($mvalue, $mtype, false, true))));
                break;
            case 'aggregated':
            /*    $result[] = array(__('Measurement value', 'live-weather-station'), 'measure_value', $this->get_td_aggregated_value_format(array($mvalue, $this->output_value($mvalue, $mtype))));
                break;*/
            case 'outdoor':
                $result[] = array(__('Measurement value', 'live-weather-station'), 'measure_value', $this->get_td_aggregated_value_format(array($mvalue, $this->output_value($mvalue, $mtype))));
                break;
            case 'firmware':
                $result[] = array(__('Measurement value', 'live-weather-station'), 'measure_value', $this->get_td_firmware_value_format(array($mvalue)));
                break;
            case 'loc_latitude':
            case 'loc_longitude':
                $result[] = array(__('Measurement value', 'live-weather-station'), 'measure_value', $this->get_td_coordinate_value_format(array($mvalue, $this->output_coordinate($mvalue, $mtype, 1), $this->output_coordinate($mvalue, $mtype, 2), $this->output_coordinate($mvalue, $mtype, 3), $this->output_coordinate($mvalue, $mtype, 4), $this->output_coordinate($mvalue, $mtype, 5))));
                break;
            case 'heat_index':
            case 'humidex':
                $result[] = array(__('Measurement value', 'live-weather-station'), 'measure_value', $this->get_td_simple_value_format(array($mvalue, $this->output_value($mvalue, $mtype))));
                break;
            case 'windangle':
            case 'gustangle':
            case 'windangle_max':
            case 'windangle_day_max':
            case 'windangle_hour_max':
                $result[] = array(__('Measurement value', 'live-weather-station'), 'measure_value', $this->get_td_wind_value_format(array($mvalue, $this->output_value($mvalue, $mtype), $this->output_value($mvalue, $mtype, true), $this->get_angle_text($mvalue), $this->get_angle_full_text($mvalue))));
                break;
            case 'sunrise':
            case 'sunset':
            case 'moonrise':
            case 'moonset':
                $result[] = array(__('Measurement value', 'live-weather-station'), 'measure_value', $this->get_td_time_format(array($mvalue, $this->get_date_from_utc($mvalue, $sample['place']['timezone']), $this->get_time_from_utc($mvalue, $sample['place']['timezone']), $this->get_time_diff_from_utc($mvalue))));
                break;
            default:
                $result[] = array(__('Measurement value', 'live-weather-station'), 'measure_value', $this->get_td_value_format(array($mvalue, $this->output_value($mvalue, $mtype), $this->output_value($mvalue, $mtype, true))));
        }
        return $result;
    }

    /**
     * Get measure line for javascript.
     *
     * @param   array   $sample An array containing sample data.
     * @param   boolean     $full The array must contain all measured data types including operational datas.
     * @param   boolean     $aggregated The array must contain aggregated data types.
     * @param   boolean     $reduced The array is reduced. i.e. contains only modules and measures.
     * @param   boolean     $computed The array must contain computed data types.
     * @return  array   An array containing the available measure lines.
     * @since    1.0.0
     * @access   private
     */
    private function get_td_measure($sample, $full=false, $aggregated=false, $reduced=false, $computed=false) {
        $result = array();
        $ts = $sample['measure_values']['time_utc'] ;
        switch (strtolower($sample['module_type'])) {
            case 'namain':
                $netatmo = !Owm_Client::is_owm_station($sample['device_id']);
                if ($aggregated) {
                    $result[] = array($this->get_measurement_type('aggregated'), 'aggregated', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'aggregated', (array_key_exists('rf_status', $sample) ? $sample['rf_status'] : ''))));
                }
                if ($full && $netatmo) {
                    $result[] = array($this->get_measurement_type('battery'), 'battery', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'battery', (array_key_exists('battery_vp', $sample) ? $sample['battery_vp'] : ''))));
                    $result[] = array($this->get_measurement_type('firmware'), 'firmware', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'firmware', (array_key_exists('firmware', $sample) ? $sample['firmware'] : ''))));
                    $result[] = array($this->get_measurement_type('signal'), 'signal', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'signal', (array_key_exists('rf_status', $sample) ? $sample['rf_status'] : ''))));
                }
                if ($netatmo) {
                    $result[] = array($this->get_measurement_type('co2'), 'co2', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'co2', (array_key_exists('CO2', $sample['measure_values']) ? $sample['measure_values']['CO2'] : ''))));
                    $result[] = array($this->get_measurement_type('humidity'), 'humidity', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'humidity', (array_key_exists('Humidity', $sample['measure_values']) ? $sample['measure_values']['Humidity'] : ''))));
                    $result[] = array($this->get_measurement_type('noise'), 'noise', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'noise', (array_key_exists('Noise', $sample['measure_values']) ? $sample['measure_values']['Noise'] : ''))));
                    $result[] = array($this->get_measurement_type('pressure'), 'pressure', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'pressure', (array_key_exists('Pressure', $sample['measure_values']) ? $sample['measure_values']['Pressure'] : ''))));
                }
                if ($full && $netatmo) {
                    $result[] = array($this->get_measurement_type('pressure_trend'), 'pressure_trend', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'pressure_trend', (array_key_exists('pressure_trend', $sample['measure_values']) ? $sample['measure_values']['pressure_trend'] : ''))));
                }
                if ($netatmo) {
                    $result[] = array($this->get_measurement_type('temperature'), 'temperature', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature', (array_key_exists('Temperature', $sample['measure_values']) ? $sample['measure_values']['Temperature'] : ''))));
                }
                if ($full) {
                    if ($netatmo) {
                        $result[] = array($this->get_measurement_type('temperature_max'), 'temperature_max', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature_max', (array_key_exists('max_temp', $sample['measure_values']) ? $sample['measure_values']['max_temp'] : ''))));
                        $result[] = array($this->get_measurement_type('temperature_min'), 'temperature_min', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature_min', (array_key_exists('min_temp', $sample['measure_values']) ? $sample['measure_values']['min_temp'] : ''))));
                        $result[] = array($this->get_measurement_type('temperature_trend'), 'temperature_trend', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature_trend', (array_key_exists('temp_trend', $sample['measure_values']) ? $sample['measure_values']['temp_trend'] : ''))));
                    }
                    if (isset($sample['place']) && is_array($sample['place'])) {
                        $place = $sample['place'];
                        $result[] = array($this->get_measurement_type('loc_timezone'), 'loc_timezone', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'loc_timezone', (array_key_exists('timezone', $place) ? $place['timezone'] : ''))));
                        $result[] = array($this->get_measurement_type('loc_altitude'), 'loc_altitude', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'loc_altitude', (array_key_exists('altitude', $place) ? $place['altitude'] : ''))));
                        if (isset($place['location']) && is_array($place['location'])) {
                            $result[] = array($this->get_measurement_type('loc_latitude'), 'loc_latitude', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'loc_latitude', (count($place['location']) > 1 ? $place['location'][1] : ''))));
                            $result[] = array($this->get_measurement_type('loc_longitude'), 'loc_longitude', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'loc_longitude', (count($place['location']) > 0 ? $place['location'][0] : ''))));
                        }
                    }
                }
                break;
            case 'namodule1': // Outdoor module
                if ($aggregated) {
                    $result[] = array($this->get_measurement_type('aggregated'), 'aggregated', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'aggregated', (array_key_exists('rf_status', $sample) ? $sample['rf_status'] : ''))));
                }
                if ($full) {
                    $result[] = array($this->get_measurement_type('battery'), 'battery', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'battery', (array_key_exists('battery_vp', $sample) ? $sample['battery_vp'] : ''))));
                    $result[] = array($this->get_measurement_type('firmware'), 'firmware', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'firmware', (array_key_exists('firmware', $sample) ? $sample['firmware'] : ''))));
                    $result[] = array($this->get_measurement_type('signal'), 'signal', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'signal', (array_key_exists('rf_status', $sample) ? $sample['rf_status'] : ''))));
                }
                $result[] = array($this->get_measurement_type('humidity'), 'humidity', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'humidity', (array_key_exists('Humidity', $sample['measure_values']) ? $sample['measure_values']['Humidity'] : ''))));
                $result[] = array($this->get_measurement_type('temperature'), 'temperature', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature', (array_key_exists('Temperature', $sample['measure_values']) ? $sample['measure_values']['Temperature'] : ''))));
                if ($full) {
                    $result[] = array($this->get_measurement_type('temperature_max'), 'temperature_max', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature_max', (array_key_exists('max_temp', $sample['measure_values']) ? $sample['measure_values']['max_temp'] : ''))));
                    $result[] = array($this->get_measurement_type('temperature_min'), 'temperature_min', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature_min', (array_key_exists('min_temp', $sample['measure_values']) ? $sample['measure_values']['min_temp'] : ''))));
                    $result[] = array($this->get_measurement_type('temperature_trend'), 'temperature_trend', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature_trend', (array_key_exists('temp_trend', $sample['measure_values']) ? $sample['measure_values']['temp_trend'] : ''))));
                }
                break;
            case 'namodule3': // Rain gauge
                if ($aggregated) {
                    $result[] = array($this->get_measurement_type('aggregated'), 'aggregated', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'aggregated', (array_key_exists('rf_status', $sample) ? $sample['rf_status'] : ''))));
                }
                if ($full) {
                    $result[] = array($this->get_measurement_type('battery'), 'battery', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'battery', (array_key_exists('battery_vp', $sample) ? $sample['battery_vp'] : ''))));
                    $result[] = array($this->get_measurement_type('firmware'), 'firmware', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'firmware', (array_key_exists('firmware', $sample) ? $sample['firmware'] : ''))));
                    $result[] = array($this->get_measurement_type('signal'), 'signal', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'signal', (array_key_exists('rf_status', $sample) ? $sample['rf_status'] : ''))));
                }
                $result[] = array($this->get_measurement_type('rain'), 'rain', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'rain', (array_key_exists('Rain', $sample['measure_values']) ? $sample['measure_values']['Rain'] : ''))));
                $result[] = array($this->get_measurement_type('rain_hour_aggregated'), 'rain_hour_aggregated', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'rain_hour_aggregated', (array_key_exists('sum_rain_1', $sample['measure_values']) ? $sample['measure_values']['sum_rain_1'] : ''))));
                $result[] = array($this->get_measurement_type('rain_day_aggregated'), 'rain_day_aggregated', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'rain_day_aggregated', (array_key_exists('sum_rain_24', $sample['measure_values']) ? $sample['measure_values']['sum_rain_24'] : ''))));
                break;
            case 'namodule2': // Wind gauge
                if ($aggregated) {
                    $result[] = array($this->get_measurement_type('aggregated'), 'aggregated', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'aggregated', (array_key_exists('rf_status', $sample) ? $sample['rf_status'] : ''))));
                }
                if ($full) {
                    $result[] = array($this->get_measurement_type('battery'), 'battery', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'battery', (array_key_exists('battery_vp', $sample) ? $sample['battery_vp'] : ''))));
                    $result[] = array($this->get_measurement_type('firmware'), 'firmware', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'firmware', (array_key_exists('firmware', $sample) ? $sample['firmware'] : ''))));
                    $result[] = array($this->get_measurement_type('signal'), 'signal', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'signal', (array_key_exists('rf_status', $sample) ? $sample['rf_status'] : ''))));
                }
                $result[] = array($this->get_measurement_type('windangle'), 'windangle', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'windangle', (array_key_exists('WindAngle', $sample['measure_values']) ? $sample['measure_values']['WindAngle'] : ''))));
                $result[] = array($this->get_measurement_type('windstrength'), 'windstrength', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'windstrength', (array_key_exists('WindStrength', $sample['measure_values']) ? $sample['measure_values']['WindStrength'] : ''))));
                $result[] = array($this->get_measurement_type('gustangle'), 'gustangle', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'gustangle', (array_key_exists('GustAngle', $sample['measure_values']) ? $sample['measure_values']['GustAngle'] : ''))));
                $result[] = array($this->get_measurement_type('guststrength'), 'guststrength', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'guststrength', (array_key_exists('GustStrength', $sample['measure_values']) ? $sample['measure_values']['GustStrength'] : ''))));
                if ($full) {
                    $result[] = array($this->get_measurement_type('windangle_max'), 'windangle_max', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'windangle_max', (array_key_exists('max_wind_angle', $sample['measure_values']['WindHistoric']) ? $sample['measure_values']['WindHistoric']['max_wind_angle'] : ''))));
                    $result[] = array($this->get_measurement_type('windstrength_max'), 'windstrength_max', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'windstrength_max', (array_key_exists('max_wind_str', $sample['measure_values']['WindHistoric']) ? $sample['measure_values']['WindHistoric']['max_wind_str'] : ''))));
                }
                break;
            case 'namodule4': // Additional indoor module
                if ($aggregated) {
                    $result[] = array($this->get_measurement_type('aggregated'), 'aggregated', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'aggregated', (array_key_exists('rf_status', $sample) ? $sample['rf_status'] : ''))));
                }
                if ($full) {
                    $result[] = array($this->get_measurement_type('battery'), 'battery', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'battery', (array_key_exists('battery_vp', $sample) ? $sample['battery_vp'] : ''))));
                    $result[] = array($this->get_measurement_type('firmware'), 'firmware', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'firmware', (array_key_exists('firmware', $sample) ? $sample['firmware'] : ''))));
                    $result[] = array($this->get_measurement_type('signal'), 'signal', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'signal', (array_key_exists('rf_status', $sample) ? $sample['rf_status'] : ''))));
                }
                $result[] = array($this->get_measurement_type('co2'), 'co2', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'co2', (array_key_exists('CO2', $sample['measure_values']) ? $sample['measure_values']['CO2'] : ''))));
                $result[] = array($this->get_measurement_type('humidity'), 'humidity', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'humidity', (array_key_exists('Humidity', $sample['measure_values']) ? $sample['measure_values']['Humidity'] : ''))));
                $result[] = array($this->get_measurement_type('temperature'), 'temperature', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature', (array_key_exists('Temperature', $sample['measure_values']) ? $sample['measure_values']['Temperature'] : ''))));
                if ($full) {
                    $result[] = array($this->get_measurement_type('temperature_max'), 'temperature_max', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature_max', (array_key_exists('max_temp', $sample['measure_values']) ? $sample['measure_values']['max_temp'] : ''))));
                    $result[] = array($this->get_measurement_type('temperature_min'), 'temperature_min', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature_min', (array_key_exists('min_temp', $sample['measure_values']) ? $sample['measure_values']['min_temp'] : ''))));
                    $result[] = array($this->get_measurement_type('temperature_trend'), 'temperature_trend', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature_trend', (array_key_exists('temp_trend', $sample['measure_values']) ? $sample['measure_values']['temp_trend'] : ''))));
                }
                break;
            case 'aggregated': // All modules aggregated in one
                if ($aggregated) {
                    $result[] = array($this->get_measurement_type('aggregated'), 'aggregated', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'aggregated', (array_key_exists('rf_status', $sample) ? $sample['rf_status'] : ''))));
                    $result[] = array($this->get_measurement_type('outdoor'), 'outdoor', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'outdoor', (array_key_exists('rf_status', $sample) ? $sample['rf_status'] : ''))));
                }
                $result[] = array($this->get_measurement_type('co2'), 'co2', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'co2', (array_key_exists('CO2', $sample['measure_values']) ? $sample['measure_values']['CO2'] : ''))));
                $result[] = array($this->get_measurement_type('humidity'), 'humidity', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'humidity', (array_key_exists('Humidity', $sample['measure_values']) ? $sample['measure_values']['Humidity'] : ''))));
                $result[] = array($this->get_measurement_type('temperature'), 'temperature', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature', (array_key_exists('Temperature', $sample['measure_values']) ? $sample['measure_values']['Temperature'] : ''))));
                break;
            case 'nacomputed': // Virtual module for computed values
                if ($computed) {
                    if ($aggregated) {
                        $result[] = array($this->get_measurement_type('aggregated'), 'aggregated', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'aggregated', (array_key_exists('rf_status', $sample) ? $sample['rf_status'] : ''))));
                    }
                    if ($full) {
                        $result[] = array($this->get_measurement_type('firmware'), 'firmware', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'firmware', (array_key_exists('firmware', $sample) ? $sample['firmware'] : ''))));
                        $result[] = array($this->get_measurement_type('temperature_ref'), 'temperature_ref', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature_ref', (array_key_exists('temperature_ref', $sample['measure_values']) ? $sample['measure_values']['temperature_ref'] : ''))));
                        $result[] = array($this->get_measurement_type('humidity_ref'), 'humidity_ref', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'humidity_ref', (array_key_exists('humidity_ref', $sample['measure_values']) ? $sample['measure_values']['humidity_ref'] : ''))));
                        $result[] = array($this->get_measurement_type('wind_ref'), 'wind_ref', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'wind_ref', (array_key_exists('wind_ref', $sample['measure_values']) ? $sample['measure_values']['wind_ref'] : ''))));

                    }
                    $result[] = array($this->get_measurement_type('dew_point'), 'dew_point', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'dew_point', (array_key_exists('dew_point', $sample['measure_values']) ? $sample['measure_values']['dew_point'] : ''))));
                    $result[] = array($this->get_measurement_type('frost_point'), 'frost_point', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'frost_point', (array_key_exists('frost_point', $sample['measure_values']) ? $sample['measure_values']['frost_point'] : ''))));
                    $result[] = array($this->get_measurement_type('heat_index'), 'heat_index', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'heat_index', (array_key_exists('heat_index', $sample['measure_values']) ? $sample['measure_values']['heat_index'] : ''))));
                    $result[] = array($this->get_measurement_type('humidex'), 'humidex', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'humidex', (array_key_exists('humidex', $sample['measure_values']) ? $sample['measure_values']['humidex'] : ''))));
                    $result[] = array($this->get_measurement_type('wind_chill'), 'wind_chill', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'wind_chill', (array_key_exists('wind_chill', $sample['measure_values']) ? $sample['measure_values']['wind_chill'] : ''))));
                    $result[] = array($this->get_measurement_type('cloud_ceiling'), 'cloud_ceiling', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'cloud_ceiling', (array_key_exists('cloud_ceiling', $sample['measure_values']) ? $sample['measure_values']['cloud_ceiling'] : ''))));
                }
                break;
            case 'nacurrent': // Virtual module for current values from OpenWeatherMap.org
                if ($aggregated) {
                    $result[] = array($this->get_measurement_type('aggregated'), 'aggregated', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'aggregated', (array_key_exists('rf_status', $sample) ? $sample['rf_status'] : ''))));
                }
                if ($full) {
                    $result[] = array($this->get_measurement_type('firmware'), 'firmware', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'firmware', (array_key_exists('firmware', $sample) ? $sample['firmware'] : ''))));
                }
                $result[] = array($this->get_measurement_type('pressure'), 'pressure', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'pressure', (array_key_exists('pressure', $sample['measure_values']) ? $sample['measure_values']['pressure'] : ''))));
                $result[] = array($this->get_measurement_type('humidity'), 'humidity', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'humidity', (array_key_exists('humidity', $sample['measure_values']) ? $sample['measure_values']['humidity'] : ''))));
                $result[] = array($this->get_measurement_type('temperature'), 'temperature', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'temperature', (array_key_exists('temperature', $sample['measure_values']) ? $sample['measure_values']['temperature'] : ''))));
                $result[] = array($this->get_measurement_type('rain'), 'rain', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'rain', (array_key_exists('rain', $sample['measure_values']) ? $sample['measure_values']['rain'] : ''))));
                $result[] = array($this->get_measurement_type('snow'), 'snow', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'snow', (array_key_exists('snow', $sample['measure_values']) ? $sample['measure_values']['snow'] : ''))));
                $result[] = array($this->get_measurement_type('windangle'), 'windangle', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'windangle', (array_key_exists('windangle', $sample['measure_values']) ? $sample['measure_values']['windangle'] : ''))));
                $result[] = array($this->get_measurement_type('windstrength'), 'windstrength', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'windstrength', (array_key_exists('windstrength', $sample['measure_values']) ? $sample['measure_values']['windstrength'] : ''))));
                $result[] = array($this->get_measurement_type('cloudiness'), 'cloudiness', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'cloudiness', (array_key_exists('cloudiness', $sample['measure_values']) ? $sample['measure_values']['cloudiness'] : ''))));
                break;
            case 'naephemer': // Virtual module for ephemeris
                if ($computed) {
                    if ($full) {
                        $result[] = array($this->get_measurement_type('firmware'), 'firmware', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'firmware', (array_key_exists('firmware', $sample) ? $sample['firmware'] : ''))));
                    }
                    $result[] = array($this->get_measurement_type('sunrise'), 'sunrise', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'sunrise', (array_key_exists('sunrise', $sample['measure_values']) ? $sample['measure_values']['sunrise'] : ''))));
                    $result[] = array($this->get_measurement_type('sunset'), 'sunset', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'sunset', (array_key_exists('sunset', $sample['measure_values']) ? $sample['measure_values']['sunset'] : ''))));
                    $result[] = array($this->get_measurement_type('sun_distance'), 'sun_distance', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'sun_distance', (array_key_exists('sun_distance', $sample['measure_values']) ? $sample['measure_values']['sun_distance'] : ''))));
                    $result[] = array($this->get_measurement_type('sun_diameter'), 'sun_diameter', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'sun_diameter', (array_key_exists('sun_diameter', $sample['measure_values']) ? $sample['measure_values']['sun_diameter'] : ''))));
                    $result[] = array($this->get_measurement_type('moonrise'), 'moonrise', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'moonrise', (array_key_exists('moonrise', $sample['measure_values']) ? $sample['measure_values']['moonrise'] : ''))));
                    $result[] = array($this->get_measurement_type('moonset'), 'moonset', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'moonset', (array_key_exists('moonset', $sample['measure_values']) ? $sample['measure_values']['moonset'] : ''))));
                    $result[] = array($this->get_measurement_type('moon_phase'), 'moon_phase', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'moon_phase', (array_key_exists('moon_phase', $sample['measure_values']) ? $sample['measure_values']['moon_phase'] : ''))));
                    $result[] = array($this->get_measurement_type('moon_age'), 'moon_age', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'moon_age', (array_key_exists('moon_age', $sample['measure_values']) ? $sample['measure_values']['moon_age'] : ''))));
                    $result[] = array($this->get_measurement_type('moon_illumination'), 'moon_illumination', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'moon_illumination', (array_key_exists('moon_illumination', $sample['measure_values']) ? $sample['measure_values']['moon_illumination'] : ''))));
                    $result[] = array($this->get_measurement_type('moon_distance'), 'moon_distance', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'moon_distance', (array_key_exists('moon_distance', $sample['measure_values']) ? $sample['measure_values']['moon_distance'] : ''))));
                    $result[] = array($this->get_measurement_type('moon_diameter'), 'moon_diameter', ($reduced ? array() : $this->get_td_elements($sample, $ts, 'moon_diameter', (array_key_exists('moon_diameter', $sample['measure_values']) ? $sample['measure_values']['moon_diameter'] : ''))));
                }
                break;
        }
        return $result;
    }

    /**
     * Get station's datas.
     *
     * @return  array   An array containing the available station's datas ready to convert to a JS array.
     * @param   boolean     $full The array must contain all measured data types including operational datas.
     * @param   boolean     $aggregated The array must contain aggregated data types.
     * @param   boolean     $reduced The array is reduced. i.e. contains only modules and measures.
     * @param   boolean     $computed The array must contain computed data types.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_js_array($datas, $full=true, $aggregated=false, $reduced=false, $computed=false) {
        $result = array();
        if (count($datas) == 0) {return $result;}
        foreach($datas['devices'] as $device) {
            $netatmo = !Owm_Client::is_owm_station($device['_id']);
            $t_module = array() ;
            if ($aggregated && count($device['modules']) > 1 && $netatmo) {
                $sample = array();
                $sample['device_id'] = 'aggregated';
                $sample['device_name'] = $device['station_name'];
                $sample['module_id'] = 'aggregated';
                $sample['module_type'] = 'aggregated';
                $sample['module_name'] = __('[all modules]', 'live-weather-station');
                $sample['measure_values'] = $device['dashboard_data'];
                $sample['battery_vp'] = 0;
                $sample['rf_status'] = $device['wifi_status'];
                $sample['place'] = $device['place'];
                $t_module[] = array ($sample['module_name'], $sample['device_id'], $this->get_td_measure($sample, $full, $aggregated, $reduced, $computed));
            }
            if (($aggregated  && $netatmo) || $full) {
                $sample = array();
                $sample['device_id'] = $device['_id'];
                $sample['device_name'] = $device['station_name'];
                $sample['module_id'] = $device['_id'];
                $sample['module_type'] = $device['type'];
                $sample['module_name'] = $device['module_name'];
                $sample['measure_values'] = $device['dashboard_data'];
                $sample['battery_vp'] = 0;
                $sample['rf_status'] = $device['wifi_status'];
                $sample['firmware'] = $device['firmware'];
                $sample['place'] = $device['place'];
                $t_module[] = array($device['module_name'], $device['_id'], $this->get_td_measure($sample, $full, $aggregated, $reduced, $computed));
            }
            foreach($device['modules'] as $module) {
                if (($module['type'] == 'NAComputed' || $module['type'] == 'NAEphemer') && !$computed) {
                    continue;
                }
                $sample = array();
                $sample['device_id'] = $device['_id'];
                $sample['device_name'] = $device['station_name'];
                $sample['module_id'] = $module['_id'];
                $sample['module_type'] = $module['type'];
                $sample['module_name'] = $module['module_name'];
                $sample['measure_values'] = $module['dashboard_data'];
                $sample['battery_vp'] = $module['battery_vp'];
                $sample['rf_status'] = $module['rf_status'];
                $sample['firmware'] = $module['firmware'];
                $sample['place'] = $device['place'];
                $t_module[] = array ($module['module_name'], $module['_id'], $this->get_td_measure($sample, $full, $aggregated, $reduced, $computed));
            }
            $result[] = array($device['station_name'], $device['_id'], $t_module);
        }
        return $result;
    }

    /**
     * Get the size options for the lcd panel.
     *
     * @return  array   An array containing the lcd size options ready to convert to a JS array.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_lcd_size_js_array() {
        $result = array();
        $result[] = array('small',  __('Small', 'live-weather-station'));
        $result[] = array('medium',  __('Medium', 'live-weather-station'));
        $result[] = array('large',  __('Large', 'live-weather-station'));
        $result[] = array('scalable',  __('Scalable', 'live-weather-station'));
        return $result;
    }

    /**
     * Get the speed options for the lcd panel.
     *
     * @return  array   An array containing the lcd speed options ready to convert to a JS array.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_lcd_speed_js_array() {
        $result = array();
        $result[] = array('2000',  __('Fast', 'live-weather-station'));
        $result[] = array('4000',  __('Medium', 'live-weather-station'));
        $result[] = array('8000',  __('Slow', 'live-weather-station'));
        return $result;
    }

    /**
     * Get the designs options for the lcd panel.
     *
     * @return  array   An array containing the lcd designs options ready to convert to a JS array.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_lcd_design_js_array() {
        $result = array();
        $result[] = array('standard',  __('Standard - Without backlight', 'live-weather-station'));
        $result[] = array('lightgreen-black',  __('Standard - With backlight', 'live-weather-station'));
        $result[] = array('red',  __('Translucent - Red', 'live-weather-station'));
        $result[] = array('orange',  __('Translucent - Orange', 'live-weather-station'));
        $result[] = array('lcd-beige',  __('Translucent - Beige', 'live-weather-station'));
        $result[] = array('yellow-black',  __('Translucent - Yellow', 'live-weather-station'));
        $result[] = array('yellow',  __('Translucent - Yellow green', 'live-weather-station'));
        $result[] = array('lightgreen',  __('Translucent - Light green', 'live-weather-station'));
        $result[] = array('standard-green',  __('Translucent - Standard green', 'live-weather-station'));
        $result[] = array('blue',  __('Translucent - Light blue', 'live-weather-station'));
        $result[] = array('blue-blue',  __('Translucent - Blue', 'live-weather-station'));
        $result[] = array('lightblue',  __('Translucent - Light purple', 'live-weather-station'));
        $result[] = array('sections',  __('Translucent - Gray', 'live-weather-station'));
        $result[] = array('white',  __('Translucent - White', 'live-weather-station'));
        $result[] = array('red-darkred',  __('Contrasted - Red', 'live-weather-station'));
        $result[] = array('darkamber',  __('Contrasted - Amber', 'live-weather-station'));
        $result[] = array('green-darkgreen',  __('Contrasted - Green', 'live-weather-station'));
        $result[] = array('green',  __('Contrasted - Turquoise', 'live-weather-station'));
        $result[] = array('blue-lightblue2',  __('Contrasted - Light blue', 'live-weather-station'));
        $result[] = array('blue-gray',  __('Contrasted - Blue', 'live-weather-station'));
        $result[] = array('darkblue',  __('Contrasted - Dark blue', 'live-weather-station'));
        $result[] = array('blue-lightblue',  __('Contrasted - Purple', 'live-weather-station'));
        $result[] = array('yoctopuce',  __('Contrasted - Dark purple', 'live-weather-station'));
        $result[] = array('black-yellow',  __('Contrasted - Black & Yellow', 'live-weather-station'));
        $result[] = array('black',  __('Contrasted - Black', 'live-weather-station'));
        $result[] = array('gray',  __('Contrasted - Dark grey', 'live-weather-station'));
        $result[] = array('amber',  __('Soft - Amber', 'live-weather-station'));
        $result[] = array('green-black',  __('Soft - Dark green', 'live-weather-station'));
        $result[] = array('blue-black',  __('Soft - Blue', 'live-weather-station'));
        $result[] = array('blue2',  __('Soft - Dark blue', 'live-weather-station'));
        $result[] = array('blue-darkblue',  __('Soft - Navy', 'live-weather-station'));
        $result[] = array('purple',  __('Soft - Purple', 'live-weather-station'));
        $result[] = array('darkpurple',  __('Soft - Dark purple', 'live-weather-station'));
        $result[] = array('gray-purple',  __('Soft - Grey', 'live-weather-station'));
        $result[] = array('flat-pomegranate',  __('Flat - Pomegranate', 'live-weather-station'));
        $result[] = array('flat-alizarin',  __('Flat - Alizarin', 'live-weather-station'));
        $result[] = array('flat-pumpkin',  __('Flat - Pumpkin', 'live-weather-station'));
        $result[] = array('flat-carrot',  __('Flat - Carrot', 'live-weather-station'));
        $result[] = array('flat-orange',  __('Flat - Orange', 'live-weather-station'));
        $result[] = array('flat-sunflower',  __('Flat - Sunflower', 'live-weather-station'));
        $result[] = array('flat-emerland',  __('Flat - Emerald', 'live-weather-station'));
        $result[] = array('flat-nephritis',  __('Flat - Nephritis', 'live-weather-station'));
        $result[] = array('flat-turqoise',  __('Flat - Turquoise', 'live-weather-station'));
        $result[] = array('flat-peter-river',  __('Flat - Peter river', 'live-weather-station'));
        $result[] = array('blue-black',  __('Flat - Sky', 'live-weather-station'));
        $result[] = array('flat-belize-hole',  __('Flat - Belize hole', 'live-weather-station'));
        $result[] = array('flat-amythyst',  __('Flat - Amethyst', 'live-weather-station'));
        $result[] = array('flat-wisteria',  __('Flat - Wisteria', 'live-weather-station'));
        $result[] = array('flat-wet-asphalt',  __('Flat - Wet asphalt', 'live-weather-station'));
        $result[] = array('flat-midnight-blue',  __('Flat - Midnight blue', 'live-weather-station'));
        $result[] = array('black-red',  __('Flat - Black', 'live-weather-station'));
        $result[] = array('flat-asbestos',  __('Flat - Asbestos', 'live-weather-station'));
        $result[] = array('flat-concrete',  __('Flat - Concrete', 'live-weather-station'));
        $result[] = array('flat-silver',  __('Flat - Silver', 'live-weather-station'));
        $result[] = array('flat-clouds',  __('Flat - Clouds', 'live-weather-station'));
        return $result;
    }

    /**
     * Get a human readable time zone.
     *
     * @param   string  $timezone  Standardized timezone string
     * @return  array  A human readable time zone.
     * @since    2.0.0
     */
    private function get_readable_timezone($timezone) {
        $result = str_replace('/', ' / ', $timezone);
        $result = str_replace('_', ' ', $result);
        $result = str_replace('DU', ' d\'U', $result);
        return $result;
    }

    /**
     * Get an array containing timezones names.
     *
     * @return  array  An associative array with timezones (with country breakdowns) ready to convert to a JS array.
     * @since    2.0.0
     */
    protected function get_timezones_js_array() {
        $result = [];
        $country_codes = [];
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $continue = array('BU', 'CS', 'DY', 'EU', 'HV', 'FX', 'NH', 'QO', 'RH', 'SU', 'TP', 'YU', 'ZR', 'ZZ');
        $locale = get_locale();
        for ($i=0; $i<26; $i++) {
            for ($j=0; $j<26; $j++) {
                $s = $letters[$i].$letters[$j];
                if (in_array($s, $continue)) {
                    continue;
                }
                $t = Locale::getDisplayRegion('-'.$s, $locale);
                if ($s != $t) {
                    $country_codes[] = $s;
                }
            }
        }
        foreach ($country_codes as $cc) {
            $timezones = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $cc);
            if (count($timezones) == 0) {
                switch ($cc) {
                    case 'AN':
                        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ATLANTIC);
                        break;
                    case 'CP':
                        $timezones = array('Pacific/Tahiti');
                        break;
                    case 'DG':
                        $timezones = array('Indian/Chagos');
                        break;
                    case 'EA':
                        $timezones = array('Africa/Ceuta');
                        break;
                    case 'HM':
                        $timezones = array('Antarctica/Mawson');
                        break;
                    case 'IC':
                        $timezones = array('Europe/Madrid');
                        break;
                    default: // AC, BV, SH, TA, ...
                        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::UTC);
                }
            }
            $timezone_offsets = array();
            foreach( $timezones as $timezone ) {
                $tz = new DateTimeZone($timezone);
                $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
            }
            $timezone_list = array();
            foreach( $timezone_offsets as $timezone => $offset ) {
                $offset_prefix = $offset < 0 ? '-' : '+';
                $offset_formatted = gmdate( 'H:i', abs($offset) );
                $elem = array();
                $elem[0] = $timezone;
                $elem[1] = '(UTC'.$offset_prefix.$offset_formatted.') '.$this->get_readable_timezone($timezone);
                $timezone_list[] = $elem;
            }
            $result[$cc] = $timezone_list;
        }
        return $result;
    }
}