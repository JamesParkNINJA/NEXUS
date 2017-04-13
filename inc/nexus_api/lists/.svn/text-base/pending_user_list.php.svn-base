<div class="pure-g pendingUsersPage">
    <div class="pure-u-5-5">
        <h1 class="txtC">Pending Users</h1>
         <?php if ($cuTYPE == 'designer') { ?>

            <table class="pendingUsers">
                <thead>
                    <th>Name</th> 
                    <th>Email</th> 
                    <th>&nbsp;</th>
                </thead>
                <tbody>
                    <?php 
                        $pending = new WP_User_Query(
                            array(
                                'meta_query' => array (
                                    'relation' => 'OR',
                                    array (
                                        'key' => 'nexus_account_status',
                                        'value' => 'active',
                                        'compare' => '!='
                                    ),
                                    array (
                                        'key' => 'nexus_account_status',
                                        'compare' => 'NOT EXISTS'
                                    )
                                )
                            )
                        ); 

                        if ( ! empty( $pending->results ) ) { $ui = 0;
                        foreach ( $pending->results as $user ) { $ui = $ui + 1;
                        $userData = nexus_userDetailsArray($user->ID);
                    ?>
                        <tr class="pendingUser">
                            <td><?php echo $userData['fullname']; ?></td>
                            <td><?php echo $userData['email']; ?></td>
                            <td>
                                <form id="pendingUser-<?php echo $user->ID; ?>" name="pendingUser-<?php echo $user->ID; ?>">
                                    <ul class="inline">
                                        <li>
                                            <input type="hidden" name="userID" value="<?php echo $user->ID; ?>" />
                                            <a href="#" class="cta txtC green approveUser hPad-top" data-form="pendingUser-<?php echo $user->ID; ?>" data-id="<?php echo $user->ID; ?>" style="margin-top:0;">Approve</a>
                                        </li>
                                        <li>
                                            <a href="#" class="cta txtC red rejectUser hPad-top" data-form="pendingUser-<?php echo $user->ID; ?>" data-id="<?php echo $user->ID; ?>" style="margin-top:0;">Reject</a>
                                        </li>
                                    </ul>
                                </form>
                            </td>
                        </tr>
                    <?php } } else { ?>
                        <tr class="pendingUser" style="background:#f0f0f0;">
                            <td colspan="4">No pending users</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <h1>Access Denied</h1>
            <h2>You need to be an Administrator to view this page.</h2>
        <?php } ?>
    </div>
</div>