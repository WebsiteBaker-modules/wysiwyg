<?php
/**
 *
 * @category        modules
 * @package         wysiwyg
 * @author          WebsiteBaker Project
 * @copyright       WebsiteBaker Org. e.V.
 * @link            http://websitebaker.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.3
 * @requirements    PHP 5.3.6 and higher
 * @version         $Id: upgrade.php 2 2017-07-02 15:14:29Z Manuela $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.10.x/branches/main/modules/wysiwyg/upgrade.php $
 * @lastmodified    $Date: 2017-07-02 17:14:29 +0200 (So, 02. Jul 2017) $
 *
 */

/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if (!defined('SYSTEM_RUN')) { header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); flush(); exit; }
/* -------------------------------------------------------- */
    $globalStarted = preg_match('/upgrade\-script\.php$/', $_SERVER["SCRIPT_NAME"]);
    $sWbVersion = ($globalStarted && defined('VERSION') ? VERSION : WB_VERSION);
    if (version_compare($sWbVersion, '2.11.0', '<')){
        throw new Exception ('It is not possible to install from WebsiteBaker Versions before 2.11.0');
    }
    $msg = '';
    $sInstallStruct = __DIR__.'/install-struct.sql';
    if (!$database->SqlImport($sInstallStruct, TABLE_PREFIX, 'upgrade' )){
        $msg = $database->get_error();
    }
// sanitize URLs inside mod_wysiwyg.content ----------------------------
    $msg = '';
    $sql = 'SELECT `content`, `section_id` FROM `'.TABLE_PREFIX.'mod_wysiwyg`';
    if (($oInstances = $database->query($sql))) {
        while (($aInstance = $oInstances->fetchRow(MYSQLI_ASSOC))) {
            // add $sDocumentRootUrl to relative URLs
            $sContent = $admin->ReplaceAbsoluteMediaUrl($aInstance['content']);
            $sText = strip_tags($sContent);
            $sql = 'UPDATE `'.TABLE_PREFIX.'mod_wysiwyg` '
                 . 'SET `content`=\''.$database->escapeString($sContent).'\', '
                . '`text`=\''.$database->escapeString($sText).'\' '
                 . 'WHERE `section_id`='.(int)$aInstance['section_id'];
            if (!$database->query($sql)) {
                $msg = $database->get_error();
                break;
            }
        }// end while
    } else { $msg = $database->get_error(); }

// ---------------------------------------------------------------------
/*
$sql  = 'UPDATE `'.$sTable.'` SET '
      . '`content` = REPLACE(`content`, \'"'.WB_URL.MEDIA_DIRECTORY.'\', \'"{SYSVAR:MEDIA_REL}\')';
if (!$database->query($sql)) {
    $msg .= $database->get_error().'<br />';
}
*/
// ------------------------------------