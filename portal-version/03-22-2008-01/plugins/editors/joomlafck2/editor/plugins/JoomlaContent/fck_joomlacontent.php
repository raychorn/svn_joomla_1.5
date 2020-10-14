<?php
/*
 * joomlafck2 - Joomla Content Item Link Plugin for FCKeditor
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

define( '_VALID_MOS', 1 );

require_once( '../../../../../../configuration.php' );
require_once( $mosConfig_absolute_path . '/includes/joomla.php' );

if ( isset( $_GET["cmbContents"] ) ) {
	if ( $_GET["cmbContents"] < 0 ) {
		$url = '';
	} else {
		$exp_url = parse_url($mosConfig_live_site);
		$url = @$exp_url["path"] . '/index.php?option=com_content&amp;task=view&amp;id=' . $_GET["cmbContents"];
	}
}

function GetCategories( $section )
{
	global $database;
	
	if ( !isset($section) ) {
		$query = "SELECT id,title FROM #__categories where published = 1 order by ordering";
	} else {
		$query = "SELECT id,title FROM #__categories where published = 1 and section = " . $section . " order by ordering";
	}
	$database->setQuery( $query );
	$id = $database->loadResult();

	$categories = $database->loadObjectList();

	return $categories;

}

function GetSections( )
{
	global $database;
	
	$query = "SELECT id,title FROM #__sections where published = 1 order by ordering";
	$database->setQuery( $query );
	$id = $database->loadResult();
	
	$sections = $database->loadObjectList();
		
	return $sections;

}

function GetContents( $section, $category )
{
	global $database;
	
	if (isset($category)) {
		$query = "SELECT id,title FROM #__content where state = 1 and catid = " . $category . " order by ordering";
	} elseif (isset($section)) {
		$query = "SELECT id,title FROM #__content where state = 1 and sectionid = " . $section . " order by ordering";
	} else {
		$query = "SELECT id,title FROM #__content where state = 1 order by ordering";
	}
	
	$database->setQuery( $query );
	$id = $database->loadResult();

	$contents = $database->loadObjectList();
		
	return $contents;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Insert Joomla Content Item Link</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="noindex, nofollow" name="robots">
		<script type="text/javascript">
		<!--

			var oEditor				= window.parent.InnerDialogLoaded(); 
			var FCK					= oEditor.FCK; 
			//var FCKConfig			= oEditor.FCKConfig ;
			//var FCKJoomlaContent	= oEditor.FCKJoomlaContent; 
			
			// Function to set special attributes. Copied from FCK Core function
			function SetAttribute( element, attName, attValue )
			{
				if ( attValue == null || attValue.length == 0 )
					element.removeAttribute( attName, 0 ) ;			// 0 : Case Insensitive
				else
					element.setAttribute( attName, attValue, 0 ) ;	// 0 : Case Insensitive
			}
			
			// oLink: The actual selected link in the editor, if existing link
			var oLink = FCK.Selection.MoveToAncestorNode( 'A' ) ;
			if ( oLink ) {
				FCK.Selection.SelectNode( oLink );
			}						 
	
			window.onload = function ()	{ 
				
				LoadSelected();							//See function below 

				window.parent.SetOkButton( true );		//Show the "Ok" button. 
				
			} 
			 
			//If an anchor (A) object is currently selected, load the properties into the dialog 
			function LoadSelected()	{
			
				var sSelected;
		
				if ( oEditor.FCKBrowserInfo.IsGeckoLike ) {
					sSelected = FCK.EditorWindow.getSelection();
				} else {
					sSelected = FCK.EditorDocument.selection.createRange().text;
				}

				if ( sSelected == '' ) {
					alert( 'Please select some text to link' );
				}
				
			}

			//Code that runs after the OK button is clicked 
			function Ok() {
			
				// Check option is selected
				var oContents = document.getElementById( 'cmbContents' ) ;
				if( oContents.selectedIndex == -1 || oContents.value == -1 ) {
					alert('Please select a content item in order to create a link');
					return false;
				}
				
				var sURL = document.getElementById('txtURL').value ; 
				var sTarget = document.getElementById('cmbTarget').value ; 
				
				if ( oLink ) { // Modifying an existent link.
					oLink.href = sURL ;
				} else { // Creating a new link.
                    oLink = oEditor.FCK.CreateLink( sURL ) ;
                }
				
				// oLink can be an array when returned from CreateLink
				if ( oLink.length ) {
					SetAttribute(oLink[0], 'target', sTarget);
				} else {
					SetAttribute(oLink, 'target', sTarget);
				}

                oEditor.FCKSelection.Collapse( false ) ;

				return true;
			} 
			
			function SubmitForm(clear) {
			
				if (clear) {
					document.getElementById('cmbContents').selectedIndex = -1;
				}
				document.frmJoomlaContent.submit();
				
			}
			
		//-->
		</script>
	</head>
	<body scroll="no" style="overflow:hidden;">
		<form method="get" id="frmJoomlaContent" name="frmJoomlaContent">
		<table width="100%">
			<tr>
				<td colspan="2">Select a Joomla content item to link to:</td>
			</tr>
			
			<tr>
				<td width="30%">Sections:</td>
				<td width="70%">
					<select id="cmbSections" name="cmbSections" onchange="SubmitForm(true);">
<?php
					$sections = GetSections();
					
					echo "<option value=\"-1\">Please select a section</value>";
					
					foreach ($sections as $section) {
						
						if ( isset($_GET["cmbSections"]) && $_GET["cmbSections"] == $section->id ) {
							echo "<option selected value=\"" . $section->id . "\">" . $section->title . "</value>";	
						} else {
							echo "<option value=\"" . $section->id . "\">" . $section->title . "</value>";	
						}

					}
?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%">Categories:</td>
				<td width="70%">
					<select id="cmbCategories" name="cmbCategories" onchange="SubmitForm(true);">
<?php
					if ( isset($_GET["cmbSections"]) ) {
						$categories = GetCategories( $_GET["cmbSections"] );
					} else {
						$categories = GetCategories( );
					}
					
					echo "<option value=\"-1\">Please select a category</value>";
					
					foreach ($categories as $category) {
					
						if ( isset($_GET["cmbCategories"]) && $_GET["cmbCategories"] == $category->id ) {
							echo "<option selected value=\"" . $category->id . "\">" . $category->title . "</value>";	
						} else {
							echo "<option value=\"" . $category->id . "\">" . $category->title . "</value>";	
						}

					}
?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td colspan="2">Content items:</td>
			</tr>
			<tr>
				<td colspan="2" width="100%">
					<select style="max-width:100%;width:100%;" id="cmbContents" name="cmbContents" onchange="SubmitForm(false);">
<?php
					if ( isset($_GET["cmbCategories"]) && $_GET["cmbCategories"] > -1 ) {
						$contents = GetContents( null, $_GET["cmbCategories"] );
						echo "<option value=\"-1\">Choose category content item...</value>";	
					} elseif ( isset($_GET["cmbSections"]) && $_GET["cmbSections"] > -1) {
						$contents = GetContents( $_GET["cmbSections"], null );
						echo "<option value=\"-1\">Choose section content item...</value>";	
					} else {
						$contents = GetContents( 0, 0); // Load static content
						echo "<option value=\"-1\">Choose static content item...</value>";	
					}
					
					foreach ($contents as $content) {
					
						if ( isset( $_GET["cmbContents"] ) && $_GET["cmbContents"] == $content->id ) {
							echo "<option selected value=\"" . $content->id . "\">" . $content->title . "</value>";	
						} else {
							echo "<option value=\"" . $content->id . "\">" . $content->title . "</value>";	
						}
						
					}
?>
					</select>
				</td>
			</tr>
			<tr>
			<td colspan="2" width="100%">
				<input style="font-size:x-small;max-width:100%;width:100%;" type="text" name="txtURL" id="txtURL" value="<?php if (isset($url)) { echo $url; } ?>"/>
			</td>
			</tr>
			<tr>
			<td>Target:</td>
			<td>
				<select id="cmbTarget" name="cmbTarget">
					<option value="">(not set)</option>
					<option value="_blank">New Window (_blank)</option>
					<option value="_parent">Parent Window (_parent)</option>
					<option value="_self">Same Window (_self)</option>
					<option value="_top">Topmost Window (_top)</option>
				</select>
			</td>
			</tr>
			</table>
		</form>
	</body>
</html> 