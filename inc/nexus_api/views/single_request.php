<?php include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options ?>
<?php include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details ?>
<?php 
    // Date for comparisons
    $today = strtotime(date('d-m-Y')); 

    // Request Types & ID 
    $realType = get_post_type($postID); $priorType = get_post_meta($postID, 'nexus_prior_type', true);
    $requestType = ($realType == 'nexus_complete' ? $priorType : $realType);
    $requestType = ($realType == 'nexus_rejected' ? $priorType : $realType);
    $projectID = nexus_requestID($postID);
    $requestComplete = ($realType == 'nexus_complete' ? 'yes' : 'no'); 
    $requestRejected = ($realType == 'nexus_rejected' ? 'yes' : 'no');
    
    // Author/Requestee Details
    $authorID = get_post_field('post_author', $postID);
    $authorObject = get_userdata($authorID);
    $authorEmail = $authorObject->user_email;     
    $authorPhone = get_user_meta($authorID, 'nexus_contact_number', true);
    $authorFirstName = $authorObject->first_name;   
    $authorLastName = $authorObject->last_name;
    $authorFileName = $authorFirstName.'_'.$authorLastName;
    $authorImage = nexus_getUserIMG($authorID);

    // Request Details
    $requestTitle = get_the_title($postID);
    $requestDescription = get_post_field('post_content', $postID);
    $requestURL = get_permalink($postID);
    $requestDate = get_the_time(get_option('date_format'),$postID);
    $deadlineDate = intval(get_post_meta($postID,'nexus_deadline_date',true), 10);
    $requestPriority = get_post_meta($postID,'nexus_request_importance',true);
    $feebackByDesigner = (get_post_meta($postID,'nexus_client_feedback',true) ? get_post_meta($postID,'nexus_client_feedback',true) : false);
    $feebackByAuthor = (get_post_meta($postID,'nexus_request_feedback',true) ? get_post_meta($postID,'nexus_request_feedback',true) : false);
    $overdue = ($today > $deadlineDate ? 'overdue' : '');
    $requestDateFormat = date('d/m/Y', strtotime($requestDate));
    $deadlineDateFormat = date('d/m/Y', $deadlineDate);
    $lineColor = '#b4ff00';
    $timeTracked = get_post_meta($postID, 'nexus_tracked_time',true);
        $timeTracked_hours = floor($timeTracked / 3600);
        $timeTracked %= 3600;
        $timeTracked_minutes = floor($timeTracked / 60);
        $timeTracked_seconds = $timeTracked % 60;
        $timeTracked_output = sprintf("%02d",$timeTracked_hours) . ':' . sprintf("%02d",$timeTracked_minutes) . ':' . sprintf("%02d",$timeTracked_seconds);
        $timeTracked_cost = get_post_meta($postID,'nexus_project_cost',true);
        if (!$timeTracked_cost || $timeTracked_cost == '') { 
            if ($timeTracked) {
                $timeTracked_cost = nexus_calculateCost($timeTracked);
            } else {
                $timeTracked_cost = 0.00;
            }
        }

    $clientBudget = get_post_meta($postID, 'nexus_client_budget', true);
        $clientBudget = (!$clientBudget ? '0.00' : $clientBudget);

    // Completion Details (if completed)
    if ($requestComplete == 'yes') { 
        $completedOn = intval(get_post_meta($postID,'nexus_completion_date',true), 10); 
        $completedDateFormat = date('d/m/Y', $completedOn);
        $overdue = ($completedOn > $deadlineDate ? 'overdue' : '');
        $lineColor = '#ffffff';
        $signOffArr = get_post_meta($postID,'nexus_signoff_dates',true);
        $signOffDate = intval($signOffArr['timestamp'], 10);
        $signOffDateFormat = date('d/m/Y', $signOffDate);
        $signOffUserObj = nexus_userDetailsArray($signOffArr['user']);
    }

    // Designer Details
    $designerID = (get_post_meta($postID,'nexus_assigned_user',true) ? get_post_meta($postID,'nexus_assigned_user',true) : false);
    if ($designerID) {
        $designerObject = nexus_userDetailsArray($designerID);
        $designerComments = get_post_meta($postID,'nexus_admin_comments',true);
        $designerName = $designerObject['fullname']; 
        $designerIMG = $designerObject['img']; 
        $designerExt = $designerObject['phone'];
        $designerEmail = $designerObject['email']; 
    }

    $today = strtotime(date('Y-m-d'));
    $sdate = strtotime(get_the_date('Y-m-d', $postID));
    $edate = intval(get_post_meta($postID,'nexus_deadline_date',true), 10);
    
    $days = ceil(abs($edate - $sdate) / 86400);
    $tdays = ceil(abs($today - $sdate) / 86400);
    
    if ($tdays > $days) {
        $percComplete = 99;
    } else {
        $percComplete = round((100 / $days) * $tdays); 
    }

    // Request Stage Data
    $requestStatusArray = nexus_getRequestStatus($postID);
    $requestCSS = $requestStatusArray['statusID'];
    $requestColor = $requestStatusArray['color'];
    $percentComplete = $requestStatusArray['percent'];
    $percentNumber = str_replace('%','',$percentComplete);
    $percentDisplay = str_replace('%','<span>%</span>',$percentComplete);

    if ($requestStatusArray['title']) {
        $requestStatusTitle = ' - '.$requestStatusArray['title'];
    }
