<?php
    include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options
    include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details
    $requestObject = get_post_type_object($requestType);
    $requestLabel = $requestObject->labels->name;
    $test = post_type_exists($requestType);
    echo nexus_logMe($test);
?>
<div class="pure-g fullWidth">

    <div class="pure-u-5-5 tbs requestHeader formHeader">
        <h1 class="newRequestTitle txtWhite"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAuCAYAAABXuSs3AAAFSUlEQVRogbWafYiVRRTGn1Xb1HQtTUPQUtTNdbNt02ozKtOFSMLoQ4qMSCwi+sAQSsh1F9cks5Q+pRJNElQK27KI8A8NAinENrItE11My680VyqytX79MXPdd+fOvHfey90HBu57zjPnnHfuzJkzc28ZoBKjQtJeSf3sc4eksZLOlNJJr1IasxgvaZikgbaNkFRZaifFBP6ipKYUfXWkLIeltmUDENP6AvcB39GFOwLcl8nHkgD33gTnG+AeoDwmptjAKzzBAEzwcLd4eJs8vNqAzf6lDFzABx4nvwHnW30N8AhwwsM7BjwMXGm5A4HTHt57sfGUEZ9Vpkra5pG3STotqS7Szg5JF0sa59HVSfoqxkiWwCXpiKRLsnTIgAOSRsWSs2aVRRn5WbAwC7mPR3aBpD8D/NEF7O2RtFPSPkknrWyIpDGSJis9n/umTg4DJP3RTeJM+tuB43aR3OboXg1kgU7gNeDaiEV1PfAm8G/A1ooEt8zGs8EmgelJW67hdsfQPmABsDTgaBMwKiJgt40BNgdsNgPPeWL5MRT46wFDITxeRMBuezqjz2W5vsnFeaLA/E1ilqQ3MvBDWClpdgZ+x7lPzgjMinjrx0ow0llH/iwwM9nHZ6QW+DVgYEsPBJ1rWwM+DwBXuPyQkUHATsfAf8CFRQRUg8kOfQrwhnqC3gEM8PFDG1CHpH8c2duSTmWawQaPSnpfUu8CvOOS1jmyv+Tm7xwCb1/pefuqAiM2nq6CK9k6MYWXgOoCNq7y+L00y4jf4jzvl/RDymgtsvonHHm9zO48RdLdknZLak6x0yrpkCOb5mUCQ4A6YA7wEvAp8Lvz1u8GRqgKaLWc/cAUR/+t1QmYDOy1z+3ATQGbGxzfJ4BPgOXAQ8B1wGABRz1fj4uFjvFy4NmEfqUngMFWt8aRJ3fhVcBwR98cEc9RRZAgf5dssfI2AnMQs8sR0A8Ddln9NkcXtZsWe8r/WGa1V0l6Xub6wcUzMjX2z468UtJbkmoltUta5ujLoiIADkW8YINn1CowRVYO8zGHamEqOTA7cXJ6PZXgr/LYFOZgXQgHhTn/1QL3206bMaVtEusCTgTMwJSdAE1WlpsGSd6TVnYSqE+xt9HxfRRz3l2MuRWoAQaEOs91OrenOMq1VzB5uq/t42aiiZgKtHcBO784vmf7eKHOY8lHXr0QaC9YfmjRprVJHr8jswQu4EvHwOoIx+WWe6SIoAWsd3xuDXFDWWWozNkzibky58fUtS5phaR5UZmhO4YrvzavkHSR31P+29SRvzhz+LzIkYxp2wM+DwNXu3y38+xA5yTm9UDQCyL8JlNrt8BDB2IfvCu9yDYng9/GXL/kHO/nnUt+rJc0P9MM9mOBpDUZ+OXnPjlvv9d5wzZM7dAYGIEWTO2edZQnYKpQHxZiduE9jnx30oZr8FbMBrAamObolgccAbwD3Fgg2DJgKqZaDGGp06ceWIs5A9+c1PkuPc+T1Bn4qhZLakj5Ktsl7ZL/Cm6SpMtS+jZIWpIyRbodJX13h6GgJXNbm4bRKny/GMLBFJ17/s18zXxMZnPqCRySNDKWnKUeny5/0K2SvshgZ7vM2dPFCEk3RFspsKCSrYV8HAF6WX0V8CBdJW4Sh4EHgMstty+mvHWxMTae2KAHBbLAOA/3o8iAqgM2o368ip0qf0u6UyZj5DBD5hdkFz9Fyr6XdFfi+WtJMyWdjQnIl1V8OCOpxbZmmRumzwJc3/z1ySTpQ0mNMmutKTIWSdmzSgyukRm9JCYqHHxR6InAB8pMof72+ZTM7zsl/RPC/7pNme/opfTBAAAAAElFTkSuQmCC" />New <?php echo $requestLabel; ?></h1> 
    </div>

</div>

<div class="pure-g" id="submitConfirmation" style="display:none;">
    <div class="pure-u-5-5">
        <h1 class="txtC">Your request has been submitted!</h1>
        <p class="txtC">You will be notified when someone has been assigned to your job.</p>
    </div>
    <div class="pure-u-5-5 pure-u-md-1-2 leftContent">
        <p class="txtC"><a class="nexus_ajaxFunction cta" data-requesttype="<?php echo $requestType; ?>" data-query="request" href="#">New Request</a></p>
    </div>
    <div class="pure-u-5-5 pure-u-md-1-2 rightContent">
        <p class="txtC"><a class="cta" href="<?php echo $nexus_DASHBOARDURL; ?>">Return to Dashboard</a></p>
    </div>
