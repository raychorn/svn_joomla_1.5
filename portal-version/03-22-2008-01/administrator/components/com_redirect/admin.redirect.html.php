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

class HTML_redirect{
  
  /**
   * Display all redirects...
   * 
   * @param array $rows
   * @param <var>mosPageNav</var> $pageNav
   */
  function showRedirects($rows, $pageNav){
    global $option;
    
    HTMLhelper::heading('View all redirects');
    HTMLhelper::formHeader();
    ?>
    
    <table class="adminform">
	  <tr>
	    <th width="10">#</th>
	    <th width="10">&nbsp;</th>
	    <th>Old url</th>
	    <th>New url</th>
	    <th>Error code</th>
	    <th>Hits</th>
	  </tr>
    <?php
    for($i=0,$n=count($rows);$i<$n;$i++){
      $row = $rows[$i];
      ?>
      <tr>
        <td><?php echo $i+1+$pageNav->limitstart; ?></td>
	      <td><?php echo mosHTML::idBox( $i, $row->id ); ?></td>
	      <td><a href="index2.php?option=<?php echo $option; ?>&task=editA&cid=<?php echo $row->id; ?>&hidemainmenu=1"><?php echo $row->original; ?></a></td>
	      <td><?php echo $row->redirect; ?></td>
	      <td><?php echo $row->error_code; ?></td>
	      <td><?php echo $row->hits; ?></td>
	    </tr>
      <?php
    }
    ?>
    </table>
    <?php    
    echo $pageNav->getListFooter();
    HTMLhelper::formFooter('');
  }
  
  /**
   * Edit a redirect
   *
   * @param <var>dbRedirect</var> $row
   * @param array lists
   */
  function editRedirect($row, $lists){
    global $option;
    
    HTMLhelper::heading('Edit a redirect');
    HTMLhelper::formHeader();
    ?>
    <table class="adminform">
		<tr>
			<th colspan="2">
				Redirect details
			</th>
		</tr>
		<tr>
		  <td width="150">Old url</td>
		  <td><input type="text" name="original" value="<?php echo $row->original; ?>" size="50" /></td>
		</tr>
		<tr>
		  <td>Redirect to</td>
		  <td><input type="text" name="redirect" value="<?php echo $row->redirect; ?>" size="50" /></td>
		</tr>
		<tr>
		  <td>Error code</td>
		  <td><?php echo $lists['error_code']; ?></td>
		</tr>
	  </table>
    <?php
    HTMLhelper::formFooter('', $row->id);
  }
  
  /**
   * Display all configuration...
   */
  function showConfiguration(){
    global $option, $config_path;
    
    HTMLhelper::heading('Edit configuration');
    HTMLhelper::formHeader();
    
    if(!isset($_SERVER['REQUEST_URI'])){
      $url = str_replace($config_path, '', $_SERVER['QUERY_STRING']);
    } else {
      $url = str_replace($config_path, '', $_SERVER['REQUEST_URI']);
    }
    ?>
    
    <table class="adminform">
	  <tr>
	    <th colspan="2">Configuration</th>
	  </tr>
	  <tr valign="bottom">
	    <td width="100">Path:</td>
	    <td>
	      <strong><?php echo $url; ?></strong> is your current path<br />
	      <strong>administrator/index2.php?option=com_redirect&act=config</strong> is the path it should be<br />
	      Suggested path: <input type="text" name="config_path" value="<?php echo str_replace('administrator/index2.php?option=com_redirect&act=config', '', $url); ?>" />
	    </td>
	  </tr>
    </table>
    <?php    
    HTMLhelper::formFooter('config');
  }
}
  
class HTMLhelper{ 
  /**
   * Display form header
   *
   */
  function formHeader(){
    ?>
    <form action="index2.php" method="post" name="adminForm">
    <?php
  }
  
  function formFooter($act, $id = null){
    if(!is_null($id)){
      echo '<input type="hidden" name="id" value="' . $id . '" />';
    }
    ?>
    <input type="hidden" name="act" value="<?php echo $act; ?>" />
    <input type="hidden" name="option" value="com_redirect" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
    </form>
    <div class="small"><br />Powered by <a href="http://www.joomla-addons.org/redirect-component.html" target="_blank">Redirect</a> &copy; 2006 <a href="http://www.joomla-addons.org" target="_blank" title="Joomla components, modules, plugins and hosting">Joomla-addons.org</a></div>
    <?php
  }
  
  function heading($title, $html = ''){
    ?>
    <table class="adminheading" border="0"><tr><th nowrap><?php echo $title; ?></th><?php echo $html; ?></tr></table>
    <?php
  }
}

?>