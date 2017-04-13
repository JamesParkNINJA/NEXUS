<?php
    $nexus_MAINSETTINGS = get_option('nexus_main_settings');
    $nexus_TIMESETTINGS = get_option( 'nexus_time_tracker_settings' );
    $nexus_THEMESETTINGS = get_option( 'nexus_theme_settings' );
    $nexus_MODESETTINGS = get_option( 'nexus_mode_settings' );
    $nexus_MODE = $nexus_MODESETTINGS['nexus_mode'];
    $nexus_TEAM = $nexus_MODESETTINGS['team_mode'];
    $nexus_COMMUNITY = $nexus_MODESETTINGS['community_mode'];

    $nexus_ACTIVATION = ($nexus_MAINSETTINGS['client_needs_activation'] ? true : false);

    $nexus_DEBUGMODE = $nexus_MAINSETTINGS['nexus_debug_mode'];
    $nexus_DEBUGEMAIL = ($nexus_MAINSETTINGS['nexus_debug_email'] ? $nexus_MAINSETTINGS['nexus_debug_email'] : get_option('admin_email'));
    $nexus_EMAILTOGGLE = $nexus_MAINSETTINGS['nexus_email_toggle'];
    $nexus_EMAIL = ($nexus_MAINSETTINGS['nexus_email_address'] ? $nexus_MAINSETTINGS['nexus_email_address'] : get_option('admin_email'));
    $nexus_DASHBOARD = $nexus_MAINSETTINGS['nexus_dashboard_page'];
    $nexus_DASHBOARDURL = get_permalink($nexus_MAINSETTINGS['nexus_dashboard_page']);
    $nexus_LOGO = $nexus_THEMESETTINGS['nexus_brand_logo'];
    $nexus_SIDEBARLOGO = $nexus_THEMESETTINGS['nexus_sidebar_logo'];

    $nexus_REQUESTTYPEARRAY = nexus_output_post_types('array_single');
    $nexus_REQUESTTYPELIST = nexus_output_post_types('list');

    if ($nexus_MODE == 'team') { 
        $nexus_TMACTIVE = ($nexus_TEAM['time_tracking_toggle'] ? true : false);
    } else { $nexus_TMACTIVE = false; }

    $nexus_CURRENCY = $nexus_TIMESETTINGS['nexus_time_tracking_currency'];
    switch($nexus_CURRENCY) {
        case 'USD': $nexus_CURR = '$'; break;
        case 'AUD': $nexus_CURR = '$'; break;
        case 'GBP': $nexus_CURR = '£'; break;
        case 'EUR': $nexus_CURR = '€'; break;
        default: $nexus_CURR = '£';
    }

    $nexus_BUDGET = ($nexus_COMMUNITY['budget'] ? true : false);    
?>