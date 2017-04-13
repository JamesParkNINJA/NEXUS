<?php include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options ?>
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
                    <p class="designerEmail"><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $des['email']; ?></p>
                    <p class="designerPhone">&nbsp;</p>
                    <p class="designerPhone">&nbsp;</p>
                </div>
            </div>

            <a class="menuButton nexus_ajaxFunction" data-query="single_request" data-newdesigner="<?php echo $desID['ID']; ?>" data-status="<?php echo $stage; ?>" data-postid="<?php echo $postID; ?>" data-menu="single_request" data-tab="single_request" data-type="<?php echo get_post_type($postID); ?>" href="#"></a>
        </div>
<?php } } ?>
</div>