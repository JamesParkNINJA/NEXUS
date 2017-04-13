<?php
// NEXUS - Community Edition v0.6
// JamesPark.ninja
// 2017

// CONTENTS -----------------------------------

// 001 SCRIPT QUEUE
// 002 NAVIGATION QUEUE
// 003 HEADER FUNCTIONS
// 004 COMMUNAL FUNCTIONS
// 005 DESIGN SYSTEM FUNCTIONS: 
// --- N01 = New Request
// --- N02 = Mockup Upload
// --- N03 = Designer Assigned
// --- N04 = Stage Completed
// --- N05 = Request Completion
// --- N06 = Request Updated
// --- N07 = Feedback Entry
// --- N08 = Stage Sign-Off
// --- N09 = Feedback Assigned for Carousel
// --- N10 = Designer Skills
// --- N11 = Request Cancelled
 
// 003 HEADER FUNCTIONS ---------------------------

function nexus_plugin_inc($file) {
    $fullinc = get_option('nexus_plugin_dir').'inc/'.$file;
    return $fullinc;
}

// Ajax meta update form
add_action( 'wp_ajax_nopriv_nexus_update_post_meta', 'nexus_update_post_meta' );
add_action( 'wp_ajax_nexus_update_post_meta', 'nexus_update_post_meta' );
function nexus_update_post_meta_ajax() {
    $id = $_POST['postid'];
    $array = $_POST['data'];
    
    $done = nexus_update_post_meta($id, $array);
    
    $return['done'] == 'true';
    echo json_encode($return);
    die();
}
                  
// Meta update form
function nexus_update_post_meta($id, $array) {
    
    if (count($array) === 1) {
        $field = $array[0];
        update_post_meta($id, $field['key'], $field['value']);
    } else if (count($array) > 1) {
        foreach ($array as $field) {
            update_post_meta($id, $field['key'], $field['value']);
        }
    }    
}

function nexus_lumos($hex) {
    list($red, $green, $blue) = sscanf($hex, "#%02x%02x%02x");
    $luma = ($red + $green + $blue)/3;

    if ($luma < 128){
      $textcolour = "light";
    }else{
      $textcolour = "dark";
    }
    return $textcolour;
}

// Global User Info
function nexus_theUserObject() {
    global $current_user; get_currentuserinfo(); return $current_user;
}

// allows you to use nexus_tURL() instead of get_template_directory_uri()
// passing through the file or folder within the function will build the full link, eg:
// echo nexus_tURL('/images/testImage.png);
function nexus_tURL($add) {
    $theURL = get_template_directory_uri();
    if ($add && $add != '') {
        $theURL = $theURL.$add;
    }
    return $theURL;
}

add_action( 'wp_login_failed', 'aa_login_failed' ); // hook failed login

function aa_login_failed( $user ) {
// check what page the login attempt is coming from
$referrer = $_SERVER['HTTP_REFERER'];

// check that were not on the default login page
if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) {
// make sure we don't already have a failed login attempt
if ( !strstr($referrer, '?login=failed' )) {
// Redirect to the login page and append a querystring of login failed
wp_redirect( $referrer . '?login=failed');
} else {
wp_redirect( $referrer );
}

exit;
}
}

// Checks if the user-agent (browser) is Internet Explorer 8 or lower
function nexus_ltIE8() {
    if (preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT'])) {
        $return = true;
    } else {
        $return = false;
    }
    return $return;
}

// Checks the latest modification time of a file
function nexus_fileModTime($url){
    $ch = curl_init($url);

     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
     curl_setopt($ch, CURLOPT_HEADER, TRUE);
     curl_setopt($ch, CURLOPT_NOBODY, TRUE);
     curl_setopt($ch, CURLOPT_FILETIME, TRUE);

     $data = curl_exec($ch);
     $filetime = curl_getinfo($ch, CURLINFO_FILETIME);

     curl_close($ch);
     return $filetime;
}

// Log the chosen variable/text in the javascript console
// eg: echo nexus_logMe($varaibleName);
function nexus_logMe($text) {
    $jsAlert = '<script>//console.log("'.$text.'");</script>';
    return $jsAlert;
}

// Adds the Wordpress AJAX URL and template directory URI to a Javascript Variable in the Head
function nexus_wcAJAX() {
?>
<script type="text/javascript">
var nexus_ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
var nexus_templateURL = '<?php echo get_template_directory_uri(); ?>';
</script>
<?php
}

add_image_size( 'xlmain', 1920 ); // 1920 pixels wide (and unlimited height)

// Adds the current user's id as a javascript variable in the Head
function nexus_cuid() {
?>
<script type="text/javascript">
var nexus_cuid = '<?php echo get_current_user_id(); ?>';
</script>
<?php
}

// 004 COMMUNAL FUNCTIONS (Not Site Specific) ---------------------------

// Get user image
function nexus_getUserIMG($id){
    
    if (get_user_meta($id, 'nexus_user_image', true) && is_user_logged_in()) {
        $img = wp_get_attachment_url(get_user_meta($id, 'nexus_user_image', true));
    } else {
        $img = 'http://0.gravatar.com/avatar/6d814fac2b564550e3f71931714e6746?s=96&amp;d=mm&amp;r=g';
    }
    
    return $img;
}

// Remove last instance of character from string
function nexus_str_lreplace($search, $replace, $subject) {
    $pos = strrpos($subject, $search);

    if($pos !== false) {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }

    return $subject;
}

// Pulls the first image out of a wordpress post, then returns only the SRC.
function nexus_catch_that_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches [1] [0];
    
    // no image found display default image instead
    if(!empty($first_img)){
        return $first_img;
    }    
}

// CHecks if post id exists
add_action( 'wp_ajax_nopriv_nexus_is_post', 'nexus_is_post' );
add_action( 'wp_ajax_nexus_is_post', 'nexus_is_post' );
function nexus_is_post($id) {
    if (!isset($_POST['postid'])) { return is_string( get_post_status( $id ) ); }
        
    $return['exists'] = is_string(get_post_status($_POST['postid']));
    echo json_encode($return);
    die();
}

// Gets the current tracked time of a request
add_action( 'wp_ajax_nopriv_nexus_getTime', 'nexus_getTime' );
add_action( 'wp_ajax_nexus_getTime', 'nexus_getTime' );
function nexus_getTime() {
    $postID = $_POST['postid'];
    
    $time['time'] = get_post_meta($postID,'nexus_tracked_time',true);
    if (!$time['time'] || $time['time'] == '') { $time['time'] = 0; }
    
    echo json_encode($time);
    die();
}

function nexus_calculateCost($time) {
    $tmOptions = get_option( 'nexus_time_tracker_settings' );
    $hr = $tmOptions['nexus_time_tracking_pricing'];
    $hr = (float)$hr;
    
    $ratePerSecond = $hr / 3600;
    
    $cost = $ratePerSecond * $time;
    $cost = number_format((float)$cost, 2, '.', '');
    
    return $cost;
}

// Updates the specified request's tracked time
add_action( 'wp_ajax_nopriv_nexus_updateTime', 'nexus_updateTime' );
add_action( 'wp_ajax_nexus_updateTime', 'nexus_updateTime' );
function nexus_updateTime() {
    $postID = $_POST['postid'];
    $time = $_POST['time'];
    
    $cost = nexus_calculateCost($time);
    
    update_post_meta($postID,'nexus_tracked_time',$time);
    update_post_meta($postID,'nexus_project_cost',$cost);
    
    $return['time'] = $time;
    echo json_encode($return);
    die();
}

// Loops post types
function nexus_output_post_types($as) {
    $options = get_option('nexus_request_settings'); $list = $options['nexus_request_types'];
    if ($list) { 
        if ($as == 'array') {
            $typeArray = explode(',',$list); $ri = 0;
            foreach ($typeArray as $type) { $ri = $ri + 1;
                $types[$ri]['title'] = $type;
                $types[$ri]['slug'] = 'nexus_'.sanitize_title($type);
            }
        }
        
        if ($as == 'array_single') {
            $typeArray = explode(',',$list); $ri = 0;
            foreach ($typeArray as $type) { $ri = $ri + 1;
                $types[] = 'nexus_'.sanitize_title($type);
            }
        }
        
        if ($as == 'title_list') {
            $types = $list;
        }
        
        if ($as == 'slug_list') {
            $typeArray = explode(',',$list); $ri = 0;
            foreach ($typeArray as $type) { $ri = $ri + 1;
                if ($ri > 1) { $types .= ','; }
                $types .= 'nexus_'.sanitize_title($type);
            }
        }
        
        if ($as == 'loop_list') {
            $typeArray = explode(',',$list); 
            $types = "("; $ri = 0;
            foreach ($typeArray as $type) { $ri = $ri + 1;
                $type = 'nexus_'.sanitize_title($type);
                if ($ri > 1) { $types .= ','; }
                $types .= "'".$type."'";
            }
            $types = ")";
        }
    }
    
    return $types;
}

// Adds CPTs to Author Page
add_filter('posts_where', 'nexus_include_for_author');
function nexus_include_for_author($where){
    if(is_author()) {
        $where = str_replace(".post_type = 'post'", ".post_type in ".nexus_output_post_types('loop_list'), $where);
    }
    return $where;
}

add_filter('pre_option_default_role', function($default_role){
    // You can also add conditional tags here and return whatever
    return 'author'; // This is changed
    //return $default_role; // This allows default
});

// Autosizes an image depending on width and height constraints
// Has optional fields for adding a link around the image, and giving it a class
function nexus_autosizeMe($width, $height, $img, $link, $class) {
    list($originalWidth, $originalHeight) = getimagesize($img);
    $ratio = $originalWidth / $originalHeight;

    if ($originalWidth > $width && $originalWidth != $originalHeight) {
        if ($originalHeight > $height) {
            $style = 'height="'.$height.'px" width="'.$width.'px" ';   
        } else {
            $style = 'width="'.$width.'px" ';   
        }
    } else if ($originalHeight > $height && $originalWidth != $originalHeight) {
        if ($originalWidth > $width) {
            $style = 'height="'.$height.'px" width="'.$width.'px" ';   
        } else {
            $style = 'height="'.$height.'px" ';   
        }
    } else if ($originalWidth == $originalHeight) {
        $style = 'height="'.$height.'px" ';
    } else if ($originalHeight == $height && $originalWidth == $width) {
        $style = 'name="correct" ';   
    }
    
    // Class is optional
    
    if ($class) {
        $classText = 'class="'.$class.'"';   
    }
    
    $newIMG = '<img '.$classText.' src="'.$img.'" '.$style.' />';
    
    // Link is optional
    
    if ($link) {
        $newIMG = '<a style="width:'.$width.'px; height:'.$height.'px; display:block;" href="'.$link.'"><img '.$classText.' src="'.$img.'" '.$style.' /></a>';
    }
    
    return $newIMG;
}

