<?php include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options ?>
<?php include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details ?>
<div class="pure-g">
    <div class="pure-u-5-5 txtC">
        <h3>Reject Request <?php echo nexus_requestID($postID); ?></h3>
        <p class="txtC">What's the reasoning for rejecting the request?</p>
        <form name="cancelForm" id="cancelForm" class="nexus_ajaxForm" data-function="nexus_denyRequest">
            <div class="form-style-7 TEST">
                <div class="pure-g">
                    <div class="pure-u-5-5">
                        <label for="reason-1" class="css-label">Insufficient Information</label>
                        <input class="css-checkbox" id="reason-1" type="checkbox" name="cancelReasons[]" value="Insufficient Information" />
                        <label for="reason-2" class="css-label">Missing Assets</label>
                        <input class="css-checkbox" id="reason-2" type="checkbox" name="cancelReasons[]" value="Missing Assets" />
                        <label for="reason-3" class="css-label">Other</label>
                        <input class="css-checkbox" id="reason-3" type="checkbox" name="cancelReasons[]" value="Other" />
                        <div class="otherRejection" style="display:none;">
                            <label for="otherRejection">Other Reason</label>
                            <input type="text" name="otherRejection" />
                        </div>                                               
                    </div>
                </div>
            </div>
            <input type="hidden" name="type" id="type" value="<?php echo get_post_type($postID); ?>" />
            <input type="hidden" name="user" id="user" value="<?php echo get_current_user_id(); ?>" />
            <input type="hidden" name="project" id="project" value="<?php echo $postID; ?>" />
        </form>
        <a href="#cancelForm" data-query="single_request" data-reject="true" data-user="<?php echo $cuID; ?>" data-postid="<?php echo $postID; ?>" class="denyButton cta imgC nexus_ajaxSubmit" style="margin:10px auto 0 auto; display:block; max-width:300px;">Reject Request</a> 
        <a href="#" data-query="single_request" data-postid="<?php echo $postID; ?>" class="smallCTA imgC nexus_ajaxFunction" style="margin:10px auto 0 auto; display:block;">Cancel</a> 
    </div>
</div>

<script>
    $(document).on('change','#reason-3',function(e){
        if ($(this).is(':checked')) {
            $('.otherRejection').fadeIn();
        } else {
            $('.otherRejection').fadeOut().find('input').val('');
        }
    });
</script>