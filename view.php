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
 * @version         $Id: view.php 2 2017-07-02 15:14:29Z Manuela $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.10.x/branches/main/modules/wysiwyg/view.php $
 * @lastmodified    $Date: 2017-07-02 17:14:29 +0200 (So, 02. Jul 2017) $
 *
 */

/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if(defined('WB_PATH') == false) { die('Illegale file access /'.basename(__DIR__).'/'.basename(__FILE__).''); }
/* -------------------------------------------------------- */
// Get content
$content = '';
$sql = 'SELECT `content` FROM `'.TABLE_PREFIX.'mod_wysiwyg` '
     . 'WHERE `section_id`='.(int)$section_id;
if(!($content = $database->get_one($sql)) ) {}
echo $content;
