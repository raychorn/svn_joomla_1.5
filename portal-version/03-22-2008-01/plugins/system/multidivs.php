<?php
////////////////////////////////////////////////////////////////////
// FILE:         multidivs.php
//------------------------------------------------------------------
// PACKAGE:      multidivs
// NAME:         MultiDivs!
// DESCRIPTION:  MultiDivs! ...easily create divs in Joomla!
// VERSION:      1.1.1
// CREATED:      October 2007
// MODIFIED:     March 2008
//------------------------------------------------------------------
// AUTHOR:       NoNumber! (Peter van Westen)
// E-MAIL:       peter@nonumber.nl
// WEBSITE:      http://www.nonumber.nl
//------------------------------------------------------------------
// COPYRIGHT:    (C) 2008-2010 - NoNumber! - All Rights Reserved
// LICENSE:      GNU/GPL  [ http://www.gnu.org/copyleft/gpl.html ]
////////////////////////////////////////////////////////////////////

// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin');

/**
* Plugin that replaces MultiDivs! code with a nested div structure
*/
class plgSystemMultiDivs extends JPlugin
{
	function plgSystemMultiDivs(&$subject, $config)  {
		parent::__construct($subject, $config);
	}

	function onAfterRender() {
		$app =& JFactory::getApplication();

		if($app->getName() != 'site') {
			return true;
		}
		
		$MD_newbody = JResponse::getBody();

		if ( strpos( $MD_newbody, '{multidivs' ) === false && strpos( $MD_newbody, '{/multidivs}' ) === false ) {
			return true;
		}
		
		$MD_regex = "#{multidivs\s*([1-9]*)?\s*([^\}]*)}(.*?){/multidivs}#s";
		
		if ( preg_match_all($MD_regex, $MD_newbody, $MD_matches, PREG_SET_ORDER) > 0 ) {
			foreach ( $MD_matches as $MD_match ) {
				$MD_nr_divs = (is_numeric($MD_match[1]))?$MD_match[1]:0;
				$MD_classname = ($MD_match[2])?$MD_match[2]:$this->get( 'default_classname', 'quote' );
				$MD_newstring = $MD_match[3];
				if ( !$MD_nr_divs ) {
						$MD_newstring = '<div class="'.$MD_classname.'">'.$MD_newstring.'</div>';
				} else {
					for ( $i = 1; $i <= $MD_nr_divs; $i++ ) {
						$MD_newstring = '<div class="'.$MD_classname.$this->get( 'class_delimiter', '_' ).(($MD_nr_divs-$i)+1).'">'.$MD_newstring.'</div>';
					}
				}
				$MD_newbody = str_replace($MD_match[0], $MD_newstring, $MD_newbody);
			}
		}

		JResponse::setBody($MD_newbody);

		return true;
	}
}
?>
