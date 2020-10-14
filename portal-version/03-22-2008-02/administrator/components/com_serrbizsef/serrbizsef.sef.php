<?php
/**
* @version $Id: serrbizsef.sef.php 2007-10-19 11:19:30 $
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

/* Restricted access */
defined( '_VALID_MOS' ) or die( 'Restricted access' );

if($mosConfig_sef) 
{    
        $strRecURL = $_SERVER['REQUEST_URI'];

		if(trim($strRecURL)=="/" || trim($strRecURL)=="" || trim($strRecURL)=="index.php" || trim($strRecURL)=="/index.php" )
		   $strRecURL = "/";

        $fragment = '';
        $intPos = strpos($strRecURL, '#');
        if ($intPos !== false) {
            $fragment  = substr($strRecURL, $intPos);
            $strRecURL = substr($strRecURL, 0, $intPos);
        }
		
        if((!$_POST) && $SBZ_ALLOW_REDIRECT > 0 && !isset($_GET['mosmsg']))
        {
            $filepath = $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_serrbizsef/serrbizsef.redirect.class.php';
            if (file_exists($filepath))
            {  
                require_once($filepath);             
                //create object
                $objSB = new clsSerrBizSEFRedirect();
                // parse url to get the component
                $parsedURL = parse_url($strRecURL);                  
                // to check if link contains fragment identifiers
                $strFragment = "";        
                if(isset($parsedURL['fragment'])) {
                    // ensure fragment identifiers are compatible with HTML4
                    if(preg_match('@^[A-Za-z][A-Za-z0-9:_.-]*$@', $parsedURL['fragment'])) {
                        $strFragment = '#'. $parsedURL['fragment'];
                    }
                }
                unset($parsedURL); 
				//global $toSaveNewVarInDb;
				global $parsedNewURL;
				$parsedNewURL['SAVE_IN_DB']==0;

				if($strRecURL!= "/index.php")
                   $objSB->sbRedirect($strRecURL,$strFragment);
                
				unset($objSB);
            }                    
        }
         
        $filepath = $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_serrbizsef/serrbizsef.sef.class.php';
        if (file_exists($filepath))
        {

            //include class file to create SEF URL
            require_once($filepath);
            //create object
            $objSBSEFF = new clsSBSEF('');
            
            //check if sef has a querystring
            if(substr($strRecURL,0,10)!='/index.php' && isset($_GET['mosmsg'])){
                 $strMosMsg = $_GET['mosmsg'];
                 $strRecURL = $objSBSEFF->removeQueryParameters($strRecURL,"?mosmsg=");
            }

           if(isset($parsedNewURL) && is_array($parsedNewURL) && isset($parsedNewURL['SAVE_IN_DB']) && $parsedNewURL['SAVE_IN_DB']==1 && isset($parsedNewURL['query']))
			{
				$strRecURL = substr($strRecURL,0,strpos($strRecURL,"?")); //removed query parameter
				$arrRES = $objSBSEFF->get_OriginalURL($strRecURL); 
			}
			else
				$arrRES = $objSBSEFF->get_OriginalURL($strRecURL);
			
			/*
			echo "<pre>";
			print_r($arrRES);
			echo "</pre>";
			*/
			
            if(is_array($arrRES) && count($arrRES)>0)
            {                
                //set the section id back
                if(isset($varSectionID) && strlen(trim($varSectionID))>0) 
				    $arrRES['joom_original'] = $arrRES['joom_original']."&".$varSectionID;
                
				//set the item id back
                if(isset($varItemID) && strlen(trim($varItemID))>0) 
				   $arrRES['joom_original'] = $arrRES['joom_original']."&".$varItemID;                
                
				@session_start();
                //if any extra val in session                
				/*
                if(isset($_SESSION[$strRecURL1])){
                 $arrRES['joom_original'] = $arrRES['joom_original']."&".$_SESSION[$strRecURL1];                  
                 //unset($_SESSION[$strRecURL1]);
                }
				*/
				/*
                if(trim($strMosMsg)!=""){
                 $arrRES['joom_original'] = $arrRES['joom_original']."&mosmsg=".$strMosMsg;                  
                } 
				*/                                               
                $_SERVER['REQUEST_URI'] = $arrRES['joom_original'].$fragment;                                
                $parseUrl = parse_url($_SERVER['REQUEST_URI']);
                if (isset($parseUrl['query'])) 
                {
                    $_SERVER['QUERY_STRING'] = $parseUrl['query'];
                    parse_str($parseUrl['query'], $getQuery);
                    $_REQUEST = $_REQUEST + $getQuery;
                    $_GET = $_GET + $getQuery;
                }
				
                $blURLFound = true; 
                if($SB_MeatInfo_Active)
                {   
                    if(isset($arrRES['title']) && strlen($arrRES['title'])>0){
                        global $SBZ_PTITLE;
                        $SBZ_PTITLE = $arrRES['title'];    
                    }

                    if(isset($arrRES['meta_title']) && strlen($arrRES['meta_title'])>0){
                        global $SBZ_MTITLE;
                        $SBZ_MTITLE = $arrRES['meta_title'];    
                    }                    

                    if(isset($arrRES['meta_description']) && strlen($arrRES['meta_description'])>0){
                        global $SBZ_MDESC;
                        $SBZ_MDESC = $arrRES['meta_description'];
                    }

                    if(isset($arrRES['meta_keywords']) && strlen($arrRES['meta_keywords'])>0){
                        global $SBZ_MKEYWORDS;
                        $SBZ_MKEYWORDS = $arrRES['meta_keywords'];
                    }

                    if(isset($arrRES['meta_robot']) && strlen($arrRES['meta_robot'])>0){
                        global $SBZ_MROBOT;
                        $SBZ_MROBOT = $arrRES['meta_robot'];  
                    }    

                }
            }else{                 
                $blURLFound = false;  
            }   
			
           if(isset($parsedNewURL) && is_array($parsedNewURL) && isset($parsedNewURL['SAVE_IN_DB']) && $parsedNewURL['SAVE_IN_DB']==1 && isset($parsedNewURL['query']))
			{
			  /*Request URI is changed from here*/
			  $_SERVER['REQUEST_URI'] = "/"."index.php?".$_SERVER['QUERY_STRING']."&".$parsedNewURL['query'];
			  sefRelToAbs("index.php?".$_SERVER['QUERY_STRING']."&".$parsedNewURL['query']);
			}
            unset($objSBSEFF);
        } 
   //}

    if($blURLFound == false)
    {
        $url_array = explode('/', $_SERVER['REQUEST_URI']);    

        if (in_array('content', $url_array)) 
        {   
            /**
            * Content
            * http://www.domain.com/$option/$task/$sectionid/$id/$Itemid/$limit/$limitstart
            */
            $uri                 = explode('content/', $_SERVER['REQUEST_URI']);
            $option             = 'com_content';
            $_GET['option']     = $option;
            $_REQUEST['option'] = $option;
            $pos                 = array_search ('content', $url_array);
            // language hook for content
            $lang = '';
            foreach($url_array as $key=>$value) {
                if ( !strcasecmp(substr($value,0,5),'lang,') ) {
                    $temp = explode(',', $value);
                    if (isset($temp[0]) && $temp[0]!='' && isset($temp[1]) && $temp[1]!='') {
                        $_GET['lang']       = $temp[1];
                        $_REQUEST['lang']   = $temp[1];
                        $lang               = $temp[1];
                    }
                    unset($url_array[$key]);
                }
            }

            if (isset($url_array[$pos+8]) && $url_array[$pos+8] != '' && in_array('category', $url_array) && ( strpos( $url_array[$pos+5], 'order,' ) !== false ) && ( strpos( $url_array[$pos+6], 'filter,' ) !== false ) ) {
                // $option/$task/$sectionid/$id/$Itemid/$order/$filter/$limit/$limitstart
                $task                   = $url_array[$pos+1];
                $sectionid              = $url_array[$pos+2];
                $id                     = $url_array[$pos+3];
                $Itemid                 = $url_array[$pos+4];
                $order                  = str_replace( 'order,', '', $url_array[$pos+5] );
                $filter                 = str_replace( 'filter,', '', $url_array[$pos+6] );
                $limit                  = $url_array[$pos+7];
                $limitstart             = $url_array[$pos+8];
                // pass data onto global variables
                $_GET['task']             = $task;
                $_REQUEST['task']         = $task;
                $_GET['sectionid']         = $sectionid;
                $_REQUEST['sectionid']     = $sectionid;
                $_GET['id']             = $id;
                $_REQUEST['id']         = $id;
                $_GET['Itemid']         = $Itemid;
                $_REQUEST['Itemid']     = $Itemid;
                $_GET['order']             = $order;
                $_REQUEST['order']         = $order;
                $_GET['filter']         = $filter;
                $_REQUEST['filter']     = $filter;
                $_GET['limit']             = $limit;
                $_REQUEST['limit']         = $limit;
                $_GET['limitstart']     = $limitstart;
                $_REQUEST['limitstart'] = $limitstart;

                $QUERY_STRING = "option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid&order=$order&filter=$filter&limit=$limit&limitstart=$limitstart";

            } else if (isset($url_array[$pos+7]) && $url_array[$pos+7] != '' && $url_array[$pos+5] > 1000 && ( in_array('archivecategory', $url_array) || in_array('archivesection', $url_array) ) ) {
                // $option/$task/$id/$limit/$limitstart/year/month/module
                $task                     = $url_array[$pos+1];
                $id                        = $url_array[$pos+2];
                $limit                     = $url_array[$pos+3];
                $limitstart             = $url_array[$pos+4];
                $year                     = $url_array[$pos+5];
                $month                     = $url_array[$pos+6];
                $module                    = $url_array[$pos+7];

                // pass data onto global variables
                $_GET['task']             = $task;
                $_REQUEST['task']         = $task;
                $_GET['id']             = $id;
                $_REQUEST['id']         = $id;
                $_GET['limit']             = $limit;
                $_REQUEST['limit']         = $limit;
                $_GET['limitstart']     = $limitstart;
                $_REQUEST['limitstart'] = $limitstart;
                $_GET['year']             = $year;
                $_REQUEST['year']         = $year;
                $_GET['month']             = $month;
                $_REQUEST['month']         = $month;
                $_GET['module']            = $module;
                $_REQUEST['module']        = $module;

                $QUERY_STRING = "option=com_content&task=$task&id=$id&limit=$limit&limitstart=$limitstart&year=$year&month=$month&module=$module";            

            } else if (isset($url_array[$pos+7]) && $url_array[$pos+7] != '' && $url_array[$pos+6] > 1000 && ( in_array('archivecategory', $url_array) || in_array('archivesection', $url_array) ) ) {

                // $option/$task/$id/$Itemid/$limit/$limitstart/year/month
                $task                     = $url_array[$pos+1];
                $id                        = $url_array[$pos+2];
                $Itemid                 = $url_array[$pos+3];
                $limit                     = $url_array[$pos+4];
                $limitstart             = $url_array[$pos+5];
                $year                     = $url_array[$pos+6];
                $month                     = $url_array[$pos+7];
                // pass data onto global variables
                $_GET['task']             = $task;
                $_REQUEST['task']         = $task;
                $_GET['id']             = $id;
                $_REQUEST['id']         = $id;
                $_GET['Itemid']         = $Itemid;
                $_REQUEST['Itemid']     = $Itemid;
                $_GET['limit']             = $limit;
                $_REQUEST['limit']         = $limit;
                $_GET['limitstart']     = $limitstart;
                $_REQUEST['limitstart'] = $limitstart;
                $_GET['year']             = $year;
                $_REQUEST['year']         = $year;
                $_GET['month']             = $month;
                $_REQUEST['month']         = $month;

                $QUERY_STRING = "option=com_content&task=$task&id=$id&Itemid=$Itemid&limit=$limit&limitstart=$limitstart&year=$year&month=$month";            

            } else if (isset($url_array[$pos+7]) && $url_array[$pos+7] != '' && in_array('category', $url_array) && ( strpos( $url_array[$pos+5], 'order,' ) !== false )) {

                // $option/$task/$sectionid/$id/$Itemid/$order/$limit/$limitstart
                $task                     = $url_array[$pos+1];
                $sectionid                = $url_array[$pos+2];
                $id                     = $url_array[$pos+3];
                $Itemid                 = $url_array[$pos+4];
                $order                     = str_replace( 'order,', '', $url_array[$pos+5] );
                $limit                     = $url_array[$pos+6];
                $limitstart             = $url_array[$pos+7];
                // pass data onto global variables
                $_GET['task']             = $task;
                $_REQUEST['task']         = $task;
                $_GET['sectionid']         = $sectionid;
                $_REQUEST['sectionid']     = $sectionid;
                $_GET['id']             = $id;
                $_REQUEST['id']         = $id;
                $_GET['Itemid']         = $Itemid;
                $_REQUEST['Itemid']     = $Itemid;
                $_GET['order']             = $order;
                $_REQUEST['order']         = $order;
                $_GET['limit']             = $limit;
                $_REQUEST['limit']         = $limit;
                $_GET['limitstart']     = $limitstart;
                $_REQUEST['limitstart'] = $limitstart;
            
                $QUERY_STRING = "option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid&order=$order&limit=$limit&limitstart=$limitstart";

            } else if (isset($url_array[$pos+6]) && $url_array[$pos+6] != '') {
                // $option/$task/$sectionid/$id/$Itemid/$limit/$limitstart
                $task                     = $url_array[$pos+1];
                $sectionid                = $url_array[$pos+2];
                $id                     = $url_array[$pos+3];
                $Itemid                 = $url_array[$pos+4];
                $limit                     = $url_array[$pos+5];
                $limitstart             = $url_array[$pos+6];
            
                // pass data onto global variables

                $_GET['task']             = $task;
                $_REQUEST['task']         = $task;
                $_GET['sectionid']         = $sectionid;
                $_REQUEST['sectionid']     = $sectionid;
                $_GET['id']             = $id;
                $_REQUEST['id']         = $id;
                $_GET['Itemid']         = $Itemid;
                $_REQUEST['Itemid']     = $Itemid;
                $_GET['limit']             = $limit;
                $_REQUEST['limit']         = $limit;
                $_GET['limitstart']     = $limitstart;
                $_REQUEST['limitstart'] = $limitstart;

                $QUERY_STRING = "option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid&limit=$limit&limitstart=$limitstart";

            } else if (isset($url_array[$pos+5]) && $url_array[$pos+5]!='') {

                // $option/$task/$id/$Itemid/$limit/$limitstart
                $task                     = $url_array[$pos+1];
                $id                     = $url_array[$pos+2];
                $Itemid                 = $url_array[$pos+3];
                $limit                     = $url_array[$pos+4];
                $limitstart             = $url_array[$pos+5];
                // pass data onto global variables
                $_GET['task']             = $task;
                $_REQUEST['task']         = $task;
                $_GET['id']             = $id;
                $_REQUEST['id']         = $id;
                $_GET['Itemid']         = $Itemid;
                $_REQUEST['Itemid']     = $Itemid;
                $_GET['limit']             = $limit;
                $_REQUEST['limit']         = $limit;
                $_GET['limitstart']     = $limitstart;
                $_REQUEST['limitstart'] = $limitstart;

                $QUERY_STRING = "option=com_content&task=$task&id=$id&Itemid=$Itemid&limit=$limit&limitstart=$limitstart";

            } else if (isset($url_array[$pos+4]) && $url_array[$pos+4]!='' && ( in_array('archivecategory', $url_array) || in_array('archivesection', $url_array) )) {

                    // $option/$task/$year/$month/$module
                    $task                     = $url_array[$pos+1];
                    $year                     = $url_array[$pos+2];
                    $month                     = $url_array[$pos+3];
                    $module                 = $url_array[$pos+4];
                    
                    // pass data onto global variables

                    $_GET['task']             = $task;
                    $_REQUEST['task']         = $task;
                    $_GET['year']             = $year;
                    $_REQUEST['year']         = $year;
                    $_GET['month']             = $month;
                    $_REQUEST['month']         = $month;
                    $_GET['module']         = $module;
                    $_REQUEST['module']        = $module;    

                    $QUERY_STRING = "option=com_content&task=$task&year=$year&month=$month&module=$module";

            } else if (!(isset($url_array[$pos+5]) && $url_array[$pos+5]!='') && isset($url_array[$pos+4]) && $url_array[$pos+4]!='') {

            // $option/$task/$sectionid/$id/$Itemid

                $task                     = $url_array[$pos+1];
                $sectionid                 = $url_array[$pos+2];
                $id                     = $url_array[$pos+3];
                $Itemid                 = $url_array[$pos+4];

                // pass data onto global variables

                $_GET['task']             = $task;
                $_REQUEST['task']         = $task;
                $_GET['sectionid']         = $sectionid;
                $_REQUEST['sectionid']     = $sectionid;
                $_GET['id']             = $id;
                $_REQUEST['id']         = $id;
                $_GET['Itemid']         = $Itemid;
                $_REQUEST['Itemid']     = $Itemid;
                
                $QUERY_STRING = "option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid";

            } else if (!(isset($url_array[$pos+4]) && $url_array[$pos+4]!='') && (isset($url_array[$pos+3]) && $url_array[$pos+3]!='')) {

                // $option/$task/$id/$Itemid
                $task                     = $url_array[$pos+1];
                $id                     = $url_array[$pos+2];
                $Itemid                 = $url_array[$pos+3];

                // pass data onto global variables
                $_GET['task']             = $task;
                $_REQUEST['task']         = $task;
                $_GET['id']             = $id;
                $_REQUEST['id']         = $id;
                $_GET['Itemid']         = $Itemid;
                $_REQUEST['Itemid']     = $Itemid;

                $QUERY_STRING = "option=com_content&task=$task&id=$id&Itemid=$Itemid";

            } else if (!(isset($url_array[$pos+3]) && $url_array[$pos+3]!='') && (isset($url_array[$pos+2]) && $url_array[$pos+2]!='')) {

            // $option/$task/$id
                $task                     = $url_array[$pos+1];
                $id                     = $url_array[$pos+2];
                // pass data onto global variables
                $_GET['task']             = $task;
                $_REQUEST['task']         = $task;
                $_GET['id']             = $id;
                $_REQUEST['id']         = $id;

                $QUERY_STRING = "option=com_content&task=$task&id=$id";

            } else if (!(isset($url_array[$pos+2]) && $url_array[$pos+2]!='') && (isset($url_array[$pos+1]) && $url_array[$pos+1]!='')) {

            // $option/$task

                $task = $url_array[$pos+1];
                $_GET['task']             = $task;
                $_REQUEST['task']         = $task;

                $QUERY_STRING = 'option=com_content&task='. $task;

            }

            if ($lang!='') {
                $QUERY_STRING .= '&amp;lang='. $lang;
            }

            $_SERVER['QUERY_STRING']     = $QUERY_STRING;
            $REQUEST_URI                 = $uri[0].'index.php?'.$QUERY_STRING;
            $_SERVER['REQUEST_URI']     = $REQUEST_URI; 
        } 
        else if (in_array('component', $url_array)) 
        {
            /*
            Components
            http://www.domain.com/component/$name,$value
            */

            $uri = explode('component/', $_SERVER['REQUEST_URI']);
            $uri_array = explode('/', $uri[1]);
            $QUERY_STRING = '';

            // needed for check if component exists
            $path        = $mosConfig_absolute_path .'/components';
            $dirlist     = array();
            if ( is_dir( $path ) ) {
                $base = opendir( $path );    
                while (false !== ( $dir = readdir($base) ) ) {
                    if ($dir !== '.' && $dir !== '..' && is_dir($path .'/'. $dir) && strtolower($dir) !== 'cvs' && strtolower($dir) !== '.svn') {
                        $dirlist[] = $dir;
                    }
                }
                closedir($base);
            }

            foreach($uri_array as $value) {
                $temp = explode(',', $value);
                if (isset($temp[0]) && $temp[0]!='' && isset($temp[1]) && $temp[1]!='') {
                    $_GET[$temp[0]]     = $temp[1];
                    $_REQUEST[$temp[0]] = $temp[1];

                    // check to ensure component actually exists
                    if ( $temp[0] == 'option' ) {
                        $check = '';
                        if (count( $dirlist )) {
                            foreach ( $dirlist as $dir ) {
                                if ( $temp[1] == $dir ) {
                                    $check = 1;
                                    break;
                                }
                            }
                        }

                        // redirect to 404 page if no component found to match url
                        if ( !$check ) {
                            header( 'HTTP/1.0 404 Not Found' );
                            require_once( $mosConfig_absolute_path . '/templates/404.php' );
                            exit( 404 );
                        }
                    }

                    if ( $QUERY_STRING == '' ) {
                        $QUERY_STRING .= "$temp[0]=$temp[1]";
                    } else {
                        $QUERY_STRING .= "&$temp[0]=$temp[1]";
                    }
                }
            }
            $_SERVER['QUERY_STRING']    = $QUERY_STRING;
            $REQUEST_URI                = $uri[0].'index.php?'.$QUERY_STRING;
            $_SERVER['REQUEST_URI']     = $REQUEST_URI;

            if (defined('RG_EMULATION') && RG_EMULATION == 1) {
                // Extract to globals
                while(list($key,$value)=each($_GET)) {
                    if ($key!="GLOBALS") {
                        $GLOBALS[$key]=$value;
                    }
                }

                // Don't allow config vars to be passed as global
                include( 'configuration.php' );
                // SSL check - $http_host returns <live site url>:<port number if it is 443>
                $http_host = explode(':', $_SERVER['HTTP_HOST'] );
                if( (!empty( $_SERVER['HTTPS'] ) && strtolower( $_SERVER['HTTPS'] ) != 'off' || isset( $http_host[1] ) && $http_host[1] == 443) && substr( $mosConfig_live_site, 0, 8 ) != 'https://' ) {
                    $mosConfig_live_site = 'https://'.substr( $mosConfig_live_site, 7 );
                }
            }      

        } else {   

            /*
            Unknown content
            http://www.domain.com/unknown
            */
            $jdir = str_replace( 'index.php', '', $_SERVER['PHP_SELF'] );
            $juri = str_replace( $jdir, '', $_SERVER['REQUEST_URI'] );            
            if ($juri != '' && $juri != '/' && !eregi( "index\.php", $_SERVER['REQUEST_URI'] ) && !eregi( "index2\.php", $_SERVER['REQUEST_URI'] ) && !eregi( "/\?", $_SERVER['REQUEST_URI'] ) && $_SERVER['QUERY_STRING'] == '' ) {
                if(isset($SBZ_CUSTOM_ERROR) && strlen($SBZ_CUSTOM_ERROR)>0) {
                    header('HTTP/1.0 404 Not Found' );
                    header("Location:$SBZ_CUSTOM_ERROR");
                    exit( 404 );
                }else{
                    header( 'HTTP/1.0 404 Not Found' );
                    require_once( $mosConfig_absolute_path . '/templates/404.php' );
                    exit( 404 );
                }                                 
            }
        }
    }//blFound is false
    
}//


