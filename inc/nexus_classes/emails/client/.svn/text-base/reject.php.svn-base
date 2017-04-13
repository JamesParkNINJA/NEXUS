<h2>Your Request, <?php echo $oldID; ?>, has been rejected</h2>
<p>
    Hi there <?php echo $cfname; ?>,
</p>
<p>
    Your request has been rejected for the following reason(s):
</p>
<ul>
    <?php $reasonList = explode(', ', $reasons); foreach ($reasonList as $reason) { ?>
        <?php if ($reason && str_replace(' ','',$reason) != '') { ?><li><?php echo $reason; ?></li><?php } ?>
    <?php } ?>
</ul>
<p>
    Please amend your request and resubmit, or if you feel like this was in error, please contact <a href="mailto:<?php echo $designEmail; ?>"><?php echo $designEmail; ?></a> quoting your request ID (<?php echo $oldID; ?>) and we'll look into it for you.
</p>
<p>
    Best regards,<br>
    <?php echo $website_title; ?>
</p>