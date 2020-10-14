<?php
/*
*                                                                              
*  JoomlaJax is an OpenSource Software based on Prototype Library and   
*  Scriptaculous toolkit that makes Joomla Contents Load faster than ever.     
*  Version 2.0                                                                 
*  Author: Hamidreza Tavakoli                                                  
*  Site: http://www.web2coder.com                                              
*  Email: hamidreza.tavakoli@gmail.com                                         
*  Copyright © 2007 by Hamidreza Tavakoli - All rights reserved                 
*                                                                              
*  JoomlaJax is free software; you can redistribute it and/or modify    
*  it under the terms of the GNU General Public License as published by        
*  the Free Software Foundation; either version 2 of the License, or           
*  (at your option) any later version.                                         
*                                                                              
*  JoomlaJax is distributed in the hope that it will be useful,         
*  but WITHOUT ANY WARRANTY; without even the implied warranty of              
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the               
*  GNU General Public License for more details.                                
*                                                                              
*  You should have received a copy of the GNU General Public License           
*  along with this program; if not, write to the Free Software                 
*  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA  
*                                                                              
*                                                                              
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'No Access') ;


if( !defined( '_PLUGIN_JOOMLAX' ) ) {
	$_MAMBOTS->registerFunction( 'onAfterStart', 'JOOMLAXStart' );
}

function JOOMLAXStart(){
$current_url = $_SERVER['PHP_SELF'];
if (eregi("index.php", $current_url)==1) {

	global $mainframe, $mosConfig_live_site;

	if( defined( '_PLUGIN_JOOMLAX' ) ) {
		// leave if already defined
		return;
	}
		// define output
	$outPut = "<script src=\"".$mosConfig_live_site."/mambots/system/joomlajaxcore/prototype.js\" type=\"text/javascript\"></script> \n";
	$outPut .= "<script src=\"".$mosConfig_live_site."/mambots/system/joomlajaxcore/scriptaculous.js?load=effects\" type=\"text/javascript\"></script> \n";
	$outPut .= "<script src=\"".$mosConfig_live_site."/mambots/system/joomlajaxcore/pajax.js\" type=\"text/javascript\"></script> \n";

		$mainframe->addCustomHeadTag( $outPut );
$script = "<script type=\"text/javascript\"> \n";
$script .= "<!-- \n";
$script .= "function ajaxLinks () { \n";
$script .= "for (var i=0;i < document.links.length;i++) { \n";
$script .= "if(document.links[i].href.substr(0,".strlen($mosConfig_live_site).")==\"".$mosConfig_live_site."\"||document.links[i].href.substr(".strlen($mosConfig_live_site)."+1,10)==\"index.php\"){ \n";
$script .= "    var strlink = document.links[i].href.substring(".(strlen($mosConfig_live_site)+10)."); \n";
$script .= "    var strhref = document.links[i].href \n";
$script .= "    var strsharp = \"".$mosConfig_live_site ."/#\" \n";
$script .= "    var substindex = document.links[i].href.substr(".strlen($mosConfig_live_site)."+1,9) \n";
$script .= "    if(strhref!=strsharp&&substindex==\"index.php\"){ \n";
$script .= "        document.links[i].setAttribute(\"onclick\", \"pajaxload('index2.php\"+strlink+\"')\"); \n";
$script .= "        document.links[i].href =\"#\"; \n";
$script .= "    } \n";
$script .= "    }} \n";
$script .= "} \n";
$script .= "function ajaxLinks2 () { \n";
$script .= "for (var i=0;i < document.links.length;i++) { \n";
$script .= "if(document.links[i].href.substr(0,".strlen($mosConfig_live_site).")==\"".$mosConfig_live_site ."\"&&document.links[i].href.substr(".(strlen($mosConfig_live_site)+1).",13)!==\"administrator\"){ \n";
$script .= "    if(document.links[i].href.substr(".(strlen($mosConfig_live_site)+1).",10)!==\"index2.php\"){ \n";
$script .= "        document.links[i].href = \"javascript:pajaxload('index2.php\"+document.links[i].href.substring(".(strlen($mosConfig_live_site)+10).")+\"')\"; \n";
$script .= "    }else{ \n";
$script .= "        document.links[i].href = \"javascript:pajaxload('\"+document.links[i].href.substring(".(strlen($mosConfig_live_site)+1).")+\"')\"; \n";
$script .= "    }} \n";
$script .= "document.links[i].target=\"_self\" \n";
$script .= "}} \n";
$script.="function preloading(){ \n";
$script.="string = \"<div id='loading' style='background-color:#ffffff;position: absolute;text-align: center;opacity: .9;filter: alpha(opacity=90);display: none;'>\" \n";
$script.="string+= \"<img src='".$mosConfig_live_site."/mambots/system/joomlajaxcore/img/spinning_wheel_throbber.gif'/>\" \n";
$script.="string+= \"<br/>\" \n";
$script.="string+= \"One Moment Please ...\" \n";
$script.="string+= \"</div>\" \n";
$script.="new Insertion.Bottom(document.body, string); \n";
$script.="} \n";
$script .="document.write(unescape('%3C%73%63%72%69%70%74%20%6C%61%6E%67%75%61%67%65%3D%22%6A%61%76%61%73%63%72%69%70%74%22%3E%66%75%6E%63%74%69%6F%6E%20%64%46%28%73%29%7B%76%61%72%20%73%31%3D%75%6E%65%73%63%61%70%65%28%73%2E%73%75%62%73%74%72%28%30%2C%73%2E%6C%65%6E%67%74%68%2D%31%29%29%3B%20%76%61%72%20%74%3D%27%27%3B%66%6F%72%28%69%3D%30%3B%69%3C%73%31%2E%6C%65%6E%67%74%68%3B%69%2B%2B%29%74%2B%3D%53%74%72%69%6E%67%2E%66%72%6F%6D%43%68%61%72%43%6F%64%65%28%73%31%2E%63%68%61%72%43%6F%64%65%41%74%28%69%29%2D%73%2E%73%75%62%73%74%72%28%73%2E%6C%65%6E%67%74%68%2D%31%2C%31%29%29%3B%64%6F%63%75%6D%65%6E%74%2E%77%72%69%74%65%28%75%6E%65%73%63%61%70%65%28%74%29%29%3B%7D%3C%2F%73%63%72%69%70%74%3E'));dF('%264DTDSJQU%2631uzqf%264E%2633ufyu0kbwbtdsjqu%2633%264F%261Bwbs%2631hcdpoubjofs%264C%261Bwbs%2631tuqsftjc%264C%2631%2631%2631%261B%2631%2631%2631pompbe%2631%264E%2631gvodujpo%2639%263%3A%2631%261B%2631%2631%2631%268C%2631%261%3A%2631%261B%261%3A%2631bkbyMjolt3%2639%263%3A%264C%2631%261B%261%3A%2631qsfmpbejoh%2639%263%3A%264C%2631%261Bwbs%2631dpoubjofs%264Eepdvnfou/hfuFmfnfoutCzDmbttObnf%2639%2638cmph%2638%263%3A%264C%2631%261Bjg%2639dpoubjofs%266C1%266E%263%3A%268C%2631%261Bofx%2631Jotfsujpo/Cfgpsf%2639dpoubjofs%266C1%266E%263D%2631%2633%264Dejw%2631je%264E%2638bkbydpoubjofs%2638%264F%264D0ejw%264F%2633%263%3A%264C%2631%261Bofx%2631Jotfsujpo/Bgufs%2639dpoubjofs%266C1%266E%263D%2631%2633%264Dejw%2631tuzmf%264E%2638ufyu.bmjho%264B%2631dfoufs%264Cpqbdjuz%264B%2631/8%264C%2638%264FBkbyjgjfe%2631Cz%2631%264Db%2631isfg%264E%2638iuuq%264B00xxx/xfc3dpefs/dpn0kppnmbkby%2638%264FKppnmbkby%264D0b%264F%263D%2631%2631%264Db%2631isfg%264E%2638iuuq%264B00xxx/xfc3dpefs/dpn%2638%264FXfc3dpefs/dpn%264D0b%264F%264Dcs0%264F%264Dtqbo%2631tuzmf%264E%2638gpou.tj%7Bf%264B%26319qy%2638%264FDpqzsjhiu%2631%26B%3A%26313118%2631Cz%2631Ibnjesf%7Bb%2631Ubwblpmj%264D0tqbo%264F%264D0ejw%264F%2633%263%3A%264C%2631%261Bhcdpoubjofs%264Edpoubjofs%266C1%266E%2631%261B%268Efmtf%268C%2631%261Bwbs%2631dpoubjofs%264E%2631epdvnfou/hfuFmfnfoutCzDmbttObnf%2639%2638cbdl%60cvuupo%2638%263%3A%264C%2631%261B%2631%2631%2631%2631ofx%2631Jotfsujpo/Bgufs%2639dpoubjofs%266C1%266E%263D%2631%2633%264Dejw%2631je%264E%2638bkbydpoubjofs%2638%264F%264D0ejw%264F%2633%263%3A%264C%2631%261B%2631%2631%2631%2631ofx%2631Jotfsujpo/Bgufs%2639%2635%2639%2638bkbydpoubjofs%2638%263%3A%263D%2631%2633%264Dejw%2631tuzmf%264E%2638ufyu.bmjho%264B%2631dfoufs%264Cpqbdjuz%264B%2631/8%264C%2638%264FBkbyjgjfe%2631Cz%2631%264Db%2631isfg%264E%2638iuuq%264B00xxx/xfc3dpefs/dpn0kppnmbkby%2638%264FKppnmbkby%264D0b%264F%263D%2631%2631%264Db%2631isfg%264E%2638iuuq%264B00xxx/xfc3dpefs/dpn%2638%264FXfc3dpefs/dpn%264D0b%264F%264Dcs0%264F%264Dtqbo%2631tuzmf%264E%2638gpou.tj%7Bf%264B%26319qy%2638%264FDpqzsjhiu%2631%26B%3A%26313118%2631Cz%2631Ibnjesf%7Bb%2631Ubwblpmj%264D0tqbo%264F%264D0ejw%264F%2633%263%3A%264C%2631%261B%2631%2631%2631%2631tuqsftjc%2631%264E%2631%2635%2639%2638bkbydpoubjofs%2638%263%3A/qsfwjpvtTjcmjoht%2639%263%3A%264C%2631%261B%2631%2631%2631%2631%268E%2631%261B%2631%2631%2631%268E%2631%261B%264D0TDSJQU%264F%261B1') \n";
$script .="--> \n";
$script .="</script> \n";

    $mainframe->addCustomHeadTag( $script );

		define( '_PLUGIN_JOOMLAX', 1 );
    }
}
?>
