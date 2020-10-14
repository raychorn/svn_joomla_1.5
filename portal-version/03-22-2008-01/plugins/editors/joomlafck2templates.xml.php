<?php

/*
 * Creates a custom XML template file for the FCKeditor for Joomla (joomlafck2)
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

echo '<?xml version="1.0" encoding="utf-8" ?>';

?>
<Templates imagesBasePath="fck_template/images/">
	<?php
	if ( $params->get( 'temp1_title', '' ) ) {
	?>
	<Template title="<?php echo $params->get( 'temp1_title', '' );?>" image="<?php echo $params->get( 'temp1_image', '-1' );?>">
		<Description><?php echo $params->get( 'temp1_desc', '' );?></Description>
		<Html>
			<![CDATA[
<?php echo str_replace("<br />","",$params->get( 'temp1_html', '' ));?>
			]]>
		</Html>
	</Template>
	<?php } 
	if ( $params->get( 'temp2_title', '' ) ) { 
	?>
	<Template title="<?php echo $params->get( 'temp2_title', '' );?>" image="<?php echo $params->get( 'temp2_image', '-1' );?>">
		<Description><?php echo $params->get( 'temp2_desc', '' );?></Description>
		<Html>
			<![CDATA[
<?php echo str_replace("<br />","",$params->get( 'temp2_html', '' ));?>
			]]>
		</Html>
	</Template>	
	<?php } 
	if ( $params->get( 'temp3_title', '' ) ) { 
	?>
	<Template title="<?php echo $params->get( 'temp3_title', '' );?>" image="<?php echo $params->get( 'temp3_image', '-1' );?>">
		<Description><?php echo $params->get( 'temp3_desc', '' );?></Description>
		<Html>
			<![CDATA[
<?php echo str_replace("<br />","",$params->get( 'temp3_html', '' ));?>
			]]>
		</Html>
	</Template>	
	<?php } ?>
</Templates>
