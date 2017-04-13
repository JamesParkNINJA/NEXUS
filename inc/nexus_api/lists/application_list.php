<?php
    include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options
    include(nexus_plugin_inc('nexus_api/data/current_user.php'));  // Current User Details

    $applications = get_post_meta($postID, 'nexus_job_application', true);
    $list = (array)$applications;
?>
<div class="pure-g">
<?php
    foreach ($list as $application) {
        $details = nexus_auto_add_link_markup($application['application']);
        $userID = $application['userID'];
        $userDetails = nexus_userDetailsArray($userID);
        if ($userID && trim($userID) != '') {
?>

<div class="pure-u-5-5 pure-u-md-1-2">
    <div class="pure-g application">
        <div class="application__inner card">
            <div class="pure-u-5-5 pure-u-md-6-24 txtC relative">
                <a class="nexus_ajaxFunction fullLink" data-query="member_profile" data-menu="member_profile" data-designer="<?php echo $userID; ?>" href="#" data-backto="<?php echo $postID; ?>"></a>
                <div class="profileIMG" style="background-image:url('<?php echo $userDetails['img']; ?>')"></div>
                <h2 class="userName blueText"><?php echo $userDetails['fullname']; ?></h2>
                <ul class="rating">
                    <?php for ($i = 0; $i < (5 - $userDetails['rating']); $i++) { ?>
                        <li><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABOklEQVQ4jaXUsS8EURDH8c9tRK4lQmgJEqVk+Buu1ClOqyJR+FOUCvT+Aa3CXqETTnIdiotGI6IQxT1ybpe7Pb9kszPzZr/z3pu3r5bnuRG0kd6F5Ij44U+MAMuwn+wmPoYlD1MDS+lpjFL9L9Wx2+fvptjYwG3M9vmzKTYWcEpvzwbVTGOlqqUu17GIVSxjJfmTv3z3jg7auMcdOhHxVsvz/BBbQ2Y7ij5wnuEIt/+ESYyjDK840FvCuOrgICJev5b5ond4H8aAPWA/Il74uW/PCdqtAOtiLyKevwKDjXjEcQXgcUQ89QfKOjtdAVjILQPOVwAWcsuACxWAhdyy62uwahtnyW7q/UW/5RaAGeaSfY0TXPWNX2ATO1jHXKvVyiLi+44cBM7gEqe4KZm9VOAKawk8o9pRq6ZPtvM+PENCsKoAAAAASUVORK5CYII=" /></li>
                    <?php } ?>
                    <?php for ($i = 0; $i < $userDetails['rating']; $i++) { ?>
                        <li><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABMUlEQVQ4jbXTsS4EURTG8d/aSNiEkkgUFKJBQkNLwkq8gE6rVelpPIDCg2jQaDWmWI3Y0GxINtGQIBFWMXeTNTvMzoiT3MydM9/5zzdzzym1mnqJtXA9zRKWegD2IQr7eXxmibNiC3NhbWWJsxxWcI3xcN/ANF6KOtzpgAn7naIOR3CD4UT+CVNIrWwDK5jFgvjHz2MGAz+87A1X4sOKcIkaXkqtpkNso/zbp/QQHzgqtZqGcIbFPwIvsNqHZ2yILReNWmA8t0/5EeuoF4DVUQ2Mb21zHx40csAa4rF8aCeSfXiL/RzAPdx1JtIaeyQHcDSZSANO5AB2adOAkzmAXdpeHEbYDCvK0HbNchmv6Mc5DnCSqKliF8t4x6B4SlIdjuEYS6EgCRNyK0FzHGr+L74ARddCn3gEdJMAAAAASUVORK5CYII=" /></li>
                    <?php } ?>
                    <li class="count">(<?php echo nexus_getUserRatingCount($userID); ?>)</li>
                </ul>
            </div>
            <div class="pure-u-5-5 pure-u-md-18-24 application__details">
                <h3>Application Details:</h3>
                <?php echo $details; ?>
                <a href="#" class="nexus_ajaxFunction green cta txtC" data-requesttype="<?php echo get_post_type($postID); ?>" data-postid="<?php echo $postID; ?>" data-query="pick_handler" data-menu="single_request" data-user="<?php echo $userID; ?>">Accept <?php echo $userDetails['firstname']; ?>'s Application</a>
            </div>
        </div>
    </div>
</div>

<?php } } ?>
</div>