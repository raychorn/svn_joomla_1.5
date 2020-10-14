<?php
/**
* @version		$Id: smartsef_urls.php 163 2008-01-24 21:12:14Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
class Tablesmartsef_urls extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id 	 		= null;
	var $url_sef 		= null;
	var $url_orginal 	= null;
	var $cache 			= null;
	var $published		= null;
	var $valid			= null;
	var $remarks		= null;
	var $delete_locked 	= null;
	var $temp_key		= null;
	var $ordering		= null;
	var $vars			= null;
	var $block_rewrite	= null;
	var $sef_tmp_url	= null;

	function Tablesmartsef_urls (& $db) {
		parent::__construct('#__smartsef_urls', 'id', $db);
	}

}
