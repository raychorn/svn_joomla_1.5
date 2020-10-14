<?php
/**
* SEF advance component extension
*
* This extension will give the SEF advance style URLs to the maXcomment component
* Place this file (sef_ext.php) in the main component directory
* Note that class must be named: sef_componentname
*
* Copyright (C) 2003-2004 Emir Sakic, http://www.sakic.net, All rights reserved.
*
* Comments: for SEF advance > v3.6
**/

class sef_alphacontent {

	var $url_array = array();

	function _getValue( $string, $sefstring, $val, $addval=false ) {
		$retval = "";
		if ( trim( $val ) ) {
			if (eregi("&amp;$val=",$string)) {
				$temp = split("&amp;$val=", $string);
				$temp = split("&", $temp[1]);
				if ($addval) $sefstring .= $temp[0]."/";
				$retval = $temp[0];
			}
		}
		return $retval;
	}

	function _revertValue( $QUERY_STRING, $pos, $valname="" ) {
		$var = "";
		if (isset($this->url_array[$pos]) && $this->url_array[$pos]!="") {
			// component/example/$var1/
			$var = $this->url_array[$pos];
			if ( $valname ) $this->_setValue( $valname, $var );
		}
		return $var;
	}

	function _setValue( $valname, $var ) {
		$QUERY_STRING = "";
		$_GET[$valname] = $var;
		$_REQUEST[$valname] = $var;
		$QUERY_STRING .= "$valname=$var";
	}

	function _cleanupString( $string ) {
		global $lowercase, $longurl, $url_replace;
		$string = strtr( $string, " ", _SEF_SPACE );
		$string = strtr( $string, $url_replace );
		if ( $lowercase > 0 ) $string = strtolower( $string );
		return $string;
	}

	/**
	* Creates the SEF advance URL out of the Mambo request
	* Input: $string, string, The request URL (index.php?option=com_example&Itemid=$Itemid)
	* Output: $sefstring, string, SEF advance URL ($var1/$var2/)
	**/
	function create ( $string ) {
		global $database, $mosConfig_absolute_path, $mosConfig_lang;
		
		// Get the right language if it exists
		if (file_exists($mosConfig_absolute_path . "/administrator/components/com_alphacontent/languages/" . $mosConfig_lang . ".php")){
			 include_once($mosConfig_absolute_path . "/administrator/components/com_alphacontent/languages/" . $mosConfig_lang . ".php");
		}else{
			 include_once($mosConfig_absolute_path . "/administrator/components/com_alphacontent/languages/english.php");
		}
 
		$sefstring = "";

		$alpha = $this->_getValue( $string, $sefstring, 'alpha' );
		if ( $alpha ) $sefstring .= "alpha/$alpha/";				
		$section = $this->_getValue( $string, $sefstring, 'section' );
		if ( $section!='all' && $section!='com_weblinks' && is_numeric($section) && $section>0 ) {
			$database->setQuery("SELECT title FROM #__sections WHERE id='$section'");
			$sefstring .= sefencode($database->loadResult()) . "/" ;
		} elseif ( $section=='all' ) {
			$sefstring .= "all/" ;
		} elseif ( $section=='0' ) {
			$sefstring .= sefencode( _ALPHACONTENT_NO_CATEGORISED ) . "/" ;
		} elseif ( $section=='com_weblinks' ) {
			$sefstring .= sefencode( _ALPHACONTENT_WEBLINKS ) . "/" ;
		}		
		$cat = $this->_getValue( $string, $sefstring, 'cat' );
		
		if ( $cat!='all' && is_numeric($cat) && $cat>0 ) {
			$database->setQuery("SELECT title FROM #__categories WHERE id='$cat'");
			$sefstring .= sefencode($database->loadResult()) . "/" ;
		} elseif ( ($cat!='all' && is_numeric($cat) && $cat==0 ) || $cat=='all' ) {
			$sefstring .= "all/" ;
		}
		$sort = $this->_getValue( $string, $sefstring, 'sort' );
		if ( $sort ) $sefstring .= "sort/$sort/";
		//$searchfilter = $this->_getValue( $string, $sefstring, 'searchfilter' );
		//if ( $searchfilter ) $sefstring .= "searchfilter/$searchfilter/";
		$limit = $this->_getValue( $string, $sefstring, 'limit' );			
		if ( $limit ) $sefstring .= "$limit/";
		$limitstart = $this->_getValue( $string, $sefstring, 'limitstart' );
		if ( $limitstart ) $sefstring .= "$limitstart/"; 
		
		return $sefstring;		
	}