// Simple text word limiter, removes tags automatically
function nexus_limit_text($text, $limit) {
    $text = strip_tags($text);
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
        }
    return $text;
}

// Checks if a file exists via URL
function nexus_remoteFileExists($url) {
    $curl = curl_init($url);

    //don't fetch the actual page, you only want to check the connection is ok
    curl_setopt($curl, CURLOPT_NOBODY, true);

    //do request
    $result = curl_exec($curl);

    $ret = false;

    //if request did not fail
    if ($result !== false) {
        //if request was ok, check response code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  

        if ($statusCode == 200) {
            $ret = true;   
        }
    }

    curl_close($curl);

    return $ret;
}

// Get page ID from Slug
function nexus_slugID($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}

// Auto embed a google map iframe based on passed value being used as address/place.
function nexus_gMap($add) {
    
    // PASS Specific, stops the function from working if venue is "To be confirmed, or includes "etc"
    if (strpos(strtolower($add), 'confirmed') !== false XOR strpos(strtolower($add), 'etc') !== false) {
        return '';
    } else {
        
        $addFixed = str_replace(' ','+',$add); // Replaces spaces with '+' as this is the string type gMaps uses.
        
        $map = '<iframe width="600" height="450" frameborder="0" style="border:0"
src="https://www.google.com/maps/embed/v1/place?q='.$addFixed.'&key=AIzaSyDsTb1FlyemsQG_C6zEuP1Mcc1_ylORuXU"></iframe>';
        
        return $map;
    }
}

function nexus_trim_text($text, $limit) {
    $text = preg_replace("/<img[^>]+>/i","",$text);
    $text = preg_replace("/<a[^>]+>/i","",$text);
    $text = preg_replace("/<\/a>/i","",$text);
    $text = preg_replace("/<div[^>]+>/i","",$text);
    $text = preg_replace("/<\/div>/i","",$text);
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    } else {
        $text .= "...";
    }
    return $text;
}

