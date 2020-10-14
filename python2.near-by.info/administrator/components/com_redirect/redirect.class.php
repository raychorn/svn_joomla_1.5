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

$version = '1.0 beta 1';

class redirect{
  
  /**
   * Show all defined redirects
   *
   */
  function showRedirects(){
    global $database, $mainframe, $option;
    
    $limit = $mainframe->getUserStateFromRequest( "view{$option}listlimit", 'limit', $mainframe->getCfg('list_limit') );
    $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
    
    $query = "SELECT COUNT(1) FROM #__redirect";
    $database->setQuery($query);
    $total = $database->loadResult();
    
    require_once($mainframe->getCfg('absolute_path') . '/administrator/includes/pageNavigation.php');
    $pageNav = new mosPageNav($total, $limitstart, $limit);
    
    $query = "SELECT * 
      FROM #__redirect 
      ORDER BY original ASC
      LIMIT $limitstart, $limit";
    $database->setQuery($query);
    $rows = $database->loadObjectList();
    
    HTML_redirect::showRedirects($rows, $pageNav);
  }
  
  /**
   * Edit redirect
   *
   * @param int $id
   */
  function editRedirect($id){
    global $database;
    
    $row = new dbRedirect($database);
    $row->load($id);
    
    $options = array();
    $options[] = mosHTML::makeOption(301, '301 Moved Permanently');
    $options[] = mosHTML::makeOption(307, '307 Temporary Redirect');
    $lists['error_code'] = mosHTML::selectList($options, 'error_code', '', 'value', 'text', $row->error_code);
    
    HTML_redirect::editRedirect($row, $lists);
  }
  
  /**
   * Save redirect
   *
   */
  function saveRedirect(){
    global $database, $option, $task;
    
    $row = new dbRedirect($database);
    $row->bind($_POST);
    
    if (!$row->check()) {
    	echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    	exit();
    }
    
    if (!$row->store()) {
    	echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    	exit();
    }
    
  	switch ($task) {
  		case 'apply':
  			$link = 'index2.php?option=' . $option . '&task=edit&cid='. $row->id .'&hidemainmenu=1';
  			break;
  		
  		case 'save':
  		default:
  			$link = 'index2.php?option=' . $option . '';
  			break;
  	}

  	mosRedirect($link, 'Redirect saved');
  }
  
  function removeRedirects($cid){
    global $database, $option;
    
    $ids = implode(",", $cid);
    
    $query = "DELETE FROM #__redirect WHERE id IN($ids)";
    $database->setQuery($query);
    if(!$database->query()){
      echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
    	exit();
    }
    
    mosRedirect('index2.php?option=' . $option . '', 'Redirect(s) removed');
  }
  
  function saveConfiguration(){
    global $option, $mainframe;
    
    $config_path = mosGetParam($_REQUEST, 'config_path', '/');
    
    $string = "<?php \n\n \$config_path = '$config_path'; \n\n ?>";
    if(!is_writable($mainframe->getCfg('absolute_path') . '/administrator/components/com_redirect/configuration.php')){
      mosRedirect('index2.php?option=' . $option . '&act=config', 'Configuration file is not writable');
      exit;
    }
    $fp = fopen($mainframe->getCfg('absolute_path') . '/administrator/components/com_redirect/configuration.php', 'w+');
    fwrite($fp, $string);
    fclose($fp);
    
    mosRedirect('index2.php?option=' . $option . '', 'Configuration saved');
  }
}


class dbRedirect extends mosDBTable {
  /** @var int id **/
  var $id = null;
  /** @var string old url **/
  var $original = null;
  /** @var string new url **/
  var $redirect = null;
  /** @var int error_code **/
  var $error_code = null;
  /** @var int hits **/
  var $hits = null;
  
  function dbRedirect(&$db){
    $this->mosDBTable('#__redirect', 'id', $db);
  }
}
?>