<?php
    $queryWC = new WP_Query(array('post_type' => 'complete', 'meta_key' => 'request_type', 'meta_value'=>'webchange', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear), 'inclusive'=>true)));
    $completedWebchanges = $queryWC->found_posts;
    
    $queryPro = new WP_Query(array('post_type' => 'complete', 'meta_key' => 'request_type', 'meta_value'=>'projects', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear), 'inclusive'=>true)));
    $completedProjects = $queryPro->found_posts;
    
    $queryD = new WP_Query(array('post_type' => 'complete', 'meta_key' => 'request_type', 'meta_value'=>'design', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear), 'inclusive'=>true)));
    $completedDesigns = $queryD->found_posts;
    
    $queryAd = new WP_Query(array('post_type' => 'complete', 'meta_key' => 'request_type', 'meta_value'=>'advert', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear), 'inclusive'=>true)));
    $completedAdverts = $queryAd->found_posts;
    
    $queryPub = new WP_Query(array('post_type' => 'complete', 'meta_key' => 'request_type', 'meta_value'=>'publication', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear), 'inclusive'=>true)));
    $completedPublications = $queryPub->found_posts;
    
    $queryMM = new WP_Query(array('post_type' => 'complete', 'meta_key' => 'request_type', 'meta_value'=>'multimedia', 'meta_compare' => 'EXISTS','date_query' => array(array('after'=>$startYear, 'before'=>$endYear), 'inclusive'=>true)));
    $completedMM = $queryMM->found_posts;
    
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
    
    $designPercent = number_format(($completedDesignRequests / $completedRequests),1);
    $webPercent = number_format(($completedWebRequests / $completedRequests),1);

    $designUserArgs = array('role'=>'administrator','meta_key'=>'user_type','meta_value'=>'design','meta_compare' => 'EXISTS');
    $webUserArgs = array('role'=>'administrator','meta_key'=>'user_type','meta_value'=>'web','meta_compare' => 'EXISTS');
    $designUsers = get_users( $designUserArgs );
    $webUsers = get_users( $webUserArgs );
    
    foreach ($designUsers as $desUser) {
        $creRatings = array(); $desRatings = array(); $pubRatings = array(); $adRatings = array();
        $queryD = new WP_Query(array('post_type' => 'complete', 'meta_query' => array('relation'=>'AND', array('key'=>'request_type','value'=>'design','compare'=>'exists'), array('key'=>'designer','value'=>$desUser->ID, 'compare'=>'=')),'date_query' => array(array('after'=>$startYear, 'before'=>$endYear), 'inclusive'=>true)));
        if ( $queryD->have_posts() ) : while ( $queryD->have_posts() ) : $queryD->the_post(); if (get_field('rating')) { $desRatings[] = intval(get_field('rating'), 10); $creRatings[] = intval(get_field('rating'), 10); } endwhile; endif; wp_reset_query();
        
        $dCount = $queryD->found_posts;
        
        $queryA = new WP_Query(array('post_type' => 'complete', 'meta_query' => array('relation'=>'AND', array('key'=>'request_type','value'=>'advert','compare'=>'exists'), array('key'=>'designer','value'=>$desUser->ID, 'compare'=>'=')),'date_query' => array(array('after'=>$startYear, 'before'=>$endYear), 'inclusive'=>true)));
        if ( $queryA->have_posts() ) : while ( $queryA->have_posts() ) : $queryA->the_post(); if (get_field('rating')) { $adRatings[] = intval(get_field('rating'), 10); $creRatings[] = intval(get_field('rating'), 10); } endwhile; endif; wp_reset_query();
        
        $aCount = $queryA->found_posts;
        
        $queryPub = new WP_Query(array('post_type' => 'complete', 'meta_query' => array('relation'=>'AND', array('key'=>'request_type','value'=>'publication','compare'=>'exists'), array('key'=>'designer','value'=>$desUser->ID, 'compare'=>'=')),'date_query' => array(array('after'=>$startYear, 'before'=>$endYear), 'inclusive'=>true)));
        if ( $queryPub->have_posts() ) : while ( $queryPub->have_posts() ) : $queryPub->the_post(); if (get_field('rating')) { $pubRatings[] = intval(get_field('rating'), 10); $creRatings[] = intval(get_field('rating'), 10); } endwhile; endif; wp_reset_query();
        
        $pubCount = $queryPub->found_posts;
        
        $pubAverage = round( array_sum($pubRatings) / count($pubRatings) );
        $adAverage = round( array_sum($adRatings) / count($adRatings) );
        $desAverage = round( array_sum($desRatings) / count($desRatings) );
        $creAverage = round( array_sum($creRatings) / count($creRatings) );
        
        $rating = array('full'=>$creAverage,'Design Requests'=>$desAverage,'Advert Requests'=>$adAverage,'Publication<br>Requests'=>$pubAverage);
        
        $count = $dCount + $aCount + $pubCount;
        $subCount = array('full'=>$count,'Design Requests'=>$dCount, 'Advert Requests'=>$aCount, 'Publication<br>Requests'=>$pubCount);
        $percent = number_format(($count / $completedDesignRequests),1);
        $desIDs[$desUser->first_name.' '.$desUser->last_name] = array('ratings'=>$rating,'count'=>$subCount,'percent'=>$percent);
        $completedTypes[$webUser->first_name.' '.$webUser->first_name] = array('ratings'=>$rating, 'count'=>$subCount,'percent'=>$percent);
    }
    
    foreach ($webUsers as $webUser) { 
        $webRatings = array(); $wcRatings = array(); $proRatings = array();
        $queryPro = new WP_Query(array('post_type' => 'complete', 'meta_query' => array('relation'=>'AND', array('key'=>'request_type','value'=>'projects','compare'=>'exists'), array('key'=>'designer','value'=>$webUser->ID, 'compare'=>'=')),'date_query' => array(array('after'=>$startYear, 'before'=>$endYear), 'inclusive'=>true)));
        if ( $queryPro->have_posts() ) : while ( $queryPro->have_posts() ) : $queryPro->the_post(); if (get_field('rating')) { $proRatings[] = intval(get_field('rating'), 10); $webRatings[] = intval(get_field('rating'), 10); } endwhile; endif; wp_reset_query();
        
        $proCount = $queryPro->found_posts;
        
        $queryWC = new WP_Query(array('post_type' => 'complete', 'meta_query' => array('relation'=>'AND', array('key'=>'request_type','value'=>'webchange','compare'=>'exists'), array('key'=>'designer','value'=>$webUser->ID, 'compare'=>'=')),'date_query' => array(array('after'=>$startYear, 'before'=>$endYear), 'inclusive'=>true)));
        if ( $queryWC->have_posts() ) : while ( $queryWC->have_posts() ) : $queryWC->the_post(); if (get_field('rating')) { $wcRatings[] = intval(get_field('rating'), 10); $webRatings[] = intval(get_field('rating'), 10); } endwhile; endif; wp_reset_query();
        
        $wcCount = $queryWC->found_posts;
        
        $proAverage = round( array_sum($proRatings) / count($proRatings) );
        $wcAverage = round( array_sum($wcRatings) / count($wcRatings) );
        $webAverage = round( array_sum($webRatings) / count($webRatings) );
        //echo $webAverage;
        
        $rating = array('full'=>$webAverage,'Webchange Requests'=>$wcAverage,'Project<br>Requests'=>$proAverage);
        
        $count = $proCount + $wcCount;
        $subCount = array('full'=>$count,'Project<br>Requests'=>$proCount, 'Webchange Requests'=>$wcCount);
        $percent = number_format(($count / $completedWebRequests),1);
        $webIDs[$webUser->first_name.' '.$webUser->first_name] = array('ratings'=>$rating,'count'=>$subCount,'percent'=>$percent);
        $completedTypes[$webUser->first_name.' '.$webUser->first_name] = array('ratings'=>$rating, 'count'=>$subCount,'percent'=>$percent);
    }
        
    $args = array('post_type' => 'complete','posts_per_page' => -1,'date_query' => array(array('after'=>$startYear, 'before'=>$endYear), 'inclusive'=>true));
    $the_query = new WP_Query( $args ); if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); if (get_field('rating')) {
        if( get_post_type() == 'design') {
            $allDesignRatings[] = intval(get_field('rating'), 10);
            $desDesRatings[] = intval(get_field('rating'), 10);
        }
        if( get_post_type() == 'advert') {
            $allDesignRatings[] = intval(get_field('rating'), 10);
            $desAdRatings[] = intval(get_field('rating'), 10);
        }
        if( get_post_type() == 'publication') {
            $allDesignRatings[] = intval(get_field('rating'), 10);
            $desPubRatings[] = intval(get_field('rating'), 10);
        }
        if( get_post_type() == 'projects') {
            $allWebRatings[] = intval(get_field('rating'), 10); $webProRatings[] = intval(get_field('rating'), 10);
        }
        if( get_post_type() == 'webchange') {
            $allWebRatings[] = intval(get_field('rating'), 10); $webWCRatings[] = intval(get_field('rating'), 10);
        }
    } endwhile; endif; wp_reset_query();
    
    $designAverage = round( array_sum($allDesignRatings) / count($allDesignRatings) ); 
    $webAverage = round( array_sum($allWebRatings) / count($allWebRatings) );  
    $desDesAverage = round( array_sum($desDesRatings) / count($desDesRatings) ); 
    $desAdAverage = round( array_sum($desAdRatings) / count($desAdRatings) );  
    $desPubAverage = round( array_sum($desPubRatings) / count($desPubRatings) ); 
    $webProAverage = round( array_sum($webProRatings) / count($webProRatings) );  
    $webWCAverage = round( array_sum($webWCRatings) / count($webWCRatings) ); 
    
    $designRatings = array(
        'Design Requests' => $desDesAverage,
        'Advert Requests' => $desAdAverage,
        'Publication<br>Requests' => $desPubAverage
    );
    $webRatings = array(
        'Webchange Requests' => $webWCAverage,
        'Project<br>Requests' => $webProAverage
    );
?>