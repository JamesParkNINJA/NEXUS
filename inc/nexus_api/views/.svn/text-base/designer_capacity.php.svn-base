<?php include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details ?>
<div class="pure-g designerList fullWidth"> 
<?php 
    $adminQuery = new WP_User_Query( array( 'role' => 'Administrator' ) );
    foreach($adminQuery->results as $user) {
        $desID = $user->ID; $des = nexus_userDetailsArray($desID); if ($designerID != $desID) { ?>
    <div class="pure-u-5-5 pure-u-md-1-2 menuItem designer">
        <div class="pure-g">
            <div class="pure-u-5-5 pure-u-md-8-24 relative">
                <div class="userImage" style="background-image:url(<?php echo $des['img']; ?>);"><div></div></div> 
            </div>
            <div class="pure-u-5-5 pure-u-md-16-24">
                <h2 class="designerName"><?php echo $des['fullname']; ?></h2>
                <p class="designerPhone">Active Requests: <strong><?php echo $des['activerequests']; ?></strong></p>
                <p class="designerPhone">&nbsp;</p>
                <p class="designerPhone">&nbsp;</p>
            </div>
        </div>
        
        <a class="menuButton nexus_ajaxFunction" data-query="designer_profile" data-designer="<?php echo $desID['ID']; ?>" href="#"></a>
    </div>
<?php } } ?>
</div>