<?php include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options ?>
<?php include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details ?>

<ul class="navigationMenu">
    <?php if ($nexus_MODE == 'community' && $nexus_COMMUNITY['public_requests']) { ?>
        <li>
            <a class="nexus_ajaxFunction <?php if (!$tab) { ?>active<?php } ?>" data-query="menu" href="#">Dashboard</a> 
        </li> 
    <?php } ?>
    <li>
        <a class="nexus_ajaxFunction" data-query="signup_client" data-menu="signup" data-tab="signup_client" href="#">Client Registration</a> 
    </li> 
    <li>
        <a class="nexus_ajaxFunction" data-query="signup_member" data-menu="signup" data-tab="signup_member" href="#">Member Registration</a> 
    </li> 
</ul>