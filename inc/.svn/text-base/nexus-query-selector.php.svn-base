<?php 
    /*
    Template Name: Nexus Query Selector
    */
    ob_start();
    wp_head();
    ob_end_clean();

    include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details 
    
    $query = $_POST['query'];
    $postID = $_POST['postid'];
    $requestType = $_POST['requesttype'];
    $userQuery = $_POST['user'];
    $searchQuery = $_POST['searchquery'];
    $designerID = $_POST['designer'];
    $newDesigner = $_POST['newdesigner'];
    $override = $_POST['override'];
    $stage = $_POST['stage'];
    $signoff = $_POST['signoff'];
    $update = $_POST['update'];
    $updateStatus = $_POST['updatestatus'];

    if ($query == 'statistics') {
        $startYear = (isset($_POST['startdate']) ? date('Y-m-d', strtotime($_POST['startdate'])) : '2016-01-01');
        $endYear = (isset($_POST['enddate']) ? date('Y-m-d', strtotime($_POST['enddate'])) : '2099-12-31');
        $sY = (isset($_POST['startdate']) ? $_POST['startdate'] : '01-01-2016');
        $eY = (isset($_POST['startdate']) ? $_POST['startdate'] : '31-12-2099');
    }

    if ($newDesigner) {
        nexus_takeJob($postID, $newDesigner, $stage);
    } else {
        if ($stage) { update_post_meta($postID,'nexus_request_stage',$stage); }
        if ($signoff == 'true') {
            update_post_meta($postID,'nexus_request_stage',3);
            update_post_meta($postID,'nexus_signoff_toggle',0);
            set_post_type($postID,'nexus_complete'); // Changes post type to complete
            update_post_meta($postID,'nexus_prior_type',$requestType); // Adds the old post type as a variable
        }
    }

    if ($cuSTATUS != 'active') { $query = 'access_denied'; }

    switch ($query) {
        // Forms
        case 'request': include(nexus_plugin_inc('nexus_api/forms/request_form.php')); break;
        case 'reassign_request': include(nexus_plugin_inc('nexus_api/forms/reassign_request.php')); break;
        case 'rejection': include(nexus_plugin_inc('nexus_api/forms/rejection.php')); break;
        case 'edit_request': include(nexus_plugin_inc('nexus_api/forms/edit_request.php')); break;
        case 'completion': include(nexus_plugin_inc('nexus_api/forms/completion.php')); break;
        case 'request_signoff': include(nexus_plugin_inc('nexus_api/forms/request_signoff.php')); break;
            
        // Lists
        case 'request_list': include(nexus_plugin_inc('nexus_api/lists/request.php')); break;
        case 'pending_users': include(nexus_plugin_inc('nexus_api/lists/pending_user_list.php')); break;
            
        // Views
        case 'single_request': include(nexus_plugin_inc('nexus_api/views/single_request.php')); break;
        case 'designer_capacity': include(nexus_plugin_inc('nexus_api/views/designer_capacity.php')); break;
        case 'request_log': include(nexus_plugin_inc('nexus_api/views/request_log.php')); break;
        case 'feedback': include(nexus_plugin_inc('nexus_api/forms/feedback.php')); break;
            
        // Main
        case 'menu': include(nexus_plugin_inc('nexus_api/main/dashboard.php')); break;
        case 'dashboard': include(nexus_plugin_inc('nexus_api/main/dashboard.php')); break;
        case 'statistics': include(nexus_plugin_inc('nexus_api/main/statistics.php'));
            
        // Errors
        case 'access_denied': include(nexus_plugin_inc('nexus_api/access_denied.php')); break;
        default: include(nexus_plugin_inc('nexus_api/error.php'));
    }
?>