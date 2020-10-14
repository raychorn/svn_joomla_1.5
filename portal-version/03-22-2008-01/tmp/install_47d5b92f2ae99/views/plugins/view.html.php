<?php
/* @version		$Id: view.html.php 230 2008-02-20 19:17:37Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

jimport( 'joomla.application.component.view');
class pluginsViewplugins extends JView
{
	function view( $tpl = null)	{
		global $mainframe, $option;
		$document =& JFactory::getDocument();
		$document->addStyleSheet( '/administrator/components/com_smartsef/includes/smartsef.css');

		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'id',			'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );

		$search				= $mainframe->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );

		$filter_state		= $mainframe->getUserStateFromRequest( $option.'filter_state',			'filter_state',			'',				'filter_state' );

		// Get data from the model
		$items		= & $this->get( 'Data');
		$total		= & $this->get( 'Total');
		$pagination = & $this->get( 'Pagination' );

		// build list of categories
		$javascript 	= 'onchange="document.adminForm.submit();"';

		// state filter
		$lists['state']	= JHTML::_('grid.state',  $filter_state );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] 	= $filter_order;

		// search filter
		$lists['search']= $search;

		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$items);
		$this->assignRef('pagination',	$pagination);

		parent::display($tpl);

	}

}

?>
