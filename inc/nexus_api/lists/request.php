<?php

    include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options
    include(nexus_plugin_inc('nexus_api/data/current_user.php'));  // Current User Details

    // Post Type Selection
    $customTypeArray = nexus_output_post_types('array_single'); $compArray = array('nexus_complete'); $rejArray = array('nexus_rejected');
    $fullTypeArray = $customTypeArray + $compArray + $rejArray; $completeArray = $customTypeArray + $compArray;

    $reqType = ($requestType == 'all' ? $customTypeArray : $requestType);
    $reqType = ($requestType == 'search' ? $fullTypeArray : $reqType);
    $reqType = ($requestType == 'action' ? $completeArray : $reqType);

    $requestObject = get_post_type_object($reqType); $requestLabel = $requestObject->labels->name;
    $requestLabel = ($requestType == 'all' ? 'Requests' : $requestObject->labels->name);
    $requestLabel = ($requestType == 'search' ? 'Search Results' : $requestLabel);

    $sortBy = array(
        'post_type' => $reqType,
        'posts_per_page' => -1,
        'order' => 'ASC'
    );

    $sortByNew = array(
        'post_type' => $reqType,
        'posts_per_page' => -1,
        'order' => 'ASC',
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'nexus_assigned_user',
                'compare' => 'NOT EXISTS'
            ),
            array(
                'key' => 'nexus_assigned_user',
                'value' => '',
                'compare' => '=='
            )
        )
    );

    $sortByAssigned = array(
        'post_type' => $reqType,
        'posts_per_page' => -1,
        'order' => 'ASC',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'nexus_assigned_user',
                'compare' => 'EXISTS'
            ),
            array(
                'key' => 'nexus_assigned_user',
                'value' => '',
                'compare' => '!='
            )
        )
    );

    $sortBySignoff = array(
        'post_type' => $reqType,
        'posts_per_page' => -1,
        'order' => 'ASC',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'nexus_signoff_toggle',
                'value' => 1,
                'compare' => '==',
            ),
        ),
    );

    if ($userQuery && $userQuery != '') {
        $sortBy['author'] = $userQuery;
    }

    if ($designerID && $designerID != '') {
        $sortByAssigned['meta_query'][] = array('key'=>'nexus_assigned_user','value'=>$designerID,'compare'=>'==');
        $sortBySignoff['meta_query'][] = array('key'=>'nexus_assigned_user','value'=>$designerID,'compare'=>'==');
    }

    if ($reqType == 'action') {
        $sortBy['meta_query'] = array (
            'relation' => 'OR',
            array(
                'key' => 'nexus_feedback_toggle',
                'value' => 1,
                'compare' => '=='
            ),
            array(
                'key' => 'nexus_signoff_toggle',
                'value' => 1,
                'compare' => '=='
            )
        );
    }

    if ($requestType == 'nexus_complete' && !$designerID) {
        $sortBy['orderby'] = 'meta_value';
        $sortBy['meta_key'] = 'nexus_prior_type';
    }

    // Arguments and post counts
    $args = $sortBy;
    $the_query = new WP_Query($args); 

    if ($requestType == 'search') {
    $reqCount = $the_query->found_posts;
    $reqCount = $reqCount - 1; 
?>
<div class="pure-u-5-5">
    <?php $mainTitle = ($reqCount == 1 ? rtrim(rtrim($requestLabel,'s'),'S') : $requestLabel); ?>
    <h1 class="txtC"><strong id="resultAmount"><?php echo $reqCount; ?></strong> <?php echo $mainTitle; ?><strong id="resultFor"></strong></h1>
</div>
<?php } ?>

<?php 
    if (is_user_logged_in()) {
        if ($requestType == 'nexus_complete') { 
            include(nexus_plugin_inc('nexus_api/panels/com_filter.php')); 
        } else { 
            include(nexus_plugin_inc('nexus_api/panels/filter.php')); 
        } 
    }
?>

<div class="pure-g fullWidth" id="requestListContainer">
    
<?php 
    if ($requestType == 'action' || $requestType == 'search') { 
        
        $the_query = new WP_Query( $args ); if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            include(nexus_plugin_inc('nexus_api/panels/request_preview.php'));
        endwhile; endif; wp_reset_query(); 
        
    } elseif ($requestType == 'nexus_complete') {
        
        $comQ = new WP_Query( $sortBy ); if ( $comQ->have_posts() ) : while ( $comQ->have_posts() ) : $comQ->the_post();
            include(nexus_plugin_inc('nexus_api/panels/request_preview.php'));
        endwhile; endif; wp_reset_query(); 
        
    } else {
        
        if (!$designerID) {
            $newQ = new WP_Query($sortByNew); if ( $newQ->have_posts() ) : ?>
                <div class="pure-u-5-5">
                    <h2 class="subsection">
                        <?php echo $newQ->found_posts; ?> New Requests
                    </h2>
                </div>
            <?php while ( $newQ->have_posts() ) : $newQ->the_post();
                include(nexus_plugin_inc('nexus_api/panels/request_preview.php'));
            endwhile; endif; wp_reset_query();
        }
        
        $assQ = new WP_Query($sortByAssigned); if ( $assQ->have_posts() ) : $assC = 0; while ( $assQ->have_posts() ) : $assQ->the_post(); if (get_post_meta(get_the_ID(), 'nexus_signoff_toggle',true) != 1) { $assC = $assC + 1; } endwhile; ?>
            <div class="pure-u-5-5">
                <h2 class="subsection">
                    <?php echo $assC; ?> Assigned Requests
                </h2>
            </div>
        <?php while ( $assQ->have_posts() ) : $assQ->the_post(); if (get_post_meta(get_the_ID(), 'nexus_signoff_toggle',true) != 1) {
            include(nexus_plugin_inc('nexus_api/panels/request_preview.php'));
        } endwhile; endif; wp_reset_query();
        
        $sigQ = new WP_Query($sortBySignoff); if ( $sigQ->have_posts() ) : ?>
            <div class="pure-u-5-5">
                <h2 class="subsection">
                    <?php echo $sigQ->found_posts; ?> Awaiting Sign-Off
                </h2>
            </div>
        <?php while ( $sigQ->have_posts() ) : $sigQ->the_post();
            include(nexus_plugin_inc('nexus_api/panels/request_preview.php'));
        endwhile; endif; wp_reset_query();
        
    }
