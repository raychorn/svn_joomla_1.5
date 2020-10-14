<?php
/**
* @author Ryan McLaughlin (www.daobydesign.com, info@daobydesign.com)
* This plugin will automatically generate Meta Description tags from your content.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$mainframe->registerEvent( 'onAfterDisplayContent', 'autoMetaDesc' );

/**
* This plugin will automatically generate Meta Description tags from your content.
*/
function autoMetaDesc( &$row, &$params, $page=0 ) 
{
	$plugin =& JPluginHelper::getPlugin('content', 'autoMetaDescSEO_1.0');

	$document =& JFactory::getDocument();
 	$pluginParams 	= new JParameter( $plugin->params );
 	$thelength = $pluginParams->def('length', 200);

	$thecontent = rtrim(substr(strip_tags($row->text),0,$thelength));
	$document->setMetaData("description", $thecontent);
}


?>