<?php 
    // All of the details for each request gets calculated here, so we don't have to search the entire block of code for it
    $authorID = get_the_author_meta('ID');
    $postID = get_the_ID();
    $authorFirstName = get_the_author_meta('first_name');
    $authorLastName = get_the_author_meta('last_name');
    $authorEmail = get_the_author_meta('user_email');
    $authorFullName = $authorFirstName.' '.$authorLastName;
    $authorFullNameBR = $authorFirstName.'<br>'.$authorLastName;
    $authorFileName = str_replace(' ','_',$authorFullName);
    $authorIMG = nexus_getUserIMG($authorID);

    $requestTitle = get_the_title();
    $singleRequestType = (get_post_type(get_the_ID()) == 'nexus_complete' ? get_post_meta(get_the_ID(), 'nexus_prior_type',true) : get_post_type(get_the_ID()));
    $trueRequestType = get_post_type(get_the_ID());
    $requestID = nexus_requestID(get_the_ID());
    
    $today = strtotime(date('d-m-Y'));

    $completionTS = get_post_meta(get_the_ID(),'nexus_completion_date',true);

    if (get_post_type(get_the_ID()) == 'nexus_complete') {
        $neededBy = get_post_meta(get_the_ID(),'nexus_deadline_date',true);
        $completionDue = ($neededBy < $completionTS ? 'overdue' : '');
        $requestRating = nexus_getRequestRating(get_the_ID(), 'designer');
        $clientRating = nexus_getRequestRating(get_the_ID(), 'client');
    } else {
        $completionTS = get_post_meta(get_the_ID(),'nexus_deadline_date',true);
        if ($statusID != 'tbs') { $completionDue = ($completionTS < $today ? 'overdue' : ''); } else { $completionDue = ''; }
    }
      
    $completionDate = date('d/m/Y', get_post_meta(get_the_ID(),'nexus_deadline_date',true));
    $completedOnDate = date('d/m/Y', $completionTS);

    $clientBudget = get_post_meta(get_the_ID(), 'nexus_client_budget', true);
        $clientBudget = (!$clientBudget ? '0.00' : $clientBudget);

    
    // Default Status
    $requestStatus = 'To Be Started';
    $statusID = 'tbs';

    // Return status from applied variable
    $requestStatusArray = nexus_getRequestStatus(get_the_ID());
    $statusIDActual = $requestStatusArray['statusID'];

    $stageNum = get_post_meta(get_the_ID(),'nexus_request_stage',true);

    $importance = get_post_meta(get_the_ID(),'nexus_request_importance',true);

    $desTest = get_post_meta(get_the_ID(),'nexus_assigned_user',true);

    // Important overriders 
    if ($desTest && trim($desTest) != '') {
        $designerID  = get_userdata($desTest);
        $designer    = $designerID->user_firstname.' '.$designerID->user_lastname;
        $designerBR    = $designerID->user_firstname.'<br>'.$designerID->user_lastname;
        $designerIMG = nexus_getUserIMG($designerID->ID);
        
        if ($stageNum < 2) {
            $requestStatus = 'Assigned'; $statusID = 'assigned';
        } else {
            $requestStatus = 'In Progress'; $statusID = 'progress';
        }
    } else {
        $designerID  = '';
        $designer    = '';
        $designerIMG = 'noImage';
        
        $overdue = ($completionTS < $today ? 'overdue' : '');
        if ($overdue == 'overdue') { $statusID = 'overdue'; $requestStatus = 'Overdue'; } else {
            if ($importance && $importance != 'low') { $requestStatus = 'Urgent'; $statusID = $importance; }
        }
        
    }

    if (get_post_type(get_the_ID()) == 'nexus_rejected') { $statusID = 'rejected'; $requestStatus = 'Rejected'; }
    if (get_post_type(get_the_ID()) == 'nexus_complete') { $statusID = 'complete'; $requestStatus = 'Complete'; }

    $calcStatus = nexus_getRequestStatus(get_the_ID());
    if ($calcStatus['signoff'] && trim($calcStatus['signoff']) != '') { $statusID = 'signoff'; $requestStatus = 'Needs Sign-Off'; }
        
    if ($cuTYPE == 'designer') {
        $linkMe = 'linkMe ';
    } else {
        if (get_current_user_id() == $authorID){ $linkMe = 'linkMe '; } else { $linkMe = ''; }
    }

    $allDetails = strtolower($authorFullName).' '.strtolower($designer).' '.strtolower($statusID).' '.strtolower($singleRequestType).' '.strtolower($requestID).' '.strtolower($importance).' '.$overdue.' '.$requestTitle.' '.get_the_date('d/m/Y').' '.$requestStatus;