function sefRelToAbs($ReceivedURL)
{

    global $mosConfig_live_site, $mosConfig_sef, $mosConfig_multilingual_support;
    global $iso_client_lang, $_MAMBOTS, $database,$parsedNewURL;
    $blVMCHK = false;
	$fragment='';
    
    $filepath = $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_serrbizsef/serrbizsef.sef.class.php';
    //include class file to create SEF URL
    require_once($filepath);
    //first validate the URL.
    if(preg_match("/dex\]\.value/", $ReceivedURL)) return;
    //check for relative path   
    if (substr($ReceivedURL, 0, strlen($mosConfig_live_site)) == $mosConfig_live_site) {
        $ReceivedURL = substr($ReceivedURL, strlen($mosConfig_live_site));
    }    
    $ReceivedURL = ltrim($ReceivedURL, '/');   
    //multilingual code url support
    if ($mosConfig_sef && $mosConfig_multilingual_support && $ReceivedURL!='index.php' && !eregi("^(([^:/?#]+):)",$ReceivedURL) && !strcasecmp(substr($ReceivedURL,0,9),'index.php') && !eregi('lang=', $ReceivedURL)) {
        $ReceivedURL .= '&amp;lang='. $iso_client_lang;
    }    
    
    //validation complete now proceed to create SEF
    
    
    if(!checkStringInArr($ReceivedURL) && $mosConfig_sef && !eregi("^(([^:/?#]+):)",$ReceivedURL) && (!strcasecmp(substr($ReceivedURL,0,9),'index.php') || !strcasecmp(substr($ReceivedURL,0,10),'index2.php'))   )
    {
        // Replace all &amp; with &
        $ReceivedURL = str_replace('&amp;', '&', $ReceivedURL);
        //index.php  
        if ($ReceivedURL=='index.php') {
            //$ReceivedURL = '';
        }
        
        ## REMOVE ITEMID, SECTION ID FROM QUERY STRING
        $tempURL = parse_url($ReceivedURL); 
        if(isset($tempURL['query']) && trim($tempURL['query'])!='')
        {
            // break url into component parts            
            parse_str($tempURL['query'], $temp_parts );
            if(isset($temp_parts['option']) && $temp_parts['option']=='com_content' && $temp_parts['task']=='category')
            {
                //first remove section id
                //$ReceivedURL = removeSectionid($ReceivedURL);                                                    
                //check for Itemid and remove it
                //$ReceivedURL = removeItemid($ReceivedURL);
            }else if(isset($temp_parts['option']) && ($temp_parts['option']=='com_content' || $temp_parts['option']=='com_deeppockets'))
            {
                //$ReceivedURL = removeItemid($ReceivedURL);        
            }
            
            if(isset($temp_parts['option']) && $temp_parts['option']=='com_virtuemart' && isset($temp_parts['vmcchk']))
            {
               $blVMCHK = true; 
               $valVM = $temp_parts['vmcchk'];       
               //$ReceivedURL = clsSBSEF::removeQueryParameters($ReceivedURL,'&vmcchk=');                
               //print "<BR>Received : ".$ReceivedURL;                                    
            }
            
            unset($temp_parts);            
            unset($tempURL);   
        }
        ##        
        //create object
        $objSBSEFF = new clsSBSEF($ReceivedURL);
        // parse url to get the component
        $parsedURL = parse_url($ReceivedURL);                  
        // to check if link contains fragment identifiers
        $strFragment = "";        
        if(isset($parsedURL['fragment'])) 
        {
            // ensure fragment identifiers are compatible with HTML4
            if (preg_match('@^[A-Za-z][A-Za-z0-9:_.-]*$@', $parsedURL['fragment'])) {
                $strFragment = '#'. $parsedURL['fragment'];
            }
        }                
        //check 3rd party components
        //$objSBSEFF->sbThirdPartyComponents($ReceivedURL);                
        //search database to get SEF of current URL
        $result = $objSBSEFF->get_SEFURL($strFragment);  
		
        //if($result!="")
		
        if($result!=='' && isset($parsedNewURL['SAVE_IN_DB']) && $parsedNewURL['SAVE_IN_DB']==0)
        {
            unset($objSBSEFF);
            if($blVMCHK) {
                @session_start();
                $_SESSION[$result] = 'vmcchk='.$valVM;
            }
            //we have found a SEF for current URL, return it.
            return $mosConfig_live_site.$result;

        }
        //execute Joomla's default SEF handling
		//pr($parsedURL);
       
	   
	    if(isset($parsedURL)) {
            $ReceivedURL = $objSBSEFF->exec_DefaultSEF($parsedURL);
        }
        if(isset($objSBSEFF) && is_object($objSBSEFF))
        {
           $strResultURL = $objSBSEFF->exec_SerrBizSEF();     
        }
        if($strResultURL == "") {
            $strResultURL = '/'.$ReceivedURL; 
        }
		
		 if(isset($parsedNewURL) && is_array($parsedNewURL) && isset($parsedNewURL['SAVE_IN_DB']) && $parsedNewURL['SAVE_IN_DB']==1)
		 {
		   /*Uncomment this line for storing in database*/
		   //$strResultURL = $strResultURL."?".$parsedNewURL['query'];
		 }
		
		unset($parsedNewURL);
        if($objSBSEFF->save_SEFURL(&$strResultURL))
        {
			unset($objSBSEFF);
            if($blVMCHK) {
                @session_start();
                $_SESSION[$strResultURL] = 'vmcchk='.$valVM;
            }
			//exit; 
            return $mosConfig_live_site . $strResultURL . $fragment;    
        }else{
            exit;
        }
		
		
    }//end of SEF
    else
    {  
		//SEF is not active  
        //Relative link handling
        if ( (strpos( $ReceivedURL, $mosConfig_live_site ) !== 0) ) {
            // if URI starts with a "/", means URL is at the root of the host...
            if (strncmp($ReceivedURL, '/', 1) == 0) {
                // splits http(s)://xx.xx/yy/zz..." into [1]="http(s)://xx.xx" and [2]="/yy/zz...":
                $live_site_parts = array();
                eregi("^(https?:[\/]+[^\/]+)(.*$)", $mosConfig_live_site, $live_site_parts);
                $ReceivedURL = $live_site_parts[1] . $ReceivedURL;
            } else {
                $check = 1;
                // array list of non http/https    URL schemes
                $url_schemes     = explode( ', ', _URL_SCHEMES );
                $url_schemes[]     = 'http:';
                $url_schemes[]     = 'https:';
                foreach ( $url_schemes as $url ) {
                    if ( strpos( $ReceivedURL, $url ) === 0 ) {
                        $check = 0;
                    }
                }
                if ( $check ) {
                    $ReceivedURL = $mosConfig_live_site .'/'. $ReceivedURL;
                }
            }
        }
        return $ReceivedURL;      
    }
}


