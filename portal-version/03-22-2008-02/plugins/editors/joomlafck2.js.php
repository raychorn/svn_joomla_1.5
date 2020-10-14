<?php
/*
 * Creates a custom javascript config file for the FCKeditor for Joomla (joomlafck2)
 * Copyright (C) 2007 Nick Miles - Database Developments Ltd
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 * == END LICENSE ==
*/

// Prevent the browser from caching the result.
// Date in the past
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT') ;
// always modified
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT') ;
// HTTP/1.1
header('Cache-Control: no-store, no-cache, must-revalidate') ;
header('Cache-Control: post-check=0, pre-check=0', false) ;
// HTTP/1.0
header('Pragma: no-cache') ;

// Set the response format.
header('Content-type: text/javascript');

// Set flag that this is a parent file
define( '_VALID_MOS', 1 );

require_once( '../../configuration.php' );
require_once ( $mosConfig_absolute_path . '/includes/joomla.php' );

// Load params from db
$query = "SELECT id FROM #__mambots WHERE element = 'joomlafck2' AND folder = 'editors'";
$database->setQuery( $query );
$id = $database->loadResult();
$mambot = new mosMambot( $database );
$mambot->load( $id );
$params =& new mosParameters( $mambot->params );

// Read params
$toolbar = $params->get( 'toolbar', 'Default' );
$skin = $params->get( 'skin', 'silver' );
$text_direction	= $params->get( 'text_direction', 'ltr' );
$enter = $params->get( 'enter', 'BR' );
$shift_enter = $params->get( 'shift_enter', 'BR' );
$custom_line_1 = $params->get( 'custom_line_1', '' );
$custom_line_2 = $params->get( 'custom_line_2', '' );
$custom_line_3 = $params->get( 'custom_line_3', '' );
$auto_lang = $params->get( 'auto_lang', 1 );
$def_lang = $params->get( 'def_lang', 'en' );
$use_custom_templates = $params->get( 'use_custom_templates', 0 );
$process_html_entities = $params->get( 'process_html_entities', 1 );
$include_latin_entities = $params->get( 'include_latin_entities', 1 );
$include_greek_entities = $params->get( 'include_greek_entities', 1 );
$force_simple_ampersand = $params->get( 'force_simple_ampersand', 0 );

// Fix up
if ($auto_lang == 1) { $auto_lang = "true"; } else { $auto_lang = "false"; }
if ($process_html_entities == 1) { $process_html_entities = "true"; } else { $process_html_entities = "false"; }
if ($include_latin_entities == 1) { $include_latin_entities = "true"; } else { $include_latin_entities = "false"; }
if ($include_greek_entities == 1) { $include_greek_entities = "true"; } else { $include_greek_entities = "false"; }
if ($force_simple_ampersand == 1) { $force_simple_ampersand = "true"; } else { $force_simple_ampersand = "false"; }

$custom_toolbar = '';
if ($toolbar == 'Custom') {
	if ($custom_line_1) {
		$custom_toolbar = $custom_line_1;
	}
	if ($custom_line_2) {
		$custom_toolbar .= "\n,'/'," . $custom_line_2;
	}
	if ($custom_line_3) {
		$custom_toolbar .= "\n,'/'," . $custom_line_3;
	}
}

// Get rid of any <br /> added by the textarea in the config screen
$custom_toolbar = str_replace( "<br />", "", $custom_toolbar );

// Output javascript config
echo "FCKConfig.AutoDetectLanguage = " . $auto_lang . ";\n\n" ;
echo "FCKConfig.DefaultLanguage = '" . $def_lang . "';\n\n" ;
echo "FCKConfig.EnterMode = '" .  $enter . "';\n\n" ;
echo "FCKConfig.ShiftEnterMode = '" .  $shift_enter . "';\n\n" ;
echo "FCKConfig.ContentLangDirection = '" . $text_direction . "';\n\n" ;
echo "FCKConfig.SkinPath = '" . $mosConfig_live_site . "/mambots/editors/joomlafck2/editor/skins/" . $skin . "/" . "';\n\n" ;

echo <<<EOD

FCKConfig.Plugins.Add('JoomlaContent');
FCKConfig.Plugins.Add('ImageManager');

FCKConfig.ToolbarSets["Default"] = [
	['Source','Templates','Preview'],
	['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],
	['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],
	'/',
	['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
	['OrderedList','UnorderedList','-','Outdent','Indent','Blockquote'],
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
	['JoomlaContent','Link','Unlink','Anchor'],
	['Image','ImageManager','Flash','Table','Rule','Smiley','SpecialChar','PageBreak'],
	'/',
	['Style','FontFormat','FontName','FontSize'],
	['TextColor','BGColor'],
	['FitWindow','ShowBlocks','-','About']		// No comma for the last row.
] ;

FCKConfig.ToolbarSets["Basic"] = [
	['Bold','Italic','Underline','-','OrderedList','UnorderedList','-','JoomlaContent','Link','Unlink']
] ;

FCKConfig.CustomStyles = { };

EOD;

if ($toolbar == 'Custom') {
	echo "FCKConfig.ToolbarSets[\"Custom\"] = [ \n" . $custom_toolbar . "\n];\n\n" ;
}

if ($use_custom_templates == 1) {
	echo "FCKConfig.TemplatesXmlPath = '" . $mosConfig_live_site . "/mambots/editors/joomlafck2templates.xml.php';\n\n" ;
}

echo "FCKConfig.ProcessHTMLEntities = " . $process_html_entities . ";\n\n" ;
echo "FCKConfig.IncludeLatinEntities = " . $include_latin_entities . ";\n\n" ;
echo "FCKConfig.IncludeGreekEntities = " . $include_greek_entities . ";\n\n" ;
echo "FCKConfig.ForceSimpleAmpersand = " . $force_simple_ampersand . ";\n\n" ;

?> 