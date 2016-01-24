<?php

/**
 * Types descriptions functionalities for Live Weather Station plugin
 *
 * @since      1.0.0
 * @package    Live_Weather_Station
 * @subpackage Live_Weather_Station/includes
 * @author     Pierre Lannoy <https://pierre.lannoy.fr/>
 */

trait Type_Description {
    /**
     * Get the module type in plain text.
     *
     * @param   string  $type The type of the module.
     * @return  string  The type of the module in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_module_type($type) {
        switch (strtolower($type)) {
            case 'namain':
                $result = __('Base station', 'live-weather-station');
                break;
            case 'namodule1': // Outdoor module
                $result = __('Outdoor module', 'live-weather-station');
                break;
            case 'namodule3': // Rain gauge
                $result = __('Rain gauge', 'live-weather-station');
                break;
            case 'namodule2': // Wind gauge
                $result = __('Wind gauge', 'live-weather-station');
                break;
            case 'namodule4': // Additional indoor module
                $result = __('Indoor module', 'live-weather-station');
                break;
            case 'nacomputed': // Computed values virtual module
                $result = __('[Computed Values]', 'live-weather-station');
                break;
            case 'nacurrent': // Current weather (from OWM) virtual module
                $result = __('[OpenWeatherMap Records]', 'live-weather-station');
                break;
            case 'naephemer': // Current weather (from OWM) virtual module
                $result = __('[Ephemeris]', 'live-weather-station');
                break;
            default:
                $result = __('Unknonw module', 'live-weather-station');
        }
        return $result;
    }

    /**
     * Get the measurement type in plain text.
     *
     * @param   string $type    The type of the measurement.
     * @return  string  The type of the measurement in plain text.
     * @since    1.0.0
     * @access   protected
     */
    protected function get_measurement_type ($type) {
        switch (strtolower($type)) {
            case 'firmware':
                $result = __('Firmware version', 'live-weather-station');
                break;
            case 'battery':
                $result = __('Battery level', 'live-weather-station');
                break;
            case 'signal':
                $result = __('RF/WiFi signal quality', 'live-weather-station');
                break;
            case 'co2':
                $result = __('C02 level', 'live-weather-station');
                break;
            case 'humidity':
                $result = __('Humidity', 'live-weather-station');
                break;
            case 'humidity_ref':
                $result = __('Reference humidity', 'live-weather-station');
                break;
            case 'noise':
                $result = __('Noise level', 'live-weather-station');
                break;
            case 'pressure':
                $result = __('Atmospheric pressure', 'live-weather-station');
                break;
            case 'pressure_trend':
                $result = __('Pressure trend', 'live-weather-station');
                break;
            case 'temperature':
                $result = __('Temperature', 'live-weather-station');
                break;
            case 'temperature_ref':
                $result = __('Reference temperature', 'live-weather-station');
                break;
            case 'wind_ref':
                $result = __('Reference wind strength', 'live-weather-station');
                break;
            case 'temperature_max':
            case 'max_temp':
                $result = __('Highest temperature of the day', 'live-weather-station');
                break;
            case 'temperature_min':
            case 'min_temp':
                $result = __('Lowest temperature of the day', 'live-weather-station');
                break;
            case 'temperature_trend':
            case 'temp_trend':
                $result = __('Temperature trend', 'live-weather-station');
                break;
            case 'dew_point':
                $result = __('Dew point', 'live-weather-station');
                break;
            case 'frost_point':
                $result = __('Frost point', 'live-weather-station');
                break;
            case 'heat_index':
                $result = __('Heat index', 'live-weather-station');
                break;
            case 'humidex':
                $result = __('Humidex', 'live-weather-station');
                break;
            case 'wind_chill':
                $result = __('Wind chill', 'live-weather-station');
                break;
            case 'cloud_ceiling':
                $result = __('Cloud base altitude', 'live-weather-station');
                break;
            case 'cloudcover':
            case 'cloud_cover':
            case 'cloudiness':
                $result = __('Cloudiness', 'live-weather-station');
                break;
            case 'rain':
                $result = __('Rainfall', 'live-weather-station');
                break;
            case 'snow':
                $result = __('Snowfall', 'live-weather-station');
                break;
            case 'rain_hour_aggregated':
            case 'sum_rain_1':
                $result = __('Accumulated rainfall for the last hour', 'live-weather-station');
                break;
            case 'rain_day_aggregated':
            case 'sum_rain_24':
                $result = __('Accumulated rainfall for today', 'live-weather-station');
                break;
            case 'windangle':
                $result = __('Wind direction', 'live-weather-station');
                break;
            case 'windstrength':
                $result = __('Wind strength', 'live-weather-station');
                break;
            case 'gustangle':
                $result = __('Gust direction', 'live-weather-station');
                break;
            case 'guststrength':
                $result = __('Gust strength', 'live-weather-station');
                break;
            case 'windangle_max':
            case 'max_wind_angle':
                $result = __('Wind direction for the maximal wind strength for the last hour', 'live-weather-station');
                break;
            case 'windstrength_max':
            case 'max_wind_str':
                $result = __('Maximal wind strength for the last hour', 'live-weather-station');
                break;
            case 'loc_altitude':
            case 'altitude':
                $result = __('Altitude', 'live-weather-station');
                break;
            case 'loc_latitude':
            case 'latitude':
                $result = __('Latitude', 'live-weather-station');
                break;
            case 'loc_longitude':
            case 'longitude':
                $result = __('Longitude', 'live-weather-station');
                break;
            case 'loc_timezone':
            case 'timezone':
                $result = __('Time zone', 'live-weather-station');
                break;
            case 'aggregated':
                $result = __('[all measures]', 'live-weather-station');
                break;
            case 'outdoor':
                $result = __('[outdoor measures]', 'live-weather-station');
                break;
            case 'sunrise':
                $result = __('Sunrise', 'live-weather-station');
                break;
            case 'sunset':
                $result = __('Sunset', 'live-weather-station');
                break;
            case 'moonrise':
                $result = __('Moonrise', 'live-weather-station');
                break;
            case 'moonset':
                $result = __('Moonset', 'live-weather-station');
                break;
            case 'moon_age':
                $result = __('Moon age', 'live-weather-station');
                break;
            case 'moon_phase':
                $result = __('Moon phase', 'live-weather-station');
                break;
            case 'moon_illumination':
                $result = __('Moon illumination', 'live-weather-station');
                break;
            case 'moon_distance':
                $result = __('Moon distance', 'live-weather-station');
                break;
            case 'moon_diameter':
                $result = __('Moon angular size', 'live-weather-station');
                break;
            case 'sun_distance':
                $result = __('Sun distance', 'live-weather-station');
                break;
            case 'sun_diameter':
                $result = __('Sun angular size', 'live-weather-station');
                break;
            default:
                $result = __('Unknown measurement', 'live-weather-station');
        }
        return $result;
    }
}







