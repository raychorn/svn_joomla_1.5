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

function com_uninstall(){
  global $mainframe, $database;
  //remove mambot as well...  
  
  unlink($mainframe->getCfg('absolute_path') . '/mambots/system/redirect.xml');
  unlink($mainframe->getCfg('absolute_path') . '/mambots/system/redirect.php');
  
  $query = "DELETE FROM #__mambots WHERE folder = 'system' AND element = 'redirect'";
  $database->setQuery($query);
  $database->query();
}

?>