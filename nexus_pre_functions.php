<?php 

function nexus_add_page($title) {
    // Set up new post
    $request = array(
      'post_title'    => wp_strip_all_tags($title),
      'post_content'  => '',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type' => 'page',
    );
    
    // Insert the post into the database
    $postID = wp_insert_post( $request );
    
    if (get_option('kill_nexus_pages')) {
        $postArray = get_option('kill_nexus_pages');
    }
    
    $postArray[] = $postID;
    update_option('kill_nexus_pages',$postArray);
}

// Add colour-picker to admin
add_action( 'wp_enqueue_scripts', 'nexus_enqueue_scripts' );
function nexus_enqueue_scripts( $hook_suffix ) {
    if (is_page_template('page-nexus-dashboard.php')) {
        
        wp_enqueue_media();
        
        //Dequeue Styles
        wp_dequeue_style( get_stylesheet() );
        
        // Nexus Scripts
        wp_enqueue_script( 'nexus_modernizr',     plugins_url('/js/modernizr.min.js', __FILE__ ), array(), '1.0.0', false );
        wp_enqueue_script( 'nexus_mMenu',         plugins_url('/js/materialMenu.js', __FILE__ ), array(), '1.1.0', false );
        wp_enqueue_script( 'nexus_moment',        plugins_url('/js/moment.js', __FILE__ ), array(), '1.1.0', false );
        wp_enqueue_script( 'nexus_pikaday',       plugins_url('/js/pikaday.js', __FILE__ ), array(), '1.1.0', false );
        wp_enqueue_script( 'nexus_pikadayJS',     plugins_url('/js/pikaday.jquery.js', __FILE__ ), array(), '1.1.0', false );
        wp_enqueue_script( 'nexus_fileInput',     plugins_url('/js/jquery.custom-file-input.js', __FILE__ ), array(), '1.1.0', false );
        wp_enqueue_script( 'nexus_progressbar',   plugins_url('/js/progressbar.min.js', __FILE__ ), array(), '1.1.0', false );
        wp_enqueue_script( 'nexus_magnific',      plugins_url('/js/jquery.magnific-popup.min.js', __FILE__ ), array(), '1.1.0', false );
        wp_enqueue_script( 'nexus_scrolls',       plugins_url('/js/jquery.mCustomScrollbar.concat.min.js', __FILE__ ), array(), '1.1.0', false );
        wp_enqueue_script( 'magnific',            plugins_url('/js/jquery.magnific-popup.min.js', __FILE__ ), array(), '1.1.0', false );
        wp_enqueue_script( 'nexus_uploader',      plugins_url('/js/dmuploader.js', __FILE__ ), array(), '1.1.0', false );
        wp_enqueue_script( 'nexus_mobiledetect',  plugins_url('/js/mobile-detect.js', __FILE__ ), array(), '1.1.0', false );
        wp_enqueue_script( 'nexus_currency',  plugins_url('/js/jquery.formatCurrency-1.4.0.min.js', __FILE__ ), array(), '1.1.0', false );
    }
}

