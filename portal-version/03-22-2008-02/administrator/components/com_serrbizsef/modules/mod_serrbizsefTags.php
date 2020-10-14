<?php
/**
* @version $Id: mod_serrbizsefTags.php 2007-10-19 11:19:30 $
* @package Joomla
* @subpackage SerrBizSEF
* @copyright Copyright (C) Serr.biz. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*
* SerrBizSEF is a released under the terms of the GNU General Public License;
* Warranty : This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
* FITNESS FOR A PARTICULAR PURPOSE. 
*
* @author Serr.biz
* @version 1.0 Complete
*/
/* no direct access*/
defined( '_VALID_MOS' ) or die( 'Restricted access' );

include_once("mod_serrbizsef_tags/mod_serrbizsef_tags_data.php");

$shPage = ob_get_contents();
ob_end_clean();

$SerrBizSEFSocialTags  = new SerrBizSEFSocialTags();
global $tags_params;

if($SerrBizSEFSocialTags->ConstructBookmarks("loadParam"))
 {
	$tags_params = $SerrBizSEFSocialTags->objParams->_params;
	unset($SerrBizSEFSocialTags);
 }

global $SB_Active, $SB_SEF_Active, $SB_MeatInfo_Active,$mosConfig_sef,$mosConfig_live_site;

function sbzStripPos($haystack, $needle, $offset=0)
{
    return strpos(strtoupper($haystack),strtoupper($needle),$offset);
}

function SearchReplaceMeta($opBuffer)
{                              
    global $SBZ_PTITLE, $SBZ_MTITLE, $SBZ_MKEYWORDS, $SBZ_MDESC,$SBZ_MROBOT,$mosConfig_live_site;
    
    if(!$opBuffer) return $opBuffer;
    
    if(isset($SBZ_PTITLE) && strlen($SBZ_PTITLE)>0) {
      $opBuffer = eregi_replace( '<\s*title\s*>.*<\s*\/title\s*>','<title>'.$SBZ_PTITLE.'</title>', $opBuffer);
    }  
    if(isset($SBZ_MDESC) && strlen($SBZ_MDESC)>0) {
      $opBuffer = preg_replace( '/\<\s*meta\s+name\s*=\s*"description.*\/\>/', '<meta name="description" content="'.$SBZ_MDESC.'"/>',$opBuffer);
    }        
    if(isset($SBZ_MKEYWORDS) && strlen($SBZ_MKEYWORDS)>0) {
      $opBuffer = preg_replace( '/\<\s*meta\s+name\s*=\s*"keywords.*\/\>/', '<meta name="keywords" content="'.$SBZ_MKEYWORDS.'" />',$opBuffer);  
    }    
    
    if(sbzStripPos($opBuffer, '<meta name="robots" content="') !== false) { 
      $opBuffer = preg_replace( '/\<\s*meta\s+name\s*=\s*"robots.*\/\>/', '<meta name="robots" content="'.$SBZ_MROBOT.'" />', $opBuffer); 
    }elseif(sbzStripPos($opBuffer, '</head>') !== false) {
      $opBuffer = preg_replace('</head>','meta name="robots" content="'.$SBZ_MROBOT.'"/></head', $opBuffer);     
    } 
	
    return $opBuffer;
}

if(isset($SB_Active) && $SB_Active > 0 && isset($SB_SEF_Active) && $SB_SEF_Active >0 && isset($SB_MeatInfo_Active) && $SB_MeatInfo_Active >0) 
{
    $shPage = SearchReplaceMeta($shPage);
	if(!isset($tags_params->show_message)  || strtolower($tags_params->show_message)!='no')
	{
		$fpath = $mosConfig_live_site.'/modules/mod_serrbizsef_tags/';
		$msg = '<div align="center">';
		$msg = $msg.'<link rel="stylesheet" href="'.$fpath.'css/floating-window.css" media="screen" type="text/css"> ';
		$msg = $msg.'<script type="text/javascript" src="'.$fpath.'js/floating-window.js"></script> ';
		$msg = $msg.'<div id="book_detail1" style="width:100px">';
		$msg = $msg.'<div id="CloseDiv1" style="display:none;">';
		$msg = $msg.'<div align="right"> <a href="javascript:MyhideWindow();" >Close</a><br><br></div>';
		$msg = $msg.'<div align="justify">';
		$msg = $msg.'This page has been search engine optimized in part by Serr.biz, ';
		$msg = $msg.'an <a href="http://www.serr.biz/seo-code-of-ethics.html" title="Ethical SEO">ethical</a> <a href="http://www.serr.biz" title="SEO company">SEO company</a> that provides comprehensive web design and ';
		$msg = $msg.'emarketing with an expertise in <a href="http://www.serr.biz/ask-a-question/joomla-seo-serrbizsef.html" title="Joomla SEO, search engine optimization">Joomla SEO</a>. For more information, ';
		$msg = $msg.'please visit Serr.biz directly at : http://www.serr.biz<br><br>';
		$msg = $msg.'</div>';
		$msg = $msg.'</div></div>';
		$msg = $msg.'<div id="tag_container"> ';
		$msg = $msg.'<a href="javascript:void(0);" id="bookmark_link1" onclick="fnShowBookContainer1(event,\'right\',\''.$fpath.'\',\'CloseDiv1\',\'book_detail1\',\'bookmark_link1\',\'bookimg1\');" >';
		$msg = $msg.'<img src="'.$fpath.'image/serrbiz_logo25x25.jpg" id="bookimg1" border="0"></a>';
		$msg = $msg.'</div></div>';
		//$opBuffer=preg_replace('/\<\s*div\s+id\s*=\s*"footer*"\s*>/',$msg,$opBuffer);
		$shPage=$shPage.$msg;
	}
	unset($tags_params,$msg);
}    
ob_start();
echo $shPage;
?>

