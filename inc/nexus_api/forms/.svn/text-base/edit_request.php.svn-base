<?php
    include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options
    include(nexus_plugin_inc('nexus_api/data/current_user.php'));  // Current User Details
    $requestType = get_post_type($postID);
    $requestObject = get_post_type_object($requestType);
    $requestLabel = $requestObject->labels->name;

    $authorID = get_post_field('post_author', $postID);
    $authorOBJ = nexus_userDetailsArray($authorID);
    $authorNAME = $authorOBJ['fullname'];
    $authorIMG = $authorOBJ['img'];
?>
<div class="pure-g fullWidth">

    <div class="pure-u-5-5 tbs requestHeader">
        <h1 class="newRequestTitle txtWhite"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAuCAYAAABXuSs3AAAFSUlEQVRogbWafYiVRRTGn1Xb1HQtTUPQUtTNdbNt02ozKtOFSMLoQ4qMSCwi+sAQSsh1F9cks5Q+pRJNElQK27KI8A8NAinENrItE11My680VyqytX79MXPdd+fOvHfey90HBu57zjPnnHfuzJkzc28ZoBKjQtJeSf3sc4eksZLOlNJJr1IasxgvaZikgbaNkFRZaifFBP6ipKYUfXWkLIeltmUDENP6AvcB39GFOwLcl8nHkgD33gTnG+AeoDwmptjAKzzBAEzwcLd4eJs8vNqAzf6lDFzABx4nvwHnW30N8AhwwsM7BjwMXGm5A4HTHt57sfGUEZ9Vpkra5pG3STotqS7Szg5JF0sa59HVSfoqxkiWwCXpiKRLsnTIgAOSRsWSs2aVRRn5WbAwC7mPR3aBpD8D/NEF7O2RtFPSPkknrWyIpDGSJis9n/umTg4DJP3RTeJM+tuB43aR3OboXg1kgU7gNeDaiEV1PfAm8G/A1ooEt8zGs8EmgelJW67hdsfQPmABsDTgaBMwKiJgt40BNgdsNgPPeWL5MRT46wFDITxeRMBuezqjz2W5vsnFeaLA/E1ilqQ3MvBDWClpdgZ+x7lPzgjMinjrx0ow0llH/iwwM9nHZ6QW+DVgYEsPBJ1rWwM+DwBXuPyQkUHATsfAf8CFRQRUg8kOfQrwhnqC3gEM8PFDG1CHpH8c2duSTmWawQaPSnpfUu8CvOOS1jmyv+Tm7xwCb1/pefuqAiM2nq6CK9k6MYWXgOoCNq7y+L00y4jf4jzvl/RDymgtsvonHHm9zO48RdLdknZLak6x0yrpkCOb5mUCQ4A6YA7wEvAp8Lvz1u8GRqgKaLWc/cAUR/+t1QmYDOy1z+3ATQGbGxzfJ4BPgOXAQ8B1wGABRz1fj4uFjvFy4NmEfqUngMFWt8aRJ3fhVcBwR98cEc9RRZAgf5dssfI2AnMQs8sR0A8Ddln9NkcXtZsWe8r/WGa1V0l6Xub6wcUzMjX2z468UtJbkmoltUta5ujLoiIADkW8YINn1CowRVYO8zGHamEqOTA7cXJ6PZXgr/LYFOZgXQgHhTn/1QL3206bMaVtEusCTgTMwJSdAE1WlpsGSd6TVnYSqE+xt9HxfRRz3l2MuRWoAQaEOs91OrenOMq1VzB5uq/t42aiiZgKtHcBO784vmf7eKHOY8lHXr0QaC9YfmjRprVJHr8jswQu4EvHwOoIx+WWe6SIoAWsd3xuDXFDWWWozNkzibky58fUtS5phaR5UZmhO4YrvzavkHSR31P+29SRvzhz+LzIkYxp2wM+DwNXu3y38+xA5yTm9UDQCyL8JlNrt8BDB2IfvCu9yDYng9/GXL/kHO/nnUt+rJc0P9MM9mOBpDUZ+OXnPjlvv9d5wzZM7dAYGIEWTO2edZQnYKpQHxZiduE9jnx30oZr8FbMBrAamObolgccAbwD3Fgg2DJgKqZaDGGp06ceWIs5A9+c1PkuPc+T1Bn4qhZLakj5Ktsl7ZL/Cm6SpMtS+jZIWpIyRbodJX13h6GgJXNbm4bRKny/GMLBFJ17/s18zXxMZnPqCRySNDKWnKUeny5/0K2SvshgZ7vM2dPFCEk3RFspsKCSrYV8HAF6WX0V8CBdJW4Sh4EHgMstty+mvHWxMTae2KAHBbLAOA/3o8iAqgM2o368ip0qf0u6UyZj5DBD5hdkFz9Fyr6XdFfi+WtJMyWdjQnIl1V8OCOpxbZmmRumzwJc3/z1ySTpQ0mNMmutKTIWSdmzSgyukRm9JCYqHHxR6InAB8pMof72+ZTM7zsl/RPC/7pNme/opfTBAAAAAElFTkSuQmCC" />Edit Request <?php echo nexus_requestID($postID); ?></h1> 
    </div>

</div>

<div class="pure-g" id="submitConfirmation" style="display:none;">
    <div class="pure-u-5-5">
        <h1 class="txtC">The request has been edited!</h1>
    </div>
    <div class="pure-u-5-5 pure-u-md-1-2 leftContent">
        <p class="txtC"><a class="nexus_ajaxFunction cta" data-query="single_request" data-postid="<?php echo $postID; ?>" href="#">Return to Request</a></p>
    </div>
    <div class="pure-u-5-5 pure-u-md-1-2 rightContent">
        <p class="txtC"><a class="cta" href="<?php echo get_bloginfo('url'); ?>/dashboard/">Return to Dashboard</a></p>
    </div>