?>

<script>
        
    function searchInput(theType, theVal) {
        jQuery('input[type="text"].searchInput:not([data-type="'+theType+'"])').val('');
        jQuery('select.searchInput').val('na');

        if (theVal != '') {
            jQuery('div.requestContainer[data-'+theType+'*="'+theVal+'"]').each(function() {
                jQuery(this).fadeIn();
            });
            jQuery('div.requestContainer').not('[data-'+theType+'*="'+theVal+'"]').each(function() {
                jQuery(this).fadeOut();
            });
        } else {
            jQuery('.requestContainer').each(function() {
                if (!jQuery(this).hasClass('printOnly')) {
                    jQuery(this).fadeIn();
                }
            });
        }    
    }
    
         
     // Search Input Functions
         // Reorder functions
            jQuery(document).on('click', '.reorder-requests', function(e) {
                e.preventDefault();
                var type = jQuery(this).attr('data-type'),
                    order = jQuery(this).attr('data-order'),
                    list = jQuery('.requestContainer'),
                    container = jQuery('#requestListContainer');

                if (type == 'default') {
                    var sorted = list.sort(function(a, b){
                        return jQuery(a).data('date')-jQuery(b).data('date');
                    });
                } else {
                    if (order == 'asc') {
                        var sorted = list.sort(function(a, b) {
                            var aD = jQuery(a).data(type).toLowerCase(),
                                bD = jQuery(b).data(type).toLowerCase();

                            return aD.localeCompare(bD);
                        });
                        jQuery(this).attr('data-order', 'desc');
                    } else {
                        var sorted = list.sort(function(a, b) {
                            var aD = jQuery(a).data(type).toLowerCase(),
                                bD = jQuery(b).data(type).toLowerCase();

                            return bD.localeCompare(aD);
                        });
                        jQuery(this).attr('data-order', 'asc');
                    }
                }
                
                container.fadeOut('fast').empty().html(sorted);
                container.fadeIn();
            });
         
        // Complicated filtering system for request lists
            jQuery(document).on('input change', '.searchInput', function(){
                var dataValue = jQuery(this).val(),
                    dataValue = dataValue.toLowerCase(),
                    elementType = jQuery(this).prev().prop('nodeName');

                var inputType = jQuery(this).attr('type');
                        
                //console.log(inputType);
                
                if (inputType == 'checkbox') {
                    jQuery(this).toggleClass('active', this.checked);
                } else {
                    if (dataValue != '' && dataValue != 'na' && dataValue != 'overdue') {
                        jQuery(this).addClass('active');
                    } else {
                        jQuery(this).removeClass('active');
                    }
                }
                
                var activeFilters = jQuery('.searchInput.active').length;
                //jQuery('div.requestContainer:not(.doNotFilter)').fadeOut('fast');

                if (activeFilters > 0) {
                
                    jQuery('.searchInput.active').each(function() {
                        var dataType = jQuery(this).attr('data-type'),
                            dataValue = jQuery(this).val(),
                            dataValue = dataValue.toLowerCase();

                        if (dataValue != '' && dataValue != 'na' && dataValue != 'overdue') {                        
                            jQuery('div.requestContainer:not(.doNotFilter):not([data-'+dataType+'*="'+dataValue+'"])').fadeOut('fast').addClass('filtered');
                            jQuery('div.requestContainer.filtered:not(.doNotFilter)[data-'+dataType+'*="'+dataValue+'"]').fadeIn().removeClass('filtered');
                        } else if (dataValue == 'overdue') {
                            jQuery('div.requestContainer:not(.doNotFilter):not([data-overdue*="'+dataValue+'"])').fadeOut('fast').addClass('filtered');
                            jQuery('div.requestContainer.filtered:not(.doNotFilter)[data-overdue*="'+dataValue+'"]').fadeIn().removeClass('filtered');
                        }
                    });
                    
                } else { 
                    
                    jQuery('.searchInput.active').removeClass('active');
                    jQuery('.requestContainer:not(.doNotFilter)').fadeIn();
                    
                }
            });
         
        function nexus_searchAllPosts(queryString){
            if (queryString && queryString != '') {
                var oldAmount = jQuery('#resultAmount').html(),
                    oldAmount = parseInt(oldAmount, 10),
                    forRemoval = jQuery('div.requestContainer:not([data-all*="'+queryString+'"])').length,
                    newAmount = (oldAmount + 1) - forRemoval;
                
                jQuery('div.requestContainer:not([data-all*="'+queryString+'"])').remove();
                
                if (forRemoval > oldAmount || !forRemoval) {
                    jQuery('#resultAmount').html('0');
                    jQuery('#resultFor').html(' for "'+queryString+'"');                    
                } else {
                    jQuery('#resultAmount').html(newAmount);
                    jQuery('#resultFor').html(' for "'+queryString+'"');
                }
            }
        }
</script>

<div class="pure-u-5-5">&nbsp;</div>
    
</div>