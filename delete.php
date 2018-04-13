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
 * @version         $Id: delete.php 2 2017-07-02 15:14:29Z Manuela $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.10.x/branches/main/modules/wysiwyg/delete.php $
 * @lastmodified    $Date: 2017-07-02 17:14:29 +0200 (So, 02. Jul 2017) $
 *
 */
/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if(!defined('WB_PATH')) {
  die('Cannot access '.basename(__DIR__).'/'.basename(__FILE__).' directly');
/* -------------------------------------------------------- */
} else {
// Delete record from the database
    $sql  = 'DELETE FROM `'.TABLE_PREFIX.'mod_wysiwyg` '
          . 'WHERE `section_id` = '.$database->escapeString($section_id);
    $database->query($sql);
}
