<?php 
    include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options
    require_once(nexus_plugin_inc('nexus_classes/Mobile_Detect.php'));
    global $detect;
    $detect = new Mobile_Detect;
?>
<nav id="mm-menu" class="mm-menu navDrawer <?php if (!$detect->isMobile()) { ?>active<?php } ?>">
    <div class="pure-g menuContainer">
        <div class="pure-u-5-5 mCustomScrollbar" data-mcs-theme="minimal">
            <?php if (is_user_logged_in()) { ?>
            <div class="searchContainer">
                <input name="fullSiteSearch" id="fullSiteSearch" type="text" />
                <a href="#" class="nexus_ajaxFunction" data-tab="dashboard" data-requesttype="search" data-query="request_list">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </a>
            </div>
            <?php } ?>
            <ul class="mm-menu__items">
            <?php if (is_user_logged_in()) { ?>
                <li class="mm-menu__item  <?php if (!$detect->isMobile()) { ?>in-view<?php } ?>">
                    <a class="mm-menu__link" href="<?php echo $nexus_DASHBOARDURL; ?>">
                        Dashboard
                    </a>
                </li>
                
                <?php $all = nexus_requestCount('all'); ?>
                <li class="mm-menu__item  <?php if (!$detect->isMobile()) { ?>in-view<?php } ?>">
                    <a class="mm-menu__link nexus_ajaxFunction" data-tab="request_list" data-menu="request_list" data-requesttype="all" data-query="request_list" href="#">
                        All Requests <span class="requestCount"><?php echo $all; ?></span>
                    </a>
                </li>
                
                <li class="mm-menu__item  <?php if (!$detect->isMobile()) { ?>in-view<?php } ?> header orange">
                    <strong>Current Requests</strong>
                </li>
                <?php $requestTypes = nexus_output_post_types('array'); ?>
                <?php if ($requestTypes) { foreach ($requestTypes as $type) { ?>
                    <?php 
                        $requestArr = nexus_newRequests($type['slug']); 
                        if ($requestArr['count'] && $requestArr['count'] > 0) {
                            $class = ($requestArr['new'] > 0 ? 'action' : '');
                        } else {
                            $class = 'disabled';
                        }
                    ?>
                
                    <li class="mm-menu__item  <?php if (!$detect->isMobile()) { ?>in-view<?php } ?>">
                        <a class="mm-menu__link nexus_ajaxFunction <?php echo $class; ?>" data-requesttype="<?php echo $type['slug']; ?>" data-query="request_list" href="#" data-menu="dashboard">
                            <?php echo $type['title']; ?> List
                        </a>
                        <a href="#" class="addRequest nexus_ajaxFunction" data-menu="dashboard" data-requesttype="<?php echo $type['slug']; ?>" data-query="request">+</a>
                    </li>
                <?php } } ?>
                
                <?php $compCount = nexus_requestCount('nexus_complete'); ?>
                <li class="mm-menu__item  <?php if (!$detect->isMobile()) { ?>in-view<?php } ?>">
                    <?php $comArr = new WP_Query(array('post_type' => 'nexus_complete', 'posts_per_page' => -1)); $comi = $comArr->found_posts; ?>
                    <?php $comCSS = ($comi > 0 ? '' : 'disabled'); ?>
                    <a class="noPlus mm-menu__link nexus_ajaxFunction <?php echo $comCSS; ?>" data-menu="dashboard" data-requesttype="nexus_complete" data-query="request_list" href="#">
                        Completed Requests <span class="requestCount"><?php echo $compCount; ?></span>
                    </a>
                </li>
                
                <?php $rejCount = nexus_requestCount('nexus_rejected'); ?>
                <li class="mm-menu__item  <?php if (!$detect->isMobile()) { ?>in-view<?php } ?>">
                    <?php $rejArr = new WP_Query(array('post_type' => 'nexus_rejected', 'posts_per_page' => -1)); $reji = $rejArr->found_posts; ?>
                    <?php $rejCSS = ($reji > 0 ? '' : 'disabled'); ?>
                    <a class="noPlus mm-menu__link nexus_ajaxFunction <?php echo $rejCSS; ?>" data-menu="dashboard" data-requesttype="nexus_rejected" data-query="request_list" href="#">
                        Rejected Requests <span class="requestCount"><?php echo $rejCount; ?></span>
                    </a>
                </li>
                
                <!-- WIP for future iteration -->
                
                <li class="mm-menu__item  <?php if (!$detect->isMobile()) { ?>in-view<?php } ?> header blue">
                    <strong>Information</strong>
                </li>
                
                <li class="mm-menu__item  <?php if (!$detect->isMobile()) { ?>in-view<?php } ?>">
                    <a class="noPlus mm-menu__link nexus_ajaxFunction" href="#" data-query="member_list" data-menu="profile_menu">
                        Member List
                    </a>
                </li>
                <!--
                <li class="mm-menu__item  <?php if (!$detect->isMobile()) { ?>in-view<?php } ?>">
                    <a class="noPlus mm-menu__link nexus_ajaxFunction" href="#" data-query="statistics" data-menu="statistics" data-startdate="01-01-2016" data-enddate="31-12-2099">
                        Statistics
                    </a>
                </li>
                -->
                
                <?php if ($cuTYPE == 'designer') { ?>           
                    <li class="mm-menu__item  <?php if (!$detect->isMobile()) { ?>in-view<?php } ?> header red">
                        <strong>Admin</strong>
                    </li>
                    <?php if ($nexus_ACTIVATION) { ?>
                        <?php $pending = new WP_User_Query( array( 'meta_query' => array ( 'relation' => 'OR', array ( 'key' => 'nexus_account_status', 'value' => 'active', 'compare' => '!=' ), array ( 'key' => 'nexus_account_status', 'compare' => 'NOT EXISTS' ) ) ) ); ?> 
                        <?php if ( ! empty( $pending->results ) ) { $pending = 'pending'; } else { $pending = ''; } ?>
                        <li class="mm-menu__item  <?php if (!$detect->isMobile()) { ?>in-view<?php } ?>">
                            <a class="noPlus mm-menu__link nexus_ajaxFunction <?php echo $pending; ?>" href="#" data-menu="pending_users" data-query="pending_users">
                                Pending Users
                            </a>
                        </li>    
                    <?php } ?>
                    <li class="mm-menu__item  <?php if (!$detect->isMobile()) { ?>in-view<?php } ?>">
                        <a class="noPlus mm-menu__link" target="_blank" href="<?php echo get_bloginfo('url'); ?>/wp-admin/">
                            Admin Menu
                        </a>
                    </li>
                <?php } ?>
                
                <li class="logoutLink txtC">
                    <a href="<?php echo wp_logout_url( $nexus_DASHBOARDURL ); ?>">
                        <img src="data:image/png;base64,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" />
                    </a>
                </li>
                <?php } else { ?>
                    <div class="pure-g" role="login">
                        <?php include(nexus_plugin_inc('nexus_api/forms/login_form.php')); ?>
                    </div>
                <?php } ?>
                <!--
                <li class="copyright">
                    <p class="txtC">
                        <a target="_blank" href="http://jamespark.ninja">© JamesPark.NINJA</a>
                    </p>
                </li>
                -->
            </ul>
        </div>
    </div>
</nav>