<?php
/**
 * 
 * @version $Id: toolbar.rd_rss.php,v 1.1.1.1 2005/12/20 15:49:40 deutz Exp $
 * @package RdRss
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 * 
 * This is free software
 * 
 * changed to show all sections and categories as rss feed by Robert Deutz 
 *         joomla at run-digital dot com
 **/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

require_once( $mainframe->getPath( 'toolbar_html' ) );


switch ($task) {
	case "apply":
	case "new":
	case "edit":
	case "editA":
		toolbarRdRss::EDIT_ITEM();		
		break;

	case "list":
	default:
		toolbarRdRss::LIST_ITEM();		
		break;

}
	

?>