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


$_MAMBOTS->registerFunction( 'onStart', 'botRedirect' );

function botRedirect(){
  global $database, $mosConfig_absolute_path, $mosConfig_debug;
  
  include($mosConfig_absolute_path . '/administrator/components/com_redirect/configuration.php');
  
  
  if($mosConfig_debug){
    echo 'REQUEST URI: ' . $_SERVER['REQUEST_URI'] . '<br />';
  }
  
  $url = substr($_SERVER['REQUEST_URI'], strlen($config_path));
//  $url = str_replace($config_path, '', $_SERVER['REQUEST_URI']);
//  $url = $_SERVER['REQUEST_URI'];
  if($mosConfig_debug){
    echo 'URL FOUND: ' . $url . '<br />';
  }
  
  $query = "SELECT * FROM #__redirect WHERE original = '$url'";
  $database->setQuery($query);
  $database->loadObject($row);
  
  if($mosConfig_debug){
    echo 'MATCH IN DATABASE: <pre>';
    print_r($row);
    echo '</pre><br />';
    die;
  }

  if(!empty($row)){
    switch($row->error_code){
      case '301':
        header("HTTP/1.0 301 Moved Permanently");
        header("Location: " . $row->redirect);
        exit;
      case '307':
        header("HTTP/1.0 307 Temporary Redirect");
        header("Location: " . $row->redirect);
        exit;
    }
  }
}

?>