<?php

/**
 * Units descriptions functionalities for Live Weather Station plugin
 *
 * @since      1.0.0
 * @package    Live_Weather_Station
 * @subpackage Live_Weather_Station/includes
 * @author     Pierre Lannoy <https://pierre.lannoy.fr/>
 */

trait Unit_Description {
    /**
     * Get available humidity units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_humidity_unit( $id = 0 ) {
        return __( '%' , 'live-weather-station');
    }

    /**
     * Get available moon illumination units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    2.0.0
     */
    protected function get_moon_illumination_unit( $id = 0 ) {
        return __( '%' , 'live-weather-station');
    }

    /**
     * Get available degree diameter units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    2.0.0
     */
    protected function get_degree_diameter_unit( $id = 0 ) {
        return __( '°' , 'live-weather-station');
    }

    /**
     * Get available cloudiness units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    2.0.0
     * @access   protected
     */
    protected function get_cloudiness_unit( $id = 0 ) {
        return __( '%' , 'live-weather-station');
    }

    /**
     * Get available battery level units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_battery_unit( $id = 0 ) {
        return __( '%' , 'live-weather-station');
    }

    /**
     * Get available signal level units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_signal_unit( $id = 0 ) {
        return __( '%' , 'live-weather-station');
    }

    /**
     * Get available rain units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_rain_unit( $id = 0 ) {
        return __( 'mm' , 'live-weather-station');
    }

    /**
     * Get available snow units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    2.0.0
     * @access   protected
     */
    protected function get_snow_unit( $id = 0 ) {
        switch ($id) {
            case 1:
                $result =  __( 'mm' , 'live-weather-station');
                break;
            default:
                $result = __( 'cm' , 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get available noise units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_noise_unit( $id = 0 ) {
        return __( 'dB' , 'live-weather-station');
    }

    /**
     * Get available CO2 units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_co2_unit( $id = 0 ) {
        return __( 'ppm' , 'live-weather-station');
    }

    /**
     * Get available wind direction units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_wind_angle_unit( $id = 0 ) {
        return __( '°' , 'live-weather-station');
    }

    /**
     * Get available pressure units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_pressure_unit( $id = 0 ) {
        switch ($id) {
            case 1:
                $result = __( 'inHg' , 'live-weather-station');
                break;
            case 2:
                $result = __( 'mmHg' , 'live-weather-station');
                break;
            default:
                $result = __( 'hPa' , 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get available temperature units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_temperature_unit( $id = 0 ) {
        switch ($id) {
            case 1:
                $result = __( '°F' , 'live-weather-station');
                break;
            default:
                $result = __( '°C' , 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get available pressure units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_wind_speed_unit( $id = 0 ) {
        switch ($id) {
            case 1:
                $result = __( 'mph' , 'live-weather-station');
                break;
            case 2:
                $result = __( 'm/s' , 'live-weather-station');
                break;
            case 3:
                $result = __( 'bf' , 'live-weather-station');
                break;
            case 4:
                $result = __( 'kts' , 'live-weather-station');
                break;
            default:
                $result = __( 'km/h' , 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get available altitude units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    1.1.0
     * @access   protected
     */
    protected function get_altitude_unit( $id = 0 ) {
        switch ($id) {
            case 1:
                $result = __( 'ft' , 'live-weather-station');
                break;
            default:
                $result = __( 'm' , 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get available distance units.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit in plain text.
     * @since    1.1.0
     * @access   protected
     */
    protected function get_distance_unit( $id = 0 ) {
        switch ($id) {
            case 1:
                $result = __( 'mi' , 'live-weather-station');
                break;
            default:
                $result = __( 'km' , 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get available pressure units names.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit name in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_pressure_unit_name( $id = 0 ) {
        switch ($id) {
            case 1:
                $result = __( 'inHg' , 'live-weather-station');
                break;
            case 2:
                $result = __( 'mmHg' , 'live-weather-station');
                break;
            default:
                $result = __( 'hPa / mbar' , 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get available temperature units names.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit name in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_temperature_unit_name( $id = 0 ) {
        switch ($id) {
            case 1:
                $result = __( 'Fahrenheit - °F' , 'live-weather-station');
                break;
            default:
                $result = __( 'Celcius - °C' , 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get available altitude units names.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit name in plain text.
     * @since    1.2.0
     * @access   protected
     */
    protected function get_altitude_unit_name( $id = 0 ) {
        switch ($id) {
            case 1:
                $result = __( 'Imperial system' , 'live-weather-station');
                break;
            default:
                $result = __( 'Metric system' , 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get available distance units names.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit name in plain text.
     * @since    2.0.0
     * @access   protected
     */
    protected function get_distance_unit_name( $id = 0 ) {
        switch ($id) {
            case 1:
                $result = __( 'Imperial system' , 'live-weather-station');
                break;
            default:
                $result = __( 'Metric system' , 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get available wind speed units names.
     *
     * @param   integer $id     Optional. The unit id.
     * @return  string  The unit name in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_wind_speed_unit_name( $id = 0 ) {
        switch ($id) {
            case 1:
                $result = __( 'mph' , 'live-weather-station');
                break;
            case 2:
                $result = __( 'm/s' , 'live-weather-station');
                break;
            case 3:
                $result = __( 'Beaufort' , 'live-weather-station');
                break;
            case 4:
                $result = __( 'Knot' , 'live-weather-station');
                break;
            default:
                $result = __( 'km/h' , 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get temperatures unit names.
     *
     * @return  array   An array containing the available temperature units names.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_temperature_unit_name_array() {
        $result = array();
        for ($i = 0; $i <= 1; $i++) {
            $result[$i] = $this->get_temperature_unit_name($i);
        }
        return $result;
    }

    /**
     * Get pressures unit names.
     *
     * @return  array   An array containing the available pressures units names.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_pressure_unit_name_array() {
        $result = array();
        for ($i = 0; $i <= 2; $i++) {
            $result[$i] = $this->get_pressure_unit_name($i);
        }
        return $result;
    }

    /**
     * Get wind speeds unit names.
     *
     * @return  array   An array containing the available wind speed units names.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_wind_speed_unit_name_array() {
        $result = array();
        for ($i = 0; $i <= 4; $i++) {
            $result[$i] = $this->get_wind_speed_unit_name($i);
        }
        return $result;
    }

    /**
     * Get altitude unit names.
     *
     * @return  array   An array containing the available altitude units names.
     * @since    1.2.0
     * @access   protected
     */
    protected function get_altitude_unit_name_array() {
        $result = array();
        for ($i = 0; $i <= 1; $i++) {
            $result[$i] = $this->get_altitude_unit_name($i);
        }
        return $result;
    }

    /**
     * Get distance unit names.
     *
     * @return  array   An array containing the available distance units names.
     * @since    2.0.0
     * @access   protected
     */
    protected function get_distance_unit_name_array() {
        $result = array();
        for ($i = 0; $i <= 1; $i++) {
            $result[$i] = $this->get_distance_unit_name($i);
        }
        return $result;
    }

    /**
     * Get viewing options.
     *
     * @return  array   An array containing the available viewing options.
     * @since    1.1.0
     * @access   protected
     */
    protected function get_viewing_options_array() {
        $result = array();
        $result[0] = __( 'Measured and computed values' , 'live-weather-station');
        $result[1] = __( 'Only measured values' , 'live-weather-station');
        return $result;
    }

    /**
     * Get mode options.
     *
     * @return  array   An array containing the available mode options.
     * @since    2.0.0
     * @access   protected
     */
    protected function get_mode_options_array() {
        $result = array();
        $result[0] = __( 'Netatmo and OpenWeatherMap' , 'live-weather-station');
        $result[1] = __( 'Only Netatmo' , 'live-weather-station');
        $result[2] = __( 'Only OpenWeatherMap' , 'live-weather-station');
        return $result;
    }

    /**
     * Get obsolescence values.
     *
     * @return  array   An array containing the available obsolescence values.
     * @since    2.0.0
     * @access   protected
     */
    protected function get_obsolescence_array() {
        $result = array();
        $result[0] = __( 'Never' , 'live-weather-station');
        $result[1] = __( 'After 30 minutes' , 'live-weather-station');
        $result[2] = __( 'After 1 hour' , 'live-weather-station');
        $result[3] = __( 'After 2 hours' , 'live-weather-station');
        $result[4] = __( 'After 4 hours' , 'live-weather-station');
        $result[5] = __( 'After 12 hours' , 'live-weather-station');
        $result[6] = __( 'After 24 hours' , 'live-weather-station');
        return $result;
    }
}