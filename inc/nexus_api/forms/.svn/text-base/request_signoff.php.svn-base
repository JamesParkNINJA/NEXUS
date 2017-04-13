<?php include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options ?>
<?php include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details ?>
<?php $desID = get_post_meta($postID,'nexus_assigned_user',true); $desObj = nexus_userDetailsArray($desID); ?>
<div class="pure-g fullWidth">
    <div class="pure-u-5-5 tbs requestHeader">
        <h1 class="newRequestTitle txtWhite"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAuCAYAAABXuSs3AAAFSUlEQVRogbWafYiVRRTGn1Xb1HQtTUPQUtTNdbNt02ozKtOFSMLoQ4qMSCwi+sAQSsh1F9cks5Q+pRJNElQK27KI8A8NAinENrItE11My680VyqytX79MXPdd+fOvHfey90HBu57zjPnnHfuzJkzc28ZoBKjQtJeSf3sc4eksZLOlNJJr1IasxgvaZikgbaNkFRZaifFBP6ipKYUfXWkLIeltmUDENP6AvcB39GFOwLcl8nHkgD33gTnG+AeoDwmptjAKzzBAEzwcLd4eJs8vNqAzf6lDFzABx4nvwHnW30N8AhwwsM7BjwMXGm5A4HTHt57sfGUEZ9Vpkra5pG3STotqS7Szg5JF0sa59HVSfoqxkiWwCXpiKRLsnTIgAOSRsWSs2aVRRn5WbAwC7mPR3aBpD8D/NEF7O2RtFPSPkknrWyIpDGSJis9n/umTg4DJP3RTeJM+tuB43aR3OboXg1kgU7gNeDaiEV1PfAm8G/A1ooEt8zGs8EmgelJW67hdsfQPmABsDTgaBMwKiJgt40BNgdsNgPPeWL5MRT46wFDITxeRMBuezqjz2W5vsnFeaLA/E1ilqQ3MvBDWClpdgZ+x7lPzgjMinjrx0ow0llH/iwwM9nHZ6QW+DVgYEsPBJ1rWwM+DwBXuPyQkUHATsfAf8CFRQRUg8kOfQrwhnqC3gEM8PFDG1CHpH8c2duSTmWawQaPSnpfUu8CvOOS1jmyv+Tm7xwCb1/pefuqAiM2nq6CK9k6MYWXgOoCNq7y+L00y4jf4jzvl/RDymgtsvonHHm9zO48RdLdknZLak6x0yrpkCOb5mUCQ4A6YA7wEvAp8Lvz1u8GRqgKaLWc/cAUR/+t1QmYDOy1z+3ATQGbGxzfJ4BPgOXAQ8B1wGABRz1fj4uFjvFy4NmEfqUngMFWt8aRJ3fhVcBwR98cEc9RRZAgf5dssfI2AnMQs8sR0A8Ddln9NkcXtZsWe8r/WGa1V0l6Xub6wcUzMjX2z468UtJbkmoltUta5ujLoiIADkW8YINn1CowRVYO8zGHamEqOTA7cXJ6PZXgr/LYFOZgXQgHhTn/1QL3206bMaVtEusCTgTMwJSdAE1WlpsGSd6TVnYSqE+xt9HxfRRz3l2MuRWoAQaEOs91OrenOMq1VzB5uq/t42aiiZgKtHcBO784vmf7eKHOY8lHXr0QaC9YfmjRprVJHr8jswQu4EvHwOoIx+WWe6SIoAWsd3xuDXFDWWWozNkzibky58fUtS5phaR5UZmhO4YrvzavkHSR31P+29SRvzhz+LzIkYxp2wM+DwNXu3y38+xA5yTm9UDQCyL8JlNrt8BDB2IfvCu9yDYng9/GXL/kHO/nnUt+rJc0P9MM9mOBpDUZ+OXnPjlvv9d5wzZM7dAYGIEWTO2edZQnYKpQHxZiduE9jnx30oZr8FbMBrAamObolgccAbwD3Fgg2DJgKqZaDGGp06ceWIs5A9+c1PkuPc+T1Bn4qhZLakj5Ktsl7ZL/Cm6SpMtS+jZIWpIyRbodJX13h6GgJXNbm4bRKny/GMLBFJ17/s18zXxMZnPqCRySNDKWnKUeny5/0K2SvshgZ7vM2dPFCEk3RFspsKCSrYV8HAF6WX0V8CBdJW4Sh4EHgMstty+mvHWxMTae2KAHBbLAOA/3o8iAqgM2o368ip0qf0u6UyZj5DBD5hdkFz9Fyr6XdFfi+WtJMyWdjQnIl1V8OCOpxbZmmRumzwJc3/z1ySTpQ0mNMmutKTIWSdmzSgyukRm9JCYqHHxR6InAB8pMof72+ZTM7zsl/RPC/7pNme/opfTBAAAAAElFTkSuQmCC" /><?php echo get_the_title($postID); ?> Signoff</h1> 
    </div>
</div>

<div class="pure-g">
    <div class="pure-u-5-5">
        <p class="txtC">Sign off the request once you're happy to continue.</p>
        <p class="txtC txtXS">This marks the request as complete. Any further changes you wish to make to the request should be mentioned <em>before</em> sign-off, otherwise they will have to be added as a seperate request.</p>    

        <div class="pure-g" style="max-width:500px;">
            <div class="pure-u-5-5 pure-u-md-1-2 txtC">
                <a data-signoff="true" data-menu="single_request" data-designer="<?php echo $desID; ?>" data-requesttype="<?php echo get_post_type($postID); ?>" data-postid="<?php echo $postID; ?>" data-query="single_request" class="cta orange nexus_ajaxFunction" href="#">YES, I'M SURE<br>SIGN OFF</a>
            </div> 
            <div class="pure-u-5-5 pure-u-md-1-2 txtC">
                <a href="mailto:<?php echo $desObj['email']; ?>?subject=Request <?php echo $postID; ?>" class="cta grey">NOPE, STILL<br>NEEDS WORK</a>
            </div> 
        </div>
    </div>
</div>