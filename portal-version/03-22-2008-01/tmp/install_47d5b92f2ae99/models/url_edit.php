<?php
/**
* @version		$Id: url_edit.php 52 2007-10-28 17:19:51Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org 
* @license		GNU/GPL, see LICENSE.php
* 
*/
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class url_editModelurl_edit extends Jmodel {
	
	var $_id = NULL;
	var $_data = NULL;
	
	function __construct()	{
		parent::__construct();
		$cid 	= JRequest::getVar('cid', array(0), 'method', 'array');
		
		$this->_id = $cid[0];
	}
	
	function getData()	{
		// Load the record
		$db =& JFactory::getDBO();
		
		if ( is_numeric($this->_id )){
			$this->_data   =& JTable::getInstance('smartsef_urls', 'Table'); 
			$this->_data->load ( $this->_id );
		} else {
			$query = "SELECT * FROM #__smartsef_urls where url_sef = '" . $this->_id . "' ORDER BY ordering, id";
			$db->setQuery( $query );
			$this->_data = $db->loadObject();
		}
		if ($this->_data->cache != "") {
			$query = "SELECT url_orginal, url_sef, id, published FROM #__smartsef_urls WHERE id in ( " . $this->_data->cache . ")"; 
			$db->setQuery( $query );
			$this->_data->cache = $db->loadAssocList('url_orginal');
		}
	
		return $this->_data;
	}
	
	function save ( $id = 0) {
		
		$db =& JFactory::getDBO();
		$url_record =& JTable::getInstance('smartsef_urls', 'Table'); 
		$post	= JRequest::get( 'post' );
		
		// Bind the data from the POST;
		if (!$url_record->bind( $post )) {
			return JError::raiseWarning( 500, $url_record->getError() );
		}		
		// Serialize the input parameters
		$arrOut = array();
		if ( $url_record->vars != "")  {
			$parameters = preg_split('/[\r\n]+/', $url_record->vars, -1, PREG_SPLIT_NO_EMPTY);
			$arrOut = array();
			foreach ( $parameters as $parameter ) {
				$input = explode("=", $parameter);
				$arrOut[$input[0]] = $input[1];
			}
		} else {
			// check if there is an internal URL;

			if ( $url_record->url_orginal != "") {
				$arrOut = $this->_create_vars( $url_record->url_orginal );
			}
		}
		if ( count($arrOut) > 0 ) {
			$url_record->vars = serialize($arrOut ) ;
		}
		if (!$url_record->store()) {
			return JError::raiseWarning( 500, $url_record->getError() );
		}
		
		return true;
		
	}
	
	function _create_vars ( $url ) {
		$url_check = parse_url( $url) ;
		$url_parts = explode ('&' , $url_check['query']);
		$vars=array();
		foreach ( $url_parts as $element ) {
			$content = explode('=', $element);
			$vars[$content[0]] = $content[1];
		}
		return ( $vars); 
	}
	
}

?>