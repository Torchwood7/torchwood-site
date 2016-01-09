<?php

/**
 * OpenWeatherMap client for Live Weather Station plugin
 *
 * @since      2.0.0
 * @package    Live_Weather_Station
 * @subpackage Live_Weather_Station/includes
 * @author     Pierre Lannoy <https://pierre.lannoy.fr/>
 */

require_once(LWS_INCLUDES_DIR. 'owm_api/Cmfcmf/OpenWeatherMap.php');
require_once(LWS_INCLUDES_DIR. 'owm_api/Cmfcmf/OpenWeatherMap/Exception.php');
require_once(LWS_INCLUDES_DIR. 'owm_api/Cmfcmf/OpenWeatherMap/CurrentWeather.php');
require_once(LWS_INCLUDES_DIR. 'owm_api/Cmfcmf/OpenWeatherMap/Fetcher/FetcherInterface.php');
require_once(LWS_INCLUDES_DIR. 'owm_api/Cmfcmf/OpenWeatherMap/Fetcher/CurlFetcher.php');
require_once(LWS_INCLUDES_DIR. 'owm_api/Cmfcmf/OpenWeatherMap/Fetcher/FileGetContentsFetcher.php');
require_once(LWS_INCLUDES_DIR. 'owm_api/Cmfcmf/OpenWeatherMap/Util/City.php');
require_once(LWS_INCLUDES_DIR. 'owm_api/Cmfcmf/OpenWeatherMap/Util/Sun.php');
require_once(LWS_INCLUDES_DIR. 'owm_api/Cmfcmf/OpenWeatherMap/Util/Temperature.php');
require_once(LWS_INCLUDES_DIR. 'owm_api/Cmfcmf/OpenWeatherMap/Util/Time.php');
require_once(LWS_INCLUDES_DIR. 'owm_api/Cmfcmf/OpenWeatherMap/Util/Unit.php');
require_once(LWS_INCLUDES_DIR. 'owm_api/Cmfcmf/OpenWeatherMap/Util/Weather.php');
require_once(LWS_INCLUDES_DIR. 'owm_api/Cmfcmf/OpenWeatherMap/Util/Wind.php');
require_once(LWS_INCLUDES_DIR.'trait-dashboard-manipulation.php');
require_once(LWS_INCLUDES_DIR.'trait-id-manipulation.php');

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

trait Owm_Client {

    use Dashboard_Manipulation, Id_Manipulation;

    public $last_owm_error = '';
    public $last_owm_warning = '';
    protected $owm_client;
    protected $owm_datas;

    /**
     * Get station's datas.
     *
     * @param   string  $city       The city name.
     * @param   string  $country    The country ISO-2 code.
     * @return  array     An array containing lat & lon coordinates.
     * @since    2.0.0
     */
    public static function get_coordinates_via_owm($city, $country) {
        $result = array() ;
        $owm = new OpenWeatherMap();
        $weather = $owm->getRawWeatherData($city.','.$country, 'metric', 'en', get_option('live_weather_station_owm_account')[0], 'json');
        $weather = json_decode($weather, true);
        if (is_array($weather)) {
            if (array_key_exists('coord', $weather)) {
                $result['loc_longitude'] = $weather['coord']['lon'];
                $result['loc_latitude'] = $weather['coord']['lat'];
            }
        }
        return $result;
    }

    /**
     * Synchronize main table with station table.
     *
     * @since    2.0.0
     */
    protected function synchronize_owm() {
        $this->purge_owm_from_table();
        $stations = $this->get_all_owm_stations();
        if (count($stations) > 0) {
            foreach ($stations as $station) {
                $device_id = self::get_unique_owm_id($station['station_id']);
                $updates = array() ;
                $updates['device_id'] = $device_id;
                $updates['device_name'] = $station['station_name'];
                $updates['module_id'] = $device_id;
                $updates['module_type'] = 'NAMain';
                $updates['module_name'] = $station['station_name'];
                $updates['measure_timestamp'] = date('Y-m-d H:i:s');
                $updates['measure_type'] = 'loc_altitude';
                $updates['measure_value'] = $station['loc_altitude'];
                $this->update_data_table($updates);
                $updates['measure_type'] = 'loc_latitude';
                $updates['measure_value'] = $station['loc_latitude'];
                $this->update_data_table($updates);
                $updates['measure_type'] = 'loc_longitude';
                $updates['measure_value'] = $station['loc_longitude'];
                $this->update_data_table($updates);
                $updates['measure_type'] = 'loc_timezone';
                $updates['measure_value'] = $station['loc_timezone'];
                $this->update_data_table($updates);
            }
        }
    }

