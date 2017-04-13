<?php
/*
Plugin Name: NEXUS Ticketing System
Plugin URI:  http://nexus.jamespark.ninja
Description: The central hub for request and ticket management - Community Edition
Version:     2.0
Author:      JamesPark.ninja
Author URI:  http://jamespark.ninja/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: nexus
Domain Path: /languages
*/

// Create a helper function for easy SDK access.
function nex_fs() {
    global $nex_fs;

    if ( ! isset( $nex_fs ) ) {
        // Include Freemius SDK.
        require_once dirname(__FILE__) . '/freemius/start.php';

        $nex_fs = fs_dynamic_init( array(
            'id'                  => '817',
            'slug'                => 'nexus',
            'type'                => 'plugin',
            'public_key'          => 'pk_e0dc49638462db77935b81db1e54d',
            'is_premium'          => false,
            'has_premium_version' => false,
            'has_addons'          => false,
            'has_paid_plans'      => false,
            'menu'                => array(
                'slug'           => 'nexus',
                'first-path'     => 'admin.php?page=nexus'
            ),
        ) );
    }

    return $nex_fs;
}

// Init Freemius.
nex_fs();

// Brings in functions needed for activation/deactivation/deletion to prevent any errors or junk data
require_once(plugin_dir_path(__FILE__).'nexus_pre_functions.php');
require_once(plugin_dir_path(__FILE__).'nexus_main_functions.php');

// Activation Hook
function nexus_activation_sequence() { //nexus_theme_switch('active'); 
    update_option('nexus_plugin_url', plugin_dir_url( __FILE__ ));
    update_option('nexus_plugin_dir', plugin_dir_path( __FILE__ ));
    
    $mainUser = get_current_user_id();
    update_user_meta($mainUser,'nexus_account_status','active'); // Set admin user activating plugin as "active" by default
    
    $mainSettings['nexus_dashboard_page'] = 'na';
    $mainSettings['clients_need_activation'] = false;
    $mainSettings['nexus_email_toggle'] = false;
    $mainSettings['nexus_email_address'] = get_option('admin_email');
    $mainSettings['nexus_debug_mode'] = false;
    $mainSettings['nexus_debug_email'] = get_option('admin_email');
    update_option('nexus_main_settings',$mainSettings); // Adding Main Settings Defaults
    
    $themeSettings['nexus_brand_logo'] = get_option('nexus_plugin_url').'/images/logo-small.png';
    $themeSettings['nexus_sidebar_logo'] = get_option('nexus_plugin_url').'/images/logo-sidebar.png';
    $themeSettings['nexus_theme_colors']['tbs'] = '#00adef';
    $themeSettings['nexus_theme_colors']['ass'] = '#00efaf';
    $themeSettings['nexus_theme_colors']['pro'] = '#96b4bf';
    $themeSettings['nexus_theme_colors']['rej'] = '#c71e2b';
    $themeSettings['nexus_theme_colors']['sig'] = '#e58b22';
    $themeSettings['nexus_theme_colors']['high'] = '#b90000';
    $themeSettings['nexus_theme_colors']['com'] = '#6bc31b';
    update_option('nexus_theme_settings',$themeSettings); // Adding Main Settings Defaults
    
    $ttSettings['nexus_time_tracking_pricing'] = '0.00';
    $ttSettings['nexus_time_tracking_currency'] = 'GBP';
    update_option('nexus_time_tracker_settings',$ttSettings); // Adding Time Tracker Defaults
    
    $modeSettings['nexus_mode'] = 'team';
    $modeSettings['team_mode']['time_tracking_toggle'] = false;
    $modeSettings['community_mode']['budget'] = false;
    $modeSettings['community_mode']['public_requests'] = false;
    update_option('nexus_mode_settings',$modeSettings); // Adding Mode Defaults
    
    $reqSettings['nexus_request_types'] = '';
    update_option('nexus_request_settings',$reqSettings); // Adding Request Defaults
    
    
    update_option('nexus_mode_list',array('team','community'));
    
    //nexus_trigger_error(get_template_directory());
}
register_activation_hook( __FILE__, 'nexus_activation_sequence' );

// Deactivation Hook
function nexus_shutdown_sequence() { //nexus_theme_switch('inactive'); 
    nexus_deletion();
}
register_deactivation_hook( __FILE__, 'nexus_shutdown_sequence' );

// Deletion Hook
function nexus_self_destruct() {
    nexus_deletion();
    
    $postTypes = nexus_output_post_types('slug_list').',nexus_complete,nexus_rejected';
    nexus_kill_post_types($postTypes);
    
    delete_option('nexus_main_settings');
    delete_option('nexus_request_settings');
    delete_option('nexus_time_tracker_settings');
    delete_option('nexus_mode_settings');
}
register_uninstall_hook(__FILE__, 'nexus_self_destruct');

?>