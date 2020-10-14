<?php
////////////////////////////////////////////////////////////////////
// FILE:         anytags.php
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

$mainframe->registerEvent( 'onPrepareContent', 'plgAnyTags' );

/**
* Plugin that replaces AnyTags! code with its HTML / PHP equivalent
*/
function plgAnyTags( &$row, &$params, $page=0 ) {

	$plugin =& JPluginHelper::getPlugin('content', 'anytags');
	$pluginParams = new JParameter( $plugin->params );

	if ( ( $pluginParams->get( 'use_asterisk', 1 ) && ( strpos( $row->text, '{* ' ) === false && strpos( $row->text, '{/* ' ) === false ) ) &&
		( strpos( $row->text, '{anytags ' ) === false && strpos( $row->text, '{/anytags ' ) === false ) ) {
		return true;
	}

	$acl =& JFactory::getACL();
	
	$AT_row_group = $acl->getAroGroup( $row->created_by );
	$AT_row_group_mod = $acl->getAroGroup( $row->modified_by );
	$AT_param_group = $acl->get_group_data( $pluginParams->get( 'security_level', 23 ) );
	$AT_param_group_php = $acl->get_group_data( $pluginParams->get( 'security_level_php', 25 ) );
	
	$AT_security_pass = ($AT_row_group->lft >= $AT_param_group[4] && $AT_row_group_mod->lft >= $AT_param_group[4])?1:0;
	$AT_security_pass_php = ($AT_row_group->lft >= $AT_param_group_php[4] && $AT_row_group_mod->lft >= $AT_param_group_php[4])?1:0;
	
	$AT_syntax = $pluginParams->get( 'use_asterisk', 1 )?'(\*|anytags)':'(anytags)';
		
	// Mach all PHP tags
	// {* php}code{/* php}
	// {* php}code{* /php}
	$AT_double_php_tag_start = '{'.$AT_syntax.'\s+php}';
	$AT_double_php_tag_end = '{(?:(?:/\1\s+)|(?:\1\s+/))php}';
	$AT_double_php_tag_regex = '#'.$AT_double_php_tag_start.'(.*?)'.$AT_double_php_tag_end.'#s';
	$row->text = replace_php_tags($row->text, $AT_double_php_tag_regex, $AT_security_pass_php);

	// Match all JavaScript tags
	// {* javascript}code{/* javascript}
	// {* javascript}code{* /javascript}
	$AT_double_js_tag_start = '{'.$AT_syntax.'\s+(?:js|javascript)}';
	$AT_double_js_tag_end = '{(?:(?:/\1\s+)|(?:\1\s+/))(?:js|javascript)}';
	$AT_double_js_tag_regex = '#'.$AT_double_js_tag_start.'(.*?)'.$AT_double_js_tag_end.'#s';
	$row->text = replace_js_tags($row->text, $AT_double_js_tag_regex, $AT_security_pass);

	// Match all CSS tags
	// {* css}code{/* css}
	// {* css}code{* /css}
	$AT_double_css_tag_start = '{'.$AT_syntax.'\s+(?:css|style)}';
	$AT_double_css_tag_end = '{(?:(?:/\1\s+)|(?:\1\s+/))(?:css|style)}';
	$AT_double_css_tag_regex = '#'.$AT_double_css_tag_start.'(.*?)'.$AT_double_css_tag_end.'#s';
	$row->text = replace_css_tags($row->text, $AT_double_css_tag_regex, $AT_security_pass);

	// Match all other tags
	// {* whatever parameters}
	$AT_tag = '{(/?)'.$AT_syntax.'\s+(/?)([^}]*?)}';
	$AT_tag_regex = '#'.$AT_tag.'#s';
	$row->text = replace_tags($row->text, $AT_tag_regex, $AT_security_pass);

	return true;
}

