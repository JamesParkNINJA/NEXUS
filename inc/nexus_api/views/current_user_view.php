<?php include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details ?>
<div class="currentUserView hide-sm hide-xs">
    <div class="userImage userPhotoUpload" style="background-image:url(<?php echo $cuIMG; ?>);" data-type="usrIMG"><div></div></div>
    <form id="uploadDatImage" name="uploadDatImage">
        <input type="hidden" value="<?php echo $cuID; ?>" id="currentUserID" name="currentUserID" />
        <input type="hidden" value="usrIMG" id="uploadType" name="uploadType" />
        <input type="file" name="imageUpload" id="imageUpload" />
    </form>
    <h2 class="userName blueText"><?php echo $cuNAME; ?></h2>
    <ul class="rating txtL">
        <?php for ($i = 0; $i < (5 - $cuRATE); $i++) { ?>
            <li><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABOklEQVQ4jaXUsS8EURDH8c9tRK4lQmgJEqVk+Buu1ClOqyJR+FOUCvT+Aa3CXqETTnIdiotGI6IQxT1ybpe7Pb9kszPzZr/z3pu3r5bnuRG0kd6F5Ij44U+MAMuwn+wmPoYlD1MDS+lpjFL9L9Wx2+fvptjYwG3M9vmzKTYWcEpvzwbVTGOlqqUu17GIVSxjJfmTv3z3jg7auMcdOhHxVsvz/BBbQ2Y7ij5wnuEIt/+ESYyjDK840FvCuOrgICJev5b5ond4H8aAPWA/Il74uW/PCdqtAOtiLyKevwKDjXjEcQXgcUQ89QfKOjtdAVjILQPOVwAWcsuACxWAhdyy62uwahtnyW7q/UW/5RaAGeaSfY0TXPWNX2ATO1jHXKvVyiLi+44cBM7gEqe4KZm9VOAKawk8o9pRq6ZPtvM+PENCsKoAAAAASUVORK5CYII=" /></li>
        <?php } ?>
        <?php for ($i = 0; $i < $cuRATE; $i++) { ?>
            <li><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABMUlEQVQ4jbXTsS4EURTG8d/aSNiEkkgUFKJBQkNLwkq8gE6rVelpPIDCg2jQaDWmWI3Y0GxINtGQIBFWMXeTNTvMzoiT3MydM9/5zzdzzym1mnqJtXA9zRKWegD2IQr7eXxmibNiC3NhbWWJsxxWcI3xcN/ANF6KOtzpgAn7naIOR3CD4UT+CVNIrWwDK5jFgvjHz2MGAz+87A1X4sOKcIkaXkqtpkNso/zbp/QQHzgqtZqGcIbFPwIvsNqHZ2yILReNWmA8t0/5EeuoF4DVUQ2Mb21zHx40csAa4rF8aCeSfXiL/RzAPdx1JtIaeyQHcDSZSANO5AB2adOAkzmAXdpeHEbYDCvK0HbNchmv6Mc5DnCSqKliF8t4x6B4SlIdjuEYS6EgCRNyK0FzHGr+L74ARddCn3gEdJMAAAAASUVORK5CYII=" /></li>
        <?php } ?>
        <li class="count">(<?php echo nexus_getUserRatingCount($cuID); ?>)</li>
    </ul>
    <ul class="requestStats <?php echo $cuTYPE; ?>">
        <?php if ($cuTYPE == 'client') { ?>
            <li>
                <a class="nexus_ajaxFunction" href="#" data-requesttype="all" data-query="request_list" data-user="<?php echo $cuID; ?>">
                    <strong class="activeRequests"><?php echo $cuACTIVE; ?></strong> Active Requests
                </a>
            </li>
            <li>
                <a class="nexus_ajaxFunction <?php if (nexus_needsAction($cuID,'all') > 0){ ?>action<?php } else { ?>disabled<?php } ?>" data-requestType="action" data-query="request_list" data-user="<?php echo $cuID; ?>" href="#">
                    <strong class="needsAction"><?php echo $cuACTION; ?></strong> Require Action
                </a>
            </li>
        <?php } ?>
        <?php if ($cuTYPE == 'designer') { ?>
            <li>
                <a class="nexus_ajaxFunction" href="#" data-requesttype="all" data-query="request_list" data-designer="<?php echo $cuID; ?>">
                    <strong class="activeRequests"><?php echo $cuACTIVE; ?></strong> Active Requests
                </a>
            </li>
            <li>
                <a class="nexus_ajaxFunction" href="#" data-requesttype="complete" data-query="request_list" data-designer="<?php echo $cuID; ?>">
                    <strong class="completeRequests"><?php echo $cuCOMPLETE; ?></strong> Complete
                </a>
            </li>
        <?php } ?>
    </ul>
</div>

<div class="currentUserView hide-md hide-lg hide-xl">
    <div class="userImage mobileMenu" style="background-image:url(<?php echo $cuIMG; ?>);" data-type="usrIMG"><div></div></div>
    <a href="<?php echo $nexus_DASHBOARDURL; ?>" class="logoMobile opacityButton">
        <img src="<?php echo $nexus_LOGO; ?>" />
    </a>
</div>