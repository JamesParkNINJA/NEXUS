<?php
    $queryComplete = new WP_Query(array('post_type' => 'complete','date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true)),'posts_per_page' => -1));
    $completedRequestsTest = $queryComplete->found_posts;

    if ( $queryComplete->have_posts() ) : while ( $queryComplete->have_posts() ) : $queryComplete->the_post();
        $reqTypesAll[] = get_field('request_type');
    endwhile; endif; wp_reset_query();

    $queryWC = new WP_Query(array('post_type' => 'complete','posts_per_page' => -1, 'meta_key' => 'request_type', 'meta_value'=>'webchange', 'meta_compare' => 'EXISTS', 'date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
    $completedWebchanges = $queryWC->found_posts;
    
    $queryPro = new WP_Query(array('post_type' => 'complete','posts_per_page' => -1, 'meta_key' => 'request_type', 'meta_value'=>'projects', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
    $completedProjects = $queryPro->found_posts;
    
    $queryD = new WP_Query(array('post_type' => 'complete','posts_per_page' => -1, 'meta_key' => 'request_type', 'meta_value'=>'design', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
    $completedDesigns = $queryD->found_posts;
    
    $queryAd = new WP_Query(array('post_type' => 'complete','posts_per_page' => -1, 'meta_key' => 'request_type', 'meta_value'=>'advert', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
    $completedAdverts = $queryAd->found_posts;
    
    $queryPub = new WP_Query(array('post_type' => 'complete','posts_per_page' => -1, 'meta_key' => 'request_type', 'meta_value'=>'publication', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
    $completedPublications = $queryPub->found_posts;
    
    $queryMM = new WP_Query(array('post_type' => 'complete','posts_per_page' => -1, 'meta_key' => 'request_type', 'meta_value'=>'multimedia', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
    $completedMM = $queryMM->found_posts;

    if (have_rows('departments', 'options')) : while (have_rows('departments', 'options')) : the_row();
        $deptArray[] = get_sub_field('department');
    endwhile; endif;

    $postTypeArray = array('webchange','projects','design','advert','publication','multimedia');

    foreach ($deptArray as $key => $dept) {
        
        $deptUsers = $deptUserIDs = $authors = '';
        
        $userSearch = new WP_User_Query(
            array(
                'meta_key' => 'user_dept',
                'meta_value' => $dept,
                'meta_compare' => '='
            )
        );
        
        $deptUsers = $userSearch->get_results();
        
        foreach($deptUsers as $deptUser) {
            $deptUserIDs[] = $deptUser->ID;
        }
        
        $authors = implode(',',$deptUserIDs);
        
        // Rating Calculation        
        foreach ($postTypeArray as $pType) {
            $pObject = get_post_type_object($pType);
            $pLabel = $pObject->labels->name;
            
            $queryDept = new WP_Query(array(
                'post_type' => 'complete',
                'author' => $authors,
                'meta_key' => 'request_type',
                'meta_value' => $pType,
                'posts_per_page' => -1,
                'meta_compare' => 'EXISTS',
                'date_query' => array(
                    array(
                        'after'=>$startYear,
                        'before'=>$endYear,
                        'inclusive'=>true
                    )
                )
            ));
            
            if ( $queryDept->have_posts() ) : while ( $queryDept->have_posts() ) : $queryDept->the_post();
                // Department Rating
                if (get_field('client_rating')) { $rate = get_field('client_rating'); $deptRatings[] = intval($rate, 10); }
            endwhile; endif; wp_reset_query();
            
            $deptComplete[$dept][$pLabel] = $queryDept->found_posts;
        }
        
        $queryDept = new WP_Query(array(
            'post_type' => 'complete',
            'author' => $authors,
            'posts_per_page' => -1,
            'date_query' => array(
                array(
                    'after'=>$startYear,
                    'before'=>$endYear,
                    'inclusive'=>true
                )
            )
        ));
        
        // Rejected
        $queryRej = new WP_Query(array('post_type' => 'cancelled','posts_per_page' => -1, 'author' => $authors, 'date_query' => array( array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));

        $deptRejected[$dept] = $queryRej->found_posts;
            
        // Rating Percentages
        
        if ($deptRatings) { $fullDeptAverage = round( array_sum($deptRatings) / count($deptRatings) ); } else { $fullDeptAverage = 0; }
        
        $deptComplete[$dept]['full'] = $queryDept->found_posts;
        $deptRating[$dept] = $fullDeptAverage;
        
        unset($deptRatings);
    }
    
    $completedRequests = $completedWebchanges + $completedProjects + $completedDesigns + $completedAdverts + $completedPublications + $completedMM;

    $completedTypes['full'] = array(
        'Web Project Requests' => $completedProjects,
        'Webchange Requests' => $completedWebchanges,
        'Design Requests' => $completedDesigns,
        'Publication Requests' => $completedPublications,
        'Advert Requests' => $completedAdverts,
        'Multimedia Requests' => $completedMM
    );
    
    $completedWebRequests = $completedWebchanges + $completedProjects;
    
    $completedDesignRequests = $completedDesigns + $completedAdverts + $completedPublications;
    
    $designArray = array('Design Requests'=>$completedDesigns, 'Advert Requests'=>$completedAdverts, 'Publication<br>Requests'=>$completedPublications);
    $webArray = array('Project<br>Requests'=>$completedProjects, 'Webchange Requests'=>$completedWebchanges);
    
    $designPercent = ($completedRequests == 0 ? 0 : number_format(($completedDesignRequests / $completedRequests),1));
    $webPercent = ($completedRequests == 0 ? 0 : number_format(($completedWebRequests / $completedRequests),1));

    if (have_rows('creative_designers', 'options')) : while (have_rows('creative_designers', 'options')) : the_row();
        $designUsers[] = get_sub_field('designer');
    endwhile; endif;

    if (have_rows('web_designers', 'options')) : while (have_rows('web_designers', 'options')) : the_row();
        $designUsers[] = get_sub_field('designer');
    endwhile; endif;
    
    foreach ($designUsers as $desUser) {
        if (get_field('user_type', 'user_'.$desUser['ID']) == 'web' || get_field('user_type','user_'.$desUser['ID']) == 'design') { 
        
            $fullRatings = array(); $desRatings = array(); $pubRatings = array(); $adRatings = array(); $wcRatings = array(); $proRatings = array(); $mmRatings = array();

            $queryD = new WP_Query(array('post_type' => 'complete','posts_per_page' => -1, 'meta_query' => array('relation'=>'AND', array('key'=>'request_type','value'=>'design','compare'=>'exists'), array('key'=>'designer','value'=>$desUser['ID'], 'compare'=>'=')),'date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
            if ( $queryD->have_posts() ) : while ( $queryD->have_posts() ) : $queryD->the_post(); if (get_field('rating')) { $desRatings[] = intval(get_field('rating'), 10); $fullRatings[] = intval(get_field('rating'), 10); } endwhile; endif; wp_reset_query();

            $dCount = $queryD->found_posts;

            $queryA = new WP_Query(array('post_type' => 'complete','posts_per_page' => -1, 'meta_query' => array('relation'=>'AND', array('key'=>'request_type','value'=>'advert','compare'=>'exists'), array('key'=>'designer','value'=>$desUser['ID'], 'compare'=>'=')),'date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
            if ( $queryA->have_posts() ) : while ( $queryA->have_posts() ) : $queryA->the_post(); if (get_field('rating')) { $adRatings[] = intval(get_field('rating'), 10); $fullRatings[] = intval(get_field('rating'), 10); } endwhile; endif; wp_reset_query();

            $aCount = $queryA->found_posts;

            $queryPub = new WP_Query(array('post_type' => 'complete','posts_per_page' => -1, 'meta_query' => array('relation'=>'AND', array('key'=>'request_type','value'=>'publication','compare'=>'exists'), array('key'=>'designer','value'=>$desUser['ID'], 'compare'=>'=')),'date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
            if ( $queryPub->have_posts() ) : while ( $queryPub->have_posts() ) : $queryPub->the_post(); if (get_field('rating')) { $pubRatings[] = intval(get_field('rating'), 10); $fullRatings[] = intval(get_field('rating'), 10); } endwhile; endif; wp_reset_query();

            $pubCount = $queryPub->found_posts; 

            $queryPro = new WP_Query(array('post_type' => 'complete','posts_per_page' => -1, 'meta_query' => array('relation'=>'AND', array('key'=>'request_type','value'=>'projects','compare'=>'exists'), array('key'=>'designer','value'=>$desUser['ID'], 'compare'=>'=')),'date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
            if ( $queryPro->have_posts() ) : while ( $queryPro->have_posts() ) : $queryPro->the_post(); if (get_field('rating')) { $proRatings[] = intval(get_field('rating'), 10); $fullRatings[] = intval(get_field('rating'), 10); } endwhile; endif; wp_reset_query();

            $proCount = $queryPro->found_posts;

            $queryWC = new WP_Query(array('post_type' => 'complete','posts_per_page' => -1, 'meta_query' => array('relation'=>'AND', array('key'=>'request_type','value'=>'webchange','compare'=>'exists'), array('key'=>'designer','value'=>$desUser['ID'], 'compare'=>'=')),'date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
            if ( $queryWC->have_posts() ) : while ( $queryWC->have_posts() ) : $queryWC->the_post(); if (get_field('rating')) { $wcRatings[] = intval(get_field('rating'), 10); $fullRatings[] = intval(get_field('rating'), 10); } endwhile; endif; wp_reset_query();

            $wcCount = $queryWC->found_posts;

            $queryMM = new WP_Query(array('post_type' => 'complete','posts_per_page' => -1, 'meta_query' => array('relation'=>'AND', array('key'=>'request_type','value'=>'multimedia','compare'=>'exists'), array('key'=>'designer','value'=>$desUser['ID'], 'compare'=>'=')),'date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
            if ( $queryMM->have_posts() ) : while ( $queryMM->have_posts() ) : $queryMM->the_post(); if (get_field('rating')) { $mmRatings[] = intval(get_field('rating'), 10); $fullRatings[] = intval(get_field('rating'), 10); } endwhile; endif; wp_reset_query();

            $mmCount = $queryMM->found_posts;

            if (count($fullRatings) > 0) { $fullAverage = round( array_sum($fullRatings) / count($fullRatings) ); } else { $fullAverage = 0; }
            if (count($pubRatings) > 0) { $pubAverage = round( array_sum($pubRatings) / count($pubRatings) ); } else { $pubAverage = 0; }
            if (count($adRatings) > 0) { $adAverage = round( array_sum($adRatings) / count($adRatings) ); } else { $adAverage = 0; }
            if (count($desRatings) > 0) { $desAverage = round( array_sum($desRatings) / count($desRatings) ); } else { $desAverage = 0; }
            if (count($proRatings) > 0) { $proAverage = round( array_sum($proRatings) / count($proRatings) ); } else { $proAverage = 0; }
            if (count($wcRatings) > 0) { $wcAverage = round( array_sum($wcRatings) / count($wcRatings) ); } else { $wcAverage = 0; }
            if (count($mmRatings) > 0) { $mmAverage = round( array_sum($mmRatings) / count($mmRatings) ); } else { $mmAverage = 0; }

            $rating = array('full'=>$fullAverage,'Design Requests'=>$desAverage,'Advert Requests'=>$adAverage,'Publication Requests'=>$pubAverage,'Web Projects'=>$proAverage,'Webchange Requests'=>$wcAverage,'Multimedia Requests'=>$mmAverage);

            $count = $dCount + $aCount + $pubCount + $proCount + $wcCount + $mmCount;
            $subCount = array('full'=>$count,'Design Requests'=>$dCount, 'Advert Requests'=>$aCount, 'Publication<br>Requests'=>$pubCount,'Web Projects'=>$proCount,'Webchange Requests'=>$wcCount,'Multimedia Requests'=>$mmCount);

            $percent = ($completedRequests == 0 ? 0 : number_format(($count / $completedRequests),1));

            $completedTypes[$desUser['user_firstname'].' '.$desUser['user_lastname']] = array('ratings'=>$rating, 'count'=>$subCount,'percent'=>$percent);
        }
    }
        
    $args = array('post_type' => 'complete','posts_per_page' => -1,'date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true)));
    $the_query = new WP_Query( $args ); if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); if (get_field('rating')) {
        if( get_post_type() == 'design') {
            $desDesRatings[] = intval(get_field('rating'), 10);
        }
        if( get_post_type() == 'advert') {
            $desAdRatings[] = intval(get_field('rating'), 10);
        }
        if( get_post_type() == 'publication') {
            $desPubRatings[] = intval(get_field('rating'), 10);
        }
        if( get_post_type() == 'projects') {
            $webProRatings[] = intval(get_field('rating'), 10);
        }
        if( get_post_type() == 'webchange') {
            $webWCRatings[] = intval(get_field('rating'), 10);
        }
        if( get_post_type() == 'multimedia') {
            $allMMRatings[] = intval(get_field('rating'), 10);
        }
    } endwhile; endif; wp_reset_query();
    
    if (count($desDesRatings) > 0) { $desDesAverage = round( array_sum($desDesRatings) / count($desDesRatings) ); } else { $desDesAverage = 0; }
    if (count($desAdRatings) > 0) { $desAdAverage = round( array_sum($desAdRatings) / count($desAdRatings) ); } else { $desAdAverage = 0; }
    if (count($desPubRatings) > 0) { $desPubAverage = round( array_sum($desPubRatings) / count($desPubRatings) ); } else { $desPubAverage = 0; }
    if (count($webProRatings) > 0) { $webProAverage = round( array_sum($webProRatings) / count($webProRatings) ); } else { $webProAverage = 0; }
    if (count($webWCRatings) > 0) { $webWCAverage = round( array_sum($webWCRatings) / count($webWCRatings) ); } else { $webWCAverage = 0; }
    if (count($allMMRatings) > 0) { $allMMAverage = round( array_sum($allMMRatings) / count($allMMRatings) ); } else { $allMMAverage = 0; }
    
    $allRatings = array(
        'Design Requests' => $desDesAverage,
        'Advert Requests' => $desAdAverage,
        'Publication Requests' => $desPubAverage,
        'Web Projects' => $webProAverage,
        'Webchange Requests' => $webWCAverage,
        'Multimedia Requests' => $allMMAverage
    );

    // REJECTED REQUEST COUNT

    $rejWC = new WP_Query(array('post_type' => 'cancelled','posts_per_page' => -1, 'meta_key' => 'request_type', 'meta_value'=>'webchange', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
    $rejectedWebchanges = $rejWC->found_posts;
    
    $rejPro = new WP_Query(array('post_type' => 'cancelled','posts_per_page' => -1, 'meta_key' => 'request_type', 'meta_value'=>'projects', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
    $rejectedProjects = $rejPro->found_posts;
    
    $rejD = new WP_Query(array('post_type' => 'cancelled','posts_per_page' => -1, 'meta_key' => 'request_type', 'meta_value'=>'design', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
    $rejectedDesigns = $rejD->found_posts;
    
    $rejAd = new WP_Query(array('post_type' => 'cancelled','posts_per_page' => -1, 'meta_key' => 'request_type', 'meta_value'=>'advert', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
    $rejectedAdverts = $rejAd->found_posts;
    
    $rejPub = new WP_Query(array('post_type' => 'cancelled','posts_per_page' => -1, 'meta_key' => 'request_type', 'meta_value'=>'publication', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
    $rejectedPublications = $rejPub->found_posts;
    
    $rejMM = new WP_Query(array('post_type' => 'cancelled','posts_per_page' => -1, 'meta_key' => 'request_type', 'meta_value'=>'multimedia', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));
    $rejectedMM = $rejMM->found_posts;

    $rejectedRequestsAll = $rejectedMM + $rejectedWebchanges + $rejectedProjects + $rejectedDesigns + $rejectedAdverts + $rejectedPublications;

    $rejectedTypes['full'] = array(
        'Web Project Requests' => $rejectedProjects,
        'Webchange Requests' => $rejectedWebchanges,
        'Design Requests' => $rejectedDesigns,
        'Publication Requests' => $rejectedPublications,
        'Advert Requests' => $rejectedAdverts,
        'Multimedia Requests' => $rejectedMM
    );

    // "You ever heard of the Cancellation Calculation?"
    // "I DON'T LISTEN TO HIP-HOP"
    $queryRejAll = new WP_Query( array('post_type' => 'cancelled','posts_per_page' => -1, 'date_query' => array( array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));

    if ( $queryRejAll->have_posts() ) : while ( $queryRejAll->have_posts() ) : $queryRejAll->the_post();

        // Client Rejection Reasons
        $clientName = get_the_author_meta('first_name').' '.get_the_author_meta('last_name'); 
        if (!$clientName || trim($clientName) == '') { $clientName = 'No Client'; }
        $cancelledReasons = explode(',', get_field('cancelled_reason', get_the_ID()));
        $clientRejections[$clientName]['total'] = 0;
        foreach ($cancelledReasons as $reason) {
            if ($reason && strip_tags(trim($reason)) != '' && strip_tags(trim($reason)) != ',') {
                $rejReasons[] = strip_tags(trim($reason));
                $cliNumber = $clientRejections[$clientName][strip_tags(trim($reason))];
                if (!$cliNumber || $cliNumber <= 0) { $clientRejections[$clientName][strip_tags(trim($reason))]; }
                $clientRejections[$clientName][strip_tags(trim($reason))]++;
                $clientRejections[$clientName]['total']++;
            }
        }

    endwhile; endif; wp_reset_query();

    // Ratings for Clients
    $queryCompAll = new WP_Query( array('post_type' => 'complete','posts_per_page' => -1, 'date_query' => array( array('after'=>$startYear, 'before'=>$endYear, 'inclusive'=>true))));

    if ( $queryCompAll->have_posts() ) : while ( $queryCompAll->have_posts() ) : $queryCompAll->the_post();

        $clientName = get_the_author_meta('first_name').' '.get_the_author_meta('last_name'); 
        if (!$clientName || trim($clientName) == '') { $clientName = 'No Client'; }
        if (get_field('client_rating')) { $rate = get_field('client_rating'); $clientRatings[$clientName][] = intval($rate, 10); }        

    endwhile; endif; wp_reset_query();

    if ($clientRatings) {
        foreach($clientRatings as $client => $ratings) {
            if ($ratings && $ratings != 0) { $allClientRatings[$client] = round( array_sum($ratings) / count($ratings) ); }
        }
    }    
?>