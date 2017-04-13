<?php $signoffDates = get_post_meta($postID,'nexus_signoff_dates',true); if ($signoffDates) { 
    $signoff = date('d-m-Y', $signoffDates[0]['timestamp']); $signeeID = $signoffDates[0]['user']; ?>

<?php $completed = date('d-m-Y', get_post_meta($postID,'nexus_completion_date',true)); $desID = get_post_meta($postID,'nexus_assigned_user',true); ?>

<div class="seperator"></div> 

<div class="pure-u-5-5 txtC">
    <h3 style="margin:0; padding:0; background:rgba(255,255,255,1);">Request Summary</h3>
</div>
<div class="pure-u-5-5 pure-u-md-12-24 txtC leftContent">
    <h3 style="margin:0; padding:0;">Completed</h3>
    <?php echo $completed; ?>
    <?php $designerObject = get_userdata($desID); $desName = $designerObject->first_name.' '.$designerObject->last_name; ?>
    <p class="txtC signoffBY"><?php echo $desName; ?></p>
</div>
<div class="pure-u-5-5 pure-u-md-12-24 txtC rightContent">
    <h3 style="margin:0; padding:0;">Signed Off</h3>
    <?php echo $signoff; ?>
    <?php $signeeData = get_userdata($signeeID); $signee = $signeeData->first_name.' '.$signeeData->last_name; ?>
    <p class="txtC signoffBY"><?php echo $signee; ?></p>
</div>
<?php } ?>