<?php
/* @version		$Id: view.html.php 235 2008-03-08 13:38:30Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

jimport( 'joomla.application.component.view');
class routes_settingsViewroutes_settings extends JView
{

	function view ( $tpl = null ) {
		$document =& JFactory::getDocument();
		$document->addStyleSheet( '/administrator/components/com_smartsef/includes/smartsef.css');

		// Get data from the model
		$items		= & $this->get( 'Data');

		foreach ( $items as $item ) {
			// make a select list;
			$selections = array();
			if ( $item->router_type == 1 ) {
				$selections[] = JHTML::_('select.option',  1, JTEXT::_('VW_URL_ROUTER_SELECT_ENABLE'));
				$selections[] = JHTML::_('select.option',  0, JTEXT::_('VW_URL_ROUTER_SELECT_DISABLE')) ;
				$selections[] = JHTML::_('select.option',  2, JTEXT::_('VW_URL_ROUTER_SELECT_USE_SMARSEF'));
			}
			if ( $item->router_type == 2 ) {
				$selections[] = JHTML::_('select.option', 1 , JTEXT::_('VW_URL_ROUTER_SELECT_WITH_ALIAS'));
				$selections[] = JHTML::_('select.option', 3 , JTEXT::_('VW_URL_ROUTER_SELECT_WITHOUT_ALIAS'));
				$selections[] = JHTML::_('select.option', 0 , JTEXT::_('VW_URL_ROUTER_SELECT_DISABLE_J10'));
				$selections[] = JHTML::_('select.option', 2 , JTEXT::_('VW_URL_ROUTER_SELECT_USE_SMARSEF'));
			}
			if ( $item->router_type == 0 ) {
				$selections[] = JHTML::_('select.option', 0,  JTEXT::_('VW_URL_ROUTER_SELECT_DISABLERWRITE'));
				$selections[] = JHTML::_('select.option', 2, JTEXT::_('VW_URL_ROUTER_SELECT_USE_SMARSEF'));
			}

			$fieldname = 'rewrite_rule[' . $item->id . ']';
			$item->router_select = JHTML::_('select.genericlist',  $selections, $fieldname, 'class="inputbox" size="1"', 'value', 'text', $item->rewrite_rule);
			$fieldname_bypass_post = 'bypass_post_redirect[' . $item->id. ']';
			$item->bypass_post_redirect = $lists['mode'] = JHTMLSelect::booleanlist( $fieldname_bypass_post, null,$item->bypass_post_redirect );

		}
		$this->assignRef('items',		$items);


		parent::display($tpl);


	}


}
?>