?>

<div class="pure-u-5-5 pure-u-sm-1-2 pure-u-md-1-3 requestContainer timerLoading <?php echo $nexus_MODE; ?>" 
     data-requestee="<?php echo strtolower($authorFullName); ?>"
     data-designer="<?php echo strtolower($designer); ?>"
     data-status="<?php echo strtolower($statusID); ?>"
     data-overdue="<?php echo $overdue; ?>"
     data-type="<?php echo strtolower($singleRequestType); ?>"
     data-reqid="<?php echo strtolower($requestID); ?>"
     data-importance="<?php echo strtolower($importance); ?>"
     data-id="<?php echo strtolower(get_the_ID()); ?>"
     data-date="<?php echo strtotime(get_the_date('Y-m-d')); ?>"
     data-all="<?php echo strtolower($allDetails); ?>"
     >
    
    <?php $client = get_userdata($authorID); ?>
    
    <div class="requestCard">
        <a class="nexus_ajaxFunction viewRequest" data-menu="single_request" data-query="single_request" data-requesttype="<?php echo $trueRequestType; ?>" data-postid="<?php echo get_the_ID(); ?>" ></a>
        
        <div class="requestCard__header <?php echo $statusID; ?>">
            <div class="pure-g">
                <div class="pure-u-1-4 txtL">
                    <span>Request ID</span><br>
                    <p class="reqID"><?php echo $requestID; ?></p>
                </div> 
                <div class="pure-u-1-4 txtL">
                    <?php if ($clientBudget && $clientBudget != '0.00') { ?>
                        <span>Budget</span><br>
                        <p class="subDate communityONLY"><?php echo $nexus_CURR.$clientBudget; ?></p>
                    <?php } ?>
                </div> 
                <div class="pure-u-1-4 txtR">
                    <span>Requested on</span><br>
                    <p class="subDate"><?php echo get_the_date('d/m/Y'); ?></p>
                </div> 
                <?php if (get_post_type(get_the_ID()) != 'nexus_complete') { ?>
                    <div class="pure-u-1-4">
                        <span>Deadline</span><br>
                        <p class="subDate <?php echo $completionDue; ?>"><?php echo $completionDate; ?></p>
                    </div> 
                <?php } else { ?>
                    <div class="pure-u-1-4">
                        <span>Completed on</span><br>
                        <p class="subDate"><?php echo $completedOnDate; ?></p>
                    </div> 
                <?php } ?>
            </div>
        </div> 
        
        <div class="requestCard__body">
            <div class="pure-g">
                <div class="pure-u-5-5">
                    <h3>
                        <?php 
                            if ($statusID && $statusID != 'tbs' && $statusID != 'complete') { echo '<span>'.$requestStatus.': </span>'; } 
                            echo $requestTitle; 
                        ?>
                    </h3>
                </div> 
                <div class="pure-u-1-2">
                    <div class="requestCard__user requestee">
                        <div class="userIMG" style="background-image:url('<?php echo $authorIMG; ?>')"></div>
                        <div class="pure-g">
                            <div class="pure-u-5-5">
                                <?php if (nexus_publicProtect($postID)) { ?>
                                <p><?php echo $authorFullNameBR; ?></p>
                                <?php } else { ?>
                                <p>Client<br>Name</p>
                                <?php } ?>
                            </div> 
                            <div class="pure-u-5-5">
                                <?php if ($requestRating) { echo $requestRating; } else { echo '<div class="small divider"></div>'; } ?>
                            </div> 
                        </div>
                    </div> 
                </div>      
                <div class="pure-u-1-2" style="position:relative;">
                    <?php if ($desTest) { ?>
                        <div class="requestCard__user designer">
                            <div class="userIMG" style="background-image:url('<?php echo $designerIMG; ?>')"></div>
                            <div class="pure-g">
                                <div class="pure-u-5-5">
                                    <?php if (nexus_publicProtect($postID)) { ?>
                                        <p><?php echo $designerBR; ?></p>
                                    <?php } else { ?>
                                        <p>Assignee<br>Name</p>
                                    <?php } ?>
                                </div> 
                                <div class="pure-u-5-5">
                                    <?php if ($clientRating) { echo $clientRating; } else { echo '<div class="small divider"></div>'; } ?>
                                </div> 
                            </div>
                        </div> 
                    <?php } ?>
                </div>
            </div>   
        </div>
        
        <div class="requestCard__menu">
            <!-- View Request Button -->
            <div>
                <a class="nexus_ajaxFunction" data-menu="single_request" data-query="single_request" data-requesttype="<?php echo $trueRequestType; ?>" data-postid="<?php echo get_the_ID(); ?>" >VIEW</a>
            </div>
            
            <?php if ($cuTYPE != 'designer' && $statusID == 'signoff' && get_current_user_id() == $authorID) { ?>
                    <div>
                        <a class="nexus_ajaxFunction signoff" data-query="request_signoff" data-requesttype="<?php echo $trueRequestType; ?>"  data-postid="<?php echo get_the_ID(); ?>">SIGN OFF</a>
                    </div>
            <?php } ?>
            
            <!-- Admin Only -->
            <?php if ($cuTYPE == 'designer') { ?>            
                <!-- Assign Request Button -->
                <?php if ($trueRequestType != 'nexus_complete') { ?>
                    <div class="teamONLY">
                        <?php $assignButton = ($desTest ? 'REASSIGN' : 'ASSIGN'); ?>
                        <a class="nexus_ajaxFunction assign" data-query="reassign_request" data-postid="<?php echo get_the_ID(); ?>" data-menu="reassign" data-designer="<?php echo $desTest; ?>" data-stage="1" ><?php echo $assignButton; ?></a>
                    </div>
                <?php } ?>
            
                <!-- Quick Complete / Signoff Buttons -->
                <?php if (get_current_user_id() == $desTest) { if ($trueRequestType != 'nexus_complete' && $statusID != 'signoff') { ?>
                    <div>
                        <a class="nexus_ajaxFunction complete" data-query="completion" data-override="yes" data-postid="<?php echo get_the_ID(); ?>" >COMPLETE</a>
                    </div>
                <?php } if ($statusID == 'signoff') { ?>
                    <div class="teamONLY">
                        <a class="nexus_ajaxFunction signoff" data-query="request_signoff" data-requesttype="<?php echo $trueRequestType; ?>"  data-postid="<?php echo get_the_ID(); ?>" >SIGN OFF</a>
                    </div>
                <?php } } ?>
            
                <?php if (!$desTest || trim($desTest) == '') { ?>               
                    <!-- Rejection Button -->
                    <div class="teamONLY">
                        <a class="nexus_ajaxFunction reject"  data-query="rejection" data-user="<?php echo get_current_user_id(); ?>" data-postid="<?php echo get_the_ID(); ?>" >REJECT</a>
                    </div>
                    <?php if (!nexus_checkForApplication($cuID, get_the_ID())) { ?>
                        <!-- Apply for job Button -->
                        <div class="communityONLY">
                            <a class="nexus_ajaxFunction assign" data-query="apply" data-postid="<?php echo get_the_ID(); ?>" data-menu="single_request" data-designer="<?php echo $desTest; ?>">Apply for Job</a>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
        
    </div>
    
</div>