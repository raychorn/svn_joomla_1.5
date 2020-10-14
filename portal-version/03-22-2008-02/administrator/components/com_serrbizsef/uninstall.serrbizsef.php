<?php
/**
* @version $Id: uninstall.serrbizsef.php 2007-10-19 11:19:30 $
* @package Joomla
* @subpackage SerrBizSEF
* @copyright Copyright (C) Serr.biz. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*
* SerrBizSEF is a released under the terms of the GNU General Public License;
* Warranty : This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
* FITNESS FOR A PARTICULAR PURPOSE. 
*
* @author Serr.biz
* @version 1.0 Complete
*/

// no direct access
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');
function recursive_remove_directory($directory, $empty=FALSE)
 {
     if(substr($directory,-1) == '/')
     {
         $directory = substr($directory,0,-1);
     }
  
     if(!file_exists($directory) || !is_dir($directory))
     {
         return FALSE;
     }elseif(!is_readable($directory))
     {
         return FALSE;
     }else{
         $handle = opendir($directory);

         while (FALSE !== ($item = readdir($handle)))
         {

             if($item != '.' && $item != '..')
             {

                 $path = $directory.'/'.$item;

                 if(is_dir($path)) 
                 {

                    recursive_remove_directory($path);
  
                 }else{
                     unlink($path);
                 }
             }
        }
        closedir($handle);
  
         if($empty == FALSE)
         {
             if(!rmdir($directory))
             {
                 return FALSE;
             }
         }
         return TRUE;
     }
 }

function com_uninstall() 
{
    global $mosConfig_absolute_path,$database;
    // uninstall modules
    $database->setQuery("DELETE FROM `#__modules` WHERE module= 'mod_serrbizsefTags'");
    $database->query();
    //remove the files and folder
    @unlink($mosConfig_absolute_path.'/components/com_sef/sef.php');
    @unlink($mosConfig_absolute_path.'/modules/mod_serrbizsefTags.php');
    @unlink($mosConfig_absolute_path.'/modules/mod_serrbizsefTags.xml');
    @unlink($mosConfig_absolute_path.'/administrator/components/com_serrbizsef/'); 

	@unlink($mosConfig_absolute_path.'/modules/mod_serrbizsef_tags/mod_serrbizsef_tags_data.php'); 
	@unlink($mosConfig_absolute_path.'/modules/mod_serrbizsef_tags/css/floating-window.css'); 
	@unlink($mosConfig_absolute_path.'/modules/mod_serrbizsef_tags/css/'); 
	@unlink($mosConfig_absolute_path.'/modules/mod_serrbizsef_tags/css'); 

	@unlink($mosConfig_absolute_path.'/modules/mod_serrbizsef_tags/image/serrbiz_logo25x25.jpg'); 
	@unlink($mosConfig_absolute_path.'/modules/mod_serrbizsef_tags/image/'); 
	@unlink($mosConfig_absolute_path.'/modules/mod_serrbizsef_tags/image'); 
	
	@unlink($mosConfig_absolute_path.'/modules/mod_serrbizsef_tags/js/floating-window.js'); 
	@unlink($mosConfig_absolute_path.'/modules/mod_serrbizsef_tags/js/'); 
	@unlink($mosConfig_absolute_path.'/modules/mod_serrbizsef_tags/js'); 
	
	@unlink($mosConfig_absolute_path.'/modules/mod_serrbizsef_tags/'); 
	@unlink($mosConfig_absolute_path.'/modules/mod_serrbizsef_tags'); 
	
	@recursive_remove_directory($mosConfig_absolute_path."/modules/mod_serrbizsef_tags", FALSE);
	@recursive_remove_directory($mosConfig_absolute_path."/modules/mod_serrbizsef_tags", TRUE);
	@recursive_remove_directory($mosConfig_absolute_path."/modules/mod_serrbizsef_tags/", FALSE);
	@recursive_remove_directory($mosConfig_absolute_path."/modules/mod_serrbizsef_tags/", TRUE);
    return true;
}
?>