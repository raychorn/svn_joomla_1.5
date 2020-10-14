<?php
/**
* @version $Id: users.class.php 4675 2006-08-23 16:55:24Z stingrey $
* @package Joomla
* @subpackage Users
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

/**
* BlastChat Website Table Class
*
* Provides access to the jos_blastchatc table
* @package Joomla
*/
class josBC_website extends mosDBTable {
  var $id = 0; //int(11) NOT NULL auto_increment,
  var $url = null; // varchar(100) default NULL,
  var $version = null; // varchar(20) NOT NULL default '2.3',
  var $intra_id = null; // varchar(100) default NULL,
  var $priv_key = null; //  varchar(100) default NULL,
  var $detached = 0; // binary(1) NOT NULL default '0',
  var $adm_expand = 1; // binary(1) NOT NULL default '0',
  var $width = null; //  varchar(6) NOT NULL default '100%',
  var $height = null; //  varchar(6) NOT NULL default '480',
  var $d_width = null; //  varchar(6) NOT NULL default '640',
  var $d_height = null; //  varchar(6) NOT NULL default '480',
  var $frame_border = 0; // binary(1) NOT NULL default '0',
  var $m_width = null; //  varchar(6) NOT NULL default '0',
  var $m_height = null; //  varchar(6) NOT NULL default '0',
  var $global_count = 0; //  int(11) NOT NULL default '0',
  var $global_update = 0; // int(11) NOT NULL default '0',

    /**
	* @param database A database connector object
	*/
	function josBC_website( &$database ) {
		$this->mosDBTable( '#__blastchatc', 'id', $database );
	}

	/**
	*	binds an array/hash to this object
	*	@param int $oid optional argument, if not specifed then the value of current key is used
	*	@return any result from the database operation
	*/
	function loadByURL( $oid=null ) {
		$this->reset();

		$query = "SELECT *"
		. "\n FROM $this->_tbl"
		. "\n WHERE url = '$oid'"
		;
		$this->_db->setQuery( $query );

		return $this->_db->loadObject( $this );
	}

	/**
	 * Resets public properties
	 * @param mixed The value to set all properties to, default is null
	 */
	function reset( $value=null ) {
		$keys = $this->getPublicProperties();
		foreach ($keys as $k) {
			$this->$k = $value;
		}
	}
	
	/**
	 * Validation and filtering
	 * @return boolean True is satisfactory
	 */
	function check() {
		global $mosConfig_uniquemail;
		return true;
	}

	function store( $updateNulls=false ) {
		global $acl, $migrate;

		$k = $this->_tbl_key;
		$key =  $this->$k;
		if( $key && !$migrate) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );
		} else {
			// new record
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
		}
		if( !$ret ) {
			$this->_error = strtolower(get_class( $this ))."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}

	function delete( $oid=null ) {
		global $acl;

		$k = $this->_tbl_key;
		if ($oid) {
			$this->$k = intval( $oid );
		}

		$query = "DELETE FROM $this->_tbl"
		. "\n WHERE $this->_tbl_key = '". $this->$k ."'"
		;
		$this->_db->setQuery( $query );

		if ($this->_db->query()) {
			// cleanup related data
			$query = "DELETE FROM #__blastchatc_users WHERE serverid = ". $this->$k ."";
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->_error = $this->_db->getErrorMsg();
				return false;
			}
			return true;
		} else {
			$this->_error = $this->_db->getErrorMsg();
			return false;
		}
	}
}

/**
* BlastChat User Table Class
*
* Provides access to the jos_blastchatc_users table
* @package Joomla
*/
class josBC_user extends mosDBTable {
  var $userid = 0; //` int(11) default '0',
  var $serverid = 0; //` int(11) default '0',
  var $sec_code = null; //` varchar(100) default NULL,
  var $session_id = null; //` varchar(200) default NULL,
  var $logged = 0; //` binary(1) NOT NULL default '0',
  var $last_update = 0; //` int(11) NOT NULL default '0',
  var $idle = null; //` varchar(5) default NULL,
  var $roomid = 0; //` int(11) NOT NULL default '0',
  var $room_serverid = 0; //` int(11) NOT NULL default '0',
  var $roomname = null; //` varchar(100) default NULL,

    /**
	* @param database A database connector object
	*/
	function josBC_user( &$database ) {
		$this->mosDBTable( '#__blastchatc_users', 'userid', $database );
	}

	/**
	 * Resets public properties
	 * @param mixed The value to set all properties to, default is null
	 */
	function reset( $value=null ) {
		$keys = $this->getPublicProperties();
		foreach ($keys as $k) {
			$this->$k = $value;
		}
	}

	/**
	 * Validation and filtering
	 * @return boolean True is satisfactory
	 */
	function check() {
		global $mosConfig_uniquemail;
		return true;
	}

	function store( $updateNulls=false ) {
		global $acl, $migrate;

		$k = $this->_tbl_key;
		$key =  $this->$k;
		if( $key && !$migrate) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );
		} else {
			// new record
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
		}
		if( !$ret ) {
			$this->_error = strtolower(get_class( $this ))."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}

	function delete( $oid=null ) {
		global $acl;

		$k = $this->_tbl_key;
		if ($oid) {
			$this->$k = intval( $oid );
		}

		$query = "DELETE FROM $this->_tbl"
		. "\n WHERE $this->_tbl_key = '". $this->$k ."'"
		;
		$this->_db->setQuery( $query );

		if ($this->_db->query()) {
			// cleanup related data
			return true;
		} else {
			$this->_error = $this->_db->getErrorMsg();
			return false;
		}
	}
}
?>