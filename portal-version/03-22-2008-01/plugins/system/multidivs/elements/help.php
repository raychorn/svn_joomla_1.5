<?php
////////////////////////////////////////////////////////////////////
// FILE:         help.php
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

class JElementHelp extends JElement {
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Help';

	function fetchElement($name, $value, &$node, $control_name) {
		JHTML::_('behavior.modal', 'a.modal');
		$baseurl = JURI::base(true);
	
		$html_file = 	'/plugins/system/multidivs/elements/help.html.php';
		$link = 		$baseurl.'/..'.$html_file;
		$html .= '<div class="button2-left"><div class="blank"><a class="modal" title="'.JText::_('Show the MultiDivs! Help page').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 650, y: 375}}">'.JText::_('Show Help Page').'</a></div></div>'."\n";

		return $html;
	}
}
?>