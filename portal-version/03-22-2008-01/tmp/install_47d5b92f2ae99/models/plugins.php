<?php
/**
* @version		$Id: plugins.php 167 2008-01-24 22:41:05Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class pluginsModelplugins extends Jmodel {

	var $_data 			= null;
	var $_total 		= null;
	var $_pagination 	= null;
	var $_xml			= null;

	function __construct()	{
		parent::__construct();

		global $mainframe, $option;

		// Get the pagination request variables
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $option.'limitstart', 'limitstart', 0, 'int' );

		$this->setState('limit', 		$limit		);
		$this->setState('limitstart',	$limitstart	);
	}

	function save ( $id ) {
		$smartsef_record =& JTable::getInstance('smartsef_plugins', 'Table');
		$post	= JRequest::get( 'post' );
		if ( !$smartsef_record->load ( $id ) ) {
			return JError::raiseWarning( 500, $smartsef_record->getError() );
		}
		if (!$smartsef_record->bind( $post )) {
			return JError::raiseWarning( 500, $smartsef_record->getError() );
		}
		return $smartsef_record->store();
	}

	function delete ( $id ) {
		$smartsef_record =& JTable::getInstance('smartsef_plugins', 'Table');

		if ( !$smartsef_record->load ( $id ) ) {
			return JError::raiseWarning( 500, $smartsef_record->getError() );
		}

		return $smartsef_record->delete( $id, $smartsef_record->plugin );

	}

	function publish ( $id ) {

		$plugin =& JTable::getInstance('smartsef_plugins', 'Table');
		$plugin->load ( $id );

		// first remove the Joomla user account;
		if ( $plugin->published == 0 ) {
			$plugin->published = 1;
		} else {
			$plugin->published = 0;
		}
		$plugin->store();
	}

	function &getEditdata() {
		$cid 	= JRequest::getVar('cid', array(0), 'method', 'array');
		$this->_id = $cid[0];

		$plugin_record =& JTable::getInstance('smartsef_plugins', 'Table');

		$plugin_record->load ( $this->_id);
		$plugin_record->params =  $this->getParams( $plugin_record->params, $plugin_record->plugin);
		// Read the parametes;

		return ( $plugin_record );
	}


	function &_getXML( $plugin_name )	{
		if (!$this->_xml)
		{

			$xmlfile = JPATH_SITE .DS."administrator".DS."components".DS."com_smartsef".DS."plugins".DS.$plugin_name.'.xml';

			if (file_exists($xmlfile))
			{
				$xml =& JFactory::getXMLParser('Simple');
				if ($xml->loadFile($xmlfile)) {
					$this->_xml = &$xml;
				}
			}
		}
		return $this->_xml;
	}

	function &getParams( $params, $plugin_name )	{

		$params	= new JParameter( $params );

		if ($xml =& $this->_getXML( $plugin_name ))
		{
			if ($ps = & $xml->document->params) {
				foreach ($ps as $p)	{
					$params->setXML( $p );
				}
			}
		}
		return $params;
	}


	function getData()	{
		if (empty($this->_data)){
			$query = $this->_buildViewQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
		return $this->_data;
	}

	function getTotal() {
		if (empty($this->_total)){
			$query = $this->_buildViewQuery();
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}

	function getPagination(){
		if (empty($this->_pagination))	{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}


	function _buildViewQuery() 	{
		$where		= $this->_buildViewWhere();

		$query = ' SELECT *  FROM #__smartsef_plugins '
			. $where;
		return $query;
	}

	function _buildViewWhere()
	{
		global $mainframe, $option;

		$filter_state		= $mainframe->getUserStateFromRequest( $option.'filter_state',		'filter_state',		'',				'word' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'sef_url',		'word' );
		$search				= $mainframe->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );

		$where = array();
		if ($search) {
			$where[] = 'LOWER(name) LIKE '.$this->_db->Quote('%'.$search.'%');
		}
		if ( $filter_state ) {
			if ( $filter_state == 'P' ) {
				$where[] = 'published = 1';
			} else if ($filter_state == 'U' ) {
				$where[] = 'published = 0';
			}
		}
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		return $where;
	}




}