</div>

<form id="nexus_form" name="nexus_form" class="nexus_ajaxForm" enctype="multipart/form-data" data-function="nexus_editRequest">
    
    <div class="pure-g">
        <div class="pure-u-5-5 pure-u-md-16-24 leftFormContent">
                
                <?php if ($cuTYPE == 'designer') { ?>
                    <div class="adminBox form-style-7 TEST">
                        <div class="pure-g">
                            <div class="pure-u-5-5 pure-u-md-1-2">
                                <label for="masquerade">ADMIN</label>
                                <p>Switch client? <span>(Leave as is, if not)</span></p>
                            </div>
                            <div class="pure-u-5-5 pure-u-md-1-2">
                                <table height="50" width="100%">
                                    <tr>
                                        <td>
                                            <a class="masquerade masqueIMG" style="background-image:url('<?php echo $authorIMG; ?>');"></a>
                                        </td>
                                        <td>
                                            <select class="masque" name="userID" id="userID">
                                                <?php 
                                                    $clientQuery = new WP_User_Query( array( 'role' => 'Subscriber' ) );
                                                    foreach($clientQuery->results as $user) {
                                                        $clientID = $user->ID; $clientOBJ = nexus_userDetailsArray($clientID);
                                                        $clientName = $clientOBJ['fullname']; ?>
                                                        <option value="<?php echo $clientID; ?>" 
                                                                <?php if ($clientID == $authorID) { ?>selected="selected"<? } ?> >
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
            
                <div class="form-style-7 TEST"><div class="pure-g">
                    <div class="pure-u-5-5">
                        <label for="desType">Request Title</label>
                        <input type="text" name="desType" class="required" value="<?php echo get_the_title($postID); ?>" />
                        <span class="errorText">Please enter a request title.</span>
                    </div>
                </div></div>

                <div class="form-style-7 TEST"><div class="pure-g">
                    <div class="pure-u-5-5">
                        <label for="requestContent" class="descLabel">Description</label>
                        <textarea name="requestContent" class="required"><?php echo get_post_field('post_content',$postID); ?></textarea>
                        <span class="errorText">Please enter a request summary.</span>
                    </div>
                </div></div>
        </div>
        
        <div class="pure-u-5-5 pure-u-md-8-24 rightFormContent">
            <a class="hide-sm hide-xs nexus_ajaxSubmit cta txtC green" 
               data-validate="true"
               href="#nexus_form">UPDATE REQUEST</a>
            
            <div class="form-style-7 TEST">
            <div class="pure-g">
                <div class="pure-u-5-5">
                    <label for="importance">Importance</label>
                    <select name="importance">
                        <?php $importance = get_post_meta($postID,'nexus_request_importance',true); ?>
                        <option <?php if ($importance == 'low') { ?>selected="selected"<?php } ?> value="low">Average</option>
                        <option <?php if ($importance == 'high') { ?>selected="selected"<?php } ?> value="high">Urgent</option>
                    </select>
                </div>
                <div class="pure-u-5-5">
                    <label for="completionDate">Deadline:</label>
                    <input class="datepicker required minToday" type="text" name="completionDate" value="<?php echo date('d-m-Y', intval(get_post_meta($postID,'nexus_deadline_date',true), 10)); ?>" />
                    <span class="errorText">Please enter a date.</span>
                </div>
            </div>
            </div>
            
            
            <div class="pure-g">
                <div class="pure-u-5-5">
                    <div id="uploadBox" class="uploader">
                        <input type="file" name="uploader[]" multiple="multiple" id="fileUploader" data-type="edit" style="display:none;">
                        <a href="#" class="cta txtC fileUploadLink" style="margin:0;">Upload Files...</a>
                        <ul>
                            <?php $fileList = get_post_meta('nexus_client_files'); ?>
                            <?php if (count($fileList) > 0): $listArr = ''; $fli = 0; foreach($fileList as $file) {
                                $fullFile = $file; if ($fullFile != '') { $fli = $fli + 1;
                                if ($fli > 1) { $listArr .= ','; } $listArr .= $fullFile;
                                $fileExt  = pathinfo($fullFile, PATHINFO_EXTENSION);
                                $fileName = basename($fullFile, $fileExt);
                                $niceFile = (strlen($fileName) > 24 ? substr($fileName, 0, 24).'...'.$fileExt : $fileName.$fileExt); ?>
                                <li><span><?php echo $niceFile; ?></span></li>
                            <?php } } endif; ?>
                        </ul>
                    </div>
                </div>
        
                <div class="pure-u-5-5 txtC">
                    <input type="hidden" name="postid" value="<?php echo $postID; ?>" />
                    <input type="hidden" name="requestType" value="<?php echo $requestType; ?>" />
                    <input type="hidden" id="filelist" name="filelist" value="<?php echo $listArr; ?>" />
                    <input type="hidden" id="formid" name="formid" value="nexus_form" />
                    <?php if ($cuTYPE != 'designer') { ?><input type="hidden" name="userID" value="<?php echo $cuID; ?>" /><?php } else { ?><input type="hidden" name="currentUser" value="<?php echo $cuID; ?>" /><?php } ?>
                </div>
            </div>
            
            
            <a class="hide-md hide-lg hide-xl nexus_ajaxSubmit cta txtC green" 
               data-validate="true"
               href="#nexus_form">UPDATE REQUEST</a>
        </div>
        
    </div>
</form>