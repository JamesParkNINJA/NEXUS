<?php 
    include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options
    include(nexus_plugin_inc('nexus_api/data/current_user.php'));  // Current User Details 
?>

<div class="pure-g">
    <div class="pure-u-5-5 pure-u-md-10-24">
        <label for="timeSelector">Your Active Jobs</label>
        <?php $postTypes = nexus_output_post_types('array_single'); ?>
        <select id="timeSelector" name="timeSelector">
            <option value="">Select a request to begin tracking</option>
            <?php 
                $query = new WP_Query( array( 'post_type' => $postTypes, 'posts_per_page' => -1, 'meta_key' => 'nexus_assigned_user', 'meta_value' => $cuID ) );
                $activeTest = false;
                if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 
            ?>
                <option value="<?php echo get_the_ID(); ?>">
                    <?php $proID = strtoupper(substr(str_replace('nexus_','',get_post_type()), 0, 3)).get_the_ID(); ?>
                    <?php $authID = get_post_field( 'post_author', get_the_ID() ); $authName = get_the_author_meta('display_name', $authID); ?>
                    <?php echo $proID.' - '.get_the_title().' - '.$authName; ?>
                </option>
            <?php endwhile; endif; wp_reset_query(); ?>
        </select>
    </div>
    <div class="pure-u-5-5 pure-u-md-14-24 txtC">
        <div class="timeMachine_inactive active">
            <h3>Time Tracker <i class="fa fa-clock-o" aria-hidden="true"></i></h3>
        </div>
        <div class="timeMachine_panel">
            <div class="pure-g">
                <div class="pure-u-5-5 pure-u-md-12-24">
                    <label>Time Control</label>
                    <div class="timeControls">
                        <ul class="inline">
                            <li>
                                <input type="button" value="Start Tracking" id="nexus_tmStart" />
                                <input type="button" value="Stop & Update"  id="nexus_tmStop" style="display:none;" />
                            </li> 
                            <!--
                            <li>
                                <input type="button" value="Reset" id="nexus_tmReset" />
                            </li> 
                            -->
                        </ul>
                    </div>
                </div>
                <div class="pure-u-5-5 pure-u-md-12-24">
                    <div class="timerPanel pure-g">
                        <div class="pure-u-18-24">
                            <div class="watchOut">
                                <span id="nexus_tmH">00</span>:<span id="nexus_tmM">00</span>:<span id="nexus_tmS">00</span>
                            </div> 
                        </div>
                        <div class="pure-u-6-24">
                            <p class="center countdown-timer rotate-180">
                                <span class="sand-top"></span>
                                <span class="sand-bottom"></span>
                            </p>  
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>

