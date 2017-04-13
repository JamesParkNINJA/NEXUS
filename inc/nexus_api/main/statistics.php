<div class="pure-g">
    
    <?php $args = array('post_type' => 'nexus_complete', 'posts_per_page' => 1, 'orderby' => 'date', 'order' => 'ASC'); $allRequests = get_posts($args); $firstDate = get_the_date('d-m-Y',$allRequests[0]->ID); $fdTS = strtotime($firstDate); ?>

    <?php include(nexus_plugin_inc('nexus_api/data/statistics_calculation.php')); // Completed Request Figures ?>
    
    <div class="pure-u-5-5 txtC">&nbsp;</div>
    
    <div class="pure-u-5-5">
        <h1 class="txtC">Completed Requests</h1>
    </div>
    
    <div class="pure-u-5-5 pure-u-md-1-2 txtC">
        <h3 class="txtC">Total Completed</h3> 
        <div class="circleLoad1">
            <table  align="center" style="z-index:40;">
                <tr>
                    <td>
                        <h2 class="hPad txtXL txtC txtB txtWhite">
                            <?php echo $completedRequests; ?>
                        </h2>
                        <p class="txtC txtWhite" style="padding:0 10px; margin:0;">
                            COMPLETED
                        </p>
                    </td>
                </tr>
            </table>
            <div class="aspect"></div>
        </div>
        <script>
            var progressBar1 = new ProgressBar.Circle('.circleLoad1', {
                strokeWidth: 5,
                color:'#0055aa',
                duration: 1800,
                fill: '<?php if ($completedRequests > 0) { ?>#00ADEF<?php } else { ?>#a8a8a8<?php } ?>'
            }); 
            
            progressBar1.animate(1);
        </script>
    </div>
        
    <div class="pure-u-5-5 pure-u-md-1-2">
        <h3 class="txtC">Per Request Type</h3> 
        <table class="statsTable">  
            <tr>
                <th class="key" colspan="2">Request Type</th>
                <th class="value" colspan="2">Amount</th>
            </tr>
            <?php $totalTypesArray = $completedTypes['full']; ?>
            <?php foreach ($totalTypesArray as $type => $value) { ?>
                <tr>
                    <td class="key" colspan="2"><?php echo $type; ?>:</td>
                    <td class="value" colspan="2"><?php echo $value; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    
    <div class="pure-u-5-5 txtC">&nbsp;</div>
        
    <div class="pure-u-5-5">
        <h3 class="txtC">Per Designer</h3> 
    </div>
    
    <?php foreach ($adminUsers as $adminUser) { ?>
    <?php $adminUserObj = nexus_userDetailsArray($adminUser); ?>
    <?php $desName = $adminUserObj['firstname'].' '.$adminUserObj['lastname']; ?>
    <div class="pure-u-5-5 pure-u-md-1-3">
        <?php if ($completedTypes[$desName]['count']['full'] == 0) { $tableCSS = 'greyTable'; } else { $tableCSS = ''; } ?>
        <table class="statsTable <?php echo $tableCSS; ?>"> 
            <tr>
                <th class="key" colspan="2"><?php echo $desName; ?></th>
                <th class="value" colspan="2"><?php echo $completedTypes[$desName]['count']['full']; ?></th>
            </tr>    
            
            <?php $desStats = $completedTypes[$desName]['count']; ?> 
            <?php print_r($completedTypes); ?>
            <?php foreach ($desStats as $type => $value) { ?>
                <?php if ($type != 'full') { ?>
                    <tr>
                        <td class="key" colspan="2"><?php echo $type; ?>:</td>
                        <td class="value" colspan="2"><?php echo $value; ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
    </div>
    <?php } ?>
    
    <?php $tableCSS = ''; ?>
    
    <div class="pure-u-5-5 txtC">&nbsp;</div>
    
    <div class="pure-u-5-5 txtC">&nbsp;</div>
    
    <div class="pure-u-5-5">
        <h1 class="txtC">RATINGS</h1> 
    </div>
        
    <div class="pure-u-5-5">
        <h3 class="txtC">Per Designer</h3> 
    </div>
    
    <?php foreach ($adminUsers as $adminUser) { ?>
    <?php $adminUserObj = nexus_userDetailsArray($adminUser); ?>
    <div class="pure-u-5-5 pure-u-md-1-3">
        <table class="statsTable"> 
            <?php $desName = $adminUserObj['user_firstname'].' '.$adminUserObj['user_lastname']; ?>
            <tr>
                <th class="key" colspan="2"><?php echo $desName; ?></th>
            </tr>
            <tr>
                <td class="stars" colspan="2">
                    <?php $rating = $completedTypes[$desName]['ratings']['full']; ?>
                    <?php if (!$rating || $rating <= 0) { $rating = 5; } ?>
                    <ul class="rating txtC">
                        <?php for ($i = 0; $i < $rating; $i++) { ?>
                            <li><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABMUlEQVQ4jbXTsS4EURTG8d/aSNiEkkgUFKJBQkNLwkq8gE6rVelpPIDCg2jQaDWmWI3Y0GxINtGQIBFWMXeTNTvMzoiT3MydM9/5zzdzzym1mnqJtXA9zRKWegD2IQr7eXxmibNiC3NhbWWJsxxWcI3xcN/ANF6KOtzpgAn7naIOR3CD4UT+CVNIrWwDK5jFgvjHz2MGAz+87A1X4sOKcIkaXkqtpkNso/zbp/QQHzgqtZqGcIbFPwIvsNqHZ2yILReNWmA8t0/5EeuoF4DVUQ2Mb21zHx40csAa4rF8aCeSfXiL/RzAPdx1JtIaeyQHcDSZSANO5AB2adOAkzmAXdpeHEbYDCvK0HbNchmv6Mc5DnCSqKliF8t4x6B4SlIdjuEYS6EgCRNyK0FzHGr+L74ARddCn3gEdJMAAAAASUVORK5CYII=" /></li>
                        <?php } ?>
                    </ul>
                </td>
            </tr>    
        </table>
    </div>
    <?php } ?> 
    
    <div class="pure-u-5-5 txtC">&nbsp;</div>
        
    <?php if($allClientRatings) { ?>
        <div class="pure-u-5-5">
            <h3 class="txtC">Per Client</h3> 
        </div>
    
        <?php foreach ($allClientRatings as $client => $rating) { ?>
        <div class="pure-u-5-5 pure-u-md-1-3">
            <table class="statsTable"> 
                <tr>
                    <th class="key" colspan="2"><?php echo $client; ?></th>
                </tr>
                <tr>
                    <td class="stars" colspan="2">
                        <?php if (!$rating || $rating <= 0) { $rating = 5; } ?>
                        <ul class="rating txtC">
                            <?php for ($i = 0; $i < $rating; $i++) { ?>
                                <li><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABMUlEQVQ4jbXTsS4EURTG8d/aSNiEkkgUFKJBQkNLwkq8gE6rVelpPIDCg2jQaDWmWI3Y0GxINtGQIBFWMXeTNTvMzoiT3MydM9/5zzdzzym1mnqJtXA9zRKWegD2IQr7eXxmibNiC3NhbWWJsxxWcI3xcN/ANF6KOtzpgAn7naIOR3CD4UT+CVNIrWwDK5jFgvjHz2MGAz+87A1X4sOKcIkaXkqtpkNso/zbp/QQHzgqtZqGcIbFPwIvsNqHZ2yILReNWmA8t0/5EeuoF4DVUQ2Mb21zHx40csAa4rF8aCeSfXiL/RzAPdx1JtIaeyQHcDSZSANO5AB2adOAkzmAXdpeHEbYDCvK0HbNchmv6Mc5DnCSqKliF8t4x6B4SlIdjuEYS6EgCRNyK0FzHGr+L74ARddCn3gEdJMAAAAASUVORK5CYII=" /></li>
                            <?php } ?>
                        </ul>
                    </td>
                </tr>    
            </table>
        </div>
        <?php } ?> 
    
    <?php } ?> 
    
    <div class="pure-u-5-5 txtC">&nbsp;</div>
    
    <div class="pure-u-5-5 txtC">&nbsp;</div>
    
    <?php if ($rejectedRequestsAll) { ?>
    
    <div class="pure-u-5-5">
        <h1 class="txtC">REJECTED JOBS</h1> 
    </div>
    
    <div class="pure-u-5-5 pure-u-md-1-2 txtC">
        <h3 class="txtC">Total Rejected</h3> 
        <div class="circleLoad2">
            <table  align="center" style="z-index:40;">
                <tr>
                    <td>
                        <h2 class="hPad txtXL txtC txtB txtWhite">
                            <?php echo $rejectedRequestsAll; ?>
                        </h2>
                        <p class="txtC txtWhite" style="padding:0 10px; margin:0;">
                            REJECTED
                        </p>
                    </td>
                </tr>
            </table>
            <div class="aspect"></div>
        </div>
        <script>
            var progressBar2 = new ProgressBar.Circle('.circleLoad2', {
                strokeWidth: 5,
                color:'#aa0000',
                duration: 1800,
                fill: '<?php if ($rejectedRequestsAll > 0) { ?>#ed2f2f<?php } else { ?>#a8a8a8<?php } ?>'
            }); 
            
            progressBar2.animate(1);
        </script>
    </div>
        
    <div class="pure-u-5-5 pure-u-md-1-2">
        <h3 class="txtC">By Request Type</h3> 
        <table class="statsTable rejected">  
            <tr>
                <th class="key" colspan="2">Type</th>
                <th class="value" colspan="2">Amount</th>
            </tr>
            <?php $rejTypeArray = $rejectedTypes['full']; ?>
            <?php foreach ($rejTypeArray as $type => $value) { if ($value > 0) { ?>
                <tr>
                    <td class="key" colspan="2"><?php echo $type; ?>:</td>
                    <td class="value" colspan="2"><?php echo $value; ?></td>
                </tr>
            <?php } } ?>
        </table>
    </div>
    
    <div class="pure-u-5-5 txtC">&nbsp;</div>
        
    <?php if($clientRejections) { ?>
        <div class="pure-u-5-5">
            <h3 class="txtC">Per Client</h3> 
        </div>
        <?php foreach ($clientRejections as $client => $reject) { ?>
        <div class="pure-u-5-5 pure-u-md-1-3">
            <table class="statsTable rejected"> 
                <tr>
                    <th class="key" colspan="2"><?php echo $client; ?></th>
                    <th class="value" colspan="2"><?php echo $reject['total']; ?></th>
                </tr>
                <?php foreach ($reject as $reason => $value) { ?>
                    <?php if ($reason != 'total') { ?>
                        <tr>
                            <td class="key" colspan="2"><?php echo $reason; ?>:</td>
                            <td class="value" colspan="2"><?php echo $value; ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>    
            </table>
        </div>
        <?php } ?> 
    
    <?php } ?> 
    
    <?php } ?>
        
</div>