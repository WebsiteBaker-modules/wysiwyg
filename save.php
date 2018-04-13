<?php
/**
 *
 * @category        backend
 * @package         wysiwyg
 * @author          WebsiteBaker Project
 * @copyright       WebsiteBaker Org. e.V.
 * @link            http://websitebaker.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.3
 * @requirements    PHP 5.3.6 and higher
 * @version         $Id: save.php 2 2017-07-02 15:14:29Z Manuela $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.10.x/branches/main/modules/wysiwyg/save.php $
 * @lastmodified    $Date: 2017-07-02 17:14:29 +0200 (So, 02. Jul 2017) $
 *
*/

if ( !defined( 'WB_PATH' ) ){ require( dirname(dirname((__DIR__))).'/config.php' ); }

// suppress to print the header, so no new FTAN will be set
$admin_header = false;
// Tells script to update when this page was last updated
$update_when_modified = true;
// Include WB admin wrapper script
require(WB_PATH.'/modules/admin.php');

if (!$admin->checkFTAN()) {
    $admin->print_header();
    $admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}
// After check print the header
$admin->print_header();

// Include the WB functions file
if (!function_exists('make_dir')){require(WB_PATH.'/framework/functions.php');}

$bBackLink = isset($aRequestVars['pagetree']);

// Update the mod_wysiwygs table with the contents
if(isset($aRequestVars['content'.$section_id])) {
    $content = $aRequestVars['content'.$section_id];
    if(ini_get('magic_quotes_gpc')==true)
    {
        $content = $admin->strip_slashes($aRequestVars['content'.$section_id]);
    }
    $content = $admin->ReplaceAbsoluteMediaUrl($content);
    $text = strip_tags($content);
    $sql = 'UPDATE `'.TABLE_PREFIX.'mod_wysiwyg` SET '
         . '`content`=\''.$database->escapeString($content).'\', '
         . '`text`=\''.$database->escapeString($text).'\' '
         . 'WHERE `section_id`='.(int)$section_id;
    $database->query($sql);
}
$sec_anchor = (defined( 'SEC_ANCHOR' ) && ( SEC_ANCHOR != '' )  ? '#'.SEC_ANCHOR.(int)$section_id : '' );
if(defined('EDIT_ONE_SECTION') && EDIT_ONE_SECTION){
    $edit_page = ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&wysiwyg='.$section_id;
} elseif ( $bBackLink ) {
  $edit_page = ADMIN_URL.'/pages/index.php';
} else {
    $edit_page = ADMIN_URL.'/pages/modify.php?page_id='.$page_id.$sec_anchor;
}

// Check if there is a database error, otherwise say successful
if($database->is_error()) {
    $admin->print_error($database->get_error(), $js_back);
} else {
    $admin->print_success($MESSAGE['PAGES_SAVED'], $edit_page );
}

// Print admin footer
$admin->print_footer();
