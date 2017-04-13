<?php 
    /*
    Template Name: Nexus Nav Query Selector
    */
    ob_start();
    wp_head();
    ob_end_clean();

    $query = $_POST['menu'];
    $postID = $_POST['postid'];
    $requestType = $_POST['requesttype'];
    $userQuery = $_POST['user'];
    $searchQuery = $_POST['searchquery'];
    $tab = $_POST['tab'];

    switch ($query) {
        // Menu
        case 'dashboard': include(nexus_plugin_inc('nexus_api/menus/dashboard_menu.php')); break;
        case 'single_request': include(nexus_plugin_inc('nexus_api/menus/single_request_menu.php')); break;
        case 'statistics': include(nexus_plugin_inc('nexus_api/menus/statistics_menu.php')); break;
        case 'reassign': include(nexus_plugin_inc('nexus_api/menus/reassign_menu.php')); break;
            
        // Default ("You really shouldn't be here...")
        default: include(nexus_plugin_inc('nexus_api/menus/dashboard_menu.php'));
    }  
?>