<?php
////////////////////////////////////////////////////////////////////
// FILE:         grouplevel.php
//------------------------------------------------------------------
// PACKAGE:      anytags
// NAME:         AnyTags!
// DESCRIPTION:  AnyTags! ...place special tags in Joomla!
// VERSION:      2.1.2
// CREATED:      December 2007
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

class JElementGroupLevel extends JElement {
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'GroupLevel';

	function fetchElement($name, $value, &$node, $control_name) {

		$acl =& JFactory::getACL();
		$options = $acl->get_group_children_tree( null, 'Public Backend', true );
		$list 	= JHTML::_('select.genericlist', $options, ''.$control_name.'['.$name.']', 'class="inputbox" size="4"', 'value', 'text', $value, $control_name.$name );
		
		return $list;
	}
}