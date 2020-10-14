<?php
/**
 * 
 * @version $Id: toolbar.rd_rss.html.php,v 1.1.1.1 2005/12/20 15:49:40 deutz Exp $
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

class toolbarRdRss {

/**
* Draws the menu for List
*/
	
	function LIST_ITEM()
	{
		mosMenuBar::startTable();
		mosMenuBar::publishList();
		mosMenuBar::spacer();
		mosMenuBar::unpublishList();
		mosMenuBar::spacer();
		mosMenuBar::deleteList("","del");
		mosMenuBar::spacer();
		mosMenuBar::editListX("editA");
		mosMenuBar::spacer();
		mosMenuBar::addnewX("new");
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

/**
* Draws the menu for edit list
*/
	
	function EDIT_ITEM()
	{
		mosMenuBar::startTable();
		mosMenuBar::save("save");
		mosMenuBar::spacer();
		mosMenuBar::apply("apply");
		mosMenuBar::spacer();
		mosMenuBar::cancel("cancel");
		mosMenuBar::endTable();
	}

}
?>