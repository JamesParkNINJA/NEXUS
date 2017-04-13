<?php include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options ?>
<?php include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details ?>
<?php $requestTypes = nexus_output_post_types('array'); ?>

<?php $img = "data:image/png;base64,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"; ?>

<div class="pure-g menuPage fullWidth"> 
<?php if ($requestTypes) { foreach ($requestTypes as $type) { ?>
    <?php
        $requests = new WP_Query(array('post_type' => $type['slug'],'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC'));
        $count = $requests->found_posts;
        if ($cuTYPE == 'designer') {
            $active = new WP_Query(array('post_type' => $type['slug'],'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC', 'meta_key' => 'nexus_assigned_user','meta_value'=>$cuID));
            $active = $active->found_posts;
        } else { $active = 0; }
    ?>
    <div class="pure-u-5-5 pure-u-sm-1-2 pure-u-md-1-3 menuItem">
        <div class="pure-g menuIcons">
            <div class="pure-u-16-24 pure-u-md-1-3">
                <img class="hide-sm hide-xs" src="<?php echo $img; ?>" />
                <p class="menuText txtL hide-md hide-lg hide-xl">
                    <img src="<?php echo $img; ?>" />
                    <?php echo ($cuTYPE != 'client' ? $type['title'].' List' : 'Add '.$type['title']); ?>
                </p>
            </div>
            <div class="pure-u-4-24 pure-u-md-1-3">
                <?php if ($cuTYPE == 'designer') { ?>
                    <div class="your-requests <?php if ($active > 0) { ?>has-requests<?php } ?>"><span title="Your Requests" alt="Your Requests"><?php echo $active; ?></span></div>
                <?php } ?>
            </div>
            <div class="pure-u-4-24 pure-u-md-1-3">
                <div class="requests <?php if ($count > 0) { ?>has-requests<?php } ?>"><span title="Requests" alt="Requests"><?php echo $count; ?></span></div>
            </div>
        </div>
        <p class="menuText hide-sm hide-xs">
            <img src="<?php echo $img; ?>" />
            <?php echo ($cuTYPE != 'client' ? $type['title'].' List' : 'Add '.$type['title']); ?>
        </p>
        <?php if ($cuTYPE != 'client') { ?>
            <a class="menuButton nexus_ajaxFunction <?php if (!$count || $count == 0) { ?>disabled<?php } ?>" data-requesttype="<?php echo $type['slug']; ?>" data-query="request_list" href="#"></a>
        <?php } else { ?>
            <a class="menuButton nexus_ajaxFunction" data-requesttype="<?php echo $type['slug']; ?>" data-query="request" href="#"></a>
        <?php } ?>
    </div>
<?php } } ?>
</div>