?>

<div class="pure-g fullWidth <?php echo $nexus_MODE; ?>" role="main" id="mainForm">
    
    <div class="pure-u-5-5 pure-u-md-16-24 padMe" style="position:relative;">
        
        <div class="pure-g fullWidth">
    
            <div class="pure-u-5-5 <?php echo $requestCSS; ?> requestHeader singleRequest">
                <div class="pure-g">
                    <div class="pure-u-5-5 pure-u-md-16-24" style="position:relative;">
                        <div class="userIMG2 hide-sm hide-xs" style="background-image:url('<?php echo $authorImage; ?>');">
                        </div>
                        <h1 class="projectTitle">
                            <?php echo $projectID.$requestStatusTitle; ?>
                            <span class="title"><?php echo $requestTitle; ?></span>
                            <?php if (nexus_publicProtect($postID)) { ?>
                                <span><?php echo $authorFirstName.' '.$authorLastName; ?></span>
                                <span><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo ($authorPhone ? $authorPhone : '0000'); ?></span>
                                <span><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:<?php echo $authorEmail; ?>?subject=Request <?php echo $projectID; ?> - <?php echo $requestTitle; ?>"><?php echo $authorEmail; ?></a></span>
                            <?php } ?>
                        </h1>
                    </div>

                    <div class="pure-u-5-5 pure-u-md-4-24">
                        <div class="pure-g">
                            <div class="pure-u-1-2 pure-u-md-5-5">
                                <h3 class="singleRequestDate">
                                    Submitted
                                    <span><?php echo $requestDateFormat; ?></span>
                                </h3>
                            </div>
                            <div class="pure-u-1-2 pure-u-md-5-5">
                                <?php if ($realType == 'complete') { ?>
                                    <h3 class="singleRequestDate">
                                        Completed On
                                        <span class="<?php echo $overdue; ?>"><?php echo $completedDateFormat; ?></span>
                                    </h3>
                                <?php } else { ?>
                                    <h3 class="singleRequestDate">
                                        Deadline
                                        <span class="<?php echo $overdue; ?>"><?php echo $deadlineDateFormat; ?></span>
                                    </h3>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="pure-u-5-5 pure-u-md-4-24" style="position:relative;">
                        <?php if ($nexus_TMACTIVE) { ?>
                            <div class="pure-g">
                                <div class="pure-u-1-2 pure-u-md-5-5">
                                    <h3 class="singleRequestDate txtC">
                                        Time Tracked
                                        <span><?php echo $timeTracked_output; ?></span>
                                    </h3>
                                </div>
                                <div class="pure-u-1-2 pure-u-md-5-5">
                                    <h3 class="singleRequestDate txtC">
                                        Cost Over Time
                                        <span><?php echo $nexus_CURR.$timeTracked_cost; ?></span>
                                    </h3>
                                </div>
                            </div>
                        <?php } else if ($nexus_BUDGET) { ?>
                            <div class="pure-g">
                                <div class="pure-u-1-2 pure-u-md-5-5">
                                    <h3 class="singleRequestDate txtC">
                                        Client Budget
                                        <span><?php echo $nexus_CURR.$clientBudget; ?></span>
                                    </h3>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="circleLoadSingle">
                                <table  align="center" style="z-index:40;">
                                    <tr>
                                        <td>
                                            <h2 class="hPad txtXL txtC txtB">
                                                <?php echo $percentDisplay; ?>
                                            </h2>
                                        </td>
                                    </tr>
                                </table>
                                <div class="aspect"></div>
                            </div>
                        <?php } ?>
                        <div class="lineLoadSingle"></div>

                        <script>
                            var md = new MobileDetect(window.navigator.userAgent);

                            <?php if (!$nexus_TMACTIVE && !$nexus_BUDGET) { ?>
                                var progressBarSingle = new ProgressBar.Circle('.circleLoadSingle', {
                                    strokeWidth: 5,
                                    color:'<?php echo $lineColor; ?>',
                                    duration: 1800,
                                    fill: '<?php echo $requestColor; ?>'
                                }); 
                            <?php } else { ?>
                                var progressBarSingle = new ProgressBar.Line('.lineLoadSingle', {
                                  strokeWidth: 4,
                                  easing: 'easeInOut',
                                  duration: 1400,
                                  color: '#FFFFFF',
                                  trailColor: 'rgba(0,0,0,0.2)',
                                  trailWidth: 1,
                                  svgStyle: {width: '100%', height: '100%'},
                                  text: { 
                                    style: {
                                      // Text color.
                                      // Default: same as stroke color (options.color)
                                      color: '#FFFFFF',
                                      position: 'absolute',
                                      left: '50%',
                                      top: '20px',
                                      padding: 0,
                                      margin: 0,
                                      transform: 'translateX(-50%)'
                                    },
                                    autoStyleContainer: false
                                  },
                                  from: {color: '#FFFFFF'},
                                  to: {color: '<?php echo $lineColor; ?>'},
                                  step: (state, bar) => {
                                    bar.setText(Math.round(bar.value() * 100) + ' %');
                                    bar.path.setAttribute('stroke', state.color);
                                  }
                                });
                            <?php } ?>

                            progressBarSingle.animate(<?php echo $percentNumber / 100; ?>);
                        </script>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="pure-g">
            <div class="pure-u-5-5 <?php if ($designerID) { ?>pure-u-md-12-24<?php } ?>">
                
                <?php if ($feebackByDesigner) { ?>
                    <div class="requestSection">
                        <h3>Feedback from <?php echo $designerName; ?></h3>
                        <p>
                            <?php echo $feebackByDesigner; ?>
                        </p>
                        <?php echo nexus_getRequestRating($postID, 'client'); ?>
                    </div>
                <?php } ?>

                <?php if ($feebackByAuthor) { ?>
                    <div class="requestSection">
                        <h3>Feedback from <?php echo $authorName; ?></h3>
                        <p>
                            <?php echo $feebackByAuthor; ?>
                        </p>
                        <?php echo nexus_getRequestRating($postID, 'designer'); ?>
                    </div>
                <?php } ?>
                
                <?php if ($designerComments) { ?>
                    <div class="requestSection">
                        <h3>Completion Details</h3>
                        <p>
                            <?php echo nexus_auto_add_link_markup($designerComments); ?>
                        </p>
                    </div>
                <?php } ?>

                <div class="requestSection">
                    <h3>Description</h3>
                    <?php echo nexus_auto_add_link_markup($requestDescription); ?>
                </div>
                
                <?php if ($cuTYPE != 'nope') { ?>
                <?php $clientFileList = get_post_meta($postID,'nexus_client_files',true); ?>
                    <?php if ($clientFileList) { ?>
                        <div class="requestSection">
                            <h3>Client Files</h3>
                            <div class="pure-g">
                                <div class="pure-u-5-5">
                                <ul class="fileList">
                                <?php foreach ($clientFileList as $file) { ?>
                                    <?php //$fullFile = get_attached_file($file['id']); if ($fullFile != '') { ?>
                                    <?php $fullFile = $file['url']; if ($fullFile != '') { ?>
                                    <li>
                                        <a target="_blank" href="<?php echo $fullFile; ?>">

                                            <?php $fileExt  = pathinfo($fullFile, PATHINFO_EXTENSION); ?>
                                            <?php $fileName = basename($fullFile, $fileExt); ?>
                                            <?php $niceFile = (strlen($fileName) > 24 ? substr($fileName, 0, 24).'...'.$fileExt : $fileName.$fileExt); ?>
                                            <?php echo $niceFile; ?>
                                        </a>
                                    </li>
                                <?php } } ?></ul>
                                </div>
                            </div>
                        </div>
                <?php } ?>  
                <?php } ?>  
            </div>
            
            <?php if ($designerID && $cuTYPE != 'nope') { ?>
                <?php if ($nexus_MODE != 'community' || ($nexus_MODE == 'community' && ($cuID == $designerID || $cuID == $authorID))) { ?>
                    <div class="pure-u-5-5 pure-u-md-12-24">
                        <div class="requestSection">
                            <?php include(nexus_plugin_inc('nexus_api/views/chatlog.php')); ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>  
    </div>
    
    <!-- Sidebar -->    
    <div class="pure-u-5-5 pure-u-md-8-24">
        <div class="pure-g">
            <div class="pure-u-5-5 txtC">
                <div class="formBox designerContainer">
                    <?php if (nexus_publicProtect($postID)) { ?>
                        <?php if ($designerID) { ?>
                            <div class="pure-g">
                                <div class="pure-u-5-5 pure-u-md-8-24">
                                    <a href="mailto:<?php echo $designerEmail; ?>?subject=Request <?php echo $projectID; ?> - <?php echo $requestTitle; ?>">
                                        <div class="designerIMG" style="background-image:url('<?php echo $designerIMG; ?>');"></div>
                                    </a>
                                </div>
                                <div class="pure-u-5-5 pure-u-md-16-24">
                                    <h3 class="assignedTo txtLmC">Assigned to <strong><?php echo $designerName; ?></strong></h3>
                                    <p class="designerPhone txtLmC">
                                        <a href="mailto:<?php echo $designerEmail; ?>?subject=Request <?php echo $projectID; ?> - <?php echo $requestTitle; ?>"><?php echo $designerEmail; ?></a>
                                    </p>
                                </div>                            
                            </div>
                        <?php } else { ?>
                            <div class="pure-g">
                                <div class="pure-u-5-5 pure-u-md-8-24">
                                    <div class="designerIMG" style="background-image:url('<?php echo $designerIMG; ?>');"></div>
                                </div>
                                <div class="pure-u-5-5 pure-u-md-16-24">
                                    <h3 class="assignedTo txtLmC">&nbsp;<strong>Not yet assigned</strong></h3>
                                    <p class="designerPhone txtLmC">
                                        &nbsp;
                                    </p>
                                </div>                            
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="ommitted">
                            <p style="margin-top:7px;">
                                <strong>Name, email, phone number...</strong><br>
                                Some data is ommitted publicly for user privacy reasons.<br>
                                Want to get involved?
                            </p>
                            <?php if (!is_user_logged_in()) { ?>
                                <a href="#" data-query="signup" data-menu="signup" class="nexus_ajaxFunction publicLink cta green txtC" style="margin:0;">Register Now</a>
                            <?php } else if ($cuTYPE == 'client' && $cuID != $authorID) { ?>
                                <a href="#" data-query="menu" data-menu="dashboard" class="nexus_ajaxFunction publicLink cta green txtC" style="margin:0;">Add a Request</a>
                            <?php } else if ($cuTYPE == 'designer') { ?>
                                <?php if (!nexus_checkForApplication($cuID, $postID)) { ?>
                                    <a href="#" data-query="apply" data-user="<?php echo $cuID; ?>" data-postid="<?php echo $postID; ?>" class="green cta imgC nexus_ajaxFunction communityONLY" style="margin:10px auto 0 auto; display:block;" data-menu="single_request">Apply for this Job</a>
                                <?php } else { ?>
                                    <a href="#" class="disabledLink cta imgC communityONLY" style="margin:10px auto 0 auto; display:block;">Already applied!</a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <div class="sidebar">
        <?php if ($requestRejected == 'yes') { ?>
            <div class="pure-g">
                <div class="pure-u-5-5">
                    <h3 style="margin:15px 0 0 0; padding:0;">Reason(s):</h3>
                </div>
                <div class="pure-u-5-5 txtRed">
                    <?php echo nexus_str_lreplace(',','',get_post_meta($postID,'nexus_rejection_reason',true)); ?>
                </div>
            </div>
        <?php } ?>
            
        <?php $statusObj = nexus_getRequestStatus($postID); ?>
            
        <?php if ($requestComplete != 'yes') { ?>
            <?php if ($statusObj['signoff'] == true) { ?>
                <?php if (($cuID == $designerID && $nexus_MODE == 'team') || $cuID == $authorID) { ?>
                    <a data-query="request_signoff" data-requesttype="<?php echo $requestType; ?>" data-postid="<?php echo $postID; ?>" class="cta txtC orange nexus_ajaxFunction" href="#">SIGN OFF</a>
                <?php } ?>
            <?php } else { ?>
                <?php if ($cuTYPE == 'designer' && $cuID == $designerID) { ?>
                    <?php if ($statusObj['statNum'] == 1) { ?>
                        <a data-query="single_request" data-postid="<?php echo $postID; ?>" data-stage="2" class="cta txtC green nexus_ajaxFunction" href="#">START JOB</a>
                    <?php } ?>
                    <?php if ($statusObj['statNum'] == 2) { ?>
                        <a data-query="completion" data-postid="<?php echo $postID; ?>" data-override="no" class="cta txtC green nexus_ajaxFunction" href="#">COMPLETE REQUEST</a>
                    <?php } ?>
                <?php } else { ?>
                    <?php if ($cuID == get_post_field('post_author', $postID) && get_post_meta($postID,'nexus_assigned_user', true) == '') { ?>
                        <a class="nexus_ajaxFunction communityONLY cta txtC green <?php echo (nexus_applicationCount($postID) > 0 ? '' : 'disabledLink'); ?>" data-query="application_list" data-postid="<?php echo $postID; ?>" href="#">View Applications (<?php echo nexus_applicationCount($postID); ?>)</a>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
            
        <?php if (!$designerID) { ?>
            <?php if ($requestRejected != 'yes' && $requestComplete == 'no' && $cuTYPE == 'designer') { ?>
                <a href="#" data-postid="<?php echo $postID; ?>" data-newdesigner="<?php echo $cuID; ?>" data-query="single_request" class="cta green imgC nexus_ajaxFunction teamONLY" data-stage="1" style="margin:10px auto; display:block;">Take Request</a>
                <a href="#" data-query="reassign_request" data-postid="<?php echo $postID; ?>" data-menu="reassign" data-designer="<?php echo $designerID; ?>" data-stage="1" style="margin:10px auto; display:block;" class="cta txtC nexus_ajaxFunction teamONLY">Assign Request</a>
                <a href="#" data-query="rejection" data-user="<?php echo $cuID; ?>" data-postid="<?php echo $postID; ?>" class="denyButton cta imgC nexus_ajaxFunction teamONLY" style="margin:10px auto 0 auto; display:block;">Reject Request</a>
                <?php if (!nexus_checkForApplication($cuID, $postID)) { ?>
                    <a href="#" data-query="apply" data-user="<?php echo $cuID; ?>" data-postid="<?php echo $postID; ?>" class="green cta imgC nexus_ajaxFunction communityONLY" style="margin:10px auto 0 auto; display:block;" data-menu="single_request">Apply for Job</a>
                <?php } else { ?>
                    <a href="#" class="disabledLink cta imgC communityONLY" style="margin:10px auto 0 auto; display:block;">Already Applied</a>
                <?php } ?>
            <?php } else { ?>
                <h3>Yet to be assigned</h3>
            <?php } ?>
        <?php } ?>
            
        <?php if ($requestComplete == 'no' && $nexus_MODE == 'team') { if ($cuTYPE == 'designer') { ?>
            <a href="#" data-query="reassign_request_type" data-postid="<?php echo $postID; ?>" data-menu="reassign" data-stage="<?php echo $statusObj['statNum']; ?>" class="nexus_ajaxFunction txtC smallLink teamONLY" style="margin:10px auto; display:block;">Reassign Request Type</a>
        <?php } } ?>
            
        <?php if ($designerID && $requestComplete == 'no' && $nexus_MODE == 'team') { if ($cuTYPE == 'designer') { ?>
            <a href="#" data-query="reassign_request" data-postid="<?php echo $postID; ?>" data-menu="reassign" data-designer="<?php echo $designerID; ?>" data-stage="<?php echo $statusObj['statNum']; ?>" class="nexus_ajaxFunction txtC smallLink" style="margin:10px auto; display:block;">Reassign User</a> 
            <a href="#" data-query="completion" data-override="yes" data-postid="<?php echo $postID; ?>" class="nexus_ajaxFunction txtC smallLink" style="margin:10px auto; display:block;">Skip to completion</a>
        <?php } } ?>  
            
            
        <?php if ($requestComplete == 'yes') { ?>
            <div class="form-style-7 TEST completionDetails">
                <div class="pure-g txtC">
                    <div class="pure-u-5-5">
                        <h3>Completion Details</h3>
                    </div>
                    <div class="pure-u-5-5 pure-u-md-1-2">
                        <h3>
                            Completed
                            <strong><?php echo ($completedDateFormat ? $completedDateFormat : ' '); ?></strong>
                            <span><?php echo $designerName; ?></span>
                        </h3>
                    </div>
                    <div class="pure-u-5-5 pure-u-md-1-2">
                        <h3>
                            Signed Off
                            <strong><?php echo ($signOffDateFormat ? $signOffDateFormat : ' '); ?></strong>
                            <span><?php echo ($signOffUserObj['fullname'] ? $signOffUserObj['fullname'] : ' '); ?></span>
                        </h3>
                    </div>                            
                </div>
            </div>
        <?php } ?>
            
        </div>
    </div>

</div>