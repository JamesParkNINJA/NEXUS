<?php include(locate_template('api/data/current_user.php')); // Current User Details ?>
<div class="pure-g designerList fullWidth">
<?php
    $userArgs = array( 'meta_key' => 'nexus_is_admin', 'meta_compare' => 'EXISTS', 'orderby' => 'display_name', 'order' => 'ASC' );
    $userArgs2 = array( 'orderby' => 'display_name', 'order' => 'ASC', 'role' => 'administrator' );
    
    $userArray = get_users( $userArgs ); $userArray2 = get_users( $userArgs2 );
    $memberList = array_merge( $userArray, $userArray2 );
?>
<?php if ($memberList) { foreach ($memberList as $member) { $desID = $member->ID; $des = nexus_userDetailsArray($desID); ?>
    <div class="pure-u-5-5 pure-u-sm-1-2 pure-u-md-1-3 menuItem designer txtC">
        <div class="pure-g">
            <div class="pure-u-5-5 relative" style="height:90px;">
                <div class="userImage" style="background-image:url(<?php echo $des['img']; ?>);"><div></div></div> 
            </div>
            <div class="pure-u-5-5 relative">
                <ul class="rating">
                    <?php for ($i = 0; $i < (5 - $des['rating']); $i++) { ?>
                        <li><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABOklEQVQ4jaXUsS8EURDH8c9tRK4lQmgJEqVk+Buu1ClOqyJR+FOUCvT+Aa3CXqETTnIdiotGI6IQxT1ybpe7Pb9kszPzZr/z3pu3r5bnuRG0kd6F5Ij44U+MAMuwn+wmPoYlD1MDS+lpjFL9L9Wx2+fvptjYwG3M9vmzKTYWcEpvzwbVTGOlqqUu17GIVSxjJfmTv3z3jg7auMcdOhHxVsvz/BBbQ2Y7ij5wnuEIt/+ESYyjDK840FvCuOrgICJev5b5ond4H8aAPWA/Il74uW/PCdqtAOtiLyKevwKDjXjEcQXgcUQ89QfKOjtdAVjILQPOVwAWcsuACxWAhdyy62uwahtnyW7q/UW/5RaAGeaSfY0TXPWNX2ATO1jHXKvVyiLi+44cBM7gEqe4KZm9VOAKawk8o9pRq6ZPtvM+PENCsKoAAAAASUVORK5CYII=" /></li>
                    <?php } ?>
                    <?php for ($i = 0; $i < $des['rating']; $i++) { ?>
                        <li><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABMUlEQVQ4jbXTsS4EURTG8d/aSNiEkkgUFKJBQkNLwkq8gE6rVelpPIDCg2jQaDWmWI3Y0GxINtGQIBFWMXeTNTvMzoiT3MydM9/5zzdzzym1mnqJtXA9zRKWegD2IQr7eXxmibNiC3NhbWWJsxxWcI3xcN/ANF6KOtzpgAn7naIOR3CD4UT+CVNIrWwDK5jFgvjHz2MGAz+87A1X4sOKcIkaXkqtpkNso/zbp/QQHzgqtZqGcIbFPwIvsNqHZ2yILReNWmA8t0/5EeuoF4DVUQ2Mb21zHx40csAa4rF8aCeSfXiL/RzAPdx1JtIaeyQHcDSZSANO5AB2adOAkzmAXdpeHEbYDCvK0HbNchmv6Mc5DnCSqKliF8t4x6B4SlIdjuEYS6EgCRNyK0FzHGr+L74ARddCn3gEdJMAAAAASUVORK5CYII=" /></li>
                    <?php } ?>
                    <li class="count">(<?php echo nexus_getUserRatingCount($desID); ?>)</li>
                </ul>
            </div>
            <div class="pure-u-5-5">
                <h2 class="designerName"><?php echo $des['fullname']; ?></h2>
                <p class="designerJob"><?php echo ($des['company'] ? $des['company'] : 'No Company'); ?></p>
                <p class="designerEmail"><?php echo $des['email']; ?></p>
                <p class="designerPhone"><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo ($des['phone'] ? $des['phone'] : '0000'); ?></p>
            </div>
        </div>
        
        <a class="menuButton nexus_ajaxFunction" data-query="member_profile" data-menu="member_profile" data-designer="<?php echo $desID; ?>" href="#"></a>
    </div>
<?php } } ?>
</div>