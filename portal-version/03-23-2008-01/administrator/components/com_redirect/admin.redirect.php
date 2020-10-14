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

require_once($mainframe->getPath('admin_html'));
require_once($mainframe->getPath('class'));

$act = mosGetParam($_REQUEST, 'act');
$task = mosGetParam($_REQUEST, 'task');
$cid = mosGetParam($_REQUEST, 'cid', array());

if(!is_array($cid)){
  $cid = array($cid);
}

switch($act){
  case 'config';
    swConfig($task);
    break;
  default:
    swRedirect($task, $cid);
    break;
}

/**
 * Switch for redirect/default act
 *
 * @param string $task
 * @param array $cid
 */
function swRedirect($task, $cid){
  switch ($task){
    case 'new':
      redirect::editRedirect(0);
      break;
    case 'edit':
    case 'editA':
      redirect::editRedirect($cid[0]);
      break;
    case 'save':
    case 'apply':
      redirect::saveRedirect();
      break;
    case 'remove':
      redirect::removeRedirects($cid);
      break;
    default:
      redirect::showRedirects();
      break;
  }
}

/**
 * Switch for configuration act
 *
 * @param string $task
 */
function swConfig($task){
  switch ($task){
    case 'save':
      redirect::saveConfiguration();
      break;
    default:
      HTML_redirect::showConfiguration();
      break;
  }
}
?>