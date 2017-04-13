<?php include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options ?>

<div class="pure-g fullWidth">

    <div class="pure-u-5-5 tbs requestHeader formHeader">
        <h1 class="newRequestTitle txtWhite"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAuCAYAAABXuSs3AAAFSUlEQVRogbWafYiVRRTGn1Xb1HQtTUPQUtTNdbNt02ozKtOFSMLoQ4qMSCwi+sAQSsh1F9cks5Q+pRJNElQK27KI8A8NAinENrItE11My680VyqytX79MXPdd+fOvHfey90HBu57zjPnnHfuzJkzc28ZoBKjQtJeSf3sc4eksZLOlNJJr1IasxgvaZikgbaNkFRZaifFBP6ipKYUfXWkLIeltmUDENP6AvcB39GFOwLcl8nHkgD33gTnG+AeoDwmptjAKzzBAEzwcLd4eJs8vNqAzf6lDFzABx4nvwHnW30N8AhwwsM7BjwMXGm5A4HTHt57sfGUEZ9Vpkra5pG3STotqS7Szg5JF0sa59HVSfoqxkiWwCXpiKRLsnTIgAOSRsWSs2aVRRn5WbAwC7mPR3aBpD8D/NEF7O2RtFPSPkknrWyIpDGSJis9n/umTg4DJP3RTeJM+tuB43aR3OboXg1kgU7gNeDaiEV1PfAm8G/A1ooEt8zGs8EmgelJW67hdsfQPmABsDTgaBMwKiJgt40BNgdsNgPPeWL5MRT46wFDITxeRMBuezqjz2W5vsnFeaLA/E1ilqQ3MvBDWClpdgZ+x7lPzgjMinjrx0ow0llH/iwwM9nHZ6QW+DVgYEsPBJ1rWwM+DwBXuPyQkUHATsfAf8CFRQRUg8kOfQrwhnqC3gEM8PFDG1CHpH8c2duSTmWawQaPSnpfUu8CvOOS1jmyv+Tm7xwCb1/pefuqAiM2nq6CK9k6MYWXgOoCNq7y+L00y4jf4jzvl/RDymgtsvonHHm9zO48RdLdknZLak6x0yrpkCOb5mUCQ4A6YA7wEvAp8Lvz1u8GRqgKaLWc/cAUR/+t1QmYDOy1z+3ATQGbGxzfJ4BPgOXAQ8B1wGABRz1fj4uFjvFy4NmEfqUngMFWt8aRJ3fhVcBwR98cEc9RRZAgf5dssfI2AnMQs8sR0A8Ddln9NkcXtZsWe8r/WGa1V0l6Xub6wcUzMjX2z468UtJbkmoltUta5ujLoiIADkW8YINn1CowRVYO8zGHamEqOTA7cXJ6PZXgr/LYFOZgXQgHhTn/1QL3206bMaVtEusCTgTMwJSdAE1WlpsGSd6TVnYSqE+xt9HxfRRz3l2MuRWoAQaEOs91OrenOMq1VzB5uq/t42aiiZgKtHcBO784vmf7eKHOY8lHXr0QaC9YfmjRprVJHr8jswQu4EvHwOoIx+WWe6SIoAWsd3xuDXFDWWWozNkzibky58fUtS5phaR5UZmhO4YrvzavkHSR31P+29SRvzhz+LzIkYxp2wM+DwNXu3y38+xA5yTm9UDQCyL8JlNrt8BDB2IfvCu9yDYng9/GXL/kHO/nnUt+rJc0P9MM9mOBpDUZ+OXnPjlvv9d5wzZM7dAYGIEWTO2edZQnYKpQHxZiduE9jnx30oZr8FbMBrAamObolgccAbwD3Fgg2DJgKqZaDGGp06ceWIs5A9+c1PkuPc+T1Bn4qhZLakj5Ktsl7ZL/Cm6SpMtS+jZIWpIyRbodJX13h6GgJXNbm4bRKny/GMLBFJ17/s18zXxMZnPqCRySNDKWnKUeny5/0K2SvshgZ7vM2dPFCEk3RFspsKCSrYV8HAF6WX0V8CBdJW4Sh4EHgMstty+mvHWxMTae2KAHBbLAOA/3o8iAqgM2o368ip0qf0u6UyZj5DBD5hdkFz9Fyr6XdFfi+WtJMyWdjQnIl1V8OCOpxbZmmRumzwJc3/z1ySTpQ0mNMmutKTIWSdmzSgyukRm9JCYqHHxR6InAB8pMof72+ZTM7zsl/RPC/7pNme/opfTBAAAAAElFTkSuQmCC" />Member Registration</h1> 
    </div>

