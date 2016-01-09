<?php

/**
 * Schedules & cron manipulation functionalities for Live Weather Station plugin
 *
 * @since      1.0.0
 * @package    Live_Weather_Station
 * @subpackage Live_Weather_Station/includes
 * @author     Pierre Lannoy <https://pierre.lannoy.fr/>
 */

trait Schedules_Manipulation {

    protected static $netatmo_update_schedule_name = 'lws_netatmo_update';
    protected static $owm_update_schedule_name = 'lws_owm_update';


    /**
     * Delete schedules.
     *
     * @since    1.0.0
     */
    protected static function delete_schedules() {
        wp_clear_scheduled_hook(self::$netatmo_update_schedule_name);
        wp_clear_scheduled_hook(self::$owm_update_schedule_name);
    }

    /**
     * Init schedules.
     *
     * @since    2.0.0
     */
    protected static function init_schedules() {
        wp_schedule_event(time() + 30, 'ten_minutes', self::$netatmo_update_schedule_name);
        wp_schedule_event(time() + 30, 'fifteen_minutes', self::$owm_update_schedule_name);
        /*if (get_option('live_weather_station_netatmo_account')[2] && (get_option('live_weather_station_owm_account')[1] != 2)) {
            wp_schedule_event(time() + 30, 'ten_minutes', self::$netatmo_update_schedule_name);
        }
        if ((get_option('live_weather_station_owm_account')[0] != '') && (get_option('live_weather_station_owm_account')[1] != 1)) {
            wp_schedule_event(time() + 30, 'fifteen_minutes', self::$owm_update_schedule_name);
        }*/
    }

    /**
     * Re-init schedules.
     *
     * @since    2.0.0
     */
    protected static function reinit_schedules() {
        self::delete_schedules();
        self::init_schedules();
    }

    /**
     * Add a new 10 minutes interval capacity to the WP cron feature
     *
     * @since    1.0.0
     */
    public static function add_cron_10_minutes_interval( $schedules ) {
        $schedules['ten_minutes'] = array(
            'interval' => 600,
            'display'  => __( 'Every ten minutes', 'live' ),
        );
        return $schedules;
    }

    /**
     * Add a new 15 minutes interval capacity to the WP cron feature
     *
     * @since    2.0.0
     */
    public static function add_cron_15_minutes_interval( $schedules ) {
        $schedules['fifteen_minutes'] = array(
            'interval' => 900,
            'display'  => __( 'Every fifteen minutes', 'live' ),
        );
        return $schedules;
    }
}