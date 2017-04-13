<h2>Request rejected</h2>
<p>
    A request (<?php echo $oldID; ?>) has been rejected for the following reason(s):
</p>
<ul>
    <?php $reasonList = explode(', ', $reasons); foreach ($reasonList as $reason) { ?>
        <?php if ($reason && str_replace(' ','',$reason) != '') { ?><li><?php echo $reason; ?></li><?php } ?>
    <?php } ?>
</ul>
<p>
    You can view the job from this link: <a href="<?php echo $permalink; ?>"><?php echo $pname; ?></a>
</p>
<p>
    Best regards,<br>
    <?php echo $website_title; ?>
</p>