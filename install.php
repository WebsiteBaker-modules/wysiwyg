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
 * @version         $Id: install.php 2 2017-07-02 15:14:29Z Manuela $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.10.x/branches/main/modules/wysiwyg/install.php $
 * @lastmodified    $Date: 2017-07-02 17:14:29 +0200 (So, 02. Jul 2017) $
 *
 */
if (!defined('SYSTEM_RUN')) { header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); flush(); exit; }

    $globalStarted = preg_match('/upgrade\-script\.php$/', $_SERVER["SCRIPT_NAME"]);
    $sWbVersion = (defined('VERSION') ? VERSION : WB_VERSION);
    if (version_compare($sWbVersion, '2.11.0', '<')){
        throw new Exception ('It is not possible to install from WebsiteBaker Versions before 2.11.0');
    }
    // create tables from sql dump file
    if (is_readable(__DIR__.'/install-struct.sql')) {
        $database->SqlImport(__DIR__.'/install-struct.sql', TABLE_PREFIX, __FILE__ );
    }
