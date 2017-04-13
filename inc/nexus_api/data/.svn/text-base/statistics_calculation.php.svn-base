<?php
    $queryComplete = new WP_Query(array('post_type' => 'nexus_complete','date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true)),'posts_per_page' => -1));
    $completedRequestsTest = $queryComplete->found_posts;

    if ( $queryComplete->have_posts() ) : while ( $queryComplete->have_posts() ) : $queryComplete->the_post();
        $reqTypesAll[] = get_post_meta(get_the_ID(),'nexus_prior_type',true);
    endwhile; endif; wp_reset_query();

    $postTypeArray = nexus_output_post_types('array_single');

    $adminQuery = new WP_User_Query( array( 'role' => 'Administrator' ) );
    $clientQuery = new WP_User_Query( array( 'role' => 'Subscriber' ) );
    
    foreach($adminQuery->results as $user) {
        $adminUsers[] = $user->ID;
    }

    foreach ($postTypeArray as $postType) {
        
        $postObject = get_post_type_object($postType);
        $postLabel = $postObject->labels->singular_name;
        
        // Variable Variables
        $complete = 'complete_'.$postType;
        $rejected = 'rejected_'.$postType;
        $ratesArrAv = 'rateArrayAv_'.$postType;
        $ratesArr = 'rateArray_'.$postType;
        
        $query = new WP_Query(array('post_type' => 'nexus_complete','posts_per_page' => -1, 'meta_key' => 'nexus_prior_type', 'meta_value'=>$postType, 'meta_compare' => 'EXISTS', 'date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
        $$complete = $query->found_posts;
        
        $completeArray[$postType] = $$complete;
        $completedTypes['full'][$postLabel] = $$complete;
        
        if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 

            $clientName = get_the_author_meta('first_name').' '.get_the_author_meta('last_name'); 
            if (!$clientName || trim($clientName) == '') { $clientName = 'No Client'; }

            // Ratings
            $rate = get_post_meta(get_the_ID(),'nexus_request_rating',true);
            if ($rate) { $$ratesArr[] = intval($rate, 10); }

            $crate = get_post_meta(get_the_ID(),'nexus_client_rating',true);
            if ($crate) { $clientRatings[$clientName][] = intval($crate, 10); }

        endwhile; endif; wp_reset_query();

        if (count($$ratesArr) > 0) { $$ratesArrAv = round(array_sum($$ratesArr) / count($$ratesArr)); } else { $$ratesArrAv = 0; }

        $allRatings[$postLabel] = $$ratesArrAv;
        
        // Admin Query
        foreach ($adminUsers as $adminUser) {

            $adminUserObj = nexus_userDetailsArray($adminUser);

            $ratings = 'ratings_'.$postType;
            $average = 'average_'.$postType;
            $rfound = 'rfound_'.$postType;

            $postObject = get_post_type_object($postType);
            $postLabel = $postObject->labels->singular_name;

            $$ratings = array();

            $query = new WP_Query(array('post_type' => 'nexus_complete','posts_per_page' => -1, 'meta_query' => array('relation'=>'AND', array('key'=>'request_type','value'=>$postType,'compare'=>'exists'), array('key'=>'nexus_assigned_user','value'=>$adminUser, 'compare'=>'=')),'date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));            
            if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); $rate = get_post_meta(get_the_ID(),'nexus_request_rating',true); if ($rate) { $$ratings[] = intval($rate, 10); $fullRatings[] = intval($rate, 10); } endwhile; endif; wp_reset_query();

            $$rfound = $query->found_posts; $rFoundArr[] = $$rfound; 
            $subCount[$postLabel] = $$rfound;

            if (count($$ratings) > 0) { $$average = round( array_sum($$ratings) / count($$ratings) ); } else { $$average = 0; }
            $rating[$postLabel] = $$average;

            if (count($fullRatings) > 0) { $fullAverage = round( array_sum($fullRatings) / count($fullRatings) ); } else { $fullAverage = 0; }

            $rating['full'] = $fullAverage;

            $count = array_sum($rFoundArr);
            $subCount['full'] = $count;

            $percent = ($completedRequests == 0 ? 0 : number_format(($count / $completedRequests),1));

            $completedTypes[$adminUserObj['firstname'].' '.$adminUserObj['lastname']] = array('ratings'=>$rating, 'count'=>$subCount,'percent'=>$percent);
        }
        
        // Rejected Query
        $query = new WP_Query(array('post_type' => 'nexus_rejected','posts_per_page' => -1, 'meta_key' => 'nexus_prior_type', 'meta_value'=>$postType, 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
        
        $$rejected = $query->found_posts;
        $rejectedArray[$postType] = $$rejected;
        $rejectedTypes['full'][$postLabel] = $$rejected;
        
        if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 

            // Ratings
            $rate = get_post_meta(get_the_ID(),'nexus_request_rating',true);
            if ($rate) { $$ratesArr[] = intval($rate, 10); }

            // "You ever heard of the Cancellation Calculation?"
            // "I DON'T LISTEN TO HIP-HOP"
            $clientName = get_the_author_meta('first_name').' '.get_the_author_meta('last_name');
            if (!$clientName || trim($clientName) == '') { $clientName = 'No Client'; }
            $oldAmount = $clientRejections[$clientName]['total'];
            if (!$oldAmount) { $oldAmount = 0; }
            $clientRejections[$clientName]['total'] = $oldAmount + 1;
        
        
        endwhile; endif; wp_reset_query();        
        
    }
    
    $completedRequests = array_sum($completeArray);
    $rejectedRequestsAll = array_sum($rejectedArray);

    if ($clientRatings) {
        foreach($clientRatings as $client => $ratings) {
            if ($ratings && $ratings != 0) { 
                $allClientRatings[$client] = round( array_sum($ratings) / count($ratings) ); 
            } else {
                $allClientRatings[$client] = 5;
            }
        }
    }    
?>