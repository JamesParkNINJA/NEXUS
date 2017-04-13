<?php 
    // Current User Details
    $cuOBJ       = wp_get_current_user();
    $cuID        = $cuOBJ->ID;
    $cuIMG       = nexus_getUserIMG($cuID);
    $cuFNAME     = $cuOBJ->user_firstname;
    $cuLNAME     = $cuOBJ->user_lastname;
    $cuNAME      = $cuFNAME.' '.$cuLNAME;
    $cuFILE      = $cuFNAME.'_'.$cuLNAME;
    $cuTYPE      = (get_user_meta($cuID, 'nexus_is_admin', true) ? 'designer' : 'client');
        $cuTYPE      = (current_user_can('manage_options') ? 'designer' : $cuTYPE);
        $cuTYPE      = ($cuID ? $cuTYPE : 'nope');
    $cuRATE      = nexus_getUserRating($cuID, $cuTYPE);
    $cuACTIVE    = nexus_getActiveRequests($cuID, $cuTYPE);
    $cuCOMPLETE  = nexus_getCompletedRequests($cuID, $cuTYPE);
    $cuACTION    = nexus_needsAction($cuID, 'all');
    $cuSTATUS    = get_user_meta($cuID,'nexus_account_status',true);
?>