// Add colour-picker to admin
add_action( 'admin_enqueue_scripts', 'nexus_admin_enqueue_scripts' );
function nexus_admin_enqueue_scripts( $hook_suffix ) {
    // Enqueues jQuery
    wp_enqueue_script('jquery');
    
    // This will enqueue the Media Uploader script
    wp_enqueue_media();
    
    wp_enqueue_style( 'nexus_admin_styles', plugins_url('css/nexus-admin.css', __FILE__ ), array(), '1.0.0', false);
    wp_enqueue_style( 'nexus_pure_css', plugins_url('css/pure.css', __FILE__ ), array(), '1.0.0', false);
    wp_enqueue_style( 'nexus_pure_grid', plugins_url('css/grids-responsive.css', __FILE__ ), array(), '1.0.0', false);
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'nexus-field-scripts', plugins_url('js/nexus-field-scripts.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

// Init Settings for Nexus
add_action( 'admin_init', 'nexus_main_settings_init' );
function nexus_main_settings_init() {
    
    // Nexus Main Settings
	add_settings_section( 
        'nexus_main_section', 
        __( 'Main settings for the NEXUS plugin', 'nexus' ), 
        'nexus_main_section_callback', 
        'nexus_main_section_option' 
    );
	register_setting( 'nexus_main_section_option', 'nexus_main_settings' );
	register_setting( 'nexus_time_tracker_settings_option', 'nexus_time_tracker_settings' );
	register_setting( 'nexus_mode_option', 'nexus_mode_settings' );
	register_setting( 'nexus_theme_option', 'nexus_theme_settings' );

    // Nexus Request Settings
	add_settings_section( 
        'nexus_request_section', 
        __( 'Request options and types', 'nexus' ), 
        'nexus_request_section_callback', 
        'nexus_request_section_option' 
    );
	register_setting( 'nexus_request_section_option', 'nexus_request_settings' );

}

// Add Menu Options to Sidebar
add_action( 'admin_menu', 'nexus_add_admin_menu' );
function nexus_add_admin_menu() { 
    add_menu_page( 'Nexus Options', 'Nexus Options', 'manage_options', 'nexus', 'nexus_options_page' );
    add_menu_page( 'Nexus Requests', 'Nexus Requests', 'manage_options', 'nexus-requests', 'nexus_requests' );
    //add_submenu_page( 'nexus', 'Nexus Options', 'Nexus Options', 'manage_options', 'nexus-options', 'nexus_options_page' ); 
}

// Adds pre-defined custom post type to the database
add_action( 'init', 'nexus_init');
function nexus_init() {
    
    if (!get_option('nexus_mode_list')) {
        update_option('nexus_mode_list',array('team','community'));
    }
    
    if (get_option('nexus_main_settings')) {
        $mainSettings = get_option('nexus_main_settings');
        
        global $wp_rewrite;
        
        if (isset($mainSettings['nexus_dashboard_page'])) {
            $dashboard = $mainSettings['nexus_dashboard_page'];
            update_option('nexus_previous_template', get_post_meta( $dashboard, '_wp_page_template', true ));
            update_post_meta( $dashboard, '_wp_page_template', 'page-nexus-dashboard.php' );
        }
    }
    
    if(get_option('nexus_request_settings')) { $options = get_option('nexus_request_settings');
        if ($options['nexus_request_types']) {
            $requestTypes = explode(',',$options['nexus_request_types']);
            
            $rCount = 1; foreach ($requestTypes as $type) { $rCount = $rCount + 1;
                
                $slug = 'nexus_'.sanitize_title($type);
                
                $labels = array( 
                    "name" => __( $type, '' ), 
                    "singular_name" => __( $type, '' ), 
                );
                $args = array( 
                    "label" => __( $type, '' ), 
                    "labels" => $labels, 
                    "description" => "", 
                    "public" => true, 
                    "show_ui" => true, 
                    "show_in_rest" => false, 
                    "rest_base" => "", 
                    "has_archive" => false, 
                    "show_in_menu" => 'nexus-requests',
                    "exclude_from_search" => false, 
                    "capability_type" => "post", 
                    "map_meta_cap" => true, 
                    "hierarchical" => true, 
                    "rewrite" => array( 
                        "slug" => $slug, 
                        "with_front" => true 
                    ), 
                    "query_var" => true, 
                    "supports" => array( "title", "editor", "thumbnail" ),
                );
                
                register_post_type($slug, $args);
            }
        }
    }
    
    // Complete Requests
    $labels = array( "name" => __( 'Complete', '' ), "singular_name" => __( 'Complete Request', '' ), );
    $args = array( "label" => __( 'Complete', '' ), "labels" => $labels, "description" => "", "public" => true, "show_ui" => true, "show_in_rest" => false, "rest_base" => "", "has_archive" => false, "show_in_menu" => 'nexus-requests', "exclude_from_search" => false, "capability_type" => "post", "map_meta_cap" => true, "hierarchical" => true, "rewrite" => array( "slug" => 'nexus_complete', "with_front" => true ), "query_var" => true, "supports" => array( "title", "editor", "thumbnail" ), );  register_post_type('nexus_complete', $args);
    
    // Rejected Requests
    $labels = array( "name" => __( 'Rejected', '' ), "singular_name" => __( 'Rejected Request', '' ), );
    $args = array( "label" => __( 'Rejected', '' ), "labels" => $labels, "description" => "", "public" => true, "show_ui" => true, "show_in_rest" => false, "rest_base" => "", "has_archive" => false, "show_in_menu" => 'nexus-requests', "exclude_from_search" => false, "capability_type" => "post", "map_meta_cap" => true, "hierarchical" => true, "rewrite" => array( "slug" => 'nexus_rejected', "with_front" => true ), "query_var" => true, "supports" => array( "title", "editor", "thumbnail" ), );  register_post_type('nexus_rejected', $args);
}

function nexus_hide_admin_bar($bool) {
    if ( is_page_template( 'page-nexus-dashboard.php' ) ) {
        return false;
    } else {
        return $bool;
    }
}
add_filter('show_admin_bar', 'nexus_hide_admin_bar');

// Render for Settings Tabs Headers
function nexus_main_section_callback() { 
	//echo __( 'Main NEXUS settings for theme display', 'nexus' );
}
function nexus_request_section_callback() { 
	//echo __( 'Request options and types', 'nexus' );
}

function nexus_options_page() { ?>
    <div class="wrap" id="nexus_admin_options">  
        <div id="icon-themes" class="icon32"></div>  
        <h2>NEXUS - Request Ticketing System</h2>  
        <?php //settings_errors(); ?>  

        <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'nexus_main_section'; ?>  
        
        <h2 class="nav-tab-wrapper">  
            <a 
               href="?page=nexus&tab=nexus_main_section" 
               class="nav-tab <?php echo $active_tab == 'nexus_main_section' ? 'nav-tab-active' : ''; ?>">
                Default Settings
            </a> 
            <a href="?page=nexus&tab=nexus_mode_section" 
               class="nav-tab <?php echo $active_tab == 'nexus_mode_section' ? 'nav-tab-active' : ''; ?>">
                Mode Selection
            </a>
            <a href="?page=nexus&tab=nexus_time_tracker_section" 
               class="nav-tab <?php echo $active_tab == 'nexus_time_tracker_section' ? 'nav-tab-active' : ''; ?>">
                Currency Settings
            </a>
            <a href="?page=nexus&tab=nexus_theme_section" 
               class="nav-tab <?php echo $active_tab == 'nexus_theme_section' ? 'nav-tab-active' : ''; ?>">
                Theme Settings
            </a>
            <a href="?page=nexus&tab=nexus_request_section" 
               class="nav-tab <?php echo $active_tab == 'nexus_request_section' ? 'nav-tab-active' : ''; ?>">
                Request Type Registration
            </a>
        </h2>
        
        <form method="post" action="options.php">  
            
            <div class="pure-g" id="nexus_form_container">
                <div class="pure-u-5-5 pure-u-md-18-24">
                    <div class="pure-g">

                    <?php if( $active_tab == 'nexus_main_section' ) { ?>
                        <?php settings_fields( 'nexus_main_section_option' ); ?>
                        <?php $main_options = get_option( 'nexus_main_settings' );  ?>

                        <div class="pure-u-5-5 pure-u-md-1-2" style="margin-top:15px; padding:0 20px 20px 20px; box-sizing:border-box; border-left:1px solid #cccccc; border-top:1px solid #cccccc;">
                            <p class="nexus_description">
                                <span>Dashboard Page</span>
                                Please select a page to act as your front-end request system "dashboard", acting as the main system page and showing either the Admin or Client menus when logged in. 
                            </p>

                            <select name="nexus_main_settings[nexus_dashboard_page]">
                                <option <?php if ($main_options['nexus_dashboard_page'] == 'na') { ?>selected="selected"<?php } ?> value="na">Please Select A Dashboard Page</option>
                                <?php $pages = new WP_Query( array('post_type' => 'page', 'posts_per_page'=> -1, 'no_found_rows' => true) ); ?>
                                <?php if ($pages->have_posts()) : while ($pages->have_posts()) : $pages->the_post(); ?>
                                    <option 
                                            <?php if ($main_options['nexus_dashboard_page'] == get_the_ID()) { ?>selected="selected"<?php } ?>
                                            value="<?php echo get_the_ID(); ?>" >
                                        <?php echo get_the_title(); ?>
                                    </option>
                                <?php endwhile; endif; wp_reset_query(); ?>
                            </select>
                        </div>

                        <div class="pure-u-5-5 pure-u-md-1-2" style="margin-top:15px; box-sizing:border-box; padding:0 20px 20px 20px; border-left:1px solid #cccccc; border-top:1px solid #cccccc; border-right:1px solid #cccccc;">
                            <p class="nexus_description">
                                <span>Clients Need Activation?</span>
                                If activated, clients will need manually activated by an administrator before being allowed to access the system. Works best with Team Mode, not as effective with Community Mode.
                            </p>
                            <div class="nexus_onoffswitch">
                                <?php $needsActivation = $main_options['clients_need_activation']; ?>
                                <input type="checkbox" name="nexus_main_settings[clients_need_activation]" 
                                       class="nexus_onoffswitch-checkbox <?php if ($needsActivation) { ?>active<?php } ?>" 
                                       id="nexus_onoffswitch_needs_activation" value="needs-activation" data-input="teamFields"
                                        <?php if ($needsActivation) { ?>checked="checked"<?php } ?>>
                                <label class="nexus_onoffswitch-label" for="nexus_onoffswitch_needs_activation"></label>
                            </div>
                        </div>

                        <div class="pure-u-5-5 pure-u-md-1-2 nexus_email_options_box" style="margin-top:0; border-left:1px solid #cccccc; border-bottom:1px solid #cccccc; padding:10px 20px 20px 20px;">
                            <p class="nexus_description">
                                <span>Email Options</span>
                                Choose if the client will recieve emails after every request stage or not. <br>If so, please enter an email address the automated emails should appear from.*<br>                       
                                <small><strong>* This MUST be from the same domain as the site this plugin is installed on, otherwise you can encounter many email sending issues or they may not send at all.</strong></small>
                            </p>
                            <div class="pure-g">
                                <div class="pure-u-5-5 pure-u-md-5-24">
                                    <div class="nexus_onoffswitch">
                                        <input type="checkbox" name="nexus_main_settings[nexus_email_toggle]" class="nexus_onoffswitch-checkbox" id="nexus_onoffswitch_email" value="email_toggle" data-input="#nexus_email_input" 
                                       <?php if ($main_options['nexus_email_toggle']) { ?>checked="checked"<?php } ?>>
                                        <label class="nexus_onoffswitch-label" for="nexus_onoffswitch_email"></label>
                                    </div>
                                </div>
                                <div class="pure-u-5-5 pure-u-md-19-24">
                                   <input 
                                        type='text' id='nexus_email_input' 
                                        name='nexus_main_settings[nexus_email_address]' 
                                        value='<?php if (!$main_options['nexus_email_address']) { echo get_option('admin_email'); } else { echo $main_options['nexus_email_address']; } ?>'
                                       <?php if (!$main_options['nexus_email_toggle']) { ?>disabled="disabled"<?php } ?> />
                                </div>
                            </div>
                        </div>

                        <div class="pure-u-5-5 pure-u-md-1-2 nexus_debug_options_box" style="margin-top:0;">
                            <p class="nexus_description">
                                <span>Debug Options</span>
                                If debug mode is on all emails (to both client and admin) will only be sent to the defined email address.
                            </p>
                            <div class="pure-g">
                                <div class="pure-u-5-5 pure-u-md-5-24">
                                    <div class="nexus_onoffswitch">
                                        <input type="checkbox" name="nexus_main_settings[nexus_debug_mode]" class="nexus_onoffswitch-checkbox" id="nexus_onoffswitch_debug" value="debug_mode" data-input="#nexus_debug_email_input"
                                       <?php if ($main_options['nexus_debug_mode']) { ?>checked="checked"<?php } ?>>
                                        <label class="nexus_onoffswitch-label" for="nexus_onoffswitch_debug"></label>
                                    </div>
                                </div>
                                <div class="pure-u-5-5 pure-u-md-19-24">
                                    <input 
                                       type='text' id='nexus_debug_email_input' 
                                       name='nexus_main_settings[nexus_debug_email]' 
                                       value='<?php if (!$main_options['nexus_debug_email']) { echo get_option('admin_email'); } else { echo $main_options['nexus_debug_email']; } ?>' 
                                       <?php if (!$main_options['nexus_debug_mode']) { ?>disabled="disabled"<?php } ?> />
                                </div>
                            </div>
                        </div>
                        
                        <script>
                            jQuery(document).on('change','.nexus_onoffswitch-checkbox', function(e){
                                var input = jQuery(this).attr('data-input');
                                jQuery(input).prop('disabled', function(i, v) { return !v; });
                            });
                        </script>

                    <?php } else if( $active_tab == 'nexus_time_tracker_section' ) { ?>
                        <?php settings_fields( 'nexus_time_tracker_settings_option' ); ?>
                        <?php $time_options = get_option( 'nexus_time_tracker_settings' );  ?>

                        <div class="pure-u-5-5 pure-u-md-1-2 nexus_email_options_box" style="border-bottom:1px solid #cccccc; border-left:1px solid #cccccc; padding-left:20px;">
                            <p class="nexus_description">
                                <span>Hourly Rate</span>
                                Enter a default hourly rate (only used in conjunction with Team Mode)<br>                       
                            </p>
                            <div class="pure-g">
                                <div class="pure-u-5-5">
                                   <input 
                                        type='text' id='nexus_time_tracking_pricing' 
                                        name='nexus_time_tracker_settings[nexus_time_tracking_pricing]' 
                                        value='<?php if (!isset($time_options['nexus_time_tracking_pricing'])) { echo '0.00'; } else { echo $time_options['nexus_time_tracking_pricing']; } ?>' />
                                </div>
                            </div>
                        </div>

                        <div class="pure-u-5-5 pure-u-md-1-2 nexus_debug_options_box"><p class="nexus_description">
                            <p class="nexus_description">
                                <span>System Currency</span>
                                Select the currency used for the time tracker's auto-hourly-rate calculator.<br>
                                (Currently only GBP, USD and EUR).
                            </p>
                            <?php $curCur = (isset($time_options['nexus_time_tracking_currency']) ? $time_options['nexus_time_tracking_currency'] : ''); ?>
                            <select name="nexus_time_tracker_settings[nexus_time_tracking_currency]">
                                <option value="">Select Currency</option>
                                <option value="EUR" 
                                        <?php if ($curCur == 'EUR') { ?>selected="selected"<?php } ?>
                                        >Euro</option>
                                <option value="GBP" 
                                        <?php if ($curCur == 'GBP') { ?>selected="selected"<?php } ?>
                                        >Pound Sterling</option>
                                <option value="USD" 
                                        <?php if ($curCur == 'USD') { ?>selected="selected"<?php } ?>
                                        >U.S. Dollar</option>
                                <option value="AUD" 
                                        <?php if ($curCur == 'AUD') { ?>selected="selected"<?php } ?>
                                        >Australian Dollar</option>
                            </select>
                        </div>

                    <?php 
                        } else if( $active_tab == 'nexus_mode_section' ) {
                            settings_fields( 'nexus_mode_option' );
                            $mode_options = get_option( 'nexus_mode_settings' );
                            
                            // Find a way to link up 'nexus_mode_list' with this to automate future modes, possibly allow for addons
                            $community = $mode_options['community_mode'];
                            $team = $mode_options['team_mode'];
                            $mode = $mode_options['nexus_mode']; 
    
                            $mode1 = $mode2 = false;
    
                            switch($mode) {
                                case 'team': $mode1 = true; break;
                                case 'community': $mode2 = true; break;
                                default: $mode1 = true; $mode2 = false;
                            }
                    ?>
                        
                        <div class="pure-u-5-5 pure-u-md-1-2 nexus_email_options_box" style="border-bottom:1px solid #cccccc; border-left:1px solid #cccccc; padding-left:20px;">
                            <div class="topSection">
                                <p class="nexus_description">
                                    <span>Team Mode</span>
                                    The default mode for NEXUS. This assumes all (if more than one) admin users are under the same business/team, and will be working from the same settings as each other. <br><br>This also gives visibility of <strong>everyone's</strong> details and work-lists to <strong>all</strong> admin users - though clients will only be able to see their own requests. <br><br>A client will place a request and any admin user will be able to pick it up, assign it to another team member, or reject the request.      
                                </p>
                                <div class="pure-g">
                                    <div class="pure-u-5-5 pure-u-md-19-24" style="line-height:40px; text-align:right;">
                                        <strong>Toggle Team Mode</strong>
                                    </div>
                                    <div class="pure-u-5-5 pure-u-md-5-24">
                                        <div class="nexus_onoffswitch" style="margin-left:15px;">
                                            <input type="radio" name="nexus_mode_settings[nexus_mode]" 
                                                   class="nexus_mode nexus_onoffswitch-checkbox <?php if ($mode1) { ?>active<?php } ?>" 
                                                   id="nexus_onoffswitch_mode_team" value="team" data-input="teamFields"
                                                    <?php if ($mode1) { ?>checked="checked"<?php } ?>>
                                            <label class="nexus_onoffswitch-label" for="nexus_onoffswitch_mode_team"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pure-g fieldSection <?php if (!$mode1) { ?>disableSection<?php } ?>" id="teamFields">
                                <div class="pure-u-5-5">
                                    <p class="nexus_description">
                                        <span>Time Tracker</span>
                                        Enable/disable use of the time tracker for assigned requests. Will remain active until stopped. One project can be tracked at a time.
                                    </p>
                                    <div class="nexus_onoffswitch">
                                        <input type="checkbox" name="nexus_mode_settings[team_mode][time_tracking_toggle]"
                                               class="nexus_onoffswitch-checkbox"
                                               id="nexus_onoffswitch_tracker" value="time_tracker"
                                       <?php if ($team['time_tracking_toggle']) { ?>checked="checked"<?php } ?>>
                                        <label class="nexus_onoffswitch-label" for="nexus_onoffswitch_tracker"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pure-u-5-5 pure-u-md-1-2 nexus_debug_options_box"><p class="nexus_description">
                            <div class="topSection">
                                <p class="nexus_description">
                                    <span>Community Mode</span>
                                    Alternate mode for NEXUS. This assumes all (if more than one) admin users are individual businesses/teams working under the same system for mutal benefit. <br><br>This limits visibility of client details and work lists to <strong>only</strong> the admin users <em>assigned</em> to the relevant jobs. Admin ratings will be visible to clients. <br><br>A client will place a request and their budget, and admin users will apply to pick up the request. The client will then pick a quote and begin the work. 
                                </p>
                                <div class="pure-g">
                                    <div class="pure-u-5-5 pure-u-md-19-24" style="line-height:40px; text-align:right;">
                                        <strong>Toggle Community Mode</strong>
                                    </div>
                                    <div class="pure-u-5-5 pure-u-md-5-24">
                                        <div class="nexus_onoffswitch" style="margin-left:15px;">
                                            <input type="radio" name="nexus_mode_settings[nexus_mode]" 
                                                   class="nexus_mode nexus_onoffswitch-checkbox <?php if ($mode2) { ?>active<?php } ?>" 
                                                   id="nexus_onoffswitch_mode_community" value="community" data-input="communityFields"
                                           <?php if ($mode2) { ?>checked="checked"<?php } ?>>
                                            <label class="nexus_onoffswitch-label" for="nexus_onoffswitch_mode_community"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pure-g fieldSection <?php if (!$mode2) { ?>disableSection<?php } ?>" id="communityFields">
                                <div class="pure-u-5-5">
                                    <div class="pure-g">
                                        <div class="pure-u-5-5 pure-u-md-5-24">
                                            <div class="nexus_onoffswitch" style="margin-top:15px;">
                                                <input type="checkbox" name="nexus_mode_settings[community_mode][budget]" 
                                                       class="nexus_onoffswitch-checkbox <?php if ($community['budget']) { ?>active<?php } ?>" 
                                                       id="nexus_onoffswitch_budget" value="budget"
                                               <?php if ($community['budget']) { ?>checked="checked"<?php } ?>>
                                                <label class="nexus_onoffswitch-label" for="nexus_onoffswitch_budget"></label>
                                            </div>
                                        </div>
                                        <div class="pure-u-5-5 pure-u-md-19-24" style="line-height:40px;">
                                            <p class="nexus_description">
                                                <span>Include "Budget" field for Clients</span>
                                                This allows the client to put their maximum spend on the job they're requesting.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="pure-g">
                                        <div class="pure-u-5-5 pure-u-md-5-24">
                                            <div class="nexus_onoffswitch" style="margin-top:15px;">
                                                <input type="checkbox" name="nexus_mode_settings[community_mode][public_requests]" 
                                                       class="nexus_onoffswitch-checkbox <?php if ($community['public_requests']) { ?>active<?php } ?>" 
                                                       id="nexus_onoffswitch_public_requests" value="public_requests"
                                               <?php if ($community['public_requests']) { ?>checked="checked"<?php } ?>>
                                                <label class="nexus_onoffswitch-label" for="nexus_onoffswitch_public_requests"></label>
                                            </div>
                                        </div>
                                        <div class="pure-u-5-5 pure-u-md-19-24" style="line-height:40px;">
                                            <p class="nexus_description">
                                                <span>Toggle Public Request Lists</span>
                                                Turning this feature <strong>on</strong> makes the requests lists public, so that both potential clients and admin users can see what they benefit from signing up. <strong>No contact details etc will be displayed, protecting client privacy.</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                            jQuery(document).on('change','.nexus_mode', function(e){
                                var input = jQuery(this).attr('data-input');
                                jQuery('.fieldSection').toggleClass('disableSection');
                            });
                        </script>

                    <?php } else if( $active_tab == 'nexus_theme_section' ) { ?>
                        <?php settings_fields( 'nexus_theme_option' ); ?>
                        <?php $themeOptions = get_option( 'nexus_theme_settings' );  ?>

                        
                        <div class="pure-u-5-5 pure-u-md-1-2" style="margin-top:15px; padding:20px; box-sizing:border-box; border-bottom:1px solid #cccccc; border-left:1px solid #cccccc; border-top:1px solid #cccccc;">
                            <div class="pure-g">
                                <div class="pure-u-5-5 pure-u-md-16-24">
                                    <p class="nexus_description">
                                        <span>Top Bar Logo</span>
                                        Upload a horizontal variant of your logo to be shown in the top-bar of nthe request system when logged in. This should have a max height of <strong>50px</strong> and a max width of <strong>380px</strong>.
                                    </p>
                                </div>
                                <div class="pure-u-5-5 pure-u-md-8-24" style="padding:0 10px; box-sizing:border-box;">
                                    <div>
                                        <div class='nexus_brand_logo_preview_wrapper'>
                                            <img id='nexus_brand_logo_preview' src='<?php echo $themeOptions['nexus_brand_logo']; ?>' width='100' height='100' style='max-height: 100px; width: 100px;'>
                                        </div>
                                        <input type="hidden" name="nexus_theme_settings[nexus_brand_logo]" id="nexus_brand_logo" class="regular-text" value="<?php echo $themeOptions['nexus_brand_logo']; ?>">
                                        <input type="button" data-url="nexus_brand_logo" data-src="nexus_brand_logo_preview" name="nexusUploadBTN" class="nexusUploadBTN button-secondary" value="Upload Image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pure-u-5-5 pure-u-md-1-2" style="margin-top:15px; padding:20px; box-sizing:border-box; border:1px solid #cccccc;">
                            <div class="pure-g">
                                <div class="pure-u-5-5 pure-u-md-16-24">
                                    <p class="nexus_description">
                                        <span>Sidebar Logo</span>
                                        Upload a vertical or square variant of your logo to be shown in the sidebar of the request system when logged out. This should have a max width of <strong>280px</strong>. The height can be anything, but be wary as this pushes down the login form.
                                    </p>
                                </div>
                                <div class="pure-u-5-5 pure-u-md-8-24" style="padding:0 10px; box-sizing:border-box;">
                                    <div>
                                        <div class='nexus_sidebar_logo_preview_wrapper'>
                                            <img id='nexus_sidebar_logo_preview' src='<?php echo $themeOptions['nexus_sidebar_logo']; ?>' width='100' height='100' style='max-height: 100px; width: 100px;'>
                                        </div>
                                        <input type="hidden" name="nexus_theme_settings[nexus_sidebar_logo]" id="nexus_sidebar_logo" class="regular-text" value="<?php echo $themeOptions['nexus_sidebar_logo']; ?>">
                                        <input type="button" data-url="nexus_sidebar_logo" data-src="nexus_sidebar_logo_preview" name="nexusUploadBTN" class="nexusUploadBTN button-secondary" value="Upload Image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pure-u-5-5 pure-u-sm-1-2  pure-u-md-1-4" style="margin-top:15px; padding:20px; box-sizing:border-box; border:1px solid #cccccc;">
                            <div class="pure-g">
                                <div class="pure-u-5-5 pure-u-md-16-24">
                                    <p class="nexus_description">
                                        <span>NEXUS Request Colour Scheme</span>
                                        Choose the colours you wish to use for each type of request status. (Auto-darkens/lightens text).
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pure-u-5-5 pure-u-sm-1-2  pure-u-md-1-4" style="margin-top:15px; padding:20px; box-sizing:border-box; border:1px solid #cccccc;">
                            <div class="pure-g">
                                <div class="pure-u-5-5 pure-u-md-16-24">
                                    <p class="nexus_description">
                                        <span>Unassigned</span>
                                    </p>
                                </div>
                                <div class="pure-u-5-5">
                                    <input type="text" class="nexusColorPick" value="<?php echo $themeOptions['nexus_theme_colors']['tbs']; ?>" name="nexus_theme_settings[nexus_theme_colors][tbs]">
                                </div>
                            </div>
                        </div>

                        <div class="pure-u-5-5 pure-u-sm-1-2  pure-u-md-1-4" style="margin-top:15px; padding:20px; box-sizing:border-box; border:1px solid #cccccc;">
                            <div class="pure-g">
                                <div class="pure-u-5-5 pure-u-md-16-24">
                                    <p class="nexus_description">
                                        <span>Assigned</span>
                                    </p>
                                </div>
                                <div class="pure-u-5-5">
                                    <input type="text" class="nexusColorPick" value="<?php echo $themeOptions['nexus_theme_colors']['ass']; ?>" name="nexus_theme_settings[nexus_theme_colors][ass]">
                                </div>
                            </div>
                        </div>

                        <div class="pure-u-5-5 pure-u-sm-1-2  pure-u-md-1-4" style="margin-top:15px; padding:20px; box-sizing:border-box; border:1px solid #cccccc;">
                            <div class="pure-g">
                                <div class="pure-u-5-5 pure-u-md-16-24">
                                    <p class="nexus_description">
                                        <span>In Progress</span>
                                    </p>
                                </div>
                                <div class="pure-u-5-5">
                                    <input type="text" class="nexusColorPick" value="<?php echo $themeOptions['nexus_theme_colors']['pro']; ?>" name="nexus_theme_settings[nexus_theme_colors][pro]">
                                </div>
                            </div>
                        </div>

                        <div class="pure-u-5-5 pure-u-sm-1-2  pure-u-md-1-4" style="margin-top:15px; padding:20px; box-sizing:border-box; border:1px solid #cccccc;">
                            <div class="pure-g">
                                <div class="pure-u-5-5 pure-u-md-16-24">
                                    <p class="nexus_description">
                                        <span>Rejected</span>
                                    </p>
                                </div>
                                <div class="pure-u-5-5">
                                    <input type="text" class="nexusColorPick" value="<?php echo $themeOptions['nexus_theme_colors']['rej']; ?>" name="nexus_theme_settings[nexus_theme_colors][rej]">
                                </div>
                            </div>
                        </div>

                        <div class="pure-u-5-5 pure-u-sm-1-2  pure-u-md-1-4" style="margin-top:15px; padding:20px; box-sizing:border-box; border:1px solid #cccccc;">
                            <div class="pure-g">
                                <div class="pure-u-5-5 pure-u-md-16-24">
                                    <p class="nexus_description">
                                        <span>Signoff</span>
                                    </p>
                                </div>
                                <div class="pure-u-5-5">
                                    <input type="text" class="nexusColorPick" value="<?php echo $themeOptions['nexus_theme_colors']['sig']; ?>" name="nexus_theme_settings[nexus_theme_colors][sig]">
                                </div>
                            </div>
                        </div>

                        <div class="pure-u-5-5 pure-u-sm-1-2  pure-u-md-1-4" style="margin-top:15px; padding:20px; box-sizing:border-box; border:1px solid #cccccc;">
                            <div class="pure-g">
                                <div class="pure-u-5-5 pure-u-md-16-24">
                                    <p class="nexus_description">
                                        <span>High Importance</span>
                                    </p>
                                </div>
                                <div class="pure-u-5-5">
                                    <input type="text" class="nexusColorPick" value="<?php echo $themeOptions['nexus_theme_colors']['high']; ?>" name="nexus_theme_settings[nexus_theme_colors][high]">
                                </div>
                            </div>
                        </div>

                        <div class="pure-u-5-5 pure-u-sm-1-2  pure-u-md-1-4" style="margin-top:15px; padding:20px; box-sizing:border-box; border:1px solid #cccccc;">
                            <div class="pure-g">
                                <div class="pure-u-5-5 pure-u-md-16-24">
                                    <p class="nexus_description">
                                        <span>Complete</span>
                                    </p>
                                </div>
                                <div class="pure-u-5-5">
                                    <input type="text" class="nexusColorPick" value="<?php echo $themeOptions['nexus_theme_colors']['com']; ?>" name="nexus_theme_settings[nexus_theme_colors][com]">
                                </div>
                            </div>
                        </div>
                        
                        <script>                              jQuery(document).on('change','.nexus_onoffswitch-checkbox', function(e){
                                var input = jQuery(this).attr('data-input');
                                jQuery(input).prop('disabled', function(i, v) { return !v; });
                            });
                        </script>

                    <?php } else if( $active_tab == 'nexus_request_section' ) { ?>
                        <?php settings_fields( 'nexus_request_section_option' ); ?>
                        <?php $req_options = get_option( 'nexus_request_settings' );  ?>
                            <div class="pure-u-5-5">
                                <div class="nexus_request_repeater">
                                    <p class="nexus_description">
                                        <span>Request/Ticket Types</span>
                                        Please enter the (plural) names of request types you'd like to add to the system (Eg. "Projects", or "General Enquiries").<br><small>[Up to 5, no duplicates]</small>
                                    </p>
                                    <br>
                                    <table id="nexus_request_types" width="100%">
                                        <tr><th class="txtL">Request Type (Plural)</th><th>&nbsp;</th></tr>
                                        <?php if ($req_options['nexus_request_types']) { $requestTypes = explode(',',$req_options['nexus_request_types']); ?>
                                        <?php $nTi = 0; foreach ($requestTypes as $type) { $nTi = $nTi + 1; ?>
                                            <tr id="nti_td_<?php echo $nTi; ?>">
                                                <td><input style="width:100%;" type='text' id="nti_<?php echo $nTi; ?>" class="nexus_request_type" value='<?php echo $type; ?>'></td>
                                                <td width="110" align="center"><a href="#" class="removeNexusType" data-type="<?php echo $nTi; ?>"><span class="dashicons dashicons-trash"></span> remove</a></td>
                                            </tr>
                                        <?php } } else { ?>
                                            <tr id="nti_td_1">
                                                <td><input style="width:100%;" type='text' id="nti_1" class="nexus_request_type" value=''></td>
                                                <td width="110" align="center"><a href="#" class="removeNexusType" data-type="1"><span class="dashicons dashicons-trash"></span> remove</a></td>
                                            </tr>
                                        <?php } ?>
                                    </table>

                                    <input id="requestTypeField" type="hidden" name="nexus_request_settings[nexus_request_types]" value="<?php echo $req_options['nexus_request_types']; ?>" />

                                    <a href="#" class="addNewNexusType <?php if ($nTi == 5) { ?>disabled<?php } ?>" data-num="<?php echo ($nTi > 0 ? $nTi : 1); ?>">Add New Type</a>
                                </div>
                            </div>

                            <script>
                                jQuery(document).on('click','.addNewNexusType', function(e){
                                    e.preventDefault(); var num = parseInt(jQuery(this).attr('data-num'),10), newNum = num + 1;
                                    if (newNum <= 5) {
                                        jQuery(this).removeClass('disabled');
                                        jQuery(this).attr('data-num',newNum);
                                        jQuery('#nexus_request_types').append('<tr id="nti_td_'+newNum+'"><td><input style="width:100%;" type="text" id="nti_'+newNum+'" class="nexus_request_type" value=""></td><td><a href="#" class="removeNexusType" data-type="'+newNum+'"><span class="dashicons dashicons-trash"></span> remove</a></td></tr>');
                                        updateNexusRequestField();
                                    } else {
                                        jQuery(this).addClass('disabled');
                                    }
                                });

                                jQuery(document).on('click','.removeNexusType', function(e){
                                    e.preventDefault(); var num = parseInt(jQuery(this).attr('data-type'),10), rows = parseInt(jQuery('#nexus_request_types tr').length, 10), newNum = parseInt(jQuery('.addNewNexusType').attr('data-num'),10);

                                    if(!confirm('Are you sure? This will remove all requests attributed to this type!')) return;

                                    var removeMe = jQuery('#nti_'+num).val(), 
                                        postData = {
                                            'action' : 'nexus_kill_post_types',
                                            'list' : removeMe
                                        }

                                    jQuery.ajax({
                                        url: ajaxurl,
                                        type: 'post',
                                        data: postData,
                                        success: function(data) {
                                            var dataArray = JSON.parse(data);
                                            //console.log(dataArray);
                                        },
                                        error: function(jqXHR, textStatus, errorThrown){
                                            //console.log(jqXHR);
                                        }
                                    });

                                    if (rows > 1) {
                                        jQuery('#nti_td_'+num).remove();
                                        jQuery('.addNewNexusType').attr('data-num',(newNum - 1));
                                        updateNexusRequestField();
                                    } else {
                                        jQuery('#nti_td_1 input').val('');
                                        updateNexusRequestField();
                                    }
                                });

                                jQuery(document).on('keyup','.nexus_request_type', function(e){
                                    updateNexusRequestField();
                                });

                                jQuery(document).on('input','.nexus_request_type', function() {
                                    var c = this.selectionStart,
                                        r = /[^a-z0-9\s]/gi,
                                        v = jQuery(this).val();
                                    if(r.test(v)) {
                                        jQuery(this).val(v.replace(r, ''));
                                        c--;
                                    }
                                    this.setSelectionRange(c, c);
                                });

                                function checkForDuplicates( array ) {  // finds any duplicate array elements using the fewest possible comparison
                                    var i, j, n;
                                    n = array.length;
                                    // to ensure the fewest possible comparisons
                                    for (i = 0; i < n; i++) {                        // outer loop uses each item i at 0 through n
                                        for (j = i+1; j < n; j++) {              // inner loop only compares items j at i+1 to n
                                            if (array[i] != "") {   // ignore blanks
                                                if (array[i].toLowerCase() == array[j].toLowerCase()) {return true}  // case insensitive
                                            }
                                        }
                                    }
                                }

                                function updateNexusRequestField() {
                                    var newArray = [], newList = '';
                                    jQuery('#nexus_request_types input').each(function(){
                                        if (newList && newList != '' && jQuery(this).val() != '') { newList += ','; }
                                        newList += jQuery(this).val(); newArray.push(jQuery(this).val());
                                    });

                                    jQuery('#requestTypeField').val(newList);

                                    if (checkForDuplicates(newArray)) {
                                        jQuery('#submit').attr('disabled','true');
                                        nexus_trigger_error('Please remove all duplicate Request Types');
                                    } else {
                                        jQuery('#submit').removeAttr('disabled');
                                    }
                                }
                            </script>
                    <?php } ?>    
                    </div>
            
                    <?php submit_button(); ?>
                </div>
                <div class="pure-u-5-5 pure-u-md-6-24">
                    <div class="nexus_sidebar">
                        <img src="<?php echo plugins_url('/nexus/images/nexus_plugin_logo.jpg'); ?>" style="width:100%; max-width:256px; border-radius:7px 7px 0 0;" /><img src="<?php echo plugins_url('/nexus/images/nexus_preview_banner.jpg'); ?>" style="width:100%; max-width:256px; border-radius:0 0 7px 7px;" /><a class="nexus_donate" href="http://paypal.me/jamesparkninja/5" target="_blank"><img src="<?php echo plugins_url('/nexus/images/beer.png'); ?>" style="width:30px;" /> DONATE ME A BEER</a>
                    </div>
                </div>
            </div>
            
        </form>
        
    </div>

<?php }

function get_currency_symbol($string) {
    $symbol = '';
    $length = mb_strlen($string, 'utf-8');
    for ($i = 0; $i < $length; $i++)
    {
        $char = mb_substr($string, $i, 1, 'utf-8');
        if (!ctype_digit($char) && !ctype_punct($char))
            $symbol .= $char;
    }
    return $symbol;
}
                               
function nexus_currency_convert($typeA, $typeB) {
    if ($typeA != $typeB) {
        $url = 'http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency='.$typeA.'&ToCurrency='.$typeB;
        $xml = simpleXML_load_file($url,"SimpleXMLElement",LIBXML_NOCDATA);
        if($xml ===  FALSE) {
            $rate = 'error';
        } else { 
            $rate = $xml;
        }

        $postTypes = nexus_output_post_types('array_single');
        $query = new WP_Query( array( 'post_type' => $postTypes, 'posts_per_page' => -1, 'meta_key' => 'nexus_tracked_time', 'meta_compare' => '>', 'meta_value' => 0) );
        if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
            $currentCost = get_post_meta(get_theID(),'nexus_project_cost',true);
            if (!$currentCost || $currentCost == '') {
                $currentTime = get_post_meta(get_theID(),'nexus_tracked_time',true);
                $currentCost = nexus_calculateCost($currentTime);
                $newPrice == $currentCost;
            } else {
                $newPrice = floatval($currentCost) * $rate;
                $newPrice = number_format((float)$newPrice, 2, '.', '');
            }
            update_post_meta(get_the_ID(),'nexus_project_cost',$newPrice);
        endwhile; endif; wp_reset_query();
        
        $query = new WP_Query( array( 'post_type' => $postTypes, 'posts_per_page' => -1, 'meta_key' => 'nexus_client_budget', 'meta_compare' => 'EXISTS') );
        if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();        
            $currentBudget = get_post_meta(get_theID(),'nexus_client_budget',true);
            $newBudget = floatval($currentBudget) * $rate;
            $newBudget = number_format((float)$newBudget, 2, '.', '');
            update_post_meta(get_the_ID(),'nexus_client_budget',$newBudget);
        endwhile; endif; wp_reset_query();
    }
}

// Duplicates an entire folder with subfolders/files into a nother directory.
function nexus_recurse_copy($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                nexus_recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } else { copy($src . '/' . $file,$dst . '/' . $file); } 
        } 
    } 
    closedir($dir); 
} 

