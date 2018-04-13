<?php
/*
 * Copyright (C) 2017 Manuela v.d.Decken <manuela@isteam.de>
 *
 * DO NOT ALTER OR REMOVE COPYRIGHT OR THIS HEADER
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 2 of the License.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License 2 for more details.
 *
 * You should have received a copy of the GNU General Public License 2
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/**
 * Description of modules/wysiwyg/modify.php
 *
 * @package      Core
 * @copyright    Manuela v.d.Decken <manuela@isteam.de>
 * @author       Manuela v.d.Decken <manuela@isteam.de>
 * @license      GNU General Public License 2.0
 * @version      2.0.1
 * @revision     $Id: modify.php 2 2017-07-02 15:14:29Z Manuela $
 * @since        File available since 04.10.2017
 * @deprecated   no
 * @description  xxx
 */
//declare(strict_types = 1);
//declare(encoding = 'UTF-8');

//namespace ;

// use

/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if (!defined('SYSTEM_RUN')) { header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); flush(); exit; }
/* -------------------------------------------------------- */

// Get page content   htmlspecialchars
$sql = 'SELECT `content` FROM `'.TABLE_PREFIX.'mod_wysiwyg` WHERE `section_id`='.(int)$section_id;
if (($content = $database->get_one($sql)) ) {
    $content = OutputFilterApi('ReplaceSysvar', $content);
    $content = htmlspecialchars($content);
} else {
    $content = '';
}

if(!isset($wysiwyg_editor_loaded)) {
    $wysiwyg_editor_loaded=true;
    if (!defined('WYSIWYG_EDITOR') OR WYSIWYG_EDITOR=="none" OR !file_exists(WB_PATH.'/modules/'.WYSIWYG_EDITOR.'/include.php')) {
        function show_wysiwyg_editor($name,$id,$content,$width,$height) {
            echo '<textarea name="'.$name.'" id="'.$id.'" style="width: '.$width.'; height: '.$height.';">'.$content.'</textarea>';
        }
    } else {
        $id_list = array();
        $sql  = 'SELECT `section_id` FROM `'.TABLE_PREFIX.'sections` ';
        $sql .= 'WHERE `page_id`='.(int)$page_id.' AND `module`=\'wysiwyg\'';
        if (($query_wysiwyg = $database->query($sql))) {
            while($wysiwyg_section = $query_wysiwyg->fetchRow( MYSQLI_ASSOC )) {
                $entry='content'.$wysiwyg_section['section_id'];
                $id_list[] = $entry;
            }
            require(WB_PATH.'/modules/'.WYSIWYG_EDITOR.'/include.php');
        }
    }
}
$sSectionsTitle = (isset($section) ? $section['title'] : '');
$SectionIdPrefix = (defined( 'SEC_ANCHOR' ) && ( SEC_ANCHOR != '' )  ? ''.SEC_ANCHOR.(int)$section_id : (int)$section_id );
?>
<form id="wysiwyg<?php echo $section_id; ?>" action="<?php echo WB_URL; ?>/modules/wysiwyg/save.php" method="post">
    <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
    <input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
    <input type="hidden" name="inputSection" value="1" />
    <?php echo $admin->getFTAN(); ?>
    <div id="<?php echo $SectionIdPrefix; ?>" ></div>

<?php
echo show_wysiwyg_editor('content'.$section_id,'content'.$section_id,$content,'100%','250', false);
?>
    <table style="padding-bottom: 10px; width: 100%;">
        <tr>
            <td style="text-align: left;margin-left: 1em;">
                <input class="btn w3-blue-wb w3-hover-green" name="modify" type="submit" value="<?php echo $TEXT['SAVE']; ?>"  />
                <input class="btn w3-blue-wb w3-hover-green" name="pagetree" type="submit" value="<?php echo $TEXT['SAVE'].' &amp; '.$TEXT['BACK']; ?>"  />
            </td>
            <td style="text-align: right;margin-right: 1em;">
                <input class="btn w3-blue-wb w3-hover-red" name="cancel" type="button" value="<?php echo $TEXT['CANCEL']; ?>" onclick="window.location = 'index.php';"  />
            </td>
        </tr>
    </table>
</form>
<br />
