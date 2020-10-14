<?php
/**
* @version $Id $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.HTML GNU/GPL, see LICENSE.php
* Joomla! is free software and parts of it may contain or be derived from the
* GNU General Public License or other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
 
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mosConfig_absolute_path . '/includes/domit/xml_saxy_lite_parser.php' );
  
$_MAMBOTS->registerFunction( 'onPrepareContent', 'botMosAmazon' );
 
function botMosAmazon( $published, &$row, $mask=0, $page=0  ) {
  global $mosConfig_absolute_path;
 
  if (!$published) {
    return true;
  }
 
  // define the regular expression for the bot

$regex = "#{amazon*(.*?)}#s";
 
  // perform the replacement
  $row->text = preg_replace_callback( $regex, 'botMosLink_replacer', $row->text );
 
  return true;
}
/**
* Replaces the matched tags an image
* @param array An array of matches (see preg_match_all)
* @return string
*/

function botMosLink_replacer( &$matches ) {

   global $mosConfig_live_site, $database;
 
  $query = "SELECT id FROM #__mambots WHERE element = 'mosamazon' AND folder = 'content'";
  $database->setQuery( $query );
  $id = $database->loadResult();
  $mambot = new mosMambot( $database );
  $mambot->load( $id );
  $mambotParams =& new mosParameters( $mambot->params );
  $AFid = $mambotParams->get( 'AFid' );
  $tempalign = $mambotParams->get( 'align' );
  $site = $mambotParams->get( 'site' );
  $background = $mambotParams->get( 'background' );
  $text = $mambotParams->get( 'text' );
  $link = $mambotParams->get( 'link' );

  $attribs = @SAXY_Lite_Parser::parseAttributes( $matches[1] );
 
  $ids = @$attribs['id'];
  $align = @$attribs['align'];

if ($AFid == "")
{
$AFid='qsquare06-21';
}
if ($align == "")
{
$align=$tempalign;
}
if ($site == "")
{
$site='rcm-uk.amazon.co.uk';
}
if ($background == "")
{
$background='ffffff';
}
if ($text == "")
{
$text='000000';
}
if ($link == "")
{
$link='0000ff';
}

if ($site == "rcm.amazon.com")
{
 $output = '<iframe src="http://rcm.amazon.com/e/cm?t='.$AFid.'&o=1&p=8&l=as1&asins='.$ids.'&fc1='.$text.'&IS2=1&lt1=_blank&lc1='.$link.'&bc1='.$text.'&bg1='.$background.'&f=ifr" style="width:120px;height:240px;" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" align="'.$align.'"></iframe>';
}

if ($site == "rcm-uk.amazon.co.uk")
{
 $output = '<iframe src="http://rcm-uk.amazon.co.uk/e/cm?t='.$AFid.'&o=2&p=8&l=as1&asins='.$ids.'&fc1='.$text.'&IS2=1&lt1=_blank&lc1='.$link.'&bc1='.$text.'&bg1='.$background.'&f=ifr" style="width:120px;height:240px;" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" align="'.$align.'"></iframe>';
}
if ($site == "rcm-de.amazon.de")
{
 $output = '<iframe src="http://rcm-de.amazon.de/e/cm?t='.$AFid.'&o=3&p=8&l=as1&asins='.$ids.'&fc1='.$text.'&IS2=1&lt1=_blank&lc1='.$link.'&bc1='.$text.'&bg1='.$background.'&f=ifr" style="width:120px;height:240px;" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" align="'.$align.'"></iframe>';
}
if ($site == "rcm-ca.amazon.ca")
{
 $output = '<iframe src="http://rcm-ca.amazon.ca/e/cm?t='.$AFid.'&o=15&p=8&l=as1&asins='.$ids.'&fc1='.$text.'&IS2=1&lt1=_blank&lc1='.$link.'&bc1='.$text.'&bg1='.$background.'&f=ifr" style="width:120px;height:240px;" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" align="'.$align.'"></iframe>';
}
if ($site == "rcm-fr.amazon.fr")
{
 $output = '<iframe src="http://rcm-fr.amazon.fr/e/cm?t='.$AFid.'&o=8&p=8&l=as1&asins='.$ids.'&fc1='.$text.'&IS2=1<1=_blank&lc1='.$link.'&bc1='.$text.'&bg1='.$background.'&f=ifr" style="width:120px;height:240px;" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" align="'.$align.'"></iframe>';
}
  return ' <!-- Amazon link by Stephan http://www.q-square.com --> '.$output.' <!-- Amazon link end-->';
}
?>