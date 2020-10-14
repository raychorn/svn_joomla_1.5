<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );
// Define parameters
$joomlaSiteName = $params->get('sitename', '');
$joomlaFooterSeparator = $params->get('footerSeparator', '');
$joomlaFooterTextLine1 = $params->get('footerTextLine1', '');
$joomlaFooterTextLine2 = $params->get('footerTextLine2', '');
// Execute controller
$showFooter = modCustomFooter::getFooterCode($joomlaSiteName,$joomlaFooterSeparator,$joomlaFooterTextLine1,$joomlaFooterTextLine2);
// Load viewer
require( JModuleHelper::getLayoutPath( 'mod_customFooter' ) );
