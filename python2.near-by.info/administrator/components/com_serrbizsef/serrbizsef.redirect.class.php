<?php
/**
* @version $Id: serrbizsef.redirect.class.php 2007-10-19 11:19:30 facedancer $
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

/**
* @desc class clsSerrBizSEFRedirect - to handle serrBizSef redirect.
*/
class clsSerrBizSEFRedirect
{
	/**
	* Constructor
	*/
    function clsSerrBizSEFRedirect()
    {
    }

	/**
	*@desc validateURL fucntion validates URL
	*@param strinf $URL, boolean $absolute
	*@return boolean true on success false on failure
	*/	
	function validateURL($url, $absolute = TRUE) {
	  $allowed_characters = '[a-z0-9\/:_\-_\.\?\$,;~=#&%\+]';
	  if ($absolute) 
	  {
		return preg_match("/^(http|https|ftp):\/\/". $allowed_characters ."+$/i", $url);
	  }
	  ///^(http|https|ftp):\/\/[a-z0-9\/:_\-_\.\?\$,;~=#&%\+]
	  else 
	  {
		return preg_match("/^". $allowed_characters ."+$/i", $url);
	  }
	}


	/**
	*@desc function sbzDecodeDefaultSEF - decodes default sef
	*@param string strDefaultSEF, 
	*@return string strInternalURL
	*/	
    function sbzDecodeDefaultSEF($strDefaultSEF)
    {
        global $mosConfig_sef;
        $strInternalURL='';
        if($mosConfig_sef) 
        {
            $url_array = explode('/',$strDefaultSEF);

            if (in_array('content', $url_array)) 
            {
                /**
                * Content
                * http://www.domain.com/$option/$task/$sectionid/$id/$Itemid/$limit/$limitstart
                */

                $uri     = explode('content/', $strDefaultSEF);
                $option  = 'com_content';
                $pos     = array_search ('content', $url_array);

                // language hook for content
                $lang = '';
                foreach($url_array as $key=>$value) {
                    if ( !strcasecmp(substr($value,0,5),'lang,') ) {
                        $temp = explode(',', $value);
                        if (isset($temp[0]) && $temp[0] != '' && isset($temp[1]) && $temp[1] != '') {
                            $lang = $temp[1];
                        }
                        unset($url_array[$key]);
                    }
                }

                if (isset($url_array[$pos+8]) && $url_array[$pos+8] != '' && in_array('category', $url_array) && ( strpos( $url_array[$pos+5], 'order,' ) !== false ) && ( strpos( $url_array[$pos+6], 'filter,' ) !== false ) ) {
                    // $option/$task/$sectionid/$id/$Itemid/$order/$filter/$limit/$limitstart
                    $task           = $url_array[$pos+1];
                    $sectionid      = $url_array[$pos+2];
                    $id             = $url_array[$pos+3];
                    $Itemid         = $url_array[$pos+4];
                    $order          = str_replace( 'order,', '', $url_array[$pos+5] );
                    $filter         = str_replace( 'filter,', '', $url_array[$pos+6] );
                    $limit          = $url_array[$pos+7];
                    $limitstart     = $url_array[$pos+8];

                    // pass data onto global variables
                    $_GET['task']           = $task;
                    $_REQUEST['task']       = $task;
                    $_GET['sectionid']      = $sectionid;
                    $_REQUEST['sectionid']  = $sectionid;
                    $_GET['id']             = $id;
                    $_REQUEST['id']         = $id;
                    $_GET['Itemid']         = $Itemid;
                    $_REQUEST['Itemid']     = $Itemid;
                    $_GET['order']          = $order;
                    $_REQUEST['order']      = $order;
                    $_GET['filter']         = $filter;
                    $_REQUEST['filter']     = $filter;
                    $_GET['limit']          = $limit;
                    $_REQUEST['limit']      = $limit;
                    $_GET['limitstart']     = $limitstart;
                    $_REQUEST['limitstart'] = $limitstart;

                    $QUERY_STRING = "option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid&order=$order&filter=$filter&limit=$limit&limitstart=$limitstart";
                } else if (isset($url_array[$pos+7]) && $url_array[$pos+7] != '' && $url_array[$pos+5] > 1000 && ( in_array('archivecategory', $url_array) || in_array('archivesection', $url_array) ) ) {
                    // $option/$task/$id/$limit/$limitstart/year/month/module
                    $task       = $url_array[$pos+1];
                    $id         = $url_array[$pos+2];
                    $limit      = $url_array[$pos+3];
                    $limitstart = $url_array[$pos+4];
                    $year       = $url_array[$pos+5];
                    $month      = $url_array[$pos+6];
                    $module     = $url_array[$pos+7];

                    // pass data onto global variables
                    $_GET['task']           = $task;
                    $_REQUEST['task']       = $task;
                    $_GET['id']             = $id;
                    $_REQUEST['id']         = $id;
                    $_GET['limit']          = $limit;
                    $_REQUEST['limit']      = $limit;
                    $_GET['limitstart']     = $limitstart;
                    $_REQUEST['limitstart'] = $limitstart;
                    $_GET['year']           = $year;
                    $_REQUEST['year']       = $year;
                    $_GET['month']          = $month;
                    $_REQUEST['month']      = $month;
                    $_GET['module']         = $module;
                    $_REQUEST['module']     = $module;

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
                } else if (isset($url_array[$pos+5]) && $url_array[$pos+5] != '') {
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
                } else if (isset($url_array[$pos+4]) && $url_array[$pos+4] != '' && ( in_array('archivecategory', $url_array) || in_array('archivesection', $url_array) )) {
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
                } else if (!(isset($url_array[$pos+5]) && $url_array[$pos+5] != '') && isset($url_array[$pos+4]) && $url_array[$pos+4] != '') {
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
                } else if (!(isset($url_array[$pos+4]) && $url_array[$pos+4] != '') && (isset($url_array[$pos+3]) && $url_array[$pos+3] != '')) {
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
                } else if (!(isset($url_array[$pos+3]) && $url_array[$pos+3] != '') && (isset($url_array[$pos+2]) && $url_array[$pos+2] != '')) {
                // $option/$task/$id
                    $task                     = $url_array[$pos+1];
                    $id                     = $url_array[$pos+2];

                    // pass data onto global variables
                    $_GET['task']             = $task;
                    $_REQUEST['task']         = $task;
                    $_GET['id']             = $id;
                    $_REQUEST['id']         = $id;

                    $QUERY_STRING = "option=com_content&task=$task&id=$id";
                } else if (!(isset($url_array[$pos+2]) && $url_array[$pos+2] != '') && (isset($url_array[$pos+1]) && $url_array[$pos+1] != '')) {
                // $option/$task
                    $task = $url_array[$pos+1];

                    $_GET['task']             = $task;
                    $_REQUEST['task']         = $task;

                    $QUERY_STRING = 'option=com_content&task='. $task;
                }

                if ($lang!='') {
                    $QUERY_STRING .= '&amp;lang='. $lang;
                }
                
                $strInternalURL = $uri[0].'index.php?'.$QUERY_STRING;            
                
            } else if (in_array('component', $url_array)) 
            {

                /*
                Components
                http://www.domain.com/component/$name,$value
                */
                $uri = explode('component/',$strDefaultSEF);
                $uri_array = explode('/', $uri[1]);
                $QUERY_STRING = '';

                // needed for check if component exists
                $path       = $mosConfig_absolute_path .'/components';
                $dirlist    = array();
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
                                /*header( 'HTTP/1.0 404 Not Found' );
                                require_once( $mosConfig_absolute_path . '/templates/404.php' );
                                exit( 404 );*/
                            }
                        }

                        if ( $QUERY_STRING == '' ) {
                            $QUERY_STRING .= "$temp[0]=$temp[1]";
                        } else {
                            $QUERY_STRING .= "&$temp[0]=$temp[1]";
                        }
                    }
                }            
                $strInternalURL = $uri[0].'index.php?'.$QUERY_STRING;            
            } 
        }        
        return $strInternalURL;                
    }//end of function 

		
	/**
	*@desc function sbRedirect301 - performs 301 redirect.
	*@param string formattedURL, string fragment
	*@return false if 301 redirect is not set for the specific URL
	*/	
	function sbRedirect301($formattedURL,$fragment="")
	{
		global $database,$mosConfig_live_site;
        //$formattedURL = trim(str_replace('/anups/serrbiz','',$formattedURL));
        $formattedURL = trim(str_replace('&&','&',$formattedURL));
		
		if($formattedURL[0]=='/')
		   {
		     $formattedURL[0]='';
		     $formattedURL = trim($formattedURL);
		   }	
		/*if URL is either (http://xyz.com) or (http://xyz.com/abc.html)  or (/abc.html)  */
        $sql = "SELECT * FROM ".TBL_SBZ_SEF." WHERE 
                `joom_original` = '".$mosConfig_live_site.$formattedURL."' OR 
                `joom_original` = '".$mosConfig_live_site.'/'.$formattedURL."' OR 
				`joom_original` = '".$formattedURL."'  OR 
				`joom_original` = '/".$formattedURL."'  
				 LIMIT 0,1 ";
		
        $database->setQuery($sql);
        $result = $database->query();
		
		if($result)
		{
		   unset($result);
		   $Records = $database->loadAssocList();
		   if(is_array($Records) && count($Records)>0)
		   {
		   		if(isset($Records[0]['sb_sef']) && trim($Records[0]['sb_sef'])!='' )
				{
				
					$redirect_to = $Records[0]['sb_sef'];
					header("HTTP/1.1 301 Moved Permanently");
					header("Status: 301 Moved Permanently");
					unset($Records);
					header("Location: $redirect_to");
					exit;
				   
				  /*
				  if( $this->validateURL($Records[0]['sb_sef'], TRUE) )
				  {
				     //if ur; is in format http://xyz.com
					$redirect_to = $Records[0]['sb_sef'];
					header("HTTP/1.1 301 Moved Permanently");
					header("Status: 301 Moved Permanently");
					unset($Records);
					header("Location: $redirect_to");
					exit;
				  }
				  else
				  {
				    //if ur; is in format abc.html 
					if($Records[0]['sb_sef'][0]!='/')
				       $redirect_to = $mosConfig_live_site."/".$Records[0]['sb_sef'];
					else
				       $redirect_to = $mosConfig_live_site.$Records[0]['sb_sef'];
					
					header("HTTP/1.1 301 Moved Permanently");
					header("Status: 301 Moved Permanently");
					unset($Records);
					header("Location: $redirect_to");
					exit;
				  }
				  */
				}
		   		
		   }
		}
		else
		{
		  return false;
		}
		
	}	
    
	/**
	*@desc function sbRedirect - performs redirect.
	*@param string formattedURL, string fragment
	*/	
    function sbRedirect($formattedURL,$fragment="")
    {

		$this->sbRedirect301($formattedURL,$fragment);

		global $database,$mosConfig_live_site;
        //check if there are any records in table.
        $sql = "SELECT count(*) FROM ".TBL_SBZ_SEF." WHERE status = 1";                
        $database->setQuery($sql);                                        
        $total_records = $database->loadResult();
        if(!$total_records){
            return "";
        }
        //$formattedURL = str_replace('/joomanup','',$formattedURL);         
        //$formattedURL = str_replace('&&','&',$formattedURL);       

        if($formattedURL == '/index.php') return "";
        //dont proceed for some url. we check if passed url comes under special case.
        $proceed = $this->sbCheckURL($formattedURL);        
        if(!$proceed){
            return "";
        }
        
        //check for fragment in url                                    
        $fragPos = strpos($formattedURL,'#');
        if($fragPos !== false) $formattedURL = substr($formattedURL, 0, $fragPos);        
                
        //first check if this url is a sef in SerrBizSEF
        //if it is then do not redirect user.        
        $strSql = "SELECT * FROM ".TBL_SBZ_SEF." WHERE sb_sef = '".trim($formattedURL)."'  AND link_priority = '2'";
		
        $database->setQuery($strSql);
        $result = $database->query();
		
        if(!$result) {
           unset($result); 
        }else{
           $Records = $database->loadAssocList();
           unset($result);
		   
           if(is_array($Records) && count($Records)>0){
		       //echo "<br>Recfound<br>"; 
               return "";
           }
		   elseif(is_array($Records) && count($Records)==0)
		   {
		     // to check whether URL before ?exist in the database.
		        //echo "<br>Not Found<br>"; 
			    global $parsedNewURL;
			    $parsedNewURL = parse_url($formattedURL);
				if(isset($parsedNewURL['query']))
				{
				  if(isset($parsedNewURL['path']))
				  {
				     $strSql = "SELECT * FROM ".TBL_SBZ_SEF." WHERE sb_sef = '".trim($parsedNewURL['path'])."'  AND link_priority = '2'";
					 $database->setQuery($strSql);
					 $result = $database->query();
					 if(!$result)
					 {
					   unset($result);
					 } 
					 else
					 {
			           $Records = $database->loadAssocList();
			           unset($result);
					   if(is_array($Records) && count($Records)>0)
					   {
						  $parsedNewURL['SAVE_IN_DB'] = 1;
						  return "";
					   }
					   
					 }
					 
				  }
				  
				}
		   } 
        }                 
		
		//exit;
        //process to check default joomla.               
        //pass it to decode default joomla
		
        $strDecode = $this->sbzDecodeDefaultSEF($formattedURL);
        if(strlen(trim($strDecode))>0){
            $formattedURL = $strDecode;
        }
        
        //again pass it to check if url needs to be ignored
        $proceed = $this->sbCheckURL($formattedURL);        
        if(!$proceed){
            return "";
        }
        
        $strOriginal = $formattedURL;
        $formattedURL = strtolower($this->removeQueryParameters($formattedURL,'&Itemid='));                 
        $formattedURL = str_replace('&&','&',$formattedURL);                
        $strSql = "SELECT sb_sef FROM ".TBL_SBZ_SEF." WHERE joom_original LIKE '$formattedURL%' ORDER BY link_priority ASC";
        $database->setQuery($strSql);
        $result = $database->query();
        if(!$result) {
           unset($result);  
        }else{
            $Records = $database->loadAssocList();
            if(is_array($Records) && count($Records)>0)
            {
				if($this->validateURL($Records[0]['sb_sef'], TRUE))
				{
                   $redirect_to = $Records[0]['sb_sef'].$fragment;
				}
				else
				{
                   $redirect_to = $mosConfig_live_site.$Records[0]['sb_sef'].$fragment; 
				}

                unset($result);
                unset($Records);       
				
                header("HTTP/1.1 301 Moved Permanently");
                header("Status: 301 Moved Permanently");
                header("Location: $redirect_to");
                exit(0);                   
            }else{
                //since the link is /index.. format but dont have sef. 
                //this is a case where user has set the link type as "Link URL". 
                //so we need to save it.
                if(substr($strOriginal,0,10)=='/index.php' || substr($strOriginal,0,11)=='/index2.php') 
                {
                    $filepath = $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_serrbizsef/serrbizsef.sef.php';
                    if(file_exists($filepath)) {
                        //include class file to create SEF URL
                        require_once($filepath);
                        sefRelToAbs($strOriginal); 
                        return "";
                    }    
                }                        
            }                    
        }        
        //
        //this function will be called only if above 2 conditions fail. 
        //if a sef is modified by user, then google crawler will never know it.
        //here we try to find the correct internal url.        
        $this->sbOtherCaseRedirect($formattedURL);        
        
    }//end of fnc
    
    
    function  sbOtherCaseRedirect($strURL)
    {                                         
        global $database,$mosConfig_live_site,$SBZ_CUSTOM_ERROR,$mosConfig_absolute_path;
                        
        $strSql = "SELECT joom_original FROM ".TBL_SBZ_SEF." WHERE sb_sef = '".trim($strURL)."' AND link_priority != '2'";
        $database->setQuery($strSql);
        $result = $database->query();
        if(!$result) {
           unset($result); 
        }else{
           $Records = $database->loadAssocList();
           unset($result);
           if(is_array($Records) && count($Records)>0) 
           {
              $formattedURL = $Records[0]['joom_original'];
              $formattedURL = $this->removeQueryParameters($formattedURL,'&Itemid=');
              
              $strSql = "SELECT sb_sef FROM ".TBL_SBZ_SEF." WHERE joom_original LIKE '$formattedURL%' AND link_priority = '2'";
              $database->setQuery($strSql);
              $result = $database->query();
              if(!$result) {
                unset($result);  
              }else{
                $Records = $database->loadAssocList();
                if(is_array($Records) && count($Records)>0)
                {            
                    $redirect_to = $mosConfig_live_site.$Records[0]['sb_sef'].$fragment; 
                    unset($result);
                    unset($Records);
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Status: 301 Moved Permanently");
                    header("Location: $redirect_to");
                    exit(0);                   
                }                    
              }//else                
           }else{
                if(isset($SBZ_CUSTOM_ERROR) && strlen($SBZ_CUSTOM_ERROR)>0) {
                    header('HTTP/1.0 404 Not Found' );
                    header("Location:$SBZ_CUSTOM_ERROR");
                    exit( 404 );
                }else{
                    header( 'HTTP/1.0 404 Not Found' );
                    require_once($mosConfig_absolute_path.'/templates/404.php' );
                    exit( 404 );
                }
           } 
        }       
    }
    
    
	/**
	*@desc function sbOtherCaseRedirect - checks the content of URL.
	*@param string strURL
	*/	
    function  sbCheckURL($strURL)
    {
        $flag = true;

        if(substr($strURL,0,10)=='/index.php') {
            $tempURL = parse_url($strURL); 
            if($tempURL['query']) {
                // break url into component parts            
                parse_str($tempURL['query'], $temp_parts );
                if(isset($temp_parts['option']) && $temp_parts['option']=='com_registration' && $temp_parts['task']=='activate')
                {
                    $flag = false;   
                }       
                if(isset($temp_parts['option']) && $temp_parts['option']=='com_search')
                {
                    $flag = false;   
                }
				if(isset($temp_parts['option']) && $temp_parts['option']=='com_virtuemart')
                {
                    if(isset($temp_parts['page']) && $temp_parts['page']=='shop.downloads'){
                        $flag = false;   
                    }   
                    if(isset($temp_parts['page']) && $temp_parts['page']=='account.order_details'){
                        $flag = false;   
                    }  
                    if(isset($temp_parts['page']) && $temp_parts['page']=='order.order_print'){
                        $flag = false;   
                    }                                      
                }         
                if(isset($temp_parts['option']) && $temp_parts['option']=='login')
                {
                    $flag = false;   
                }
            }//query
        }//   
        
        if(substr($strURL,0,11)=='/index2.php') {
            $tempURL = parse_url($strURL); 
            if($tempURL['query']) {
                // break url into component parts            
                parse_str($tempURL['query'], $temp_parts );
                if(isset($temp_parts['option']) && $temp_parts['option']=='ds-syndicate')
                {
                    $flag = true;   
                }else{
                   $flag = false;  
                }         
            }else{
				$flag = false; 
			}
        }//         
         
        return $flag;
    }
    
    
	/**
	*@desc function removeQueryParameters - removes parameters from query string .
	*@param string strTempURL, string strToRemove
	*@return string strTempURL
	*/	
    function removeQueryParameters($strTempURL,$strToRemove)
    {
        if(strlen(trim($strTempURL)) == 0) return ""; 

		$gotOne='';
		$strTemp='';
        $arrQueryStr = explode($strToRemove,$strTempURL);
        if(isset($arrQueryStr) && isset($arrQueryStr[1]))
        {
            if((strpos($arrQueryStr[1],"&")!==false) || (strpos($arrQueryStr[1],"#")!==false))
            {
                $strTempQuery = $arrQueryStr[1]; 
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
}// end of class
?>