</div>


<div class="pure-g" id="submitConfirmation" style="display:none;">
    <div class="pure-u-5-5">
        <h1 class="txtC">Thank you for registering as a member!</h1>
        <p class="txtC">
            <?php if (!$nexus_ACTIVATION) { ?>
                Simply change your password <a href="<?php echo wp_lostpassword_url( $nexus_DASHBOARDURL ); ?>">here</a> or via the "Forgot your password?" link in the menu, and you will be able to log in straight away.
            <?php } else { ?>
                A full member of the site will have to approve your registration before you begin. You will be notified via email once approved, then simply change your password via the "Forgot your password?" link in the menu, and you will be able to log in.
            <?php } ?>
        </p>
    </div>
    <?php if (!$nexus_ACTIVATION) { ?>
        <div class="pure-u-5-5 pure-u-md-1-2 leftContent">
            <p class="txtC"><a class="nexus_ajaxFunction cta" data-requesttype="<?php echo $requestType; ?>" data-query="request" href="#">New Request</a></p>
        </div>
        <div class="pure-u-5-5 pure-u-md-1-2 rightContent">
            <p class="txtC"><a class="cta" href="<?php echo $nexus_DASHBOARDURL; ?>">Return to Dashboard</a></p>
        </div>
    <?php } ?>
</div>

<form id="nexusSignupForm" enctype="form/multipart" name="nexusSignupForm" class="nexus_formDataFiles form-style-7" data-function="nexus_userSignup">
    <input type="hidden" name="signupType" value="member" />
    <div class="pure-g">
        <div class="pure-u-5-5 pure-u-md-1-2">
            <ul>
                <li>
                    <label for="firstName" class="descLabel">First Name</label>
                    <input type="text" name="firstName" class="required" />
                    <span class="errorText">Please enter your first name.</span>
                </li> 
                <li>
                    <label for="lastName" class="descLabel">Last Name</label>
                    <input type="text" name="lastName" class="required" />
                    <span class="errorText">Please enter your last name.</span>
                </li>  
                <li>
                    <label for="businessName" class="descLabel">Business Name</label>
                    <input type="email" name="businessName" class="required" />
                    <span class="errorText">Please enter your business name.</span>
                </li>
                <li>
                    <label for="emailAddress" class="descLabel">Email Address</label>
                    <input type="email" name="emailAddress" class="required" />
                    <span class="errorText">Please enter a valid email address.</span>
                </li>  
            </ul>
        </div> 
        <div class="pure-u-5-5 pure-u-md-1-2">
            <ul style="margin:50px 0 0 0;">
                <li>
                    <label for="contactNo" class="descLabel">Contact Number</label>
                    <input type="text" name="contactNo" class="required" />
                    <span class="errorText">Please enter your contact number.</span>
                </li>
            </ul>
            <div style="box-sizing:border-box; padding:20px; max-width:400px; text-align:center;">
                <div class='user_image_preview_wrapper'>
                    <div class="profileIMG" style="background-image:url('http://0.gravatar.com/avatar/6d814fac2b564550e3f71931714e6746?s=96&amp;d=mm&amp;r=g')"></div>
                </div>
                <input type="file" name="userImage" id="userImage" value="" class="hiddenButActive">
                <input type="button" data-url="user_image" data-src="user_image_preview" name="nexusUploadBTN" class="nexusUploadBTN button-secondary" value="Upload User Image" data-form="#imageUpload">
                <a href="#nexusSignupForm" class="nexus_ajaxSubmit cta green" data-validate="true">Register</a>
            </div>
        </div> 
    </div>
</form>