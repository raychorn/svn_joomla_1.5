<?php
/**
* @version $Id: toolbar.serrbizsef.php 2007-10-19 11:19:30 $
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
if (!($acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'all') || $acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'com_dailymessage'))) {
    mosRedirect('index2.php', _NOT_AUTH);
}

require_once($mainframe->getPath('toolbar_html'));

switch ($task) 
{

  case 'special_sef':
  case 'remove_special':
  case 'save_special_sef';
  case 'manage_special_sef':
    //TOOLBAR_sb::defaultButtons(); 
	TOOLBAR_sb::manageSpecialSEFs();
  break;

  case 'config':  
    TOOLBAR_sb::editConfigButtons();   
     break;    

  case 'save_config':
    TOOLBAR_sb::editConfigButtons();
    break;        

  case 'edit':      
    TOOLBAR_sb::editButtons();
    break;    

  case 'apply':
    TOOLBAR_sb::editButtons();
    break;              

  case 'set_link':
    Toolbar_sb::editLinkButtons();
    break;  

  case 'imported_sef_list':
  case 'inactive_import':
  case 'active_import':
    Toolbar_sb::editImportButtons();
  break;

  default: 
    TOOLBAR_sb::defaultButtons();
    break;

}

?>