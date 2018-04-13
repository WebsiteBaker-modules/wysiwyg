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
 * @version         $Id: add.php 2 2017-07-02 15:14:29Z Manuela $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.10.x/branches/main/modules/wysiwyg/add.php $
 * @lastmodified    $Date: 2017-07-02 17:14:29 +0200 (So, 02. Jul 2017) $
 *
 */
/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if(!defined('WB_PATH')) {
  die('Cannot access '.basename(__DIR__).'/'.basename(__FILE__).' directly');
/* -------------------------------------------------------- */
} else {
    // Insert an extra row into the database
    $sql = 'INSERT INTO `'.TABLE_PREFIX.'mod_wysiwyg` '
         . 'SET `page_id`='.$database->escapeString($page_id).', '
         .     '`section_id`='.$database->escapeString($section_id).', '
         .     '`content`=\'\', '
         .     '`text`=\'\'';
    $database->query($sql);
}