// Pull the gravatar icon for the given email address
function nexus_get_gravitar( $email, $s, $d = '404', $r = 'g', $img = false, $atts = array() ) {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    $headers = get_headers($url,1);
    if (strpos($headers[0],'200')) {
    if ( $img ) {
        $url = '<img class="avatar" src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
        return $url;
    } else if (strpos($headers[0],'404')) {
        return 'noImage';
    }
}

// Count words
function nexus_get_num_of_words($string) {
    $string = preg_replace('/\s+/', ' ', trim($string));
    $words = explode(" ", $string);
    return count($words);
}

// Annoyingly complex image/file upload function
function nexus_update_attachment($f,$pid,$t='',$c='') {
    wp_update_attachment_metadata( $pid, $f );
    if( !empty( $_FILES[$f]['name'] )) { //New upload
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        // $override['action'] = 'editpost';
        $override['test_form'] = false;
        $file = wp_handle_upload( $_FILES[$f], $override );

        if ( isset( $file['error'] )) {
          return new WP_Error( 'upload_error', $file['error'] );
        }
 
        $file_type = wp_check_filetype($_FILES[$f]['name'], array(
          'jpg|jpeg' => 'image/jpeg',
          'gif' => 'image/gif',
          'png' => 'image/png',
        ));
        
        if ($file_type['type']) {
            $name_parts = pathinfo( $file['file'] );
            $name = $file['filename'];
            $type = $file['type'];
            $title = $t ? $t : $name;
            $content = $c;

            $attachment = array(
                'post_title' => $title,
                'post_type' => 'attachment',
                'post_content' => $content,
                'post_parent' => $pid,
                'post_mime_type' => $type,
                'guid' => $file['url'],
            );

            foreach( get_intermediate_image_sizes() as $s ) {
                $sizes[$s] = array( 'width' => '', 'height' => '', 'crop' => true );
                $sizes[$s]['width'] = get_option( "{$s}_size_w" ); // For default sizes set in options
                $sizes[$s]['height'] = get_option( "{$s}_size_h" ); // For default sizes set in options
                $sizes[$s]['crop'] = get_option( "{$s}_crop" ); // For default sizes set in options
            }

            $sizes = apply_filters( 'intermediate_image_sizes_advanced', $sizes );

            foreach( $sizes as $size => $size_data ) {
                $resized = image_make_intermediate_size( $file['file'], $size_data['width'], $size_data['height'], $size_data['crop'] );
                if ( $resized ) { $metadata['sizes'][$size] = $resized; }
            }

            $attach_id = wp_insert_attachment( $attachment, $file['file'] /*, $pid - for post_thumbnails*/);

            if ( !is_wp_error( $attach_id )) {
                $attach_meta = wp_generate_attachment_metadata( $attach_id, $file['file'] );
                wp_update_attachment_metadata( $attach_id, $attach_meta );
            }
   
            return array(
            'pid' =>$pid,
            'url' =>$file['url'],
            'file'=>$file,
            'attach_id'=>$attach_id
            );
        }
    }
}

// Annoyingly complex image/file upload function FOR AJAX
add_action( 'wp_ajax_nopriv_nexus_update_attachment_ajax', 'nexus_update_attachment_ajax' );
add_action( 'wp_ajax_nexus_update_attachment_ajax', 'nexus_update_attachment_ajax' );
function nexus_update_attachment_ajax() {
    $postID = $_POST['postid'];
    $mockupUpload = ($_POST['mockups'] == 'true' ? 'true' : 'false');
    
    $fileArray = '';
    $actualArray = array();    
        
    if ($postID) {
        if (get_post_meta($postID, 'nexus_admin_files', true)) {
            $mockupArray = get_post_meta($postID, 'nexus_admin_files', true);
        } else {
            $mockupArray = array();
        }
    }
    
    $files = $_FILES['uploader']; $i = 0;
    foreach ($files['name'] as $key => $value) {
        if ($files['name'][$key]) {
            
            $file = array(
                'name'     => $requestID.'_'.$files['name'][$key],
                'type'     => $files['type'][$key],
                'tmp_name' => $files['tmp_name'][$key],
                'error'    => $files['error'][$key],
                'size'     => $files['size'][$key]
            );
            
            $fileUpload = wp_handle_upload($file, array('test_form' => FALSE));

            if ($fileUpload) {
                $i = $i + 1;
                $uploadDir = wp_upload_dir();
                $att = array (
                    'guid' => $uploadDir['url'].'/'.basename($fileUpload['file']),
                    'post_mime_type' => $fileUpload['type'],
                    'post_title' => preg_replace('/\.[^.]+$/','',basename($fileUpload['file'])),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                
                $attID = wp_insert_attachment($att, $fileUpload['file']);
                $attach_data = wp_generate_attachment_metadata( $attID, $fileUpload['file'] );
                wp_update_attachment_metadata( $attID, $attach_data );
                
                if ($fileArray != '') { $fileArray .= '*'; }
                $fileArray .= wp_get_attachment_url($attID).'^'.$attID;
                
                $actualArray[$i]['name'] = basename(wp_get_attachment_url($attID));
                
                if ($postID) {
                    $mockupArray[] = array('filename'=>$actualArray[$i]['name'],'att_id'=>$attID);
                }
                
                $actualArray[$i]['url'] = wp_get_attachment_url($attID);
                $actualArray[$i]['id'] = $attID;
            }
        }
    }                
    
    if ($mockupUpload == 'true') {
        update_post_meta($postID, 'nexus_admin_files', $mockupArray); // Update Files Repeater Field
        nexus_updateLog($postID, 'File(s) uploaded by admin', get_post_meta($postID, 'nexus_assigned_user', true));
    }
    
    $return['postid'] = $postID;
    $return['filelist'] = $fileArray;
    $return['mockups'] = $mockupUpload;
    $return['filearray'] = $actualArray;
    
    echo json_encode($return);
    die();
}

// Annoyingly complex image/file upload function FOR AJAX
add_action( 'wp_ajax_nopriv_nexus_removeFile', 'nexus_removeFile' );
add_action( 'wp_ajax_nexus_removeFile', 'nexus_removeFile' );
function nexus_removeFile() {
    $id = $_POST['attachID'];
    $postID = $_POST['postid'];
    $type = $_POST['type'];
    
    if ($type == 'mockups') {
        if (get_post_meta($postID, 'nexus_admin_files', true)) { 
            $adminFilesArray = get_post_meta($postID, 'nexus_admin_files', true);
            foreach ($adminFilesArray as $adminFile) {
                $filename = $adminFile['filename']; $attID = $adminFile['att_id'];
                $testArray[] = 'This ID: '.$id.' - List ID: '.$attID['id'];
                if ($id != $attID['id']) {
                    $mockupArray[] = array('filename'=>$filename,'att_id'=>$attID);
                } else {
                    $removed = 'Removed ID: '.$attID['id'];
                }
            }
        }
        
        update_post_meta($postID, 'nexus_admin_files', $mockupArray); // Update Files Repeater Field
        nexus_updateLog($postID, 'Files removed by admin', get_post_meta($postID, 'nexus_assigned_user', true));
    }
    
    wp_delete_attachment($id, true);
    
    $return['testArr'] = $testArray;
    $return['removed'] = $removed;
    $return['id'] = $id;
    
    echo json_encode($return);
    die();
}

// ************************* HERE BE WORKINS *********************** 

// Get's the Wordpress attachment ID of a file/image by its URL
function nexus_attachmentID( $attachment_url = '' ) {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id;
}

// For users to upload their own image
add_action( 'wp_ajax_nopriv_nexus_userImageUpload', 'nexus_userImageUpload' );
add_action( 'wp_ajax_nexus_userImageUpload', 'nexus_userImageUpload' );
function nexus_userImageUpload() {
    // Set variables
    $uID = $_POST['currentUserID'];
    $img = $_FILES['imageUpload'];
    
    $oldIMG = get_user_meta($uID, 'nexus_user_image', true);
    if ($oldIMG) {
        $oldID = nexus_attachmentID($oldIMG);
        wp_delete_attachment($oldID,true);
    }

    $att = nexus_update_attachment('imageUpload',$post->ID);

    // Update the field
    update_user_meta($uID, 'nexus_user_image', $att['attach_id']);

    $return['img'] = wp_get_attachment_url($att['attach_id']);
    $return['type'] = $type;
    $return['userID'] = $uID;
    echo json_encode($return);
    die();
}

// Extra mime-types for uploading
add_filter('upload_mimes', 'nexus_upload_mimes');
function nexus_upload_mimes ( $existing_mimes=array() ) {
    $existing_mimes['js'] = 'application/javascript';
    $existing_mimes['css'] = 'text/css';
    $existing_mimes['csv'] = 'text/csv';
    $existing_mimes['ppt'] = 'application/vnd.ms-powerpoint';
return $existing_mimes;
}


// Filter by multiple roles
function nexus_filter_two_roles($user, $roles) {
    if (!$roles) {
        $roles = array('subscriber','author');
    }
    return in_array($user->roles[0], $roles);
}

// Get all roles
function nexus_nae_rolls(){
    $clients = get_users('fields=all_with_meta');
    // Sort by last name
    usort($clients, create_function('$a, $b', 'if($a->last_name == $b->last_name) { return 0;} return ($a->last_name > $b->last_name) ? 1 : -1;'));
}

// 005 DESIGN SYSTEM FUNCTIONS ---------------------------

// N01 ---------------------------
// AJAX fired when request is submit
add_action( 'wp_ajax_nopriv_nexus_submitWebRequest', 'nexus_submitWebRequest' );
add_action( 'wp_ajax_nexus_submitWebRequest', 'nexus_submitWebRequest' );
function nexus_submitWebRequest() {
    //Add in upload files - REQUIRE FOR FILE UPLOAD
    include_once ABSPATH . 'wp-admin/includes/media.php';
    include_once ABSPATH . 'wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/image.php';
    
    
    // Set variables
    $requestType = $_POST['requestType'];
    $importance = $_POST['importance'];
    $requestObject = get_post_type_object($requestType);
    $requestLabel = $requestObject->labels->name;
    
    $userID = $_POST['userID'];
    $userData = get_userdata($userID);
    
    $requesteeName = $userData->first_name.' '.$userData->last_name;
    
    $requestTitle = $_POST['requestTitle'];
    $requestContent = $_POST['requestContent'];
    $requestBudget = ($_POST['requestBudget'] ? $_POST['requestBudget'] : '0.00');
    
    $completionDate = $_POST['completionDate'];
    $completionDate = strtotime($completionDate); 
    
    $mainSettings = get_option('nexus_main_settings');
    $designEmail = $mainSettings['nexus_email_address'];
        
    // Set up new post
    $request = array(
      'post_title'    => wp_strip_all_tags($requestTitle),
      'post_content'  => $requestContent,
      'post_status'   => 'publish',
      'post_author'   => $userID,
      'post_type' => $requestType
    );
    
    // Insert the post into the database
    $postID = wp_insert_post( $request );
    $requestID = strtoupper(substr($requestType, 0, 3)).''.$postID;
    
    // Add variables depending on post type
    update_post_meta($postID, 'nexus_deadline_date', $completionDate); // Deadline
    update_post_meta($postID, 'nexus_client_name', $requesteeName); // Client Name
    update_post_meta($postID, 'nexus_request_importance', $importance); // Importance
    update_post_meta($postID, 'nexus_client_budget', $requestBudget); // Client Budget
      
    if (strpos($_POST['filelist'], ',') !== false) {
        $fileList = explode(',', $_POST['filelist']);
        foreach ($fileList as $fileString) {
            $fileID = $fileString; $fileURL = wp_get_attachment_url($fileID);
            $fileArray[] = array('url'=>$fileURL,'id'=>$fileID);
        }
    } else {
        $fileID = $_POST['filelist']; $fileURL = wp_get_attachment_url($fileID);
        $fileArray[] = array('url'=>$fileURL,'id'=>$fileID);
    }
    
    update_post_meta($postID, 'nexus_client_files', $fileArray); // Update Files Repeater Field
    
    $vars['requestTitle'] = $requestTitle;
    $vars['requestContent'] = $requestContent;
    $vars['requestType'] = ucfirst($requestType);
    nexus_requestMailer('newrequest', $postID, 3, $vars);
    
    nexus_updateLog($postID, 'Request added', $userID);
    
    $return['post'] = ($postID ? "Added" : "Didn't Add");
    $return['files'] = $_POST['filelist'];
    $return['type'] = $requestType;
    $return['title'] = $requestTitle;
    echo json_encode($return);
    die();
}

// Show only posts and media related to logged in author (client) unless user is Admin
add_action('ajax_query_attachments_args', 'nexus_query_set_only_author' );
function nexus_query_set_only_author( $query ) {
    include(nexus_plugin_inc('nexus_api/data/current_user.php'));
    if ($cuTYPE != 'designer') {
        $user_id = get_current_user_id();
        if ( $user_id ) {
            $query['author'] = $user_id;
        }
    }
    return $query;
}

// N01-X ---------------------------
// AJAX fired when request is edited
add_action( 'wp_ajax_nopriv_nexus_editRequest', 'nexus_editRequest' );
add_action( 'wp_ajax_nexus_editRequest', 'nexus_editRequest' );
function nexus_editRequest() {
    //Add in upload files - REQUIRE FOR FILE UPLOAD
    include_once ABSPATH . 'wp-admin/includes/media.php';
    include_once ABSPATH . 'wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/image.php';
    
    
    // Set variables
    $postID = $_POST['postid'];
    $requestType = $_POST['requestType'];
    $requestObject = get_post_type_object($requestType);
    $requestLabel = $requestObject->labels->name;
    
    $userID = $_POST['userID'];
    $cuID = $_POST['currentUser'];
    $userData = get_userdata($userID);
    
    $requesteeName = $userData->first_name.' '.$userData->last_name;
    
    $requestTitle = $_POST['requestTitle'];
    $requestContent = $_POST['requestContent'];
    $completionDate = $_POST['completionDate'];
    $completionDate = strtotime($completionDate); 
    
    $mainSettings = get_option('nexus_main_settings');
    $designEmail = $mainSettings['nexus_email_address'];
    
    $arg = array(
        'ID' => $postID,
        'post_author' => $userID,
        'post_title'    => wp_strip_all_tags($requestTitle),
        'post_content'  => $requestContent,
    );
    wp_update_post( $arg );
    
    // Add variables depending on post type
    update_post_meta($postID, 'nexus_deadline_date', $completionDate); // Deadline
    
    $originalFileList = get_post_meta($postID, 'nexus_client_files', true);
    if (count($originalFileList) > 0) { $fileList = $originalFileList; }
        
    if (strpos($_POST['filelist'], ',') !== false) {
        $fileList = explode(',', $_POST['filelist']);
        foreach ($fileList as $fileString) {
            $fileID = $fileString; $fileURL = wp_get_attachment_url($fileID);
            $fileArray[] = array('url'=>$fileURL,'id'=>$fileID);
        }
    } else {
        $fileID = $_POST['filelist']; $fileURL = wp_get_attachment_url($fileID);
        $fileArray[] = array('url'=>$fileURL,'id'=>$fileID);
    }
    
    update_post_meta($postID, 'nexus_client_files', $fileArray); // Update Files Repeater Field
    
    $vars['requestTitle'] = $requestTitle;
    $vars['requestContent'] = $requestContent;
    $vars['requestType'] = ucfirst($requestType);
    
    nexus_updateLog($postID, 'Request edited', $cuID);
    
    $return['files'] = $_POST['filelist'];
    $return['type'] = $requestType;
    $return['title'] = $requestTitle;
    $return['array'] = array('query'=>'single_request','tab'=>'single_request','menu'=>'single_request','postid'=>$postID,'requesttype'=>$requestType);
    echo json_encode($return);
    die();
}

add_action( 'wp_ajax_nopriv_nexus_getTitleByID', 'nexus_getTitleByID' );
add_action( 'wp_ajax_nexus_getTitleByID', 'nexus_getTitleByID' );
function nexus_getTitleByID() {
    $id = $_POST['postid'];
    $return['title'] = ($id != 'nope' ? get_the_title($id) : $id);
    echo json_encode($return);
    die();
}

add_action( 'wp_ajax_nopriv_nexus_menuQuerySelector', 'nexus_menuQuerySelector' );
add_action( 'wp_ajax_nexus_menuQuerySelector', 'nexus_menuQuerySelector' );
function nexus_menuQuerySelector() {    
    $query = $_POST['menu'];
    $postID = $_POST['postid'];
    $requestType = $_POST['requesttype'];
    $userQuery = $_POST['user'];
    $searchQuery = $_POST['searchquery'];
    $tab = $_POST['tab'];
    $backTo = $_POST['backto'];

    switch ($query) {
        // Menu
        case 'dashboard': include(nexus_plugin_inc('nexus_api/menus/dashboard_menu.php')); break;
        case 'single_request': include(nexus_plugin_inc('nexus_api/menus/single_request_menu.php')); break;
        case 'statistics': include(nexus_plugin_inc('nexus_api/menus/statistics_menu.php')); break;
        case 'reassign': include(nexus_plugin_inc('nexus_api/menus/reassign_menu.php')); break;
        case 'signup': include(nexus_plugin_inc('nexus_api/menus/signup.php')); break;
        case 'profile_menu': include(nexus_plugin_inc('nexus_api/menus/profile_menu.php')); break;
        case 'member_profile': include(nexus_plugin_inc('nexus_api/menus/profile_menu.php')); break;
            
        // Default ("You really shouldn't be here...")
        default: include(nexus_plugin_inc('/nexus_api/menus/dashboard_menu.php'));
    }  
    die();
}

add_action( 'wp_ajax_nopriv_nexus_imgToBase64', 'nexus_imgToBase64' );
add_action( 'wp_ajax_nexus_imgToBase64', 'nexus_imgToBase64' );
function nexus_imgToBase64() {
    //Add in upload files - REQUIRE FOR FILE UPLOAD
    include_once ABSPATH . 'wp-admin/includes/media.php';
    include_once ABSPATH . 'wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/image.php';
    
    $files = $_FILES['imageUploadFile'];  
    $file = array(
        'name'     => $files['name'],
        'type'     => $files['type'],
        'tmp_name' => $files['tmp_name'],
        'error'    => $files['error'],
        'size'     => $files['size']
    );
    
    $fileUpload = wp_handle_upload($file, array('test_form' => FALSE));
    
    if ($fileUpload) {
        $uploadDir = wp_upload_dir();
        $att = array (
            'guid' => $uploadDir['url'].'/'.basename($fileUpload['file']),
            'post_mime_type' => $fileUpload['type'],
            'post_title' => preg_replace('/\.[^.]+$/','',basename($fileUpload['file'])),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $filename = preg_replace('/\.[^.]+$/','',basename($fileUpload['file']));
        $attID = wp_insert_attachment($att, $fileUpload['file']);
        $attach_data = wp_generate_attachment_metadata( $attID, $fileUpload['file'] );
        wp_update_attachment_metadata( $attID, $attach_data );

        $id = $attID['id']; $url = $fileUpload['file'];
       
        $img = file_get_contents($url);
        
        $base64 = 'data:image/png;base64, '.base64_encode($img);
        $deleted = wp_delete_attachment($id, true);
    } else {
        $base64 = 'Error: Upload Failed';
    }
    
    $return['base64'] = $base64;
    echo json_encode($return);
    die();
}

function nexus_imageUpload($fileInput) {
    //Add in upload files - REQUIRE FOR FILE UPLOAD
    include_once ABSPATH . 'wp-admin/includes/media.php';
    include_once ABSPATH . 'wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/image.php';
    
    $files = $fileInput;  
    $file = array(
        'name'     => $files['name'],
        'type'     => $files['type'],
        'tmp_name' => $files['tmp_name'],
        'error'    => $files['error'],
        'size'     => $files['size']
    );
    
    $fileUpload = wp_handle_upload($file, array('test_form' => FALSE));
    
    if ($fileUpload) {
        $uploadDir = wp_upload_dir();
        $att = array (
            'guid' => $uploadDir['url'].'/'.basename($fileUpload['file']),
            'post_mime_type' => $fileUpload['type'],
            'post_title' => preg_replace('/\.[^.]+$/','',basename($fileUpload['file'])),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $filename = preg_replace('/\.[^.]+$/','',basename($fileUpload['file']));
        $attID = wp_insert_attachment($att, $fileUpload['file']);
        $attach_data = wp_generate_attachment_metadata( $attID, $fileUpload['file'] );
        wp_update_attachment_metadata( $attID, $attach_data );

        $id = $attID['id']; $imgURL = $fileUpload['file'];
       
    } else {
        $imgURL = 'http://0.gravatar.com/avatar/6d814fac2b564550e3f71931714e6746?s=96&amp;d=mm&amp;r=g';
    }
    
    return $imgURL;
}

add_action( 'wp_ajax_nopriv_nexus_userSignup', 'nexus_userSignup' );
add_action( 'wp_ajax_nexus_userSignup', 'nexus_userSignup' );
function nexus_userSignup() {    
    
    $firstName = $_POST['firstName']; 
    $lastName = $_POST['lastName']; 
    $emailAddress = $_POST['emailAddress'];
    
    if (!username_exists($emailAddress)) {
        $userID = wp_insert_user(
            array(
                'user_login' => $emailAddress,
                'user_email' => $emailAddress,
                'user_pass' => uniqid('pass'),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'display_name' => $firstName.' '.$lastName,
                'role' => 'author'
            )
        );
        
        $userImage = $_FILES['userImage'];
        $url = nexus_imageUpload($userImage);
        //update_user_meta($userID, 'nexus_user_image', $url);

        $contactNo = $_POST['contactNo']; 
        update_user_meta($userID, 'nexus_contact_number', $businessName);

        $type = $_POST['signupType'];
        if ($type == 'member') { 
            $businessName = $_POST['businessName'];
            update_user_meta($userID, 'nexus_company_name', $businessName);
            update_user_meta($userID, 'nexus_is_admin', true);
        }
        
        $return['return'] = 'user_added';
        $return['id'] = $userID;
        $return['url'] = $url;
        $return['img'] = $userImage;
    } else {
        $return['return'] = 'email_exists';
    }
    
    echo json_encode($return);
    die();
}

add_action( 'wp_ajax_nopriv_nexus_querySelector', 'nexus_querySelector' );
add_action( 'wp_ajax_nexus_querySelector', 'nexus_querySelector' );
function nexus_querySelector() {    
    include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details 
    
    $query = $_POST['query'];
    $postID = $_POST['postid'];
    $requestType = $_POST['requesttype'];
    $userQuery = $_POST['user'];
    $searchQuery = $_POST['searchquery'];
    $designerID = $_POST['designer'];
    $newDesigner = $_POST['newdesigner'];
    $override = $_POST['override'];
    $stage = $_POST['stage'];
    $signoff = $_POST['signoff'];
    $update = $_POST['update'];
    $updateStatus = $_POST['updatestatus'];
    $backTo = $_POST['backto'];

    if ($query == 'statistics') {
        $startYear = (isset($_POST['startdate']) ? date('Y-m-d', strtotime($_POST['startdate'])) : '2016-01-01');
        $endYear = (isset($_POST['enddate']) ? date('Y-m-d', strtotime($_POST['enddate'])) : '2099-12-31');
        $sY = (isset($_POST['startdate']) ? $_POST['startdate'] : '01-01-2016');
        $eY = (isset($_POST['startdate']) ? $_POST['startdate'] : '31-12-2099');
    }

    if ($newDesigner) {
        nexus_takeJob($postID, $newDesigner, $stage);
    } else {
        if ($stage) { update_post_meta($postID,'nexus_request_stage',$stage); }
        if ($signoff == 'true') {
            $signoffArray['timestamp'] = strtotime(date('Y-m-d'));
            $signoffArray['user'] = get_current_user_id();
            update_post_meta($postID,'nexus_request_stage',3);
            update_post_meta($postID,'nexus_signoff_dates',$signoffArray);
            update_post_meta($postID,'nexus_signoff_toggle',0);
            set_post_type($postID,'nexus_complete'); // Changes post type to complete
            update_post_meta($postID,'nexus_prior_type',$requestType); // Adds the old post type as a variable
        }
    }
    
    if ($query == 'pick_handler') {
        nexus_takeJob($postID, $userQuery, 1);
        $query = 'single_request';
    }
    
    $main_options = get_option( 'nexus_main_settings' );
    $needsActivation = ($main_options['client_needs_activation'] ? true : false);

    if ($needsActivation && $cuSTATUS != 'active') { $query = 'access_denied'; }

    switch ($query) {
        // Forms
        case 'request': include(nexus_plugin_inc('nexus_api/forms/request_form.php')); break;
        case 'reassign_request': include(nexus_plugin_inc('nexus_api/forms/reassign_request.php')); break;
        case 'reassign_request_type': include(nexus_plugin_inc('nexus_api/forms/reassign_request_type.php')); break;
        case 'rejection': include(nexus_plugin_inc('nexus_api/forms/rejection.php')); break;
        case 'edit_request': include(nexus_plugin_inc('nexus_api/forms/edit_request.php')); break;
        case 'completion': include(nexus_plugin_inc('nexus_api/forms/completion.php')); break;
        case 'request_signoff': include(nexus_plugin_inc('nexus_api/forms/request_signoff.php')); break;
        case 'apply': include(nexus_plugin_inc('nexus_api/forms/apply.php')); break;
        case 'signup': include(nexus_plugin_inc('nexus_api/forms/signup.php')); break;
        case 'signup_client': include(nexus_plugin_inc('nexus_api/forms/signup-client.php')); break;
        case 'signup_member': include(nexus_plugin_inc('nexus_api/forms/signup-member.php')); break;
            
        // Lists
        case 'request_list': include(nexus_plugin_inc('nexus_api/lists/request.php')); break;
        case 'pending_users': include(nexus_plugin_inc('nexus_api/lists/pending_user_list.php')); break;
        case 'application_list': include(nexus_plugin_inc('nexus_api/lists/application_list.php')); break;
        case 'member_list': include(nexus_plugin_inc('nexus_api/lists/member_list.php')); break;
            
        // Views
        case 'single_request': include(nexus_plugin_inc('nexus_api/views/single_request.php')); break;
        case 'designer_capacity': include(nexus_plugin_inc('nexus_api/views/designer_capacity.php')); break;
        case 'request_log': include(nexus_plugin_inc('nexus_api/views/request_log.php')); break;
        case 'feedback': include(nexus_plugin_inc('nexus_api/forms/feedback.php')); break;
        case 'member_profile': include(nexus_plugin_inc('nexus_api/views/profile.php')); break;
            
        // Main
        case 'menu': include(nexus_plugin_inc('nexus_api/main/dashboard.php')); break;
        case 'dashboard': include(nexus_plugin_inc('nexus_api/main/dashboard.php')); break;
        case 'statistics': include(nexus_plugin_inc('nexus_api/main/statistics.php'));
            
        // Errors
        case 'access_denied': include(nexus_plugin_inc('nexus_api/access_denied.php')); break;
        default: include(nexus_plugin_inc('nexus_api/error.php'));
    }
    die();
}

function nexus_publicProtect($id) {
    include(nexus_plugin_inc('nexus_api/data/current_user.php')); // Current User Details 
    
    $authID = get_post_field( 'post_author', $id );
    $desID = trim(get_post_meta($id, 'nexus_assigned_user', true));
    $return = false;
    
    if (is_user_logged_in() && ($cuID == $authID || $cuID == $desID)) {
        $return = true;
    }
    
    return $return;
}

// N02 ---------------------------
// AJAX fired when admin uploads a file
add_action( 'wp_ajax_nopriv_nexus_adminFileUpload', 'nexus_adminFileUpload' );
add_action( 'wp_ajax_nexus_adminFileUpload', 'nexus_adminFileUpload' );
function nexus_adminFileUpload() {
    //Add in upload files - REQUIRE FOR FILE UPLOAD
    include_once ABSPATH . 'wp-admin/includes/media.php';
    include_once ABSPATH . 'wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/image.php';
    
    // Set variables
    $postID = $_POST['thePost'];
    $requestType = get_post_type($postID);
    $requestID = strtoupper(substr($requestType, 0, 3)).''.$postID;
        
    if (get_post_meta($postID, 'nexus_admin_files', true)) {
        $fileArray = get_post_meta($postID, 'nexus_admin_files', true);
    } else {
        $fileArray = array();
    }
    
    $files = $_FILES['mockupUpload'];
    foreach ($files['name'] as $key => $value) {
        if ($files['name'][$key]) {
            
            $file = array(
                'name'     => $requestID.'_'.$files['name'][$key],
                'type'     => $files['type'][$key],
                'tmp_name' => $files['tmp_name'][$key],
                'error'    => $files['error'][$key],
                'size'     => $files['size'][$key]
            );
            
            $fileUpload = wp_handle_upload($file, array('test_form' => FALSE));

            if ($fileUpload) {
                $uploadDir = wp_upload_dir();
                $att = array (
                    'guid' => $uploadDir['url'].'/'.basename($fileUpload['file']),
                    'post_mime_type' => $fileUpload['type'],
                    'post_title' => preg_replace('/\.[^.]+$/','',basename($fileUpload['file'])),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                
                $filename = preg_replace('/\.[^.]+$/','',basename($fileUpload['file']));
                $attID = wp_insert_attachment($att, $fileUpload['file']);
                $attach_data = wp_generate_attachment_metadata( $attID, $fileUpload['file'] );
                wp_update_attachment_metadata( $attID, $attach_data );
                
                $fileArray[] = $attID['id'];
            }
        }
    }
    
    update_post_meta($postID, 'nexus_admin_files', $fileArray); // Update Files Repeater Field
    nexus_updateLog($postID, 'Files uploaded by admin', get_post_meta($postID, 'nexus_assigned_user', true));
}

// N03 ---------------------------
// AJAX fired when designer is assigned
add_action( 'wp_ajax_nopriv_nexus_assignUser', 'nexus_assignUser' );
add_action( 'wp_ajax_nexus_assignUser', 'nexus_assignUser' );
function nexus_assignUser() {
    $request = $_POST['thePost'];
    $designer = $_POST['theID'];
    $type = $_POST['theType'];
    $redirect = $_POST['redirect'];
    $status = $_POST['status'];
    
    $stage = (get_post_meta($request, 'nexus_request_stage', true) ? get_post_meta($request, 'nexus_request_stage', true) : 1);
    $stage = ($status ? $status : $stage);
    if (!empty($_POST['reassign'])) { $reassign = 'yes'; } else { $reassign = 'no'; }
    if (!empty($_POST['olddesign'])) { $oldDesign = $_POST['olddesign']; } else { $oldDesign = 'no'; }
    $userID = get_post_field ('post_author', $request);
    
    $reqID = strtoupper(substr($type, 0, 3)).''.$request;
    $designerID = get_userdata($designer);
    $designerName = $designerID->user_firstname.' '.$designerID->user_lastname;
    $originalRequest = strip_tags(get_the_content($request));
    $url = get_permalink($request);
    
    $vars['designer'] = $designerID->user_firstname;
    $vars['reassign'] = $reassign;
    $vars['oldDesign'] = $oldDesign;
    
    nexus_requestMailer('assigned', $request, 3, $vars);
    
    update_post_meta($request, 'nexus_request_stage', $stage); // Request Stage = In Progress
    update_post_meta($request, 'nexus_assigned_user', $designer);
    update_post_meta($request, 'nexus_assigned_user_name', $designerName);
    update_post_meta($request, 'nexus_job_status','progress');
    
    nexus_updateLog($request, $designerName.' assigned to request', $designer);
    
    $return['redirect'] = $redirect;
    $return['url'] = $url;
    echo json_encode($return);
    die();   
}

// N03B ---------------------------
// normal Function fired when designer is assigned
function nexus_takeJob($postID, $designer, $stage) {    
    $stage = ($stage ? $stage : 1);
    $userID = get_post_field ('post_author', $postID);
    $type = get_post_type($postID);
    
    $reqID = strtoupper(substr($type, 0, 3)).''.$postID;
    $designerObj = get_userdata($designer);
    $designerName = $designerObj->user_firstname.' '.$designerObj->user_lastname;
    
    $vars['designer'] = $designerObj->user_firstname;
    $vars['reassign'] = 'no';
    $vars['oldDesign'] = 'no';
    
    nexus_requestMailer('assigned', $postID, 3, $vars);
    
    update_post_meta($postID, 'nexus_request_stage', $stage); // Request Stage = In Progress
    update_post_meta($postID, 'nexus_assigned_user', $designer);
    update_post_meta($postID, 'nexus_assigned_user_name', $designerName);
    update_post_meta($postID, 'nexus_job_status','progress');
    
    nexus_updateLog($postID, $designerName.' assigned to request', $designer);  
}

// N04 ---------------------------
// AJAX fired when stage is completed
add_action( 'wp_ajax_nopriv_nexus_completeStage', 'nexus_completeStage' );
add_action( 'wp_ajax_nexus_completeStage', 'nexus_completeStage' );
function nexus_completeStage() {
    $request = $_POST['project'];
    $requestType = $_POST['type'];
    $stageType = $_POST['stage'];
    $completionTime = strtotime(date('Y-m-d'));
    
    $comments = $_POST['comments'];
    
    $reqID = strtoupper(substr($requestType, 0, 3)).''.$request;
    
    $poID = get_post_field( 'post_author', $request );
    
    $currentStatus = intval(get_post_meta($request, 'nexus_request_stage', true),10);
    
    if (get_post_meta($request, 'nexus_stage_dates', true)) {
        $datesArray = get_post_meta($request, 'nexus_stage_dates', true);
    } else {
        $datesArray = array();
    }
    
    $datesArray[] = $completionTime;
    
    update_post_meta($request, 'nexus_stage_dates',$datesArray);
    
    $newStatus = $currentStatus + 1;
    
    update_post_meta($request, 'nexus_request_stage',$newStatus);
    
    update_post_meta($request, 'nexus_admin_comments',$comments); // Adds the comments to the post
    
    switch ($currentStatus) {
        case 1: $stage = 'Assigned'; break;
        case 2: $stage = 'In Progress'; break;
    }
    switch ($newStatus) {
        case 2: $nstage = 'In Progress'; $signOff = false; break;
        case 3: $nstage = 'Completion'; $signOff = true; break;
    }
    
    if ($signOff) {
        update_post_meta($request, 'nexus_signoff_toggle', 1); // Adds Signoff Tickbox
        $signOffBlurb = "The request has been flagged for sign-off by the assigned user. \r\nYou can do this via the project dashboard here: ".nexus_dashboard()." \r\nOr you can contact ".get_userdata(get_post_meta($request,'nexus_assigned_user',true))->user_email." quoting your request ID (".$reqID.") with confirmation - or any queries you may have beforehand. \r\nPlease bear in midn that signing off will close the request. Any other work required will then have to be submitted as a new request unless highlighted beforehand.";
    } else {
        update_post_meta($request, 'nexus_signoff_toggle', 0); // Removes Signoff Tickbox
        $signOffBlurb = "";
    }
    
    $vars['comments'] = $comments;
    $vars['oldStage'] = $stage;
    $vars['newStage'] = $nstage;
    $vars['blurb'] = $signOffBlurb;
    
    if ($newStatus > 2) {
        nexus_requestMailer('stagecomplete', $request, 1, $vars);
        nexus_updateLog($request, 'Assigned user completed request and flagged for sign-off', get_post_meta($request, 'nexus_assigned_user', true));
    }
    
    if ($newStatus == 2) {
        nexus_requestMailer('begun', $request, 1, $vars);
        nexus_updateLog($request, 'Assigned user begun work on request', get_post_meta($request, 'nexus_assigned_user', true));
    }
}

//N04-B - Use this function to determine the stage
function nexus_whatStageAmI($requestType, $newStatus, $id) {
    
    $signOffDateAmount = 0; $signOff = false;
        
    $signOffDateAmount = count(get_post_meta($id, 'nexus_signoff_dates', true));
    
    if ($newStatus == 3 && ($signOffDateAmount < 1 || !$signOffDateAmount)) {
        $signOff = true;
    }
    
    return $signOff;
}

// N05 ---------------------------
// AJAX fired when request is completed
add_action( 'wp_ajax_nopriv_nexus_completeJob', 'nexus_completeJob' );
add_action( 'wp_ajax_nexus_completeJob', 'nexus_completeJob' );
function nexus_completeJob() {
    $request = $_POST['postid'];
    $designer = $_POST['desid'];
    $type = $_POST['posttype'];
    
    $comments = $_POST['comments'];
    $override = $_POST['override'];
    
    $reqID = strtoupper(substr($type, 0, 3)).''.$request;
    $designerID = get_userdata($designer);
    $designerName = $designerID->user_firstname.' '.$designerID->user_lastname;
    
    if ($comments) { update_post_meta($request,'nexus_admin_comments',$comments); } // Adds the comments to the post
    
    update_post_meta($request,'nexus_completion_date',strtotime(date('Y-m-d')));  // Completed Timestamp
    
    if ($override == 'yes') {
        set_post_type($request,'nexus_complete'); // Changes post type to complete
        update_post_meta($request, 'nexus_prior_type', $type); // Adds the old post type as a variable
    } else {
        update_post_meta($request, 'nexus_signoff_toggle', 1); // Signoff Toggle
        update_post_meta($request, 'nexus_request_stage', 3); // Request Stage
    }
    
    $vars['oldType'] = $type;
    $vars['oldID'] = $reqID;
    nexus_requestMailer('completed', $request, 3, $vars);
    
    $return['p'] = $printer;
    $return['q'] = $quantity;
    $return['c'] = $cost;
    $return['array'] = array('query'=>'single_request','postid'=>$request);
    echo json_encode($return);
    die();
}

// N07 ---------------------------
// AJAX fired when feedback is left
add_action( 'wp_ajax_nopriv_nexus_leaveFeedback', 'nexus_leaveFeedback' );
add_action( 'wp_ajax_nexus_leaveFeedback', 'nexus_leaveFeedback' );
function nexus_leaveFeedback() {
    $request = $_POST['projectID'];
    $feedback = $_POST['feedbackText'];
    $rating = $_POST['rating'];
    $client = $_POST['client'];
    $userID = $_POST['user'];
    
    $vars['feedback'] = $feedback;
    $vars['rating'] = $rating;
    $vars['oldType'] = get_post_meta($request,'nexus_prior_type',true);
    $vars['oldID'] = strtoupper(substr($vars['oldType'], 0, 3)).''.$request;
    
    if ($client == 'no') {
        update_post_meta($request, 'nexus_client_feedback',$feedback); // Feedback about Client
        update_post_meta($request, 'nexus_client_rating',$rating); // Rating about Client
    
        update_post_meta($request, 'nexus_client_feedback_toggle', 0); // Removes Feedback Tickbox
        
        nexus_requestMailer('feedbacktoclient', $request, 1, $vars);  
        
        nexus_updateLog($request, 'Feedback left by assigned user', get_post_meta($request, 'nexus_assigned_user', true));
    } else {
        update_post_meta($request, 'nexus_request_feedback',$feedback); // Feedback about Client
        update_post_meta($request, 'nexus_request_rating',$rating); // Rating about Client
    
        update_post_meta($request, 'nexus_request_feedback_toggle', 0); // Removes Feedback Tickbox
        
        nexus_requestMailer('feedbackfromclient', $request, 2, $vars);
        
        nexus_updateLog($request, 'Feedback left by client', $userID);
    }
    
    $return['id'] = $request;
    $return['feedback'] = $feedback;
    $return['rating'] = $rating;
    $return['array'] = array('query'=>'single_request','postid'=>$request,'menu'=>'single_request','tab'=>'details','requesttype'=>'nexus_complete');
    echo json_encode($return);
    die();    
}

// N07 ---------------------------
// AJAX fired when job is applied for
add_action( 'wp_ajax_nopriv_nexus_applyForJob', 'nexus_applyForJob' );
add_action( 'wp_ajax_nexus_applyForJob', 'nexus_applyForJob' );
function nexus_applyForJob() {
    $request = $_POST['projectID'];
    $application = $_POST['applicationDetails'];
    $userID = $_POST['userID'];
    
    $varsCheck = get_post_meta($request, 'nexus_job_application', true);
    if (empty($varsCheck)) { $vars = (array)$varsCheck; }
    $vars[] = array('userID' => $userID, 'application' => $application);
    
    update_post_meta($request, 'nexus_job_application', $vars); // Add new application to request
    
    $return['id'] = $request;
    $return['application'] = $application;
    $return['user'] = $userID;
    $return['array'] = array('query'=>'single_request','postid'=>$request,'menu'=>'single_request','tab'=>'details');
    echo json_encode($return);
    die();    
}

function nexus_checkForApplication($id, $request) {
    $var = get_post_meta($request, 'nexus_job_application', true);
    $applications = (array)$var;
    $return = false;
    if (!empty($applications)) {
        foreach($applications as $application) {
            if ($application['userID'] == $id) {
                $return = true;
            }
        }
    }
    
    return $return;
}

function nexus_applicationCount($request) {
    $applications = get_post_meta($request, 'nexus_job_application', true);
    $return = 0;
    if (!empty($applications)) {
        $return = count(array_filter($applications));
    }
    
    return $return;
}

// N08 ---------------------------
// AJAX fired when stage is signed off
add_action( 'wp_ajax_nopriv_nexus_signOff', 'nexus_signOff' );
add_action( 'wp_ajax_nexus_signOff', 'nexus_signOff' );
function nexus_signOff() {
    $request = $_POST['project'];
    $requestType = $_POST['type'];
    $currentStage = $_POST['stage'];
    $completionTime = strtotime(date('Y-m-d'));
    $signee = $_POST['signee'];
    $type = get_post_type($request);
    
    $reqID = strtoupper(substr($requestType, 0, 3)).''.$request;
    
    $poID = get_post_field( 'post_author', $request );
    
    $datesArray = array('timestamp'=>$completionTime, 'user'=>$signee);
    
    update_post_meta($request, 'nexus_signoff_dates', $datesArray); // Updates the signoff array
    
    update_post_meta($request, 'nexus_signoff_toggle', 0); // Removes Signoff Tickbox
    
    nexus_requestMailer('signoff', $request, 3, $vars);
    
    nexus_updateLog($request, 'Request signed off by client', $signee);
    
    set_post_type($request,'nexus_complete'); // Changes post type to complete
    update_post_meta($request, 'nexus_prior_type',$type); // Adds the old post type as a variable

    $designer = get_post_meta($request, 'nexus_assigned_user', true);
    
    $return['id'] = $request;
    $return['type'] = $requestType;
    $return['stage'] = $currentStage;
    echo json_encode($return);
    die();   
}

// NX ---------------------------
// AJAX fired when request is stolen
add_action( 'wp_ajax_nopriv_nexus_stealRequest', 'nexus_stealRequest' );
add_action( 'wp_ajax_nexus_stealRequest', 'nexus_stealRequest' );
function nexus_stealRequest() {
    $userID = $_POST['newDesigner'];
    $postID = $_POST['theID'];
    
    $userData = get_userdata($userID);
    $designerName = $userData->first_name.' '.$userData->last_name;
    
    update_post_meta($postID, 'nexus_assigned_user', $userID);
    nexus_updateLog($postID, 'Request reassigned to '.$designerName, $userID);
    
    $return['desid'] = $userID;
    $return['postid'] = $postID;
    echo json_encode($return);
    die();   
}

// N11 ---------------------------
// AJAX fired when request is cancelled
add_action( 'wp_ajax_nopriv_nexus_denyRequest', 'nexus_denyRequest' );
add_action( 'wp_ajax_nexus_denyRequest', 'nexus_denyRequest' );
function nexus_denyRequest() {
    $request = $_POST['project'];
    $type = $_POST['type'];
    $reasons = $_POST['reasons'];
    $userID = $_POST['user'];
    $other = $_POST['otherRejection'];
    
    $reqID = strtoupper(substr($type, 0, 3)).''.$request;
    
    update_post_meta($request, 'nexus_cancelled_date',strtotime(date('Y-m-d')));  // Cancelled Timestamp
    set_post_type($request,'nexus_rejected'); // Changes post type to complete
    update_post_meta($request, 'nexus_prior_type',$type); // Adds the old post type as a variable
    
    $reasonList = "";
    foreach ($reasons as $reason) {
        $reasonList .= $reason.', ';
    }
    
    if ($other) {
        if ($reasonList != '') { $reasonList .= ', '; }
        $reasonList .= $other;
    }
    
    update_post_meta($request,'nexus_rejection_reason',$reasonList); // Adds the rejection reason
    
    $vars['oldID'] = $reqID;
    $vars['oldType'] = $type;
    $vars['reasons'] = $reasonList;
    
    nexus_requestMailer('reject', $request, 1, $vars);
    nexus_updateLog($request, 'Request Rejected due to: '.$reasonList, $userID);
    
    $return['id'] = $request;
    $return['type'] = $type;
    $return['reasons'] = $reasons;
    $return['array'] = array('menu'=>'single_request','tab'=>'details','requesttype'=>'rejected','query'=>'single_request','postid'=>$request);
    echo json_encode($return);
    die();
}

function nexus_getAttIDbyURL($attachment_url) {
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( !$attachment_url ) { return; }
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id; 
}

function nexus_requestMailer($type, $id, $who, $variables) {

    require_once(nexus_plugin_inc('nexus_classes/PHPMailerAutoload.php'));
    require_once(nexus_plugin_inc('nexus_api/data/nexus_options.php'));
    
    $alertType = $type; // What kind of email alert is this?
    $projectID = nexus_requestID($id);
    
    $mainSettings = get_option('nexus_main_settings');
    $systemEmail = $mainSettings['nexus_email_address'];
    $debugEmail = $mainSettings['nexus_debug_email'];
    
    $userID = get_post_field('post_author', $id);
    $clientName = get_user_meta($userID, 'first_name', true);
    $clientSurname = get_user_meta($userID, 'last_name', true);
    $clientEmail = get_userdata($userID)->user_email;
    
    $variables['cfname'] = $clientName; 
    $variables['clname'] = $clientSurname;
    $variables['cemail'] = $clientEmail;
    $variables['projectID'] = $projectID;
    $variables['systemEmail'] = $systemEmail;
    $variables['permalink'] = get_permalink($id);
    $variables['pname'] = get_the_title($id);
    
    $variables['website_url'] = get_bloginfo('url');
    $variables['website_title'] = get_bloginfo('name');
    $variables['website_logo'] = $nexus_LOGO;
    
    $desID = get_post_meta($id,'nexus_assigned_user',true);
    if ($desID) {
        $variables['designer'] = get_user_meta($desID, 'first_name', true);
    }
    if ($type == 'feedbackfromclient') { 
        $designerID = get_userdata($desID);
        $designEmail = $designerID->user_email;
    }
    
    if ($variables['cuid']) {
        $customID = $variables['cuid'];
        $variables['customName'] = get_user_meta($customID, 'first_name', true);
        $variables['customSurname'] = get_user_meta($customID, 'last_name', true);
        $customEmail = get_userdata($customID)->user_email;
    }
    
    /* --- Mailer Section --- */
    $headers = "From: " . $systemEmail . "\r\n";
    $headers .= "Reply-To: ". $systemEmail . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    $subjectID = ($variables['oldID'] ? $variables['oldID'] : $projectID);
    $requestType = ucfirst(get_post_type($id));
    $subject = $requestType.' Request: '.$subjectID.' '.get_the_title($id);
    
    $nheader = nexus_get_include_contents(nexus_plugin_inc('nexus_classes/emails/header.php'), $variables);
    $nfooter = nexus_get_include_contents(nexus_plugin_inc('nexus_classes/emails/footer.php'), $variables);
    
    $cbody = $nheader;
    $cbody .= nexus_get_include_contents(nexus_plugin_inc('nexus_classes/emails/client/'.$type.'.php'), $variables);
    $cbody .= $nfooter;
    
    $dbody = $nheader;
    $dbody .= nexus_get_include_contents(nexus_plugin_inc('nexus_classes/emails/design/'.$type.'.php'), $variables);
    $dbody .= $nfooter;
        
    $mainSettings = get_option('nexus_main_settings');
    $debugMode = $mainSettings['nexus_debug_mode'];
    if ($debugMode) {    
        $clientEmail = $designEmail = $debugEmail;
    }  
    
    $local = array('127.0.0.1', "::1");

    if ($nexus_EMAILTOGGLE) {
        if(!in_array($_SERVER['REMOTE_ADDR'], $local)){
            if ($who == 1 || $who == 3) { mail($clientEmail, $subject, $cbody, $headers); }
            if ($who == 2 || $who == 3) { mail($designEmail, $subject, $dbody, $headers); }
            if ($who == 5) { mail($customEmail, $subject, $cbody, $headers); }
        }
    }
}

function nexus_get_include_contents($filename, $variablesToMakeLocal) {
    extract($variablesToMakeLocal);
    if (is_file($filename)) {
        ob_start();
        include $filename;
        return ob_get_clean();
    }
    return false;
}

function nexus_get_clients() { 

    $users = array();
    $roles = array('subscriber', 'author');

    foreach ($roles as $role) :
        $users_query = new WP_User_Query( array( 
            'role' => $role, 
            'orderby' => 'display_name'
            ) );
        $results = $users_query->get_results();
        if ($results) $users = array_merge($users, $results);
    endforeach;

    return $users;
}

function nexus_premail($html) {
    // Used for applying correct styles to email templates
    require_once('parts/class.Premailer.php');
    
    $premailer = (new Premailer($html));    
    $html = $premailer->getConvertedHtml();
    
    return $html;
}

// Get Job Status of Request
function nexus_getRequestStatus($id) {
    $statusNum = get_post_meta($id, 'nexus_request_stage', true);
    $signOff = false;
    $requestType = get_post_type($id);

    $signOffDates = get_post_meta('nexus_signoff_dates', $id);
    $signOffDateAmount = count($signOffDates);
    
    $today = strtotime(date('Y-m-d'));
    $sdate = strtotime(get_the_date('Y-m-d', $id));
    $edate = get_post_meta($id, 'nexus_deadline_date', true);
    
    $days = ceil(abs($edate - $sdate) / 86400);
    $tdays = ceil(abs($today - $sdate) / 86400);
    
    $desID = get_post_meta($id, 'nexus_assigned_user',true);
    
    if ($tdays >= $days) {
        $percComplete = 99;
    } else {
        $percComplete = round((100 / $days) * $tdays); 
    }
    
    $maxStatus = 3;
    switch($statusNum) {
        case '': $statusID = 'tbs'; $status = 'To Be Started'; $signStatus = ''; $perc = '0%'; break;
        case 0: $statusID = 'tbs'; $status = 'To Be Started'; $signStatus = ''; $perc = '0%'; break;
        case 1: $statusID = 'assigned'; $status = 'Assigned'; $signStatus = ''; $perc = '0%'; break;
        case 2: $statusID = 'progress'; $status = 'In Progress'; $signStatus = ''; $perc = $percComplete.'%'; break;
        case 3: $statusID = 'progress'; $status = 'Completion'; $signStatus = 'Request Sign-Off'; $perc = '100%'; break;
        default: $statusID = 'tbs'; $status = 'To Be Started'; $signStatus = ''; $perc = '0%';
    }
    
    if (!$statusNum && $desID) {
        $statusID = 'assigned'; $status = 'Assigned'; $signStatus = ''; $perc = '0%'; $statusNum = 1;
    }
    
    $altStatus = '';

    if ($requestType == 'nexus_complete') {
        $status = 'Complete'; $statusID = 'complete'; $signStatus = ''; $perc = '100%'; $altStatus = 'completed';
    }

    if ($requestType == 'nexus_rejected') {
        $status = 'Rejected'; $statusID = 'rejected'; $signStatus = ''; $perc = '0%'; $altStatus = 'rejected';
    }
    
    if (get_post_meta($id, 'nexus_request_update',true)) {
        $statusID = get_post_meta($id, 'nexus_request_update',true);
    }
    
    switch ($statusID) {
        case 'tbs': $color = '#00adef'; $title = 'To be started'; break;
        case 'assigned': $color = '#63b1cf'; $title = 'Assigned'; break;
        case 'overdue': $color = '#00adef'; $title = 'Overdue'; break;
        case 'rejected': $color = '#c71e2b'; $title = 'Rejected'; break;
        case 'signoff': $color = '#e58b2'; $title = 'Needs Signoff'; break;
        case 'high': $color = '#b90000'; $title = 'Urgent'; break;
        case 'medium': $color = '#d56100'; $title = 'High Priority'; break;
        case 'progress': $color = '#63b1cf'; $title = 'In Progress'; break;
        case 'completion': $color = '#6bc31b'; $title = 'On Completion'; break;
        case 'complete': $color = '#6bc31b'; $title = 'Complete'; break;
        default: $color = '#00adef'; $title = 'To be started';
    }

    if (get_post_meta($id, 'nexus_signoff_toggle',true) == 1) {
        $signOff = true; $color = '#E58B22'; $statusID = 'signoff'; $title = 'Sign-Off';
    }
    
    if (!$statusNum || trim($statusNum) == '') { $statusNum = 0; }
    
    $return['status'] = $status;
    $return['statusID'] = $statusID;
    $return['color'] = $color;
    $return['title'] = $title;
    $return['signoff'] = $signOff;
    $return['percent'] = $perc;
    $return['alt'] = $altStatus;
    $return['max'] = $maxStatus;
    $return['statNum'] = $statusNum;
    $return['signoffDate'] = $signOffDates;
    
    return $return;
}

function nexus_getDesignerStatus($id) {
    $completeQuery = new WP_Query(array('post_type' => nexus_output_post_types('array_single'), 'posts_per_page' => -1, 'meta_key' => 'nexus_assigned_user','meta_value'=>$id, 'meta_compare'=>'='));
    
    $return = ''; $count = $completeQuery->found_posts;
    
    if ($count > 0) {
        $s = ($count > 1 ? 's' : '');
        $return .= 'assigned to '.$count.' request'.$s.'.';
    }
    
    return $return;
}


// Gets a specific user's star rating average
function nexus_getUserRating($uid, $type) {
    if ($uid) {
        
        if ($type == 'client') {
            $query = new WP_Query( array( 'post_type' => 'nexus_complete', 'author' => $uid, 'posts_per_page' => -1 ) );
            if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
                $ratingScore = get_post_meta(get_the_ID(),'nexus_client_rating',true);
                if ($ratingScore) { $rate = $ratingScore; $ratings[] = intval($rate, 10); }
            endwhile; endif; wp_reset_query();
        } else {
            $query = new WP_Query( array( 'post_type' => 'nexus_complete', 'posts_per_page' => -1, 'meta_key' => 'nexus_assigned_user', 'meta_value' => $uid ) );
            if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
                $ratingScore = get_post_meta(get_the_ID(),'nexus_request_rating',true);
                if ($ratingScore) { $rate = $ratingScore; $ratings[] = intval($rate, 10); }
            endwhile; endif; wp_reset_query();
        }
        
        if ($ratings) { $rating = round( array_sum($ratings) / count($ratings) ); } else { $rating = 0; }
        
    } else { $rating = 0; }
    
    return $rating;
}

// Gets a specific user's rating count
function nexus_getUserRatingCount($uid) {
    
    $rating = 0;
    
    if ($uid) {
        
        $query = new WP_Query( array( 'post_type' => 'nexus_complete', 'posts_per_page' => -1, 'meta_key' => 'nexus_assigned_user', 'meta_value' => $uid ) );
        if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
            $ratingScore = get_post_meta(get_the_ID(),'nexus_request_rating',true);
            if ($ratingScore) { $rating = $rating + 1; }
        endwhile; endif; wp_reset_query();
        
    }
    
    return $rating;
}


// Gets a specific user's active request count
function nexus_getActiveRequests($uid, $type) {
    if ($uid) {
        
        $postTypes = nexus_output_post_types('array_single');
        if ($type == 'client') {
            $query = new WP_Query( array( 'post_type' => $postTypes, 'author' => $uid, 'posts_per_page' => -1 ) );
        } else {
            $query = new WP_Query( array( 'post_type' => $postTypes, 'posts_per_page' => -1, 'meta_key' => 'nexus_assigned_user', 'meta_value' => $uid ) );
        }
        
        $count = $query->found_posts;

    } else {  $count = 0; }
    
    return $count;
}


// Gets a specific user's completed request count
function nexus_getCompletedRequests($uid, $type) {
    if ($uid) {
        
        if ($type == 'client') {
            $query = new WP_Query( array( 'post_type' => 'nexus_complete', 'author' => $uid, 'posts_per_page' => -1 ) );
        } else {
            $query = new WP_Query( array( 'post_type' => 'nexus_complete', 'posts_per_page' => -1, 'meta_key' => 'nexus_assigned_user', 'meta_value' => $uid ) );
        }
        
        $count = $query->found_posts;

    } else { $count = 0; }
    
    return $count;
}


// Gets a specific user's requests if action is neeeded
function nexus_needsAction($uid, $types) {
    
    if ($types == 'all') { $postTypes = nexus_output_post_types('array_single'); } else { $postTypes = $types; }
    
    if ($uid) {
        $count = 0;
        $query = new WP_Query( array( 'post_type' => $postTypes, 'author' => $uid, 'posts_per_page' => -1 ) );
        $query2 = new WP_Query( array( 'post_type' => 'nexus_complete', 'author' => $uid, 'posts_per_page' => -1 ) );
        
        if ($types != 'complete') {
            if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); $signOffCount = nexus_getRequestStatus(get_the_ID()); if ($signOffCount['signoff']) { $count = $count + 1; } endwhile; endif; wp_reset_query();
        }
        
        if ($types == 'all' || $types == 'complete') {
            if ( $query2->have_posts() ) : while ( $query2->have_posts() ) : $query2->the_post(); if (get_post_meta(get_the_ID(), 'nexus_request_feedback', true)) { $count = $count + 1; } endwhile; endif; wp_reset_query();
        }
        
    } else { $count = 0; }
    
    return $count;
}

function nexus_newRequests($types) {
    
    if ($types == 'all') { $postTypes = nexus_output_post_types('array_single'); } else { $postTypes = $types; }
    
    $query1 = new WP_Query( array('post_type' => $postTypes, 'posts_per_page' => -1) );
    
    $query2 = new WP_Query( 
        array( 
            'post_type' => $postTypes,
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'nexus_assigned_user',
                    'value' => false,
                    'type' => 'BOOLEAN'
                ),
                array(
                    'key' => 'nexus_assigned_user',
                    'compare' => 'NOT EXISTS'
                )
            )
        )
    );
    
    $array['new'] = $query2->found_posts;
    $array['count'] = $query1->found_posts;
    
    return $array;
}

function nexus_requestCount($type) {
    
    if (!$type || $type == 'all') {
        $postTypes = nexus_output_post_types('array_single');    
    } else {
        $postTypes = $type;
    }
    
    $query = new WP_Query( array('post_type' => $postTypes, 'posts_per_page' => -1) );
    
    $count = $query->found_posts;
    
    return $count;
    
}

function nexus_updateLog($postID, $log, $userID) {
    $user = nexus_userDetailsArray(get_current_user_ID());
    $log = str_replace('*','',$log);
    $requestLog = get_post_meta($postID,'nexus_request_log',true);
    $logText = ($requestLog ? $requestLog.'*' : '');
    $logText .= '<strong>'.date('d/m/Y - H:i:s').'</strong> - '.$user['fullname'].' - '.$log;
    
    update_post_meta($postID,'nexus_request_log',$logText);
}

function nexus_userDetailsArray($phpID) {
    $userID = $phpID;
    $userData = get_userdata($userID);
    $array['firstname'] = $userData->first_name;
    $array['lastname'] = $userData->last_name;
    $array['fullname'] = $userData->first_name.' '.$userData->last_name;
    $array['slug'] = sanitize_title($userData->first_name.'_'.$userData->last_name);
    $array['email'] = $userData->user_email;
    $array['phone'] = get_user_meta($userID, 'nexus_contact_number', true);
    $array['phone'] = ($array['phone'] ? $array['phone'] : '0000');
    $array['company'] = get_user_meta($userID, 'nexus_company_name', true);
    $array['company'] = ($array['company'] ? $array['company'] : 'No Company');
    $array['id'] = $userData->ID;
    $array['img'] = nexus_getUserIMG($userID);
    if (user_can( $userID, 'manage_options' )) {
        $array['activerequests'] = nexus_getActiveRequests($userID, 'designer');
        $array['completerequests'] = nexus_getCompletedRequests($userID, 'designer');
        $array['rating'] = nexus_getUserRating($userID, 'designer');
    } else {
        $array['activerequests'] = nexus_getActiveRequests($userID, 'client');
        $array['completerequests'] = nexus_getCompletedRequests($userID, 'client');
        $array['rating'] = nexus_getUserRating($userID, 'client');
    }
    
    return $array;
}

add_action( 'wp_ajax_nopriv_nexus_userDetailsArrayAjax', 'nexus_userDetailsArrayAjax' );
add_action( 'wp_ajax_nexus_userDetailsArrayAjax', 'nexus_userDetailsArrayAjax' );
function nexus_userDetailsArrayAjax() {
    
    $userID = $_POST['userid'];
    $userData = get_userdata($userID);
    $array['firstname'] = $userData->first_name;
    $array['lastname'] = $userData->last_name;
    $array['fullname'] = $userData->first_name.' '.$userData->last_name;
    $array['email'] = $userData->user_email;
    $array['id'] = $userData->ID;
    $array['img'] = nexus_getUserIMG($userID);
    if (user_can( $userID, 'manage_options' )) {
        $array['activerequests'] = nexus_getActiveRequests($userID, 'designer');
        $array['completerequests'] = nexus_getCompletedRequests($userID, 'designer');
        $array['rating'] = nexus_getUserRating($userID, 'designer');
    } else {
        $array['activerequests'] = nexus_getActiveRequests($userID, 'client');
        $array['completerequests'] = nexus_getCompletedRequests($userID, 'client');
        $array['rating'] = nexus_getUserRating($userID, 'client');
    }
    
    echo json_encode($array);
    die();
}

function nexus_getUserFeedback($userID) {
    
    $query = new WP_Query(array('post_type' => 'nexus_complete', 'meta_key' => 'nexus_assigned_user','meta_value'=>$userID, 'meta_compare'=>'=', 'posts_per_page' => -1));
    if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
        $rate = get_post_meta(get_the_ID(),'nexus_request_rating',true); 
        $useFeedback = get_post_meta(get_the_ID(),'nexus_use_feedback',true);
        $feedbackText = get_post_meta(get_the_ID(),'nexus_request_feedback',true);
        if ($rate) {
            if ($useFeedback == 'yes') {
                $feedback[] = array('quotee'=>get_the_author_id(),'quote'=>$feedbackText,'rating'=>intval($rate, 10));
            }
        }
    endwhile; endif; wp_reset_query();
    
    return $feedback;
}

function nexus_firstPostYear() {
    
    $args = array('post_type'=>nexus_output_post_types('array_single'), 'numberposts' => -1, 'order' => 'ASC' );
    $get = get_posts($ax_args);
    $first = $get[0];
    $firstDate = $first->post_date;
    $date = date('Y', strtotime($firstDate));

    return $date;
}

function nexus_getRequestRating($postID, $type) {
    
    if ($type == 'designer') { 
        $rate = get_post_meta($postID,'nexus_request_rating',true);
        if ($rate) { $rating = intval($rate, 10); }
    } else {
        $rate = get_post_meta($postID,'nexus_client_rating',true);
        if ($rate) { $rating = intval($rate, 10); }
    }
    
    $ratingHTML = '<ul class="rating">';
    for ($i = 0; $i < $rating; $i++) {
        $ratingHTML .= '<li><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABMUlEQVQ4jbXTsS4EURTG8d/aSNiEkkgUFKJBQkNLwkq8gE6rVelpPIDCg2jQaDWmWI3Y0GxINtGQIBFWMXeTNTvMzoiT3MydM9/5zzdzzym1mnqJtXA9zRKWegD2IQr7eXxmibNiC3NhbWWJsxxWcI3xcN/ANF6KOtzpgAn7naIOR3CD4UT+CVNIrWwDK5jFgvjHz2MGAz+87A1X4sOKcIkaXkqtpkNso/zbp/QQHzgqtZqGcIbFPwIvsNqHZ2yILReNWmA8t0/5EeuoF4DVUQ2Mb21zHx40csAa4rF8aCeSfXiL/RzAPdx1JtIaeyQHcDSZSANO5AB2adOAkzmAXdpeHEbYDCvK0HbNchmv6Mc5DnCSqKliF8t4x6B4SlIdjuEYS6EgCRNyK0FzHGr+L74ARddCn3gEdJMAAAAASUVORK5CYII=" /></li>';
    }
    $ratingHTML .= '</ul>';
    
    return $ratingHTML;
}

function nexus_requestID($id) {
    if (get_post_type($id) == 'nexus_complete' || get_post_type($id) == 'nexus_rejected') {
        $type = get_post_meta($id, 'nexus_prior_type', true);
    } else { $type = get_post_type($id); }
    
    $type = str_replace('nexus_','',$type);
    
    $reqID = strtoupper(substr($type, 0, 3)).''.$id;
    
    return $reqID;
}

// Approve Pending User
add_action( 'wp_ajax_nopriv_nexus_approveUser', 'nexus_approveUser' );
add_action( 'wp_ajax_nexus_approveUser', 'nexus_approveUser' );
function nexus_approveUser() {
    $id = $_POST['userID'];
    update_user_meta($id, 'nexus_account_status', 'active');
    
    $pending = new WP_User_Query( array( 'meta_key' => 'nexus_account_status', 'meta_value' => 'active', 'meta_compare' => '!=' ) );
    if ( empty( $pending->results ) ) { 
        $return['removeClass'] = true;
    }
    
    $return['array'] = array('query'=>'pending_users','tab'=>'pending_users');
    echo json_encode($return);
    die();
}

// Reject Pending User
add_action( 'wp_ajax_nopriv_nexus_rejectUser', 'nexus_rejectUser' );
add_action( 'wp_ajax_nexus_rejectUser', 'nexus_rejectUser' );
function nexus_rejectUser() {
    $id = $_POST['userID'];
    wp_delete_user( $id );
    
    $pending = new WP_User_Query( array( 'meta_key' => 'nexus_account_status', 'meta_value' => 'active', 'meta_compare' => '!=' ) );
    if ( empty( $pending->results ) ) { 
        $return['removeClass'] = true;
    }
    
    $return['array'] = array('query'=>'pending_users','tab'=>'pending_users');
    echo json_encode($return);
    die();
}

add_action( 'wp_ajax_nopriv_nexus_currentUserView', 'nexus_currentUserView' );
add_action( 'wp_ajax_nexus_currentUserView', 'nexus_currentUserView' );
function nexus_currentUserView() {
    include(nexus_plugin_inc('nexus_api/views/current_user_view.php'));
    die();
}

function nexus_auto_add_link_markup($value, $target='_blank') {
    $value = strip_tags($value);
    
    if ($target) {
        $target = ' target="'.$target.'"';
    } else {
        $target = '';
    }
    
    // find and replace link
    $str = preg_replace('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', '<a href="$1" '.$target.'>$1</a>', $value);
    // add "http://" if not set
    $str = preg_replace('/<a\s[^>]*href\s*=\s*"((?!https?:\/\/)[^"]*)"[^>]*>/i', '<a href="http://$1" '.$target.'>', $str);
    
    return wpautop($str);
}

add_action( 'wp_ajax_nopriv_nexus_chatLogUpdate', 'nexus_chatLogUpdate' );
add_action( 'wp_ajax_nexus_chatLogUpdate', 'nexus_chatLogUpdate' );
function nexus_chatLogUpdate() {
    $postID = $_POST['id'];
    $cuID = $_POST['userID'];
        $userData = nexus_userDetailsArray($userID);
    $text = $_POST['text'];
    $timestamp = date('d/m/Y h:i:s');
    $fileURL = $_POST['file'];
    $fileWP = $_POST['wp'];
    $fileType = $_POST['fileType'];
    
    if (get_post_meta($postID, 'nexus_chat_log', true)) {
        $currentLog = get_post_meta($postID, 'nexus_chat_log', true);
        $count = count($currentLog) - 1;
        $priorTimestamp = $currentLog[$count]['timestamp'];
        $priorUser = $currentLog[$count]['user'];
        if ($cuID != $priorUser) { $newMessage = true; } else { $newMessage = false; }
    } else {
        $currentLog = array();
        $priorTimestamp = false;
        $newMessage = true;
    }
    
    if ($userData['usertype'] == 'client') {
        $customID = get_post_meta($postID,'nexus_assigned_user',true);
        if (get_post_meta($postID, 'nexus_chat_user_not_seen', true) != 1) { update_post_meta($postID, 'nexus_chat_user_not_seen', 1); }
    } else {
        $customID = get_post_field( 'post_author', $postID );
        if (get_post_meta($postID, 'nexus_chat_client_not_seen', true) != 1) { update_post_meta($postID, 'nexus_chat_client_not_seen', 1); }
    }
    
    if ($text) {
        $currentLog[] = array(
            'user'=>$cuID,
            'text'=>$text,
            'timestamp'=>$timestamp
        );
    }
    
    if ($fileURL) {
        
        $imagePath = parse_url($fileWP, PHP_URL_PATH);
        $ext = pathinfo($imagePath, PATHINFO_EXTENSION);

        if ($ext == 'png' || $ext == 'jpg') {
            $fileOutput = '<a class="imgPopup" href="'.$fileWP.'"><img src="'.$fileWP.'" class="chatImgPreview" /></a>';
        } else {
            $fileOutput = $fileWP;
        }
        
        $currentLog[] = array(
            'user'=>$cuID,
            'text'=>$fileOutput,
            'timestamp'=>$timestamp
        );
    }
    
    update_post_meta($postID, 'nexus_chat_log', $currentLog);
    
    $sendMail = false;
    $pts = strtotime(str_replace('/','-',$priorTimestamp));
    if ($pts && $pts > strtotime('-2 hours')) { $sendMail = true; } 
    if ($newMessage) { $sendMail = true; }
    
    $vars['chatText'] = $text; $vars['cuid'] = $customID;
    
    if ($sendMail) { nexus_requestMailer('newchat', $postID, 5, $vars); }
    
    $array['text'] = $text;
    $array['timestamp'] = $timestamp;
    $array['file'] = $fileURLNormal;
    $array['filedecode'] = $fileURL;
    $array['output'] = $fileOutput;
    $array['userID'] = $cuID;
    $array['cu'] = ($cuID == get_current_user_id() ? 'yes' : 'no');
    
    echo json_encode($array);
    die();
}

function nexus_colourBrightness($hex, $percent) {
	// Work out if hash given
	$hash = '';
	if (stristr($hex,'#')) {
		$hex = str_replace('#','',$hex);
		$hash = '#';
	}
	/// HEX TO RGB
	$rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
	//// CALCULATE 
	for ($i=0; $i<3; $i++) {
		// See if brighter or darker
		if ($percent > 0) {
			// Lighter
			$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
		} else {
			// Darker
			$positivePercent = $percent - ($percent*2);
			$rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
		}
		// In case rounding up causes us to go to 256
		if ($rgb[$i] > 255) {
			$rgb[$i] = 255;
		}
	}
	//// RBG to Hex
	$hex = '';
	for($i=0; $i < 3; $i++) {
		// Convert the decimal digit to hex
		$hexDigit = dechex($rgb[$i]);
		// Add a leading zero if necessary
		if(strlen($hexDigit) == 1) {
		$hexDigit = "0" . $hexDigit;
		}
		// Append to the hex string
		$hex .= $hexDigit;
	}
	return $hash.$hex;
}

?>