<script>  
    /* Actual Watch Functions */
    
    // Setting the variables
    var nexus_tmSeconds = 0, nexus_tmMinutes = 0, nexus_tmHours = 0,
        nexus_tmLen, nexus_tmStr, nexus_tmInterval;

    // time interval
    function timeSetting(sec) {
        nexus_tmSeconds += 1;
        nexus_tmStr = nexus_tmSeconds.toString();
        nexus_tmLen = nexus_tmStr.length;

        if (nexus_tmLen < 2) {
            document.getElementById('nexus_tmS').innerHTML = '0' + nexus_tmSeconds;
        } else {
            if (nexus_tmSeconds == 60) {

                nexus_tmSeconds = 0;
                nexus_tmMinutes += 1;
                nexus_tmStr = nexus_tmMinutes.toString();
                nexus_tmLen = nexus_tmStr.length;

                if (nexus_tmLen < 2) {
                    document.getElementById('nexus_tmS').innerHTML = '0' + nexus_tmSeconds;
                    document.getElementById('nexus_tmM').innerHTML = '0' + nexus_tmMinutes;
                } else {
                    if (nexus_tmMinutes == 60) {

                        nexus_tmMinutes = 0;
                        nexus_tmHours += 1;
                        nexus_tmStr = nexus_tmHours.toString();
                        nexus_tmLen = nexus_tmStr.length;

                        if (nexus_tmLen < 2) {
                            document.getElementById('nexus_tmS').innerHTML = '0' + nexus_tmSeconds;
                            document.getElementById('nexus_tmM').innerHTML = '0' + nexus_tmMinutes;
                            document.getElementById('nexus_tmH').innerHTML = '0' + nexus_tmHours;
                        } else {
                            if (nexus_tmHours == 24) {
                                nexus_tmHours = 0
                                document.getElementById('nexus_tmS').innerHTML = '0' + nexus_tmSeconds;
                                document.getElementById('nexus_tmM').innerHTML = '0' + nexus_tmMinutes;
                                document.getElementById('nexus_tmH').innerHTML = '0' + nexus_tmHours;
                            } else {
                                document.getElementById('nexus_tmS').innerHTML = '0' + nexus_tmSeconds;
                                document.getElementById('nexus_tmM').innerHTML = '0' + nexus_tmMinutes;
                                document.getElementById('nexus_tmH').innerHTML = nexus_tmHours;
                            }
                        }

                    } else {
                        document.getElementById('nexus_tmS').innerHTML = '0' + nexus_tmSeconds;
                        document.getElementById('nexus_tmM').innerHTML = nexus_tmMinutes;
                    }
                }

            } else {
                document.getElementById('nexus_tmS').innerHTML = nexus_tmSeconds;
            }
        }

    }

    document.getElementById('nexus_tmStart').onclick = function() {
        nexus_tmInterval = setInterval(timeSetting, 1000);
        if (!jQuery('.countdown-timer').hasClass('animating')) {
            jQuery('.countdown-timer').addClass('animating');
        }
        jQuery('#nexus_tmStart').hide();
        jQuery('#nexus_tmStop').show();
        jQuery('.submitTimeMachine').attr('disabled',true);
        jQuery('#timeSelector').attr('disabled',true);
    };

    document.getElementById('nexus_tmStop').onclick = function() {
        clearInterval(nexus_tmInterval);
        jQuery('.countdown-timer.animating').removeClass('animating');
        jQuery('#nexus_tmStart').show();
        jQuery('#nexus_tmStop').hide();
        jQuery('.submitTimeMachine').attr('disabled',false);
        jQuery('#timeSelector').attr('disabled',false); 
        
        var hr = nexus_tmHours * 3600, min = nexus_tmMinutes * 60, se = nexus_tmSeconds,
            newtime = hr + min + se,
            postid = jQuery('#timeSelector').find(":selected").val();
        
        console.log(newtime);
        
        jQuery.ajax({
            url: nexus_ajaxurl+'?action=nexus_updateTime',
            type: 'post',
            data: {postid: postid, time: newtime},
            success: function(data) {
                var dataArray = JSON.parse(data);
                //console.log(dataArray);
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
            }
        });
    };

    document.getElementById('timeSelector').onchange = function() {
        clearInterval(nexus_tmInterval);
        var request = jQuery('#timeSelector').find(":selected").val();
        
        if (!request || request == '') {
            jQuery('.timeMachine_panel').removeClass('active');
            jQuery('.timeMachine_inactive').addClass('active');
        } else {
        
            jQuery.ajax({
                url: nexus_ajaxurl+'?action=nexus_getTime',
                type: 'post',
                data: {postid: request},
                success: function(data) {
                    var dataArray = JSON.parse(data);
                    //console.log(dataArray);
                    
                    var nexus_newTime = dataArray['time'];
                    
                    jQuery('.timeMachine_panel').addClass('active');
                    jQuery('.timeMachine_inactive').removeClass('active');

                    //console.log(nexus_newTime);
                    if (!nexus_newTime || nexus_newTime == '') { nexus_newTime = 0; }
                    nexus_tmHours = Math.floor(nexus_newTime / 3600);
                    nexus_newTime %= 3600;
                    nexus_tmMinutes = Math.floor(nexus_newTime / 60);
                    nexus_tmSeconds = nexus_newTime % 60;

                    var stampTime = new Date(nexus_newTime * 1000),
                        nexus_newH = nexus_tmHours,
                        nexus_newM = nexus_tmMinutes,
                        nexus_newS = nexus_tmSeconds;

                    document.getElementById('nexus_tmS').innerHTML = ("0" + nexus_newS).slice(-2);
                    document.getElementById('nexus_tmM').innerHTML = ("0" + nexus_newM).slice(-2);
                    document.getElementById('nexus_tmH').innerHTML = ("0" + nexus_newH).slice(-2);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(jqXHR);
                }
            });
        }
    };
</script>