</div>

<form id="nexus_form" name="design" class="requestForm nexus_formData" enctype="multipart/form-data" data-function="nexus_submitWebRequest">
    
    <div class="pure-g">
        <div class="pure-u-5-5 pure-u-md-16-24 leftFormContent">
            <?php $clientQuery = new WP_User_Query( array( 'role' => 'Subscriber' ) ); ?>
            <?php if ($cuTYPE == 'designer' && count($clientQuery->results) > 0) { ?>
                <div class="adminBox form-style-7 TEST">
                    <div class="pure-g">
                        <div class="pure-u-5-5 pure-u-md-1-2">
                            <label for="masquerade">ADMIN</label>
                            <p>Masquerade as another user? <span>(Leave as is, if not)</span></p>
                        </div>
                        <div class="pure-u-5-5 pure-u-md-1-2">
                            <table height="50" width="100%">
                                <tr>
                                    <td>
                                        <a class="masquerade masqueIMG" style="background-image:url('<?php echo $cuIMG; ?>');"></a>
                                    </td>
                                    <td>
                                        <select class="masque" name="userID" id="userID">
                                            <?php 
                                                foreach($clientQuery->results as $user) {
                                                    $clientID = $user->ID; $clientOBJ = nexus_userDetailsArray($clientID);
                                                    $clientName = $clientOBJ['fullname']; ?>
                                                    <option value="<?php echo $clientID; ?>" 
                                                            <?php if ($clientID == $authorID) { ?>selected="selected"<?php } ?> >
                                                        <?php echo $clientName; ?>
                                                    </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr> 
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($nexus_BUDGET) { ?><div class="pure-g padless"><div class="pure-u-5-5 pure-u-md-18-24" style="padding-right:15px;"><?php } ?>
            <div class="form-style-7 TEST"><div class="pure-g">
                <div class="pure-u-5-5">
                    <label for="requestTitle" class="descLabel">Request Title</label>
                    <input type="text" name="requestTitle" class="required" />
                    <span class="errorText">Please enter a request title.</span>
                </div>
            </div></div>
            
            <?php if ($nexus_BUDGET) { ?>
            </div><div class="pure-u-5-5 pure-u-md-6-24">
                <div class="form-style-7 TEST"><div class="pure-g">
                    <div class="pure-u-5-5">
                        <label for="requestBudget" class="descLabel">Budget</label>
                        <input type="number" name="requestBudget" class="required" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" />
                        <span class="errorText">Please enter your budget.</span>
                    </div>
                </div></div>
            </div></div>
            <?php } ?>
    
            <div class="form-style-7 TEST"><div class="pure-g">
                <div class="pure-u-5-5">
                    <label for="requestContent" class="descLabel">Description</label>
                    <textarea name="requestContent" class="required"></textarea>
                    <span class="errorText">Please enter a request summary.</span>
                </div>
            </div></div>
        </div>
        
        <div class="pure-u-5-5 pure-u-md-8-24 rightFormContent">
            <a class="nexus_formSubmit hide-sm hide-xs cta nexus_formData txtC green" 
               data-validate="true"
               data-reloadType=""
               href="#nexus_form">SUBMIT REQUEST</a>
            
            <div class="pure-g">
                <div class="pure-u-5-5 pure-u-md-1-2 leftContent">
                    <div class="form-style-7 TEST">
                        <label for="importance">Importance</label>
                        <select name="importance">
                            <option value="low">Average</option>
                            <option value="high">Urgent</option>
                        </select>
                        <span class="errorText">Select your urgency.</span>
                    </div>
                </div>
                <div class="pure-u-5-5 pure-u-md-1-2 rightContent">
                    <div class="form-style-7 TEST">
                        <label for="completionDate">Deadline:</label>
                        <input class="datepicker required minToday" type="text" name="completionDate" />
                        <span class="errorText">Please enter a date.</span>
                    </div>
                </div>
            </div>
            
            
            <div class="pure-g">
                <div class="pure-u-5-5">
                    <div id="uploadBox" class="uploader">
                        <input type="text" name="filelist" multiple="multiple" id="filelist" style="display:none;">
                        <a href="#" class="cta txtC fileUploadLink" style="margin:0;">Upload Files...</a>
                        <ul></ul>
                    </div>
                </div>
        
                <div class="pure-u-5-5 txtC">
                    <?php $current_user = wp_get_current_user(); ?>
                    <input type="hidden" name="requestType" value="<?php echo $requestType; ?>" />
                    <input type="hidden" id="filelist" name="filelist" value="" />
                    <input type="hidden" id="formid" name="formid" value="nexus_form" />
                    <?php if ($cuTYPE != 'designer') { ?><input type="hidden" name="userID" value="<?php echo $current_user->ID; ?>" /><?php } ?>
                </div>
            </div>
            
            <a class="hide-md hide-lg hide-xl nexus_formSubmit cta nexus_formData txtC green" 
               data-validate="true"
               data-reloadType=""
               href="#nexus_form">SUBMIT REQUEST</a>
        </div>
        
    </div>
</form>