function removeItemid($strTempURL)
{
    if(strlen(trim($strTempURL)) == 0) return ""; 

    $arrQueryStr = explode("&Itemid=",$strTempURL);
    if(isset($arrQueryStr) && isset($arrQueryStr[1]))
    {
      if((strpos($arrQueryStr[1],"&")!==false) || (strpos($arrQueryStr[1],"#")!==false))
      {
          $strTempQuery = $arrQueryStr[1]; 
          $strTemp = "";
          for($i=0;$i<strlen($strTempQuery);$i++)
          {
             if($strTempQuery[$i] == '&' || $strTempQuery[$i] == '#' || $gotOne == 1)
             {
                if(isset($strTempQuery[$i]))
                {
                    $strTemp = $strTemp.$strTempQuery[$i];
                    $gotOne = 1;
                }//
             }//                  
          }//for each             
       }//found &     
    }
    // if above executes then now we have a string that does not contain Itemid in it.  
    $strTempURL  = $arrQueryStr[0].$strTemp;    
    return $strTempURL;   
}

function removeSectionid($strTempURL)
{
    if(strlen(trim($strTempURL)) == 0) return ""; 
    $arrQueryStr = explode("&sectionid=",$strTempURL);
    if(isset($arrQueryStr) && isset($arrQueryStr[1]))
    {
      if((strpos($arrQueryStr[1],"&")!==false) || (strpos($arrQueryStr[1],"#")!==false))
      {
          $strTempQuery = $arrQueryStr[1]; 
          $strTemp = "";
          for($i=0;$i<strlen($strTempQuery);$i++)
          {
             if($strTempQuery[$i] == '&' || $strTempQuery[$i] == '#' || $gotOne == 1)
             {
                if(isset($strTempQuery[$i]))
                {
                    $strTemp = $strTemp.$strTempQuery[$i];
                    $gotOne = 1;
                }//
             }//                  
          }//for each             
       }//found &     
    }
    // if above executes then now we have a string that does not contain Itemid in it.  
    $strTempURL  = $arrQueryStr[0].$strTemp;    
    return $strTempURL; 
}
function checkStringInArr($str)
{
	   global $strings_type_not_to_be_saved;
	   $cnt = count($strings_type_not_to_be_saved);
	   
	   if(trim($str)=="")
	     return true;
	   //9763571204
	   $i=0;
	   for($i=0;$i<$cnt;$i++)
	   {
		 $pos = strpos($strings_type_not_to_be_saved[$i],$str);
		 $pos1 = strpos($str,$strings_type_not_to_be_saved[$i]);

	     if($pos!==false || $pos1!==false )
		 {
		   return true;
		 }  
	   }
       //String not found in array
	   return false;
}
	

?>