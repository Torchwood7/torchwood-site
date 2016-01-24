<?php

/**
 * OWM collector for Live Weather Station plugin
 *
 * @since      2.0.0
 * @package    Live_Weather_Station
 * @subpackage Live_Weather_Station/includes
 * @author     Pierre Lannoy <https://pierre.lannoy.fr/>
 */

require_once(LWS_INCLUDES_DIR.'trait-owm-client.php');


class OWM_Collector {

    use OWM_Client;
}