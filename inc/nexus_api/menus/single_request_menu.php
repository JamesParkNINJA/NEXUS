<?php 
    include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details
    include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options 
?>
<ul class="navigationMenu">
    <?php if ($cuTYPE == 'designer') { ?>
    <li>
        <a class="nexus_ajaxFunction" data-menu="dashboard_menu" data-requesttype="<?php echo $requestType; ?>" data-tab="<?php echo $requestType; ?>" data-query="request_list" href="#">Back to List</a>
    </li>
    <?php } else { ?>
    <li>
        <a class="nexus_ajaxFunction" data-menu="dashboard_menu" data-query="dashboard" href="#">Back to Dashboard</a>
    </li>
    <?php } ?>
    <li>
        <a class="nexus_ajaxFunction active" href="#" data-query="single_request" data-requesttype="<?php echo $requestType; ?>" data-postid="<?php echo $postID; ?>">Details</a> 
    </li>
    <?php if ($cuID == get_post_field('post_author', $postID) || $cuTYPE == 'designer') { ?>
    
        <?php if (get_post_type($postID) != 'nexus_complete') { ?>
            <li>
                <a class="disabled" href="#">Feedback</a>
            </li>
        <?php } else { ?>
            <?php 
                $authID = get_post_field( 'post_author', $postID );
                if ($cuID == $authID) { $client = 'yes'; } else { $client = 'no'; }
                if (($client == 'yes' && !get_post_meta($postID,'nexus_request_feedback',true)) || ($client == 'no' && !get_post_meta($postID,'nexus_client_feedback',true))) { 
                    $preWord = 'Add';
                } else { $preWord = 'View'; }
            ?>
                <li>
                    <a class="nexus_ajaxFunction <?php echo ($preWord == 'Add' ? 'action' : ''); ?>" data-query="feedback" data-postid="<?php echo $postID; ?>" href="#"><?php echo $preWord; ?> Feedback</a>
                </li>
        <?php } ?>
    
    <?php } ?>
    <?php if (true == false) { ?>
        <li>
            <a class="nexus_ajaxFunction <?php echo (get_post_meta($postID,'nexus_request_log',true) ? '' : 'disabled'); ?>" data-query="request_log" data-postid="<?php echo $postID; ?>" href="#">Request Log</a>
        </li>
    <?php } ?>
    <?php if ($nexus_MODE == 'community') { ?>
        <li>
            <a class="nexus_ajaxFunction <?php echo (nexus_applicationCount($postID) > 0 ? '' : 'disabled'); ?>" data-query="application_list" data-postid="<?php echo $postID; ?>" href="#">Application List</a>
        </li>
    <?php } ?>
</ul>