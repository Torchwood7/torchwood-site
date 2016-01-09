<?php

/**
 * Netatmo client for Live Weather Station plugin
 *
 * @since      1.0.0
 * @package    Live_Weather_Station
 * @subpackage Live_Weather_Station/includes
 * @author     Pierre Lannoy <https://pierre.lannoy.fr/>
 */

require_once(LWS_INCLUDES_DIR. 'netatmo_api/src/Clients/NAWSApiClient.php');
require_once(LWS_INCLUDES_DIR.'trait-dashboard-manipulation.php');

trait Netatmo_Client {
    
    use Dashboard_Manipulation;

    public $refresh_token = '';
    public $access_token = '';

    public $last_netatmo_error = '';
    public $last_netatmo_warning = '';
    protected $netatmo_client;
    protected $netatmo_datas;

    //////////////////////////////////////////////////////////////////////////////////////////////////////
    // these API keys are property of NetAtmo licensed to Pierre Lannoy, you CAN'T use them for your apps.
    // If you are thinking to develop something, get your API Keys here: https://dev.netatmo.com
    private $client_id = '561695d4cce37cd35c8b4659';
    private $client_secret = 'yfavTSFLnq5hzJxgMYBkfZdvaX04wx4WFLtqsChm8RGuv';
    //////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Connects to the Netatmo account.
     *
     * @since    2.0.0
     */
    public function authentication($login, $password) {
        $config = array();
        $config['client_id'] = $this->client_id;
        $config['client_secret'] = $this->client_secret;
        $config['scope'] = 'read_station';
        $this->netatmo_client = new NAWSApiClient($config);
        $this->netatmo_client->setVariable('username', $login);
        $this->netatmo_client->setVariable('password', $password);
        try
        {
            $tokens = $this->netatmo_client->getAccessToken();
            update_option('live_weather_station_netatmo_account', array($tokens['refresh_token'], $tokens['access_token'], true));
        }
        catch (Exception $ex) {
            $this->last_netatmo_error = __('Wrong credentials. Please, verify your login and password.', 'live-weather-station');
            update_option('live_weather_station_netatmo_account', array('', '', false));
            return false;
        }
        return true;
    }

    /**
     * Store station's datas.
     *
     * @since    1.0.0
     */
    private function store_netatmo_datas() {
        $datas = $this->netatmo_datas ;
        foreach($datas['devices'] as $device){
            $this->get_netatmo_dashboard($device['_id'], $device['station_name'], $device['_id'], $device['module_name'],
                $device['type'], $device['data_type'], $device['dashboard_data'], $device['place'], $device['wifi_status'], $device['firmware']);
            foreach($device['modules'] as $module)
            {
                $this->get_netatmo_dashboard($device['_id'], $device['station_name'], $module['_id'], $module['module_name'],
                    $module['type'], $module['data_type'], $module['dashboard_data'], null, $module['rf_status'], $module['firmware'], $module['battery_vp']);
            }
        }
    }


    /**
     * Get station's datas.
     *
     * @return  array     The netatmo collected datas.
     * @since    1.0.0
     */
    public function get_datas() {
        if (get_option('live_weather_station_owm_account')[1] == 2) {
            $this->netatmo_datas = array ();
            return array();
        }
        $refresh_token = get_option('live_weather_station_netatmo_account')[0];
        $access_token = get_option('live_weather_station_netatmo_account')[1];
        $this->last_netatmo_error = '';
        $this->last_netatmo_warning = '';
        if ($refresh_token != '' && $access_token != '') {
            if (!isset($this->netatmo_client)) {
                $config = array();
                $config['client_id'] = $this->client_id;
                $config['client_secret'] = $this->client_secret;
                $config['scope'] = 'read_station';
                $config['refresh_token'] = $refresh_token;
                $config['access_token'] = $access_token;
                $this->netatmo_client = new NAWSApiClient($config);
            }
            try {
                $this->netatmo_datas = $this->netatmo_client->getData();
                $this->store_netatmo_datas();
                update_option('live_weather_station_netatmo_account', array($this->netatmo_client->getRefreshToken(), $this->netatmo_client->getAccessToken(), true));
            }
            catch (Exception $ex) {
                switch ($ex->getCode()) {
                    case 2:
                    case 23:
                    case 32:
                        $this->last_netatmo_error = __('Wrong credentials. Please, verify your login and password.', 'live-weather-station');
                        update_option('live_weather_station_netatmo_account', array('', '', false));
                        break;
                    case 5:
                    case 22:
                        $this->last_netatmo_error = __('Application deactivated. Please contact support.', 'live-weather-station');
                        break;
                    case 20:
                        $this->last_netatmo_error = __('Too many users with this IP.', 'live-weather-station');
                        break;
                    default:
                        $this->last_netatmo_warning = __('Temporary unable to contact Netatmo servers. Retry will be done shortly.', 'live-weather-station');
                }
                return array();
            }
        }
        return $this->netatmo_datas;
    }
}