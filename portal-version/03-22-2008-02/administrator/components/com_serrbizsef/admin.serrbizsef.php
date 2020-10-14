<?php
/**
* @version $Id: admin.serrbizsef.php 2007-10-19 11:19:30 $
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
defined( '_VALID_MOS' ) or die( 'Restricted access' );

// ensure user has access to this function
if (!($acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'all') || $acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'com_dailymessage'))) 
{
    mosRedirect('index2.php', _NOT_AUTH);
}
//echo "111111111111";

global  $mainframe;
require_once($mainframe->getPath('admin_html'));
//echo $mainframe->getPath('admin_html');

//require_once($mainframe->getPath('admin_html'));

echo '<form action="index2.php" method="post" name="adminForm" enctype="multipart/form-data">'; 
//get id


$sef = mosGetParam( $_REQUEST, 'cid' );
if(is_array($sef)) {
    $sef_id = $sef[0];
}
$id = mosGetParam($_REQUEST,'id');    
if(isset($id)) {
    $sef_id = $id;
}


//check task and call related functions.
switch ($task) 
{
  case 'save_special_sef':
		HTML_sb::sbSaveSpecialSefURL();
        HTML_sb::sbSpecialSEFConfiguration(12);
  break;
   
  case 'manage_special_sef':
    HTML_sb::sbSpecialSEFConfiguration(12);
  break;
  
  case 'remove_special':
    HTML_sb::sbDeletePage($sef);
    HTML_sb::sbSpecialSEFConfiguration(12);
  break;
  
  case 'apply':
    $status = HTML_sb::sbCheckDuplicate($sef_id);
    if($status == 0) 
    {
        HTML_sb::sbSavePage($sef_id);
        HTML_sb::sbEditPage($sef_id);
    }else{
        $task = 'edit';
        HTML_sb::sbEditPage($sef_id);
    }            
    break;
  case 'remove':
    HTML_sb::sbDeletePage($sef);
    HTML_sb::sbDisplayPageList();
    break;
  case 'save':
    $status = HTML_sb::sbCheckDuplicate($sef_id);
    if($status == 0) 
    {
        HTML_sb::sbSavePage($sef_id);
		$singleRecInfo = HTML_sb::sbGetSingleRecord($sef_id);
		
		// Checking where to redirect "Manage Special SEF" OR "SEF URLs" 
		if(  (isset($singleRecInfo[0])) &&  ($singleRecInfo[0]->sef_type == 1 || $singleRecInfo[0]->sef_type == 2) )
		{
		  //if (sef_type==1 || sef_type==2) it means it is 301 redirect URL then we will redirect user to "Manage Special SEF" 
    	   // HTML_sb::sbSpecialSEFConfiguration(12);
		   mosRedirect("index2.php?option=com_serrbizsef&task=manage_special_sef");
		}
		else
		{
		  //if (sef_type==0) it means it is SerrBizSEF URL then we will redirect user to "SEF URLs" 
		   mosRedirect("index2.php?option=com_serrbizsef&task=sef_list");
         // HTML_sb::sbDisplayPageList();
		}  
		unset($singleRecInfo);
    }else{
        $task = 'edit';
        HTML_sb::sbEditPage($sef_id);
    }            
    break;
  case 'edit':
    HTML_sb::sbEditPage($sef_id);
    break;    
  case 'config':
    HTML_sb::sbConfiguration();
    break;
  case 'save_config':
    HTML_sb::sbSaveConfig();
    HTML_sb::sbConfiguration();
    break; 
  case 'drop_index':    
  case 'set_index': 
  case 'drop_follow':
  case 'set_follow':
  case 'link_high':
  case 'link_low':
    HTML_sb::sbSaveSettings($sef_id);
    HTML_sb::sbDisplayPageList();
    break;             
  case 'set_link':
    HTML_sb::sbSetNewLink($sef_id);                
  break;  
  
  case 'save_link':
    HTML_sb::sbSaveNewLink();    
    HTML_sb::sbDisplayPageList();            
  break;  
  
  case 'apply_link':
    HTML_sb::sbSaveNewLink();                
    $task = 'set_link';
    if(mosGetParam($_REQUEST,'lstInternal')){
       $sef_id = mosGetParam($_REQUEST,'lstInternal');  
    }
    HTML_sb::sbSetNewLink($sef_id);    
  break;  
  
  case 'imported_sef_list':
    HTML_sb::sbDisplayImportList();
  break;
  
  case 'inactive_import':
    HTML_sb::sbSetImportSEFInactive();
    HTML_sb::sbDisplayImportList();
  break;
  
  case 'active_import':
    HTML_sb::sbSetImportSEFActive();
    HTML_sb::sbDisplayImportList();
  break;
  case 'special_sef':
        //if($sef_url_type == 0 ) It will call serrBizSef URLs
        //if($sef_url_type == 1 ) It will call 301 redirect for internal URLs
        //if($sef_url_type == 2 ) It will call 301 redirect for EXTERNAL URLs
        //if($sef_url_type == 12 )It will both ( 301 redirect for EXTERNAL URLs && 301 redirect for EXTERNAL URLs ) 
		$sef_url_type = 12;
        HTML_sb::sbDisplayPageList($sef_url_type);
		unset($sef_url_type);
  break;
  
  case 'sef_list':      
  default: 

    HTML_sb::sbDisplayPageList();

    break;

}

?> 

<input type="hidden" name="option" value="com_serrbizsef" />
<input type="hidden" name="task" value="<?php echo $task;?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="hidemainmenu" value="0" />
</form>
<div align="center" style="clear:both"><BR>
<a href="http://www.serr.biz/" target="_blank">&copy; 2007 by Serr.biz LLC</A><br>
<font style="font-size:11px">
SerrBizSEF is a released under the terms of the GNU 
<a href="http://www.serr.biz/serrbiz-gpl-joomla.html">General Public License</a>
</font>
</div>

