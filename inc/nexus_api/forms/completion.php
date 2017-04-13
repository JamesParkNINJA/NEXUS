<?php include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options ?>
<?php include(nexus_plugin_inc('nexus_api/data/current_user.php'));  // Current User Details ?>
<div class="pure-g">
    <div class="pure-u-5-5 txtC">
        <h3>Request <?php echo nexus_requestID($postID); ?> Completion</h3>
        <p class="txtC">Please add any notes relevant to the closing of the request.</p>
        <form name="completion" id="completion" class="nexus_ajaxForm" data-function="nexus_completeJob">
            <div class="form-style-7 TEST">
                <textarea name="comments" id="comments"></textarea>
                <input type="hidden" name="posttype" id="posttype" value="<?php echo get_post_type($postID); ?>" />
                <input type="hidden" name="override" id="override" value="<?php echo $override; ?>" />
                <input type="hidden" name="desid" id="desid" value="<?php echo $cuID; ?>" />
                <input type="hidden" name="postid" id="postid" value="<?php echo $postID; ?>" />
            </div>
        </form>
        <a href="#completion" data-query="single_request" data-complete="true" data-user="<?php echo $cuID; ?>" data-postid="<?php echo $postID; ?>" class="green cta imgC nexus_ajaxSubmit" style="margin:10px auto 0 auto; display:block; max-width:300px;">Complete Request</a> 
        <a href="#" data-query="single_request" data-postid="<?php echo $postID; ?>" class="smallCTA imgC nexus_ajaxFunction" style="margin:10px auto 0 auto; display:block;">Cancel</a>
    </div>
</div>