	/**
	* Reverts to the Mambo query string out of the SEF advance URL
	* Input:
	*    $url_array, array, The SEF advance URL split in arrays (first custom virtual directory beginning at $pos+1)
	*    $pos, int, The position of the first virtual directory (component)
	* Output: $QUERY_STRING, string, Mambo query string (var1=$var1&var2=$var2)
	*    Note that this will be added to already defined first part (option=com_example&Itemid=$Itemid)
	**/
	function revert ( $url_array, $pos ) {
		// define all variables you pass as globals
		global $database, $alpha, $section, $cat, $sort, $limit, $limistart, $mosConfig_absolute_path, $mosConfig_lang;
		
		// Get the right language if it exists
		if (file_exists($mosConfig_absolute_path . "/administrator/components/com_alphacontent/languages/" . $mosConfig_lang . ".php")){
			 include_once($mosConfig_absolute_path . "/administrator/components/com_alphacontent/languages/" . $mosConfig_lang . ".php");
		}else{
			 include_once($mosConfig_absolute_path . "/administrator/components/com_alphacontent/languages/english.php");
		}
		
 		// Examine the SEF advance URL and extract the variables building the query string
		$this->url_array = $url_array;	
		
		$QUERY_STRING = "";
		$check = $this->_revertValue( $QUERY_STRING, $pos + 2 );				
	
		switch ( $check ) {
		
			case 'alpha':
				$alpha     = $this->_revertValue( $QUERY_STRING, $pos + 3, 'alpha' );
				$suit      = $this->_revertValue( $QUERY_STRING, $pos + 4 );
				$suit2     = $this->_revertValue( $QUERY_STRING, $pos + 5 );
				$checkSuit = $this->_revertValue( $QUERY_STRING, $pos + 6 );
				
				if ( $suit=='all' && $suit2=='all' ) {
					// alpha/$alpha/all/all/...
					$this->_setValue( "section", "all" );	
					$this->_setValue( "cat", "all" );
				} elseif ( !is_numeric($suit) && $suit==sefencode( _ALPHACONTENT_NO_CATEGORISED )) {
					// alpha/$alpha/no_categorised/all/...
					$this->_setValue( "section", "0" );
					$this->_setValue( "cat", "0" );
				} elseif ( !is_numeric($suit) && $suit==sefencode( _ALPHACONTENT_WEBLINKS )) {
					// alpha/$alpha/com_weblinks/...
					$this->_setValue( "section", "com_weblinks" );
					// alpha/$alpha/com_weblinks/$category/...
					if ( !is_numeric($suit2) && $suit2!='all' ) {
						$cat = sefdecode( $suit2 );
						$database->setQuery("SELECT id FROM #__categories WHERE title = '$cat'" );
						$this->_setValue( "cat", intval($database->loadResult()) );				
					} elseif ( $suit2=='all' ) {
						// alpha/$alpha/com_weblinks/all/...
						$this->_setValue( "cat", "all" );	
					}
				} elseif ( !is_numeric($suit) && $suit!='all' && $suit!=sefencode( _ALPHACONTENT_WEBLINKS ) && $suit!=sefencode( _ALPHACONTENT_NO_CATEGORISED )) {
					// alpha/$alpha/$section/$category/...
					$section = sefdecode( $suit );
					$database->setQuery("SELECT id FROM #__sections WHERE title = '$section'" );
					$this->_setValue( "section", intval($database->loadResult()) );						
					if ( !is_numeric($suit2) && $suit2!='all' ) {
						$cat = sefdecode( $suit2 );
						$database->setQuery("SELECT id FROM #__categories WHERE title = '$cat'" );
						$this->_setValue( "cat", intval($database->loadResult()) );				
					} elseif ( $suit2=='all' ) {
						$this->_setValue( "cat", "all" );	
					}
				} 
				// alpha/$alpha/$section/sort/...
				if ($suit=='sort') {
					$sort    = $this->_revertValue( $QUERY_STRING, $pos + 5, 'sort' );
					$limit = $this->_revertValue( $QUERY_STRING, $pos + 6, 'limit' );
					$checkSuit = $this->_revertValue( $QUERY_STRING, $pos + 7 );
					if ( $checkSuit ) $limitstart = $this->_revertValue( $QUERY_STRING, $pos + 7, 'limitstart' );
				}
				
				// alpha/$alpha/$section/$category/sort/...
				if ( $checkSuit=='sort' ) {
					$sort  = $this->_revertValue( $QUERY_STRING, $pos + 7, 'sort' );
					$limit = $this->_revertValue( $QUERY_STRING, $pos + 8, 'limit' );
					$checkSuit = $this->_revertValue( $QUERY_STRING, $pos + 9 );
					if ( $checkSuit ) $limitstart = $this->_revertValue( $QUERY_STRING, $pos + 9, 'limitstart' );
				}					
				
				break;					
	
			case 'sort':
				// sort/...
				$sort = $this->_revertValue( $QUERY_STRING, $pos + 3, 'sort' );
				$limit = $this->_revertValue( $QUERY_STRING, $pos + 4, 'limit' );
				$checkSuit = $this->_revertValue( $QUERY_STRING, $pos + 5 );
				if ( $checkSuit ) $limitstart = $this->_revertValue( $QUERY_STRING, $pos + 5, 'limitstart' );	
				break;		
										
			case '':
				// nothing = frontpage AlphaContent
				break;				
				
			default: 
				$suit = "";
				$suit = $this->_revertValue( $QUERY_STRING, $pos + 3 );
				
				// $check = section
				if ( $check=='all' && !$suit ) {
					$this->_setValue( "section", "all" );
				} elseif ( $check==sefencode( _ALPHACONTENT_NO_CATEGORISED ) && !$suit ) {
					$this->_setValue( "section", "0" );
				} elseif ( $check==sefencode( _ALPHACONTENT_WEBLINKS ) && !$suit ) {
					$this->_setValue( "section", "com_weblinks" );
				} elseif ( $check!='all' && !is_numeric($check) && $check!=sefencode( _ALPHACONTENT_NO_CATEGORISED ) && !$suit ) {
					$section = sefdecode( $check );
					if ( strtolower($section)!=strtolower(_ALPHACONTENT_WEBLINKS) )	{
						$database->setQuery("SELECT id FROM #__sections WHERE title = '$section'" );		
						$this->_setValue( "section", intval($database->loadResult()) );
					} elseif ( strtolower($section)==strtolower(_ALPHACONTENT_WEBLINKS ) ) {
						$this->_setValue( "section", "com_weblinks" );
					}
				} elseif ( $check!='all' && !is_numeric($check) && $check!=sefencode( _ALPHACONTENT_NO_CATEGORISED ) && $suit=='all' ) {
					$section = sefdecode( $check );
					if ( strtolower($section)!=strtolower(_ALPHACONTENT_WEBLINKS) )	{
						$database->setQuery("SELECT id FROM #__sections WHERE title = '$section'" );
						$this->_setValue( "section", intval($database->loadResult()) );
					} elseif ( strtolower($section)==strtolower(_ALPHACONTENT_WEBLINKS ) ) {
						$this->_setValue( "section", "com_weblinks" );
					}
					$this->_setValue( "cat", "all" );
					$checkSuit = $this->_revertValue( $QUERY_STRING, $pos + 4 );
					if ($checkSuit=='sort') {
						$sort = $this->_revertValue( $QUERY_STRING, $pos + 5, 'sort' );
						$limit = $this->_revertValue( $QUERY_STRING, $pos + 7, 'limit' );
						$checkSuit = $this->_revertValue( $QUERY_STRING, $pos + 8 );
						if ( $checkSuit ) $limitstart = $this->_revertValue( $QUERY_STRING, $pos + 8, 'limitstart' );
					}					
				} elseif ( $check!='all' && !is_numeric($check) && $check!=sefencode( _ALPHACONTENT_NO_CATEGORISED ) && $suit!='all' && !is_numeric($suit) ) {
					$section = sefdecode( $check );				
					if ( strtolower($section) != strtolower(_ALPHACONTENT_WEBLINKS) )	{
						$database->setQuery("SELECT id FROM #__sections WHERE title = '$section'" );
						$this->_setValue( "section", intval($database->loadResult()) );
					} elseif ( strtolower($section)== strtolower(_ALPHACONTENT_WEBLINKS ) ) {
						$this->_setValue( "section", "com_weblinks" );
					}
					$cat = sefdecode( $suit );
					$database->setQuery("SELECT id FROM #__categories WHERE title = '$cat'" );
					$this->_setValue( "cat", intval($database->loadResult()) );
					$checkSuit = $this->_revertValue( $QUERY_STRING, $pos + 4 );
					if ($checkSuit=='sort') {
						$sort = $this->_revertValue( $QUERY_STRING, $pos + 5, 'sort' );
						$limit = $this->_revertValue( $QUERY_STRING, $pos + 7, 'limit' );
						$checkSuit = $this->_revertValue( $QUERY_STRING, $pos + 8 );
						if ( $checkSuit ) $limitstart = $this->_revertValue( $QUERY_STRING, $pos + 8, 'limitstart' );
					}
				} 
				
				if ($suit=='sort') {
					$sort = $this->_revertValue( $QUERY_STRING, $pos + 4, 'sort' );
					$limit = $this->_revertValue( $QUERY_STRING, $pos + 5, 'limit' );
					$checkSuit = $this->_revertValue( $QUERY_STRING, $pos + 6 );
					if ( $checkSuit ) $limitstart = $this->_revertValue( $QUERY_STRING, $pos + 6, 'limitstart' );
				}				
				
		}
		
		return $QUERY_STRING ;
	}
}
?>