<?php include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options ?>
<?php include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details ?>
<?php echo nexus_logMe('stuff'); ?>
<ul class="navigationMenu">
    <?php if ($cuTYPE == 'client') { ?>
        <li>
            <a class="nexus_ajaxFunction <?php if (!$tab) { ?>active<?php } ?>" data-query="menu" href="#">Add Request</a> 
        </li>
        <li>
            <a class="nexus_ajaxFunction <?php if (nexus_getActiveRequests($cuID,'client') == 0){ ?>disabled<?php } ?>" data-requesttype="all" data-query="request_list" data-user="<?php echo $cuID; ?>" href="#">Active Requests</a> 
        </li>
        <li>
            <a class="nexus_ajaxFunction <?php if (nexus_needsAction($cuID,'all') > 0){ ?>action<?php } else { ?>disabled<?php } ?>" data-requestType="action" data-query="request_list" data-user="<?php echo $cuID; ?>" href="#">Required Action</a>
        </li>
        <li>
            <a class="nexus_ajaxFunction" href="#" data-query="member_list" data-menu="profile_menu">Member List</a>
        </li>
    <?php } else { ?>
        <li>
            <a class="nexus_ajaxFunction <?php if (!$tab) { ?>active<?php } ?>" data-query="menu" href="#">Dashboard</a> 
        </li>
        <?php $requestTypes = nexus_output_post_types('array'); ?>
        <?php foreach ($requestTypes as $type) { ?>
            <?php 
                $requestArr = nexus_newRequests($type['slug']); 
                $tabCSS = ($tab == $type['slug'] ? ' active' : '');
                if ($requestArr['count'] && $requestArr['count'] > 0) {
                    $class = ($requestArr['new'] > 0 ? 'action'.$tabCSS : $tabCSS);
                } else {
                    $class = 'disabled';
                }
            ?>
            <li>
                <a class="nexus_ajaxFunction <?php echo $class; ?>" data-requesttype="<?php echo $type['slug']; ?>" data-query="request_list" href="#"><?php echo $type['title']; ?> List</a> 
            </li>    
        <?php } ?>
    <?php } ?>
</ul>