<?php
/**
* @package Redirect
* @copyright (C) 2006 Joomla-addons.org
* @author Websmurf
* 
* --------------------------------------------------------------------------------
* All rights reserved.  Redirect is a component for Joomla and Mambo. 
* You can use it to redirect your old pages to your new ones.
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the Creative Commons - Attribution-NoDerivs 2.5 
* license as published by the Creative Commons Organisation
* http://creativecommons.org/licenses/by-nd/2.5/.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
* --------------------------------------------------------------------------------
**/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function com_install(){
  global $mainframe, $database;
  
  //Updates menu option
  $query = "UPDATE #__components 
    SET admin_menu_img='../administrator/components/com_redirect/icons/16x16_redo.png' 
    WHERE admin_menu_link='option=com_redirect'";
  $database->setQuery($query);
  if(!$database->query()){  
    echo $database->getErrorMsg() . '<br />';
  }
  //Updates menu option
  $query = "UPDATE #__components 
    SET admin_menu_img='js/ThemeOffice/config.png' 
    WHERE admin_menu_link='option=com_redirect&act=config'";
  $database->setQuery($query);
  if(!$database->query()){  
    echo $database->getErrorMsg() . '<br />';
  }
  
  //create mambot
  if(!copy($mainframe->getCfg('absolute_path') . '/administrator/components/com_redirect/mambot/redirect.xm', $mainframe->getCfg('absolute_path') . '/mambots/system/redirect.xml')){
    echo '<b>Failed</b> to copy mambot xml file<br />';
  }
  if(!copy($mainframe->getCfg('absolute_path') . '/administrator/components/com_redirect/mambot/redirect.php', $mainframe->getCfg('absolute_path') . '/mambots/system/redirect.php')){
    echo '<b>Failed</b> to copy mambot php file<br />';
  }
  
  $mambot = new mosMambot($database);
  $mambot->name = 'Redirect mambot';
  $mambot->element = 'redirect';
  $mambot->folder = 'system';
  $mambot->ordering = 1;
  $mambot->published = 1;
  
  if (!$mambot->store()) {
    echo 'Mambot install failed: ' .$mambot->getError().'<br />';
  }
}

?>