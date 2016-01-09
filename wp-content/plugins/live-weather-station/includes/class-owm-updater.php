<?php

/**
 * This class is responsible for all the croned updates from OpenWeatherMap data.
 *
 * @since      2.0.0
 * @package    Live_Weather_Station
 * @subpackage Live_Weather_Station/includes
 * @author     Pierre Lannoy <https://pierre.lannoy.fr/>
 */

require_once(LWS_INCLUDES_DIR.'trait-owm-client.php');
require_once(LWS_INCLUDES_DIR.'class-weather-computer.php');
require_once(LWS_INCLUDES_DIR.'class-ephemeris-computer.php');

class Owm_Updater {

    use Owm_Client;

    private $Live_Weather_Station;
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    2.0.0
     * @param      string    $Live_Weather_Station       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     * @access   public
     */
    public function __construct( $Live_Weather_Station, $version ) {
        $this->Live_Weather_Station = $Live_Weather_Station;
        $this->version = $version;
    }

    /**
     * Do the main job.
     *
     * @since    2.0.0
     * @access   public
     */
    public function cron_run(){
        try {
            $this->get_datas();
            $weather = new Weather_Computer();
            $weather->compute();
            $ephemeris = new Ephemeris_Computer();
            $ephemeris->compute();
        }
        catch (Exception $ex) {
            error_log(LWS_PLUGIN_NAME . ' / ' . LWS_VERSION . ' / OWM Updater / Error code: ' . $ex->getCode() . ' / Error message: ' . $ex->getMessage());
        }
    }
}