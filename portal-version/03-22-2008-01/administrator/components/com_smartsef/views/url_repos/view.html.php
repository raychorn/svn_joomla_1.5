<?php
/* @version		$Id: view.html.php 210 2008-02-04 21:31:34Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

jimport( 'joomla.application.component.view');
class url_reposViewurl_repos extends JView
{
	function view( $tpl = null)	{
		global $mainframe, $option;
		$document =& JFactory::getDocument();
  		$document->addStyleSheet( '/administrator/components/com_smartsef/includes/smartsef.css');

		$filter_state		= $mainframe->getUserStateFromRequest( $option.'filter_state',		'filter_state',		'',				'word' );
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'id',			'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );
		$filter_locked		= $mainframe->getUserStateFromRequest( $option.'filter_locked', 	'filter_locked',	'-1',			'int' );
		$filter_blocked		= $mainframe->getUserStateFromRequest( $option.'filter_blocked', 	'filter_blocked',	'-1',			'int' );
		$search				= $mainframe->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );

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

		// deleted locked filter

		$deleted_list[] = JHTMLSelect::Option( '-1', JTEXT::_('VW_URL_REPOS_SELECT_LOCKED') );
		$deleted_list[] = JHTMLSelect::Option( '0', JTEXT::_('VW_URL_REPOS_SELECT_MAY_DELETED') );
		$deleted_list[] = JHTMLSelect::Option( '1', JTEXT::_('VW_URL_REPOS_SELECT_LOCKED_FOR_DEL') );
		$javascript 	= 'onchange="document.adminForm.submit();"';
   	   	$lists['deleted_list'] = JHTMLSelect::genericlist( $deleted_list, 'filter_locked', 'class="inputbox" size="1 "' . $javascript,'value', 'text', $filter_locked );

   	   	$blocked_list[] = JHTMLSelect::Option( '-1', JTEXT::_('VW_URL_REPOS_SELECT_REWRITE_STATE') );
		$blocked_list[] = JHTMLSelect::Option( '0', JTEXT::_('VW_URL_REPOS_SELECT_MAYBE') );
		$blocked_list[] = JHTMLSelect::Option( '1', JTEXT::_('VW_URL_REPOS_SELECT_MAYNOT') );
		$javascript 	= 'onchange="document.adminForm.submit();"';
   	   	$lists['blocked_list'] = JHTMLSelect::genericlist( $blocked_list, 'filter_blocked', 'class="inputbox" size="1 "' . $javascript,'value', 'text', $filter_blocked );


		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$items);
		$this->assignRef('pagination',	$pagination);

		parent::display($tpl);

	}
}


?>
