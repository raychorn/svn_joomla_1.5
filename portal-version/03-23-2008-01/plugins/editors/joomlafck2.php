<?php
/*
 * joomlafck2
 *
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

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onInitEditor', 'botInitEditor' );
$_MAMBOTS->registerFunction( 'onEditorArea', 'botEditorArea' );
$_MAMBOTS->registerFunction( 'onGetEditorContents', 'botGetEditorContents' );

function botInitEditor() {
	global $mosConfig_live_site;
return <<<EOD
<script type="text/javascript" src="$mosConfig_live_site/mambots/editors/joomlafck2/fckeditor.js">
</script>
EOD;
}

function botEditorArea( $name, $content, $hiddenField, $width, $height, $col, $row ) {
	global $mosConfig_live_site, $database, $option, $_MAMBOTS, $mosConfig_absolute_path;
	
	$content = str_replace("&lt;", "<", $content);
	$content = str_replace("&gt;", ">", $content);
	$content = str_replace("&amp;", "&", $content);
	$content = str_replace("&nbsp;", " ", $content);
	$content = str_replace("&quot;", "\"", $content);
	
	$mainframe = new mosMainFrame( $database, $option, '.' );
	 
    $query = "SELECT id FROM #__mambots WHERE element = 'joomlafck2' AND folder = 'editors'";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$mambot = new mosMambot( $database );
	$mambot->load( $id );
	$params =& new mosParameters( $mambot->params );

	$toolbar = $params->get( 'toolbar', 'Default' );
	$wwidth = $params->get( 'wwidth', '100%' );
	$hheight = $params->get( 'hheight', '400' );
	$content_css = $params->get( 'content_css', 0 );
	$content_css_custom = $params->get( 'content_css_custom', '' );
	
	if ( strpos( $width, '%' ) === false )
		$WidthCSS = $width . 'px' ;
	else
		$WidthCSS = $width ;

	if ( strpos( $height, '%' ) === false )
		$HeightCSS = $height . 'px' ;
	else
		$HeightCSS = $height ;
		
	if ( $content_css ) {
		$template = $mainframe->getTemplate(); // Can't be in the javascript generator, needs to be here
		
		$file = $mosConfig_absolute_path ."/templates/". $template ."/css/editor_content.css";
		if ( file_exists( $file ) ) {
			$content_css = 'templates/'.$template.'/css/editor_content.css';
		} else {
			$content_css = 'templates/'.$template.'/css/template_css.css';
		}
	} else {
		if ( $content_css_custom ) {
			$content_css = $content_css_custom;
		} else {
			$content_css = 'mambots/editors/joomlafck2/editor/css/fck_editorarea.css';
		}
	}		
		
	$results = $_MAMBOTS->trigger( 'onCustomEditorButton' );
	$buttons = array();
	foreach ($results as $result) {
		if ( $result[0] ) {
			$buttons[] = '<img src="'.$mosConfig_live_site.'/mambots/editors-xtd/'.$result[0].'" onclick="InsertHTML(\''.$hiddenField.'\',\''.$result[1].'\')" />';
		}
	}
	$buttons = implode("", $buttons);		
	
return <<<EOD
<textarea name="$hiddenField" id="$hiddenField" cols="$col" rows="$row" style="width:{$WidthCSS}; height:{$HeightCSS};">$content</textarea>

<script type="text/javascript">
	
	var oFCKeditor = new FCKeditor('$hiddenField');
	
	oFCKeditor.BasePath = '$mosConfig_live_site/mambots/editors/joomlafck2/' ;
	oFCKeditor.Width = '$wwidth' ;
	oFCKeditor.Height = '$hheight' ;
	oFCKeditor.ToolbarSet = '$toolbar' ;
	
	oFCKeditor.Config['EditorAreaCSS'] = '$mosConfig_live_site/$content_css';
	oFCKeditor.Config['StylesXmlPath']= '$mosConfig_live_site/mambots/editors/joomlafck2styles.xml.php?css_filename=$content_css' ;
	oFCKeditor.Config['CustomConfigurationsPath'] = '$mosConfig_live_site/mambots/editors/joomlafck2.js.php' ;
	
	oFCKeditor.ReplaceTextarea() ;
	
	function InsertHTML(field, value) {
		// Get the editor instance that we want to interact with.
		var oEditor = FCKeditorAPI.GetInstance(field) ;

		// Check the active editing mode.
		if ( oEditor.EditMode == FCK_EDITMODE_WYSIWYG )
		{
			// Insert the desired HTML.
			oEditor.InsertHtml( value ) ;
		}
		else
			alert( 'Please switch to WYSIWYG mode.' ) ;
	}
</script>
<br />
<p>$buttons</p>
EOD;
}

function botGetEditorContents($editorArea, $hiddenField) {

}
?>