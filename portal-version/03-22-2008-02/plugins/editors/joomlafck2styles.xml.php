<?php

/*
 * Creates a custom XML styles file for the FCKeditor for Joomla (joomlafck2)
 * Copyright (C) 2007 Nick Miles - Database Developments Ltd
 *
 * Portions of this code are from JoomlaFCK
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
header( 'Content-Type: text/xml; charset=utf-8' ) ;

// Set flag that this is a parent file
define( '_VALID_MOS', 1 );

require( '../../globals.php' );
require_once( '../../configuration.php' );
require_once( '../../includes/joomla.php' );

// Load params from db
$query = "SELECT id FROM #__mambots WHERE element = 'joomlafck2' AND folder = 'editors'";
$database->setQuery( $query );
$id = $database->loadResult();
$mambot = new mosMambot( $database );
$mambot->load( $id );
$params =& new mosParameters( $mambot->params );

$xml_str="<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
$xml_str.="\n"."<Styles>";

// Bin out if no css file passed
if ( isset($_GET["css_filename"]) ) {
	$txt_filename = $mosConfig_absolute_path . '/' . $_GET["css_filename"];
} else {
	// Add dummy style that tells the users NO CSS was loaded
	$xml_str .= '<Style name="No CSS file name passed" element="unused" />';
	$xml_str.="\n"."</Styles>"; 
	echo $xml_str;
	exit;
}

// Extra path details
$path_parts = pathinfo($txt_filename);

// Bin out if css file not found
if ( !file_exists($txt_filename) ) {
	// Add dummy style that tells the users NO CSS was loaded
	$xml_str .= '<Style name="' . $path_parts["basename"] . ' not found" element="unused" />';
	$xml_str.="\n"."</Styles>"; 
	echo $xml_str;
	exit;
}

// Add dummy style that tells the users which css is loaded
$xml_str .= '<Style name="using ' . $path_parts["basename"] . '" element="unused" />';

$fp=fopen($txt_filename,'r');
$f=file($txt_filename);
$main=array();
$elem=array();

for($i=0;$i<count($f);$i++)
{
	$mm=$f[$i];
	//for dot class
		if(preg_match("/^\./", $mm,$tt))
		{
		$x=explode("{",$mm);
		$xx=trim($x[0]);
		$pp=explode(",",$xx);
		foreach($pp as $val)
			{
			$ll=explode(" ",$val);
			$nn=substr($ll[0],1);
			if(!in_array($nn,$main) && $nn!="")
				{
				array_push($main,$nn);
				array_push($elem,"p");
				}
			}
		}//end dot
		//for div class
		elseif(preg_match("/^div\./", $mm))
		{
		$x=explode("{",$mm);
		$xx=trim($x[0]);
		$pp=explode(",",$xx);
		foreach($pp as $val)
			{
			$ll=explode(" ",$val);
			$nn=substr($ll[0],4);
			if(!in_array($nn,$main) && $nn!="")
				{
				array_push($main,$nn);
				array_push($elem,"div");
				}
			}
		}//end div
		//for img class
		elseif(preg_match("/^img\./", $mm))
		{
		$x=explode("{",$mm);
		$xx=trim($x[0]);
		$pp=explode(",",$xx);
		foreach($pp as $val)
			{
			$ll=explode(" ",$val);
			$nn=substr($ll[0],4);
			if(!in_array($nn,$main) && $nn!="")
				{
				array_push($main,$nn);
				array_push($elem,"img");
				}
			}
		}//end img
		//for span class
		elseif(preg_match("/^span\./", $mm))
		{
		$x=explode("{",$mm);
		$xx=trim($x[0]);
		$pp=explode(",",$xx);
		foreach($pp as $val)
			{
			$ll=explode(" ",$val);
			$nn=substr($ll[0],5);
			if(!in_array($nn,$main) && $nn!="")
				{
				array_push($main,$nn);
				array_push($elem,"span");
				}
			}
		}//end span

	}	

if(count($main))
{

	foreach($main as $k=>$val)
	{
	
		$xml_str.='<Style name="'.$val.'" element="'.$elem[$k].'">
						<Attribute name="class" value="'.$val.'" />
					</Style>';	
		$xml_str.="\n";

	}
	
}

$xml_str.="\n"."</Styles>"; 

echo $xml_str;

?>

