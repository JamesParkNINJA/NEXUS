<?php include(locate_template('api/data/current_user.php')); // Current User Details ?>

<h3>Questions, Files, Etc</h3>

<div class="chatContainer" id="chatContainer"><div id="chatInner" class="mCustomScrollbar" data-mcs-theme="minimal"><div class="pure-g">
    <?php 
        /* 
        if (have_rows('chat_log',$postID)) : $ci = 0; while (have_rows('chat_log',$postID)) : the_row(); $ci = $ci + 1;
            $chatLog[$ci]['timestamp'] = get_sub_field('timestamp'); 
            $chatLog[$ci]['user'] = get_sub_field('user'); 
            $chatLog[$ci]['text'] = get_sub_field('text');
        endwhile; endif;
        */
    
        $chatLog = get_post_meta($postID,'nexus_chat_log',true);  
        $prevUser = ''; $same = false;
        if ($chatLog) { $cci = 0;
        foreach($chatLog as $chatOutput) { 
            if (trim($chatOutput['text']) != '') {
            $cci = $cci + 1;
            $userDetails = nexus_userDetailsArray($chatOutput['user']);

            if ($chatOutput['user'] == $prevUser) { $same = true; } else { $same = false; $prevUser = $chatOutput['user']; } ?>

            <?php if ($cuID == $chatOutput['user']) { ?>
                <div class="pure-u-4-24 txtC chatUser clientUser">&nbsp;</div>
            <?php } ?>
            
            <div class="pure-u-18-24 pure-u-md-20-24 <?php echo ($cuID != $chatOutput['user'] ? 'clientComment' : 'userComment'); ?>">
                <div class="commentBubble" 
                     title="<?php echo $chatOutput['timestamp']; ?>"
                     alt="<?php echo $chatOutput['timestamp']; ?>">
                    <?php $output = str_replace('%5C', '\\', $chatOutput['text']); $output = str_replace('%2F', '/', $output); $output = str_replace('%20', ' ', $output); ?>
                    <span class="dont-break-out"><?php echo $output; ?></span>
                </div>
            </div>

            <?php if ($cuID != $chatOutput['user']) { ?>
                <div class="pure-u-4-24 txtC chatUser currentUser">&nbsp;</div>
            <?php } ?>
    <?php } } } else { ?>
    <div class="pure-u-5-5" id="noMessage"><h3 class="txtC" style="color:#666666;">- No Messages -</h3></div>
    <?php } ?>
</div></div></div>
<div class="chatInput">
    <div class="pure-g">
        <div class="pure-u-19-24" style="position:relative;">
            <input type="text" name="nexus_chatlog" data-user="<?php echo $cuID; ?>" data-post="<?php echo $postID; ?>" />
            <input type="text" name="nexus_chatFile" placeholder="Upload File" disabled="disabled" data-filetype="" />
            <a href="#" class="nexus_chatButton chatMedia"><i class="fa fa-upload" aria-hidden="true"></i></a>
        </div>
        <div class="pure-u-5-24"><a href="#" class="nexus_chatlogSubmit nexus_ajaxChat txtC" data-post="<?php echo $postID; ?>" data-user="<?php echo $cuID; ?>">SUBMIT</a></div>
    </div>
</div>