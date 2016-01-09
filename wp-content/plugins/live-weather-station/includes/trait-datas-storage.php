<?php

/**
 * Data storage functionalities for Live Weather Station plugin
 *
 * @since      1.0.0
 * @package    Live_Weather_Station
 * @subpackage Live_Weather_Station/includes
 * @author     Pierre Lannoy <https://pierre.lannoy.fr/>
 */

trait Datas_Storage {

    /**
     *
     * @since    1.0.0
     */
    protected static function live_weather_station_datas_table() {
        return 'live_weather_station_datas';
    }

    /**
     *
     * @since    2.0.0
     */
    protected static function live_weather_station_owm_stations_table() {
        return 'live_weather_station_owm_stations';
    }

    /**
     * Creates tables for the plugin.
     *
     * @since    1.0.0
     */
    protected static function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $table_name = $wpdb->prefix.self::live_weather_station_datas_table();
        $sql = "CREATE TABLE IF NOT EXISTS ".$table_name;
        $sql .= " (device_id varchar(17) NOT NULL,";
		$sql .= " device_name varchar(60) DEFAULT '<unnamed>' NOT NULL,";
		$sql .= " module_id varchar(17) NOT NULL,";
		$sql .= " module_type varchar(10) DEFAULT '<unknown>' NOT NULL,";
		$sql .= " module_name varchar(60) DEFAULT '<unnamed>' NOT NULL,";
		$sql .= " measure_timestamp datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,";
		$sql .= " measure_type varchar(40) DEFAULT '' NOT NULL,";
		$sql .= " measure_value varchar(20) DEFAULT '' NOT NULL,";
		$sql .= " UNIQUE KEY dmm (device_id,module_id,measure_type)";
		$sql .= ") $charset_collate;";
        $wpdb->query($sql);

        $table_name = $wpdb->prefix.self::live_weather_station_owm_stations_table();
        $sql = "CREATE TABLE IF NOT EXISTS ".$table_name;
        $sql .= " ( station_id bigint(20) unsigned NOT NULL auto_increment,";
        $sql .= " station_name varchar(60) DEFAULT '' NOT NULL,";
        $sql .= " loc_city varchar(60) DEFAULT '' NOT NULL,";
        $sql .= " loc_country_code varchar(2) DEFAULT '' NOT NULL,";
        $sql .= " loc_timezone varchar(50) DEFAULT '' NOT NULL,";
        $sql .= " loc_latitude varchar(20) DEFAULT '' NOT NULL,";
        $sql .= " loc_longitude varchar(20) DEFAULT '' NOT NULL,";
        $sql .= " loc_altitude varchar(20) DEFAULT '' NOT NULL,";
        $sql .= " PRIMARY KEY (station_id)";
        $sql .= ") $charset_collate;";
        $wpdb->query($sql);
    }

    /**
     * Updates tables from previous versions.
     *
     * @since    2.0.0
     */
    protected static function update_tables() {
        global $wpdb;
        //$charset_collate = $wpdb->get_charset_collate();

        // VERSION 2.0.0
        $table_name = $wpdb->prefix.self::live_weather_station_datas_table();
        $sql = "ALTER TABLE ".$table_name." CHANGE measure_value";
        $sql .= " measure_value varchar(50) DEFAULT '' NOT NULL";
        $wpdb->query($sql);

    }

    /**
     * Truncate tables of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @static
     */
    protected static function truncate_data_table() {
        global $wpdb;
        $table_name = $wpdb->prefix.self::live_weather_station_datas_table();
        $sql = 'TRUNCATE TABLE '.$table_name;
        $wpdb->query($sql);
    }

    /**
     * Drop tables of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @static
     */
    protected static function drop_tables() {
        global $wpdb;
        $table_name = $wpdb->prefix.self::live_weather_station_datas_table();
        $sql = 'DROP TABLE '.$table_name;
        $wpdb->query($sql);
        $table_name = $wpdb->prefix.self::live_weather_station_owm_stations_table();
        $sql = 'DROP TABLE '.$table_name;
        $wpdb->query($sql);
    }

    /**
     * Update table with current value line.
     *
     * @param   string  $table_name The table to update.
     * @param   array   $value  The values to update or insert in the table
     * @since    2.0.0
     */
    private function update_table($table_name, $value) {
        global $wpdb;
        $wpdb->replace($wpdb->prefix.$table_name,$value);
    }

    /**
     * Update data table with current value line.
     *
     * @param   array   $value  The values to update or insert in the table
     * @since    1.0.0
     */
    protected function update_data_table($value) {
        $this->update_table(self::live_weather_station_datas_table(), $value);
    }

    /**
     * Update owm station table with current value line.
     *
     * @param   array   $value  The values to update or insert in the table
     * @since    2.0.0
     */
    protected function update_owm_station_table($value) {
        $this->update_table(self::live_weather_station_owm_stations_table(), $value);
    }

    /**
     * Delete some lines in a table.
     *
     * @param   string  $table_name The table to update.
     * @param   string  $field_name   The name of the field containing ids.
     * @param   array   $value  The list of id to delete.
     * @return int|false The number of rows deleted, or false on error.
     * @since    2.0.0
     */
    private function delete_table($table_name, $field_name, $value) {
        global $wpdb;
        $table_name = $wpdb->prefix . $table_name;
        $sql = "DELETE FROM ".$table_name." WHERE ".$field_name." IN (".implode(',', $value).')';
        return $wpdb->query($sql);
    }

    /**
     * Delete some owm stations.
     *
     * @param   array   $value  The values to delete from the table
     * @return int|false The number of rows deleted, or false on error.
     * @since    2.0.0
     */
    protected function delete_owm_station_table($value) {
        return $this->delete_table(self::live_weather_station_owm_stations_table(), 'station_id', $value);
    }

    /**
     * Delete some owm stations.
     *
     * @return int|false The number of rows deleted, or false on error.
     * @since    2.0.0
     */
    protected function purge_owm_from_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . self::live_weather_station_datas_table();
        $sql = "DELETE FROM ".$table_name." WHERE device_id like 'xx:%'";
        return $wpdb->query($sql);
    }
}