<?php
/**
* @version $Id: install.serrbizsef.php 2007-10-19 11:19:30 $
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
function dircpy($basePath, $source, $dest, $overwrite = false)
{
    if(!is_dir($basePath . $dest)) 
	//Lets just make sure our new folder is already created. Alright so its not efficient to check  each time... bite me
    
	@mkdir($basePath . $dest, 0777);
	
    if($handle = opendir($basePath . $source))
	{        // if the folder exploration is sucsessful, continue
        while(false !== ($file = readdir($handle)))
		{ // as long as storing the next file to $file is successful, continue
            if($file != '.' && $file != '..')
			{
                $path = $source . '/' . $file;
                if(is_file($basePath . $path))
				{
                    if(!is_file($basePath . $dest . '/' . $file) || $overwrite)
                    if(!@copy($basePath . $path, $basePath . $dest . '/' . $file))
					{
                        echo '<font color="red">File ('.$path.') could not be copied, likely a permissions problem.</font><br>';
                    }
                } 
				elseif(is_dir($basePath . $path))
				{
                    
                    
                    if(!is_dir($basePath . $dest . '/' . $file))
                    mkdir($basePath . $dest . '/' . $file."/",0777); // make subdirectory before subdirectory is copied
                    dircpy($basePath, $path, $dest . '/' . $file, $overwrite); //recurse!
                }
            }
        }
        closedir($handle);
    }
}

function com_install() 
{
	global $database, $mosConfig_absolute_path;
	//get component id
	
	$database -> setQuery("SELECT id FROM #__components WHERE name= 'SerrBizSEF'");
	$comp_id = $database -> loadResult();
	
	//delete admin menu images
	$database -> setQuery("UPDATE #__components SET admin_menu_link = '' WHERE name = 'SerrBizSEF'");
	$database -> query();

	//update admin menu images
	$database -> setQuery("UPDATE #__components SET admin_menu_img = '../administrator/components/com_serrbizsef/images/menu_comp.gif' WHERE id = '$comp_id'");
	$database -> query();

	$database -> setQuery("UPDATE #__components SET admin_menu_img = '../administrator/components/com_serrbizsef/images/module.png' WHERE parent='$comp_id' AND name = 'SEF URLs'");
	$database -> query();
	
	$database -> setQuery("UPDATE #__components SET admin_menu_img = '../administrator/components/com_serrbizsef/images/controlpanel.png' WHERE parent='$comp_id' AND name = 'Configuration'");
	$database -> query();
    
    dircpy($mosConfig_absolute_path, "/administrator/components/com_serrbizsef/modules", "/modules", true);

	@mkdir($mosConfig_absolute_path.'/components/com_sef');
	$source = $mosConfig_absolute_path.'/administrator/components/com_serrbizsef/sef.php';
	$destination = $mosConfig_absolute_path.'/components/com_sef/sef.php';
	
	if (@copy($source, $destination) == false) {
		echo '<b>Component installation is not 100% complete,! you have to <br /> manually copy file '.$source.' to '.$destination.'</b><br />';
	}
	
	
	// install module
	$database->setQuery( "INSERT INTO `#__modules` (`title`, `content`, `ordering`, `position`, `checked_out`, `checked_out_time`, `published`, `module`, `numnews`, `access`, `showtitle`, `params`, `iscore`, `client_id`) VALUES ('SerrBizSEF Custom Tags', '', 2, 'footer', 0, '0000-00-00 00:00:00',1, 'mod_serrbizsefTags', 0, 0, 0, 'show_message=yes', 0, 0);");
	$database->query();

	$module_ID = $database->insertid();
	$database->setQuery( "INSERT INTO `#__modules_menu` (`moduleid`, `menuid`) VALUES ($module_ID, 0);");
	$database->query();
	
	$mod_source = $mosConfig_absolute_path.'/administrator/components/com_serrbizsef/modules/mod_serrbizsef_tags/mod_serrbizsefTags.php';
	$mod_dest   = $mosConfig_absolute_path.'/modules/mod_serrbizsefTags.php';
	
	/*
	if (@copy($mod_source, $mod_dest) == false) {
		echo '<b>Module installation is not 100% complete,! you have to <br /> manually copy file '.$mod_source.' to '.$mod_dest.'</b><br />';
	}
	$mod_source = $mosConfig_absolute_path.'/administrator/components/com_serrbizsef/modules/mod_serrbizsef_tags/mod_serrbizsefTags.tmp';
	$mod_dest   = $mosConfig_absolute_path.'/modules/mod_serrbizsefTags.tmp';
	if (@copy($mod_source, $mod_dest) == false) {
		echo '<b>Module installation is not 100% complete,! you have to <br /> manually copy file '.$mod_source.' to '.$mod_dest.'</b><br />';
	}
	*/

	@rename( $mosConfig_absolute_path. '/modules/mod_serrbizsefTags.tmp',$mosConfig_absolute_path.'/modules/mod_serrbizsefTags.xml');
	echo '<p style="font-family: verdana;font-size:12px;text-align: left;">
	Please read detailed installation notes available at 
	Serr.biz: <a href="http://www.serr.biz/ask-a-question/joomla-seo-serrbizsef.html" target="_blank">SerrBizSEF Notes</a>
	</p>';
}//com_install() 
?>