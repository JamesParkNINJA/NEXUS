<div class="filterPanel">
    <div class="pure-g" style="height:100%;">
        <div class="pure-u-5-5">
            <a href="#" class="filterToggle">FILTER</a>
            <div class="filterContainer">
            <h4>Filter by:</h4>
            <div class="pure-g" id="searchFields">
                <div class="pure-u-5-5">
                    <input type="text" class="searchInput" data-type="requestee" placeholder="Requestee..." />
                </div>
                <div class="pure-u-5-5">
                    <input type="text" class="searchInput" data-type="designer" placeholder="Designer..." />
                </div>
                <div class="pure-u-5-5">
                    <input type="text" class="searchInput" data-type="reqid" placeholder="Request ID..." />
                </div>
                <div class="seperator"></div>
                <div class="pure-u-5-5">
                    <h4>Filter by importance:</h4>
                    <ul class="checkboxBox">
                        <li><input type="checkbox" name="importance" class="searchInput" data-type="importance" value="low" id="low" /><label for="low">Average</label></li>
                        <li><input type="checkbox" name="importance" class="searchInput" data-type="importance" value="medium" id="medium" /><label for="medium">High</label></li>
                        <li><input type="checkbox" name="importance" class="searchInput" data-type="importance" value="high" id="high" /><label for="high">Urgent</label></li>
                    </ul>
                </div>
                <div class="seperator"></div>
                <div class="pure-u-5-5">
                    <h4>Filter by status:</h4>
                    <ul class="checkboxBox">
                        <li><input type="checkbox" name="status" class="searchInput" data-type="status" value="tbs" id="tbs" /><label for="tbs">To Be Started</label></li>
                        <?php if ($reqType == 'design') { ?>
                            <li><input type="checkbox" name="status" class="searchInput" data-type="status" value="approval" id="approval" /><label for="approval">On Approval</label></li>
                            <li><input type="checkbox" name="status" class="searchInput" data-type="status" value="info" id="info" /><label for="info">Awaiting Info</label></li>
                            <li><input type="checkbox" name="status" class="searchInput" data-type="status" value="proof" id="proof" /><label for="proof">In Proofing</label></li>
                            <li><input type="checkbox" name="status" class="searchInput" data-type="status" value="print" id="print" /><label for="print">With Printers</label></li>
                        <?php } ?>
                        <li><input type="checkbox" name="status" class="searchInput" data-type="status" value="progress" id="progress" /><label for="progress">In Progress</label></li>
                        <li><input type="checkbox" name="status" class="searchInput" data-type="status" value="signoff" id="signoff" /><label for="signoff">Sign-Off</label></li>
                    </ul>
                </div>
                <div class="seperator"></div>
                <div class="pure-u-5-5">
                    <a class="cta reorder-requests" 
                       style="margin:3px auto; text-align:center; width:200px; display:block;" 
                       href="#"
                       data-type="designer"
                       data-order="asc">Order By Designer</a>
                </div>
                <div class="pure-u-5-5">
                    <a class="cta reorder-requests" 
                       style="margin:3px auto; text-align:center; width:200px; display:block;" 
                       href="#"
                       data-type="requestee"
                       data-order="asc">Order By Client</a>
                </div>
                <div class="pure-u-5-5">
                    <a class="cta green reorder-requests" 
                       style="margin:3px auto; text-align:center; width:200px; display:block;" 
                       href="#"
                       data-type="default"
                       data-order="asc">Default Order</a>
                </div> 
            </div>
            </div>
        </div>
    </div>
</div>