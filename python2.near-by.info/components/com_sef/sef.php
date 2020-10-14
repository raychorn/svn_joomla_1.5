<?php
/**
* @version $Id: sef.php 2007-10-19 11:19:30 $
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
	* includes SerrBizSEF config file
	*/
	require_once( $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_serrbizsef/serrbizsef.config.php');

	/**
	*@desc if SerrBizSEF is installed and SEF URLs are active and SerrBizSEF is active the include serrbizsef.sef.php else include joomla's default sef.php
	*/
	if(file_exists($mosConfig_absolute_path.'/administrator/components/com_serrbizsef/serrbizsef.sef.php') && $SB_Active==1 && $SB_SEF_Active==1) 
	{ 
		require_once($mosConfig_absolute_path.'/administrator/components/com_serrbizsef/serrbizsef.sef.php');
	}
	else
	{                
		require_once( $mosConfig_absolute_path .'/includes/sef.php' );    
	}

?>