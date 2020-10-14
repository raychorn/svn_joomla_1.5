<?php
/**
* @version $Id: serrbizsef.config.php 2007-10-19 11:19:30 $
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
/**
*@desc configuration for com_serrbizsef
*@global SB_Active, SB_SEF_Active, SB_MeatInfo_Active,TBL_SBZ_SEF,TBL_SBZ_CONFIG
*@global SBZ_PTITLE, SBZ_MTITLE, SBZ_MKEYWORDS, SBZ_MDESC, SBZ_MROBOT
*@global SBZ_ALLOW_REDIRECT, SBZ_CUSTOM_ERROR
*@global strings_type_not_to_be_saved
*/
    global $SB_Active, $SB_SEF_Active, $SB_MeatInfo_Active; 
    global $TBL_SBZ_SEF,$TBL_SBZ_CONFIG;
    global $SBZ_PTITLE, $SBZ_MTITLE, $SBZ_MKEYWORDS, $SBZ_MDESC, $SBZ_MROBOT;
    global $SBZ_ALLOW_REDIRECT,$SBZ_CUSTOM_ERROR;  
	global $strings_type_not_to_be_saved;
	$strings_type_not_to_be_saved = array();
	
	$strings_type_not_to_be_saved[0]='option=com_virtuemart&page=shop.downloads';
	$strings_type_not_to_be_saved[1]='serrbizflt=';
	
	//$strings_type_not_to_be_saved[]='com_registration';
	$strings_type_not_to_be_saved = array_merge($strings_type_not_to_be_saved);

    //table defines
    define('TBL_SBZ_SEF','#__serrbizsef_sef');
    define('TBL_SBZ_CONFIG','#__serrbizsef_config');
    define('TBL_SBZ_COMP','#__serrbizsef_components');
    
    $filepath = $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_serrbizsef/admin.serrbizsef.class.php';

    if(file_exists($filepath))
    {
        require_once($filepath);        
        $objSB = new sbAdmin();
        $objSB->sbGetConfig();
        //set the value into global vars
        $SB_Active          = $objSB->isSBActive;
        $SB_SEF_Active      = $objSB->isSEFActive;
        $SB_MeatInfo_Active = $objSB->isMetaInfoActive; 
        $SBZ_ALLOW_REDIRECT = $objSB->isRedirectActive;  
        $SBZ_CUSTOM_ERROR   = $objSB->strCustomError;              
        unset($objSB);        
    }                           
    unset($filepath);          
?>