<?php include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options ?>
<?php include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details ?>
<?php  
    $designerData = nexus_userDetailsArray($designerID);
    $feedbackList = nexus_getUserFeedback($designerID);
?>

<div class="pure-g fullWidth designerBackground relative"></div>
<div class="pure-g relative designerProfile">
    <div class="pure-u-1-3 hide-sm hide-xs txtC requestCount activeR">
        <a class="ajaxFunction" href="#" data-requesttype="all" data-query="request_list" data-designer="<?php echo $designerID; ?>">
            <?php echo $designerData['activerequests']; ?>
        </a>
        <p>Active Requests</p>
    </div>
    
    <div class="pure-u-5-5 pure-u-md-1-3">
        <div class="userImage" style="background-image:url(<?php echo $designerData['img']; ?>);"><div></div></div>
        <h2 class="designerName txtC"><?php echo $designerData['fullname']; ?></h2>
        <ul class="rating txtC">
            <?php for ($i = 0; $i < (5 - $designerData['rating']); $i++) { ?>
                <li><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABOklEQVQ4jaXUsS8EURDH8c9tRK4lQmgJEqVk+Buu1ClOqyJR+FOUCvT+Aa3CXqETTnIdiotGI6IQxT1ybpe7Pb9kszPzZr/z3pu3r5bnuRG0kd6F5Ij44U+MAMuwn+wmPoYlD1MDS+lpjFL9L9Wx2+fvptjYwG3M9vmzKTYWcEpvzwbVTGOlqqUu17GIVSxjJfmTv3z3jg7auMcdOhHxVsvz/BBbQ2Y7ij5wnuEIt/+ESYyjDK840FvCuOrgICJev5b5ond4H8aAPWA/Il74uW/PCdqtAOtiLyKevwKDjXjEcQXgcUQ89QfKOjtdAVjILQPOVwAWcsuACxWAhdyy62uwahtnyW7q/UW/5RaAGeaSfY0TXPWNX2ATO1jHXKvVyiLi+44cBM7gEqe4KZm9VOAKawk8o9pRq6ZPtvM+PENCsKoAAAAASUVORK5CYII=" /></li>
            <?php } ?>
            <?php for ($i = 0; $i < $designerData['rating']; $i++) { ?>
                <li><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABMUlEQVQ4jbXTsS4EURTG8d/aSNiEkkgUFKJBQkNLwkq8gE6rVelpPIDCg2jQaDWmWI3Y0GxINtGQIBFWMXeTNTvMzoiT3MydM9/5zzdzzym1mnqJtXA9zRKWegD2IQr7eXxmibNiC3NhbWWJsxxWcI3xcN/ANF6KOtzpgAn7naIOR3CD4UT+CVNIrWwDK5jFgvjHz2MGAz+87A1X4sOKcIkaXkqtpkNso/zbp/QQHzgqtZqGcIbFPwIvsNqHZ2yILReNWmA8t0/5EeuoF4DVUQ2Mb21zHx40csAa4rF8aCeSfXiL/RzAPdx1JtIaeyQHcDSZSANO5AB2adOAkzmAXdpeHEbYDCvK0HbNchmv6Mc5DnCSqKliF8t4x6B4SlIdjuEYS6EgCRNyK0FzHGr+L74ARddCn3gEdJMAAAAASUVORK5CYII=" /></li>
            <?php } ?>
            <li class="count">(<?php echo nexus_getUserRatingCount($desID); ?>)</li>
        </ul>
        <p class="designerJob txtC"><?php echo $designerData['company']; ?></p>
        <p class="designerEmail txtC">
            <a href="mailto:<?php echo $designerData['email']; ?>"><?php echo $designerData['email']; ?></a>
        </p>
        <p class="designerPhone txtC"><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo $designerData['phone']; ?></p>
    </div>
    
    <div class="pure-u-1-3 hide-sm hide-xs txtC requestCount completeR">
        <a class="ajaxFunction" href="#" data-requesttype="complete" data-query="request_list" data-designer="<?php echo $designerID; ?>">
            <?php echo $designerData['completerequests']; ?>
        </a>
        <p>Complete Requests</p>
    </div>
    
    <?php if ($feedbackList) { ?>
    <?php foreach ($feedbackList as $quote) { ?>
    <div class="pure-u-5-5 pure-u-md-1-2">
        <div class="quoteContainer">
            <div class="pure-g">
                <div class="pure-u-5-5">
                    <p class="txtC"><i class="fa fa-quote-left fa-5x"></i></p>
                </div>
            </div>
            <div class="quotes">   
                <div class="pure-g">
                    <?php 
                        $client = userDetailsArray($quote['quotee']);
                        $theQuote = strip_tags($quote['quote']);
                        $quoteCount = get_num_of_words($theQuote);
                        $rating = strip_tags($quote['rating']);
                    ?>
                    <div class="quoteBox">                    
                        <div class="pure-g">
                            <div class="pure-u-5-5">
                                <p class="quote <?php if ($quoteCount > 15) { ?>smallQuote<?php } ?> txtC"><?php echo $theQuote; ?></p>
                                <ul class="rating txtC">
                                    <?php for ($i = 0; $i < $rating; $i++) { ?>
                                        <li><img src="<?php echo get_template_directory_uri(); ?>/images/star-small.png" /></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="pure-u-5-5">
                                <p class="quotee txtC"><?php echo $client['fullname']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php } else { ?>
        <div class="quoteBox">                    
            <div class="pure-g">
                <div class="pure-u-5-5">
                    <p class="quote txtC">&nbsp;</p>
                </div>
                <div class="pure-u-5-5">
                    <p class="quotee txtC" style="color:#666666;">No feedback, yet.</p>
                </div>
            </div>
        </div>
    <?php } ?>
</div>