// Replace the PHP tags with the evaluated PHP scripts
function replace_php_tags($AT_text, $AT_regex, $AT_security_pass=1 ) {
	if ( preg_match_all($AT_regex, $AT_text, $matches, PREG_SET_ORDER) > 0 ) {
		foreach ( $matches as $match ) {
			if( !$AT_security_pass ){
				// replace tags with HTML comment
				$newtag = '<!-- AnyTags! Comment: The PHP script has been removed, because the owner of this article does not pass the security level. -->';
			} else {
				$script = remove_editor_junk(html_entity_decode($match[2]));
				// evaluate the script
				ob_start();
					@eval($script.';');
					$newtag = ob_get_contents();
				ob_end_clean();
			}
			$AT_text = str_replace($match[0], $newtag, $AT_text);
		}
	}
	return $AT_text;
}

// Replace the JavaScript tags with the scripts surrounded by JavaScript tags
function replace_js_tags($AT_text, $AT_regex, $AT_security_pass=1 ) {
	if ( preg_match_all($AT_regex, $AT_text, $matches, PREG_SET_ORDER) > 0 ) {
		foreach ( $matches as $match ) {
			if( !$AT_security_pass ){
				// replace tags with HTML comment
				$newtag = '<!-- AnyTags! Comment: The JavaScript has been removed, because the owner of this article does not pass the security level. -->';
			} else {
				$script = remove_editor_junk(html_entity_decode($match[2]));
				$newtag = "<script type=\"text/javascript\">\n<!--\n".$script."\n//-->\n</script>";
			} 
			$AT_text = str_replace($match[0], $newtag, $AT_text);
		}
	}
	return $AT_text;
}

// Replace the CSS tags with the scripts surrounded by JavaScript tags
function replace_css_tags($AT_text, $AT_regex, $AT_security_pass=1 ) {
	if ( preg_match_all($AT_regex, $AT_text, $matches, PREG_SET_ORDER) > 0 ) {
		foreach ( $matches as $match ) {
			if( !$AT_security_pass ){
				// replace tags with HTML comment
				$newtag = '<!-- AnyTags! Comment: The CSS has been removed, because the owner of this article does not pass the security level. -->';
			} else {
				$script = remove_editor_junk(html_entity_decode($match[2]));
				$newtag = "<style type=\"text/css\">\n".$script."\n</style>";
			} 
			$AT_text = str_replace($match[0], $newtag, $AT_text);
		}
	}
	return $AT_text;
}

// Replace all other tags with the HTML equivalent
function replace_tags($AT_text, $AT_regex, $AT_security_pass=1 ) {
	if ( preg_match_all($AT_regex, $AT_text, $matches, PREG_SET_ORDER) > 0 ) {
		foreach ( $matches as $match ) {
			if( !$AT_security_pass ){
				// replace tags with HTML comment
				$newtag = '<!-- AnyTags! Comment: The tags has been removed, because the owner of this article does not pass the security level. -->';
			} else {
				$newtag = "<".trim($match[1].$match[3].$match[4]).">";
			} 
			$AT_text = str_replace($match[0], $newtag, $AT_text);
		}
	}
	return $AT_text;
}

function remove_editor_junk($AT_str) {
	// replace linbreak tags with normal linebreaks (paragraphs, enters, etc).
	$junk_tags = array('p','br');
	$AT_regex = '#</?(('.implode(')|(',$junk_tags).'))+[^>]*?>#s';

	if ( preg_match_all($AT_regex, $AT_str, $matches, PREG_SET_ORDER) > 0 ) { 	
		foreach ( $matches as $match ) {
			$AT_str = str_replace($match[0], "\n", $AT_str);
		}
	}

	// remove other junk (tabs, double enters, stuff like that).
	$junk_strings = array(chr(160),chr(194));
	$AT_regex = '#(('.implode(')|(',$junk_strings).'))#s';

	if ( preg_match_all($AT_regex, $AT_str, $matches, PREG_SET_ORDER) > 0 ) { 	
		foreach ( $matches as $match ) {
			$AT_str = str_replace($match[0], "", $AT_str);
		}
	}
	
	return $AT_str;
}

?>
