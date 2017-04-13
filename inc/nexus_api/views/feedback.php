<?php include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options ?>
<?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $projectID = $_POST['project']; 
    } else {
        $projectID = $_GET['project'];
    }
    $authID = get_post_field( 'post_author', $projectID );

    if ($projectID) { 
    if ($cuTYPE == 'designer' || get_current_user_id() == $authID) {
    if (get_post_type('nexus_complete',$projectID)) { if (get_post_meta($projectID, 'nexus_request_feedback',true)) {
        $uhoh = false;
?>

<div class="pure-u-5-5">&nbsp;</div>

<div class="pure-u-5-5 txtC">    
    <h1 class="contract">
        "<?php echo get_the_title($projectID); ?>"
    </h1>
    
    <h2 class="contract">
        Request Feedback
    </h2>
</div>

<div class="pure-u-5-5 txtC">
    <?php $rating = intval(get_post_meta($projectID,'nexus_request_rating',true), 10); ?>
    <ul class="rating txtC">
        <?php for ($i = 0; $i < $rating; $i++) { ?>
            <li><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABMUlEQVQ4jbXTsS4EURTG8d/aSNiEkkgUFKJBQkNLwkq8gE6rVelpPIDCg2jQaDWmWI3Y0GxINtGQIBFWMXeTNTvMzoiT3MydM9/5zzdzzym1mnqJtXA9zRKWegD2IQr7eXxmibNiC3NhbWWJsxxWcI3xcN/ANF6KOtzpgAn7naIOR3CD4UT+CVNIrWwDK5jFgvjHz2MGAz+87A1X4sOKcIkaXkqtpkNso/zbp/QQHzgqtZqGcIbFPwIvsNqHZ2yILReNWmA8t0/5EeuoF4DVUQ2Mb21zHx40csAa4rF8aCeSfXiL/RzAPdx1JtIaeyQHcDSZSANO5AB2adOAkzmAXdpeHEbYDCvK0HbNchmv6Mc5DnCSqKliF8t4x6B4SlIdjuEYS6EgCRNyK0FzHGr+L74ARddCn3gEdJMAAAAASUVORK5CYII=" /></li>
        <?php } ?>
    </ul>
</div>

<div class="pure-u-5-5">&nbsp;</div>

<div class="pure-u-5-5">
    <div class="pure-g">
        <div class="pure-u-5-5 txtC">
            <p>
                <?php echo get_post_meta($projectID,'nexus_request_feedback',true); ?>
            </p>
        </div>
    </div> 
</div>

<div class="pure-u-5-5">&nbsp;</div>
    
<?php } else { $uhoh = true; } } else { $uhoh = true; } } else { $uhoh = true; } } else { $uhoh = true; } ?>
    
<?php if ($uhoh) { ?>
    
    <div class="pure-u-5-5">&nbsp;</div>
    
    <div class="pure-u-5-5">&nbsp;</div>
    
    <div class="pure-u-5-5 contentTitle">
        <h1>Uh-oh... You really shouldn't be here...</h1>
        <p>Looks like there's been an error, or you've reached this page through extraneous means.</p>
        <p>In any case, <a href="<?php echo $nexus_DASHBOARDURL; ?>">click here</a> to go back, or if you think you <strong><em>should</em></strong> be seeing something here, please contact us on <a href="mailto:<?php echo $nexus_EMAIL; ?>"><?php echo $nexus_EMAIL; ?></a> quoting your request ID (<?php echo $projectID; ?>), and we'll try to help as soon as possible.</p>
    </div>
    
    <div class="pure-u-5-5">&nbsp;</div>
    
    <div class="pure-u-5-5">&nbsp;</div>
    
<?php } ?>