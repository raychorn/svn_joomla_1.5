<?php
/**
* @version		$Id: url_repos.php 220 2008-02-10 21:31:18Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class url_reposModelurl_repos extends Jmodel {

	var $_data 			= null;
	var $_total 		= null;
	var $_pagination 	= null;

	function __construct()	{
		parent::__construct();

		global $mainframe, $option;

		// Get the pagination request variables
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $option.'limitstart', 'limitstart', 0, 'int' );

		$this->setState('limit', 		$limit		);
		$this->setState('limitstart',	$limitstart	);
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
			$total = $this->getTotal();
			if ( $total < ( $this->getState('limitstart') + $this->getState('limit')) ) {
				$limit_start = 0;
			} else {
				$limit_start = $this->getState('limitstart');
			}
			$this->_pagination = new JPagination( $total, $limit_start, $this->getState('limit') );
		}
		return $this->_pagination;
	}


	function _buildViewQuery() 	{
		$where		= $this->_buildViewWhere();
		$orderby	= $this->_buildViewOrderBy();

		$query = ' SELECT *  FROM #__smartsef_urls '
			. $where
			. $orderby;
		return $query;
	}

	function _buildViewWhere()
	{
		global $mainframe, $option;

		$filter_state		= $mainframe->getUserStateFromRequest( $option.'filter_state',		'filter_state',		'',				'word' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'sef_url',		'word' );
		$search				= $mainframe->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		$filter_locked		= $mainframe->getUserStateFromRequest( $option.'filter_locked', 	'filter_locked',	-1,				'int' );
		$filter_blocked		= $mainframe->getUserStateFromRequest( $option.'filter_blocked', 	'filter_blocked',	-1,				'int' );
		$search				= JString::strtolower( $search );

		$where = array();
		if ($search) {
			$where[] = 'LOWER(url_sef) LIKE '.$this->_db->Quote('%'.$search.'%');
		}
		if ( $filter_state ) {
			if ( $filter_state == 'P' ) {
				$where[] = 'published = 1';
			} else if ($filter_state == 'U' ) {
				$where[] = 'published = 0';
			}
		}
		if ( $filter_locked != -1) {
			$where[] = 'delete_locked =' . $filter_locked;
		}
		if ( $filter_blocked != -1) {
			$where[] = 'block_rewrite =' . $filter_blocked;
		}
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		return $where;
	}

	function _buildViewOrderBy() {
		global $mainframe, $option;

		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'url_sef',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'ASC',		'word' );

		if ($filter_order == 'a.ordering'){
			$orderby 	= ' ORDER BY category, ordering '.$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir ;
		}
		return $orderby;
	}

	// Switch the deletion lock of the specific URLSEF record
	function lock ( $id) {
		$sefurl =& JTable::getInstance('smartsef_urls', 'Table');
		$sefurl->load ( $id );

		if ( $sefurl->delete_locked == 0 ) {
			$sefurl->delete_locked = 1;
		} else {
			$sefurl->delete_locked = 0;
		}
		$sefurl->store();
	}

	function block ( $id) {
		$sefurl =& JTable::getInstance('smartsef_urls', 'Table');
		$sefurl->load ( $id );

		if ( $sefurl->block_rewrite == 0 ) {
			$sefurl->block_rewrite = 1;
			$sefurl->sef_tmp_url = $sefurl->url_sef ;
			$sefurl->url_sef = $sefurl->url_orginal;
		} else {
			$sefurl->block_rewrite = 0;
			$sefurl->url_sef = $sefurl->sef_tmp_url;
		}
		$sefurl->store();
	}

	function activate ( $id ) {
		$sefurl =& JTable::getInstance('smartsef_urls', 'Table');
		$sefurl->load ( $id );

		// set the ordering to 0
		$sefurl->ordering = 0;
		$sefurl->store();

		// update all same SEF urls with a ordering of 0;
		$query =  "UPDATE #__smartsef_urls SET ordering = 100 WHERE url_sef = '" . $sefurl->url_sef . "' AND id != " .  $sefurl->id;
		$this->_db->setQuery( $query);
		$this->_db->query();

	}

	function publish ( $id) {
		$sefurl =& JTable::getInstance('smartsef_urls', 'Table');
		$sefurl->load ( $id );

		// first remove the Joomla user account;
		if ( $sefurl->published == 0 ) {
			$sefurl->published = 1;
		} else {
			$sefurl->published = 0;
		}
		$sefurl->store();
	}

	function delete ( $id) {
		$sefurl =& JTable::getInstance('smartsef_urls', 'Table');
		$sefurl->load ( $id );

		// first remove the Joomla user account;
		if ( $sefurl->delete_locked == 0 ) {
			$sefurl->delete();
		}
	}
}
?>