    /**
     * Store station's datas.
     *
     * @since    2.0.0
     */
    private function store_owm_datas() {
        $datas = $this->owm_datas ;
        foreach ($datas as $data) {
            $this->get_dashboard($data['device_id'], $data['device_name'], $data['_id'], $data['module_name'],
                $data['type'], $data['data_type'], $data['dashboard_data']);
        }
    }

    /**
     * Get station's data array.
     *
     * @param   string  $json_weather    Weather array json formated.
     * @param   array   $station    Station array.
     * @param   string  $device_id  The device id.
     * @return  array     A standard array with value.
     * @throws  exception
     * @since    2.0.0
     */
    private function get_owm_datas_array($json_weather, $station, $device_id) {
        $weather = json_decode($json_weather, true);
        if (!is_array($weather)) {
            throw new Exception((string)$json_weather);
        }
        $result = array() ;
        $result['device_id'] = $device_id;
        $result['device_name'] = $station['device_name'];
        $result['_id'] = self::get_owm_virtual_id($device_id);
        $result['type'] = 'NACurrent';
        $result['module_name'] = __('[OpenWeatherMap Records]', 'live-weather-station');
        $result['battery_vp'] = 6000;
        $result['rf_status'] = 0;
        $result['firmware'] = LWS_VERSION;
        $dashboard = array() ;
        $dashboard['time_utc'] = $weather['dt'];
        $dashboard['weather'] = $weather['weather'][0]['id'];
        $dashboard['temperature'] = $weather['main']['temp'];
        $dashboard['pressure'] = $weather['main']['pressure'];
        $dashboard['humidity'] = $weather['main']['humidity'];
        if (array_key_exists('wind', $weather) && isset($weather['wind']['deg']) && isset($weather['wind']['speed'])) {
            $dashboard['windangle'] = round($weather['wind']['deg']);
            $dashboard['windstrength'] = round($weather['wind']['speed'] * 3.6);
        }
        else {
            $dashboard['windangle'] = 0;
            $dashboard['windstrength'] = 0;
        }
        if (array_key_exists('rain', $weather) && isset($weather['rain']['3h'])) {
            $dashboard['rain'] = $weather['rain']['3h'];
        }
        else {
            $dashboard['rain'] = 0;
        }
        if (array_key_exists('snow', $weather) && isset($weather['snow']['3h'])) {
            $dashboard['snow'] = $weather['snow']['3h'];
        }
        else {
            $dashboard['snow'] = 0;
        }
        if (array_key_exists('clouds', $weather) && isset($weather['clouds']['all'])) {
            $dashboard['cloudiness'] = $weather['clouds']['all'];
        }
        else {
            $dashboard['cloudiness'] = 0;
        }
        $dashboard['sunrise'] = $weather['sys']['sunrise'];
        $dashboard['sunset'] = $weather['sys']['sunset'];
        $now = time();
        if ($dashboard['sunrise'] < $now && $dashboard['sunset'] > $now) {
            $dashboard['is_day'] = 1;
        }
        else {
            $dashboard['is_day'] = 0;
        }

        $result['dashboard_data'] = $dashboard;
        $result['data_type'] = array('weather', 'temperature','pressure', 'humidity', 'windstrength', 'windangle', 'rain', 'snow', 'cloudiness', 'sunrise', 'sunset', 'is_day');
        return $result;
    }
    /**
     * Get station's datas.
     *
     * @return  array     OWM collected datas.
     * @since    2.0.0
     */
    public function get_datas() {
        $this->last_owm_warning = '';
        $this->last_owm_error = '';
        if (get_option('live_weather_station_owm_account')[1] == 1 || get_option('live_weather_station_owm_account')[0] == '') {
            $this->owm_datas = array ();
            return array ();
        }
        try
        {
            $this->synchronize_owm();
            $this->owm_datas = array ();
            $stations = $this->get_located_stations_list();
            $owm = new OpenWeatherMap();
            foreach ($stations as $key => $station) {
                $values = $this->get_owm_datas_array($owm->getRawWeatherData(array('lat' => $station['loc_latitude'], 'lon' => $station['loc_longitude']), 'metric', 'en', get_option('live_weather_station_owm_account')[0], 'json'), $station, $key);
                if (isset($values) && is_array($values)) {
                    $this->owm_datas[] = $values;
                }
            }
            $this->store_owm_datas();
        }
        catch(Exception $ex)
        {
            if (strpos($ex->getMessage(), 'Invalid API key') > -1) {
                $this->last_owm_error = __('Wrong OpenWeatherMap API key.', 'live-weather-station');
            }
            else {
                $this->last_owm_warning = __('Temporary unable to contact OpenWeatherMap servers. Retry will be done shortly.', 'live-weather-station');
            }
            return array();
        }

        return $this->owm_datas;
    }
}