// Deletes an entire folder with subfolders/files.
function nexus_recurse_delete($src) { 
    if (file_exists($src)) {
        if (is_dir($src)) {
        $dir = opendir($src);
        while(false !== ( $file = readdir($dir)) ) { 
            if (( $file != '.' ) && ( $file != '..' )) { 
                if ( is_dir($src . '/' . $file) ) { 
                    nexus_recurse_delete($src . '/' . $file); 
                } 
                else { 
                    unlink($src . '/' . $file); 
                } 
            } 
        } 
        closedir($dir); 
        rmdir($src);
        } else {
            unlink($src);
        }
    }
}

// Alters wordpress error with custom error text.
function nexus_trigger_error($message) {
    if(isset($_GET['action']) && $_GET['action'] == 'error_scrape') {
        echo '<strong>' . $message . '</strong>'; exit;
    } else {
        trigger_error($message, E_USER_ERROR);
    }
}

add_action( 'wp_ajax_nexus_kill_post_types', 'nexus_kill_post_types' );
add_action( 'wp_ajax_nopriv_nexus_kill_post_types', 'nexus_kill_post_types' );
function nexus_kill_post_types($list) {
    // Loops through all post types, then recursively deletes all posts created by the Nexus system, then removes the post type itself.
    $ajax = false;
    if (!empty($_POST['list'])) { $list = $_POST['list']; $ajax = true; }
    
    if (strpos($list, ',') !== false) {
        $postTypesToRemove = explode(',',$list);
        foreach ($postTypesToRemove as $postType) {
            $postType = sanitize_title($postType);
            $loop = new WP_Query( array( 'post_type' => $postType, 'posts_per_page' => -1 ) );
            while ( $loop->have_posts() ) : $loop->the_post(); wp_delete_post(get_the_ID(), true); endwhile; wp_reset_query();
            unregister_post_type($postType);
        }
    } else {
        $postType = sanitize_title($list);
        $loop = new WP_Query( array( 'post_type' => $postType, 'posts_per_page' => -1 ) );
        while ( $loop->have_posts() ) : $loop->the_post(); wp_delete_post(get_the_ID(), true); endwhile; wp_reset_query();
        unregister_post_type($postType);
    }
    
    if($ajax) {
        $return['list'] = $list;
        echo json_encode($return);
        die();
    }
}

function nexus_kill_pages($list) {
    // Loops through and deletes all pages created by the Nexus system.
    $pagesToRemove = $list;
    foreach ($pagesToRemove as $delete) {
        wp_delete_post($delete, true);
    }
}

function nexus_kill_list() {
    nexus_kill_pages(get_option('kill_nexus_pages'));
}

function nexus_deletion() {
    nexus_kill_list();
}

add_filter( 'page_template', 'nexus_dashboard_template' );
function nexus_dashboard_template( $page_template )
{
    $mainSettings = get_option('nexus_main_settings');
    $dashboard = $mainSettings['nexus_dashboard_page'];
    if (is_page($dashboard)) {
        $page_template = dirname( __FILE__ ) . '/inc/page-nexus-dashboard.php';
    }
    
    return $page_template;
}

?>