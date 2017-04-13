<?php
    /*
    Template Name: Nexus - Dashboard
    */
?>
<?php
    $nexus_PLUGINURL = get_option('nexus_plugin_url');
    $nexus_PLUGINDIR = get_option('nexus_plugin_dir');
?>

<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <?php $tempURL = get_template_directory_uri(); nexus_cuid(); ?>
        <?php 
            require_once(nexus_plugin_inc('nexus_classes/Mobile_Detect.php'));
            global $detect;
            $detect = new Mobile_Detect;
        ?>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#00ADEF">
        <title><?php include(nexus_plugin_inc('nexus_classes/title.php')); ?></title>
        
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,300,600' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Economica:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        
        <link rel="stylesheet" href="<?php echo $nexus_PLUGINURL; ?>css/fonts.css">

        <link rel="stylesheet" href="<?php echo $nexus_PLUGINURL; ?>css/pure.css">
        
        <?php $cssTime = nexus_fileModTime($nexus_PLUGINURL.'/css/main.css'); ?>
        <link rel="stylesheet" href="<?php echo $nexus_PLUGINURL.'/css/main.css?'.$cssTime; ?>"/>
        <link rel="stylesheet" href="<?php echo $nexus_PLUGINURL; ?>css/animate.css"/>
        <link rel="stylesheet" href="<?php echo $nexus_PLUGINURL; ?>css/materialMenu.css"/>
        <link rel="stylesheet" href="<?php echo $nexus_PLUGINURL; ?>/css/magnific-popup.css"/>
        <link rel="stylesheet" href="<?php echo $nexus_PLUGINURL; ?>css/pikaday.css"/>
        <link rel="stylesheet" href="<?php echo $nexus_PLUGINURL; ?>css/theme.css"/>
        <link rel="stylesheet" href="<?php echo $nexus_PLUGINURL; ?>css/font-awesome.min.css"/>
        <link rel="stylesheet" href="<?php echo $nexus_PLUGINURL; ?>css/jquery.mCustomScrollbar.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $nexus_PLUGINURL; ?>css/nexus-variable-css.php">

        <!--[if lte IE 8]>
            <link rel="stylesheet" href="<?php echo $nexus_PLUGINURL; ?>css/grids-responsive-old-ie.css">
        <![endif]-->
        <!--[if gt IE 8]><!-->
            <link rel="stylesheet" href="<?php echo $nexus_PLUGINURL; ?>css/grids-responsive.css">
        <!--<![endif]-->

        <?php wp_head(); ?>        
    </head>

    <body <?php body_class(); ?>>
        
    <?php include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Settings ?>
    <?php include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details ?>
        
    <div id="wrapper" 
         class="wrapper <?php echo $nexus_MODE; ?> <?php if (!$detect->isMobile()) { ?>mm-menu-open<?php } ?> <?php if ($cuTYPE == 'designer') { ?>adminlogin<?php } ?>">
        
    <?php $args = array('post_type' => nexus_output_post_types('array_single'),'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC'); $the_query = new WP_Query( $args ); $uReq = 0; if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); if (get_post_type(get_the_ID()) != 'nexus_complete') { if (get_the_author_id() == get_current_user_id()) { $uReq = $uReq + 1; } } endwhile; endif; wp_reset_query(); $uReqStat = ($uReq == 1 ? $uReq.' request' : $uReq.' requests'); ?>
        
        <?php if (is_user_logged_in()) { ?>
        <div class="pureFull whiteBG headerBar hidePrint">
            <div id="title" class="pure-g">                     
                <div class="pure-u-24-24 pure-u-md-16-24">
                    <?php include(nexus_plugin_inc('nexus_api/views/current_user_view.php')); ?>
                </div>
                <div class="pure-u-8-24 hide-sm hide-xs">
                    <?php include(nexus_plugin_inc('nexus_api/menus/logo_menu.php')); ?>
                </div>
            </div>
        </div>
        <div class="mobileSpacer"></div>
        <?php } ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <?php if (is_user_logged_in() || ($nexus_MODE == 'community' && $nexus_COMMUNITY['public_requests'])) { ?>

        <?php include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); ?>

        <div class="pureFull navigation mD2 hidePrint">
            <a class="mobileHomeButton" href="<?php echo get_permalink($nexus_DASHBOARD); ?>">
                <i class="fa fa-home" aria-hidden="true"></i>
            </a>
            <a class="mobileNavButton" href="#">
                <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
            </a> 
            <div id="ajaxNavigationContainer">
                <?php include(nexus_plugin_inc('nexus_api/menus/dashboard_menu.php')); ?>
            </div>
        </div>
        <div class="pureFull">
            <div id="ajaxContainer"><?php include(nexus_plugin_inc('nexus_api/main/dashboard.php')); ?></div>
        </div>
        <?php if ($cuTYPE == 'designer' && $nexus_TMACTIVE) { ?>
            <div class="timeMachine teamONLY">
                <?php include(nexus_plugin_inc('nexus_api/panels/time-machine.php')); ?>
            </div>
        <?Php } ?>
    <?php } else { ?>

        <?php include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); ?>
        
        <div class="pureFull navigation mD2 hidePrint">
            <div id="ajaxNavigationContainer">
                <?php include(nexus_plugin_inc('nexus_api/menus/signup.php')); ?>
            </div>
        </div>
        <div class="pureFull">
            <div id="ajaxContainer"><?php include(nexus_plugin_inc('nexus_api/forms/signup.php')); ?></div>
        </div>
    <?php } ?>

<?php endwhile; endif;?>
		
<div id="loadingCircle"></div>
<div id="loadingFade"></div>
</div>

<button id="mm-menu-toggle" class="mm-menu-toggle">MENU</button>

<?php 
    echo nexus_wcAJAX();
    $nexus_PLUGINURL = get_option('nexus_plugin_url');
    $nexus_PLUGINDIR = get_option('nexus_plugin_dir');
    include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); 
    include(nexus_plugin_inc('nexus_api/menus/sidebar_menu.php')); 
    include(nexus_plugin_inc('nexus_api/scripts/javascript_functions.php')); 
?>
        
<script>
  var menu = new Menu;
</script>

<?php wp_footer(); ?>

</body>
</html>