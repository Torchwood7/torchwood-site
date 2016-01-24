<?php
/**
 * @package    Live_Weather_Station
 * @subpackage Live_Weather_Station/admin/partials
 * @author     Pierre Lannoy <https://pierre.lannoy.fr/>
 * @since      1.0.0
 */
?>
<div id="normal-sortables" class="meta-box-sortables ui-sortable">
    <div id="referrers" class="postbox ">
        <div class="handlediv" title="<?php echo __('Click to toggle', 'live-weather-station'); ?>"><br></div>
        <h3 class="hndle"><span><?php esc_html_e('Options', 'live-weather-station');?></span></h3>
        <form name="lws_conf" id="lws-conf" action="<?php echo esc_url( $this->get_page_url() ); ?>" method="POST">
            <div class="inside">
                <table cellspacing="0" class="lws-settings">
                    <tbody>
                    <tr>
                        <th class="lws-option" width="35%" align="left" scope="row"><?php esc_html_e('Collected data', 'live-weather-station');?></th>
                        <td width="2%"/>
                        <td align="left">
                            <span class="select-option">
                                <select class="option-at-100" name="mode">
                                    <?php foreach ($mode_options as $key => $val) { ?>
                                        <option value="<?php echo $key ?>"<?php if (get_option('live_weather_station_owm_account')[1]==$key):?> selected="selected"<?php endif;?>><?php echo $val ?></option>;
                                    <?php } ?>
                                </select>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="lws-option" width="35%" align="left" scope="row"><?php esc_html_e('Live controls displays', 'live-weather-station');?></th>
                        <td width="2%"/>
                        <td align="left">
                            <span class="select-option">
                                <select class="option-at-100" name="viewing-options">
                                    <?php foreach ($viewing_options as $key => $val) { ?>
                                        <option value="<?php echo $key ?>"<?php if (get_option('live_weather_station_settings')[3]==$key):?> selected="selected"<?php endif;?>><?php echo $val ?></option>;
                                    <?php } ?>
                                </select>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="lws-option" width="35%" align="left" scope="row"><?php esc_html_e('Data obsolescence', 'live-weather-station');?></th>
                        <td width="2%"/>
                        <td align="left">
                            <span class="select-option">
                                <select class="option-at-100" name="obsolescence">
                                    <?php foreach ($obsolescence as $key => $val) { ?>
                                        <option value="<?php echo $key ?>"<?php if (get_option('live_weather_station_settings')[6]==$key):?> selected="selected"<?php endif;?>><?php echo $val ?></option>;
                                    <?php } ?>
                                </select>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="lws-option" width="35%" align="left" scope="row"><?php esc_html_e('Gauges boundaries', 'live-weather-station');?></th>
                        <td width="2%"/>
                        <td align="left">
                            <span class="select-option">
                                <select class="option-at-100" name="minmax">
                                    <?php foreach ($minmax as $key => $val) { ?>
                                        <option value="<?php echo $key ?>"<?php if (get_option('live_weather_station_settings')[7]==$key):?> selected="selected"<?php endif;?>><?php echo $val ?></option>;
                                    <?php } ?>
                                </select>
                            </span>
                        </td>
                    </tr>
                    <?php /*
                    </tbody>
                </table>
                    <hr />
                <table cellspacing="0" class="lws-settings">
                    <tbody>
                    */ ?>
                    <tr>
                        <th class="lws-option" width="35%" align="left" scope="row"><?php esc_html_e('Temperature unit', 'live-weather-station');?></th>
                        <td width="2%"/>
                        <td align="left">
                            <span class="select-option">
                                <select class="option-at-100" name="temperature-unit">
                                    <?php foreach ($temperature as $key => $val) { ?>
                                        <option value="<?php echo $key ?>"<?php if (get_option('live_weather_station_settings')[0]==$key):?> selected="selected"<?php endif;?>><?php echo $val ?></option>;
                                    <?php } ?>
                                </select>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="lws-option" width="35%" align="left" scope="row"><?php esc_html_e('Pressure unit', 'live-weather-station');?></th>
                        <td width="2%"/>
                        <td align="left">
                            <span class="select-option">
                                <select class="option-at-100" name="pressure-unit">
                                    <?php foreach ($pressure as $key => $val) { ?>
                                        <option value="<?php echo $key ?>"<?php if (get_option('live_weather_station_settings')[1]==$key):?> selected="selected"<?php endif;?>><?php echo $val ?></option>;
                                    <?php } ?>
                                </select>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="lws-option" width="35%" align="left" scope="row"><?php esc_html_e('Windspeed unit', 'live-weather-station');?></th>
                        <td width="2%"/>
                        <td align="left">
                            <span class="select-option">
                                <select class="option-at-100" name="wind-unit">
                                    <?php foreach ($wind as $key => $val) { ?>
                                        <option value="<?php echo $key ?>"<?php if (get_option('live_weather_station_settings')[2]==$key):?> selected="selected"<?php endif;?>><?php echo $val ?></option>;
                                    <?php } ?>
                                </select>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="lws-option" width="35%" align="left" scope="row"><?php esc_html_e('Altitude unit', 'live-weather-station');?></th>
                        <td width="2%"/>
                        <td align="left">
                            <span class="select-option">
                                <select class="option-at-100" name="altitude-unit">
                                    <?php foreach ($altitude as $key => $val) { ?>
                                        <option value="<?php echo $key ?>"<?php if (get_option('live_weather_station_settings')[4]==$key):?> selected="selected"<?php endif;?>><?php echo $val ?></option>;
                                    <?php } ?>
                                </select>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="lws-option" width="35%" align="left" scope="row"><?php esc_html_e('Distance unit', 'live-weather-station');?></th>
                        <td width="2%"/>
                        <td align="left">
                            <span class="select-option">
                                <select class="option-at-100" name="distance-unit">
                                    <?php foreach ($distance as $key => $val) { ?>
                                        <option value="<?php echo $key ?>"<?php if (get_option('live_weather_station_settings')[5]==$key):?> selected="selected"<?php endif;?>><?php echo $val ?></option>;
                                    <?php } ?>
                                </select>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div id="major-publishing-actions">
                <div id="publishing-action">
                    <input type="hidden" name="action" value="set-values">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'live-weather-station');?>">
                </div>
                <div class="clear"></div>
            </div>
        </form>
    </div>
</div>