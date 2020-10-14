<?php
/**
* @version $Id: serrbizsef.sef.class.php 2007-10-19 11:19:30 $
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

  class clsSBSEF
  {
	/**
     * A value of received URL 
     * @access private
     * @var string
     */
     var $receivedURL;
	/**
     * A value of formatted URL
     * @access private
     * @var string
     */
     var $formattedURL;
	/**
     * array of records
     * @access private
     * @var array
     */
     var $arrRecords = array();
	/**
     * component type of URL
     * @access private
     * @var string
     */
     var $component_type;
	/**
     * sbz_id
     * @access private
     * @var integer
     */
     var $sbz_id;
	/**
     * Link priority of URL
     * @access private
     * @var integer
     */
     var $link_priority;
	/**
     * joomla's original URL saved in the #_serrbizsef_sef table field name 'joom_original'
     * @access private
     * @var integer
     */
     var $originalURL;
	/**
     * A Whether it is an SEF URL
     * @access private
     * @var integer
     */
     var $is_sef;
	/**
     * A page type 1|2|3
     * @access private
     * @var integer
     */
     var $pageType;
	/**
     * Array of meta details
     * @access private
     * @var integer
     */
     var $arrMetaDetails;
	/**
     * Array of meta details
     * @access private
     * @var array
     */
     var $meta_set;
	/**
     * Array of selected components
     * @access private
     * @var array
     */
     var $arrSelectedComps = array();

    /**
	 * constructor  Constructor sets up {@link $receivedURL,$formattedURL,$sbz_id,$link_priority,$pageType,$arrMetaDetails,$sbCheckComponent}
	 */    
     function clsSBSEF($url)
     {
         if(strlen($url)>0)
         {
             $this->receivedURL   = $url;
             if($this->receivedURL[0]!=="/"){
                $this->formattedURL  = '/'.$this->receivedURL;             
             }else{
                $this->formattedURL  = $this->receivedURL;
             }   
             $this->sbz_id        = 0;
             $this->link_priority = 2;
             $this->pageType      = -1;
             $this->arrMetaDetails = array();
             $this->sbCheckComponent();
         }
     }   
    

    /**
     * @desc Function sbGetSearch - fetch all records from #_serrbizsef_sef assign to arrRecords
     * @access public
     */
     function get_Pages()
     {
        global $database;         

        $strSql = "SELECT * FROM ".TBL_SBZ_SEF." ORDER BY link_priority ASC";
        $database->setQuery($strSql);
        $result = $database->query();
        if(!$result) {
            //echo $database->stderr();
            //exit;
        }        
        $this->arrRecords = $database->loadAssocList();
        unset($result);        
     }

    /**
     * @desc Function get_SEFURL - gets SEF URL from table #_serrbizsef_sef for given internal URL
     * @access public
	 * @param string fragment
     */
     function get_SEFURL($fragment="")
     {
        global $database;
        $return = "";
        //check for fragment in url                                    
        $fragPos = strpos($this->formattedURL,'#');
        if($fragPos !== false) {
            $this->formattedURL = substr($this->formattedURL, 0, $fragPos);
        }
        $strSql = "SELECT sb_sef FROM ".TBL_SBZ_SEF." WHERE joom_original = '".$this->formattedURL."' AND status = 1 ORDER BY link_priority ASC";
		//print $strSql;
        $database->setQuery($strSql);
        $result = $database->query();
        if(!$result) {
           unset($result); 
           return $return; 
        }else{
           $this->arrRecords = $database->loadAssocList();
		   
		   if(count($this->arrRecords)>0)
		   {
           		return $this->arrRecords[0]['sb_sef'].$fragment; 
		   }
		   return array();
		   	
           unset($result);   
        }       
     }

   
    /**
     * @desc Function get_OriginalURL - gets Original URL from table #_serrbizsef_sef for given SEF URL
     * @access public
	 * @param string fragment
     */
     function get_OriginalURL($strURL)
     {    
        global $database;         
        $arrReturn = array();                 
        //check for fragment in url                                    
        $fragPos = strpos($this->formattedURL,'#');
        if ($fragPos !== false) {
            $this->formattedURL = substr($this->formattedURL, 0, $fragPos);
        }        
        //$strURL = str_replace('/joomanup','',$strURL);
		
		$strSql = "SELECT * FROM ".TBL_SBZ_SEF." WHERE sb_sef = '".trim($strURL)."' AND status = 1 ORDER BY link_priority ASC";
        $database->setQuery($strSql);
        $result = $database->query();
        if(!$result) {
            unset($result); 
            return $arrReturn; 
        }else{
            $this->arrRecords = $database->loadAssocList();   
            if(count($this->arrRecords) > 0)    
            {
                if(!isset($this->arrRecords[0]))
				{
				  echo '<pre>';
				  	print_r($this->arrRecords);
				  echo '</pre>';
				}
				
				$arrReturn['joom_original']    = $this->arrRecords[0]['joom_original'];
                $arrReturn['title']            = $this->sbFormatString($this->arrRecords[0]['title']);
                $arrReturn['meta_title']       = $this->sbFormatString($this->arrRecords[0]['meta_title']);
                $arrReturn['meta_description'] = $this->sbFormatString($this->arrRecords[0]['meta_description']); 
                $arrReturn['meta_keywords']    = $this->sbFormatString($this->arrRecords[0]['meta_keywords']); 
                $arrReturn['meta_robot']       = $this->sbCreateTag($this->arrRecords[0]['rob_index'],$this->arrRecords[0]['follow']);
                unset($result);
            }                     
            return $arrReturn;           
        }
     }

     
    /**
     * @desc Function sbCreateTag - returns valoe for robot tag
     * @access public
	 * @param integer ind1, integer ind2
     * @return string
     */
     function sbCreateTag($ind1,$ind2)
     {
         if($ind1 == 0 && $ind2 == 0){
            return "noindex,nofollow"; 
         }elseif($ind1 == 0 && $ind2 == 1){
            return "noindex,follow";  
         }elseif($ind1 == 1 && $ind2 == 0){
            return "index,nofollow";  
         }elseif($ind1 == 1 && $ind2 == 1){
             return "index,follow"; 
         }   
     }     

    /**
     * @desc Function sbFormatString - returns formatted string
     * @access public
	 * @param string Value
     * @return string Value
     */
     function sbFormatString($Value) 
     {
         $Value = htmlspecialchars($Value);
         $Value = stripslashes($Value); 
         $Value = str_replace("\r",'', $Value);
         $Value = str_replace("\n",'', $Value);
         return $Value; 
    }

     function exec_DefaultSEF($arrURL)
     {
        if(is_array($arrURL) && count($arrURL)>0 && isset($arrURL['query']))
        {
            // special handling for javascript
            $arrURL['query'] = stripslashes( str_replace( '+', '%2b', $arrURL['query'] ) );
            // clean possible xss attacks
            $arrURL['query'] = preg_replace( "'%3Cscript[^%3E]*%3E.*?%3C/script%3E'si", '', $arrURL['query'] );
            // break url into component parts            
            parse_str( $arrURL['query'], $parts );
            // special handling for javascript
            foreach( $parts as $key => $value) {
                if ( strpos( $value, '+' ) !== false ) {
                    $parts[$key] = stripslashes( str_replace( '%2b', '+', $value ) );
                }
            }
            
            $sefstring = '';
            // Component com_content urls
            if ( ( ( isset($parts['option']) && ( $parts['option'] == 'com_content' || $parts['option'] == 'content' ) ) ) && ( $parts['task'] != 'new' ) && ( $parts['task'] != 'edit' ) ) 
            {
                // index.php?option=com_content [&task=$task] [&sectionid=$sectionid] [&id=$id] [&Itemid=$Itemid] [&limit=$limit] [&limitstart=$limitstart] [&year=$year] [&month=$month] [&module=$module]
                $sefstring .= 'content/';
                // task 
                if ( isset( $parts['task'] ) ) {
                    $sefstring .= $parts['task'].'/';                    
                }
                // sectionid 
                if ( isset( $parts['sectionid'] ) ) {
                    $sefstring .= $parts['sectionid'].'/';                    
                }
                // id 
                if ( isset( $parts['id'] ) ) {
                    $sefstring .= $parts['id'].'/';                    
                }
                // Itemid 
                if ( isset( $parts['Itemid'] ) ) {
                    //only add Itemid value if it does not correspond with the 'unassigned' Itemid value
                    if ( $parts['Itemid'] != 99999999 && $parts['Itemid'] != 0 ) {
                        $sefstring .= $parts['Itemid'].'/';                    
                    }
                }
                // order
                if ( isset( $parts['order'] ) ) {
                    $sefstring .= 'order,'. $parts['order'].'/';    
                }
                // filter
                if ( isset( $parts['filter'] ) ) {
                    $sefstring .= 'filter,'. $parts['filter'].'/';    
                }
                // limit
                if ( isset( $parts['limit'] ) ) {
                    $sefstring .= $parts['limit'].'/';    
                }
                // limitstart
                if ( isset( $parts['limitstart'] ) ) {
                    $sefstring .= $parts['limitstart'].'/';                    
                }
                // year
                if ( isset( $parts['year'] ) ) {
                    $sefstring .= $parts['year'].'/';                    
                }
                // month
                if ( isset( $parts['month'] ) ) {
                    $sefstring .= $parts['month'].'/';                    
                }
                // module
                if ( isset( $parts['module'] ) ) {
                    $sefstring .= $parts['module'].'/';                    
                }
                // lang
                if ( isset( $parts['lang'] ) ) {
                    $sefstring .= 'lang,'. $parts['lang'].'/';                    
                }
                //return SEF for com_content
                return $sefstring;                
            }else if(isset($parts['option']) && (strpos($parts['option'],'com_') !== false)) 
            {
                $sefstring     = 'component/';
                foreach($parts as $key => $value) {
                    // remove slashes automatically added by parse_str
                    $value      = stripslashes($value);
                    $sefstring .= $key .','. $value.'/';
                }
                $sefstring = str_replace( '=', ',', $sefstring );
                //return SEF for com_component
                return $sefstring;
            }
        }else{
            return "";
        } 
     }

     

     function exec_SerrBizSEF()
     {
         global $database,$sefConfigs;
         $strSEFURL = ''; 
		 $User_Holder='';
		 $arrRules =array();
         if(isset($this->formattedURL))
         {
            //parse the url to get its component
            $arrComponents = parse_url($this->formattedURL);             
            if(isset($arrComponents['query'])) 
            {
                parse_str($arrComponents['query'],$arrQuery);    
                if(!empty($arrQuery['option'])) 
                {
                   $this->component_type = $arrQuery['option'];
                   
                   if(array_key_exists($this->component_type, $this->arrSelectedComps)) {
                        if($this->arrSelectedComps[$this->component_type][0]['status']==0){
                             return "";
                        }else{
                          if(trim($this->arrSelectedComps[$this->component_type][0]['user_value'])!=""){
                              $User_Holder = $this->arrSelectedComps[$this->component_type][0]['user_value'];
                          }  
                        }
                   }
                   
                   //first check if we have a patch for this component
                   $filepath = $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_serrbizsef/serrbizsef_sef_rules/serrbizsef.patches.php';
                   if(file_exists($filepath))
                   {
                       require_once($filepath);
                       $clsName = "SB_".$this->component_type;
                       if(class_exists($clsName))
                       {
                           $objComp = new $clsName();
                           $arrSEFURL = $objComp->SB_ExecProcess($arrQuery);
                           if(is_array($arrSEFURL) && count($arrSEFURL)>0)
                           {
                                if(isset($arrSEFURL['sbz_id'])) $this->sbz_id   = $arrSEFURL['sbz_id'];
                                if(isset($arrSEFURL['type']))   $this->pageType = $arrSEFURL['type'];   
                                if(isset($arrSEFURL['meta_info'])){
                                    $this->arrMetaDetails['metadesc'] = '';                              
                                    $this->arrMetaDetails['metakey'] = '';
                                    $this->arrMetaDetails['title'] = '';
									
									if(isset($arrSEFURL['meta_info']['metadesc']))
                                       $this->arrMetaDetails['metadesc'] = $arrSEFURL['meta_info']['metadesc'];
									
									if(isset($arrSEFURL['meta_info']['metakey']))
                                    	$this->arrMetaDetails['metakey'] = $arrSEFURL['meta_info']['metakey'];
                                    
									if(isset($arrSEFURL['meta_info']['title']))
										$this->arrMetaDetails['title'] = $arrSEFURL['meta_info']['title'];

                                    $this->meta_set = 1;
                                }                                 
                                if(isset($arrSEFURL['strSEF'])) {
                                    $this->link_priority = 2;
                                    $this->is_sef        = 1;                                    
                                    return $arrSEFURL['strSEF'];
                                } 
								
								if(isset($arrSEFURL['robot_index']))
								    $this->arrMetaDetails['robot_index'] = $arrSEFURL['robot_index'];
								
								if(isset($arrSEFURL['robot_follow']))
								    $this->arrMetaDetails['robot_follow'] = $arrSEFURL['robot_follow'];
								
                           }
                           unset($objComp);                        
                       }    
                   }
                   //format url for 3rd party component
                   $this->sbThirdPartyComponents('remove');                   
                   //again parse url
                   $arrComponents = parse_url($this->formattedURL);
                   parse_str($arrComponents['query'],$arrQuery);                   
                   //we dont have patch.. so now check if we have rules.
                   $filepath = $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_serrbizsef/serrbizsef_sef_rules/serrbizsef_'.$this->component_type.'.dat';
                   if(file_exists($filepath))
                   {
                        include($filepath);                        
                        $strSerialize = str_replace("\'", "'", $strSerialize);
                        $arrRules     = unserialize($strSerialize);                            
                        
						if(!isset($arrRules[$this->component_type])) {
                          $arrRules[$this->component_type]['status'] = 0;                                  
                        }else{
                          $arrRules[$this->component_type]['status'] = 1;      
                        }
                   }//file exist 
                   
                   if(trim($User_Holder)!="" && isset($arrRules[$this->component_type]['vars']['holder']['value']))
				   {
                     $arrRules[$this->component_type]['vars']['holder']['value'] = $User_Holder;
                   }
                                                         
                   //check if rules array is found
                   if(isset($arrRules[$this->component_type]) && $arrRules[$this->component_type]['status'] == 1)
                   {
                        $arrElementList = $arrQuery;                         
                        //remove the option element, as we dont need it now.
                        unset($arrElementList['option']);                                                
                        $arrRules[$this->component_type]['result']['item']  = array();
                        $arrRules[$this->component_type]['result']['data']  = array();                                                
                        $searchArray = array_keys($arrElementList);                
                        array_walk($searchArray, create_function('&$v,$k', '$v = \'{\' . $v . \'}\';'));                        
                        foreach($arrRules[$this->component_type]['vars'] as $vName => $vData)
                        {
                            $arrRules[$this->component_type]['result']['item'][] = '{'.$vName.'}';                            
                            if (isset($vData['ifpresent']) and empty($arrElementList[$vData['ifpresent']])) continue;
                            if (isset($vData['ifabsent']) and (! empty($arrElementList[$vData['ifabsent']]))) continue;                            
                            switch($vData['type'])
                            {
                                case 'query':                                
                                $vData['query'] = str_replace($searchArray, array_values($arrElementList), $vData['query']);
                                $database->setQuery($vData['query']);
                                $result = $database->query();                                                                
                                if($result) {
                                    $val = $database->loadResult();
                                    unset($result);
                                }
                                if(empty($val)) {
                                    $rnd = substr(md5(mt_rand(1,1000)),0,16);
                                    $val = str_replace('?', $rnd, $vData['empty']);
                                } 
                                //get the values
                                $arrRules[$this->component_type]['result']['data'][] = $this->sbFormatURLs($val);
                                break;                             
                                case 'string':                                                                
                                $arrRules[$this->component_type]['result']['data'][] = $this->sbFormatURLs(str_replace($searchArray, array_values($arrElementList), $vData['value']));

                                break;
                            }
                        }

                        foreach ($arrRules[$this->component_type]['conds'] as $arrConditions) 
                        {
                            foreach ($arrConditions['arguments'] as $argName => $argValue)
                            {
                                if (isset($arrElementList[$argName])) 
                                {
                                    if($argValue == '*') {
                                        $arrConditions['arguments'][$argName] = $arrElementList[$argName];
                                    }                                       
                                    //explode the task string
                                    $arrTask = explode('|', $argValue);                                    
                                    //check if present in array
                                    if (in_array($arrElementList[$argName], $arrTask)) {
                                        //set value
                                        $arrConditions['arguments'][$argName] = $arrElementList[$argName];
                                    }    
                                }//  
                            }//inner for   
							
							
                            if(array_intersect_assoc($arrConditions['arguments'], $arrElementList) == $arrConditions['arguments'])
                            {   


                                $strSEFURL = str_replace($arrRules[$this->component_type]['result']['item'], $arrRules[$this->component_type]['result']['data'], $arrConditions['tpl']);
                                $this->is_sef = 1;
                                break;
                            }
                        } //outer 
                   }//status                                                         
                }//option                
            }//query
         }   
         //format

         $strSEFURL = str_replace("-/-","-",$strSEFURL);         

         return $strSEFURL; 

     }// end of func

     
     function sbCheckComponent()
     {
        global $database;  
        
        $sqlStr = "SELECT format,user_specific_name,status FROM ".TBL_SBZ_COMP." ORDER BY id ASC";
        $database->setQuery($sqlStr);       
        //load records
        $Records = $database->loadObjectList();        
        if(is_array($Records) && count($Records) > 0){
            foreach($Records as $key=>$data) {
                $this->arrSelectedComps[$data->format][0]['status'] = $data->status;              
                $this->arrSelectedComps[$data->format][0]['user_value'] = $data->user_specific_name;
            } 
        }
     }
     
     
    /**
     * @desc Function save_SEFURL - saves joom_original, sb_sef, component, title, meta_description, meta_keywords,type,sbz_id,link_priority,is_sef,rob_index,follow in  #_serrbizsef_sef
	 * before saving is checks whether it already exists in database.
     * @access public
	 * @param string strResultURL
     * @return string Value
     */
     function save_SEFURL(&$strResultURL)
     {
		global $database; 
        $result = false;        
        $type   = -1;        
        $strComp1 = "section|blogsection|archivesection";      
        $strComp2 = "category|blogcategory|archivecategory";
       
        //check if we have saved url as original
        if(isset($this->originalURL) && strlen($this->originalURL)) {
            $this->formattedURL = $this->originalURL;
        }                                            

        $originalURL  = $database->getEscaped($this->formattedURL);        
        //to get the content id
        $tempURL = parse_url($originalURL);         
        if(isset($tempURL['query']) && trim($tempURL['query'])!='')
        {
            // break url into component parts            
            parse_str($tempURL['query'], $temp_parts );            
            if(isset($temp_parts['option']) && $temp_parts['option']=='com_content' && isset($temp_parts['id']))
            {
                $arr1 = explode("|",$strComp1);
                $arr2 = explode("|",$strComp2);
                if(@in_array($temp_parts['task'],$arr1))
                {
                    $this->sbz_id = $temp_parts['id']; 
                    $this->pageType = 2;    
                }else if(@in_array($temp_parts['task'],$arr2))
                {
                    $this->sbz_id = $temp_parts['id']; 
                    $this->pageType = 1;    
                }else if($temp_parts['task']== 'view')
                {
                    $this->sbz_id = $temp_parts['id'];                     
                    $this->pageType = 0;                        
                }
            }
        }                
        
        $strResultURL = $database->getEscaped($strResultURL);        
        
        if(!isset($this->component_type)) {
            $this->component_type = 'com_frontpage';
        }      
        
        if($this->meta_set!=1) {
            //get meta desc, keywords for content item
			$this->arrMetaDetails = $this->sbGetMetaInfo();
        }
                        
        //check link priority
        $this->link_priority = $this->sbCheckPriority($strResultURL);

        //check for import sef
        $strSef = $this->sbCheckImportSEF($originalURL,$strResultURL);
        if(strlen($strSef)>0){
          $strResultURL = $strSef;                         
        }
        
        //patch code
        $filepath = $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_serrbizsef/serrbizsef_sef_rules/serrbizsef.patches.php';
        if(file_exists($filepath)) {
            require_once($filepath);    
            if(function_exists('SBZ_ExtraFormatting')) {
                SBZ_ExtraFormatting(&$originalURL,&$strResultURL);
            }    
        }
        //
        
        $sql_check_before_insert = " SELECT id from ".TBL_SBZ_SEF." WHERE joom_original='".$originalURL."'  AND sb_sef='".$strResultURL."' ";
		
        $database->setQuery($sql_check_before_insert);
		$duplicateRes =  $database->query();
        $url_id = $database->loadResult();


		if(!$url_id)
	    {
			$follow = 1;
			$index = 1;
			
			 if(isset($this->arrMetaDetails['robot_index']))	
			 {
				$index=$this->arrMetaDetails['robot_index'];
			 }	
			 if(isset($this->arrMetaDetails['robot_follow']))	
			 {
			    $follow=$this->arrMetaDetails['robot_follow'];
			 } 	
			
			$pageTitle ='';$metadesc ='';$metakey='';
			
			if(isset($this->arrMetaDetails['title']))
				$pageTitle = htmlentities($this->arrMetaDetails['title']);
			
			if(isset($this->arrMetaDetails['metadesc']))
				$metadesc = htmlentities($this->arrMetaDetails['metadesc']);
			
			if(isset($this->arrMetaDetails['metakey']))
				$metakey = htmlentities($this->arrMetaDetails['metakey']);

			//$pageTitle = $this->arrMetaDetails['title'];
			//$metadesc = $this->arrMetaDetails['metadesc'];
			//$metakey = $this->arrMetaDetails['metakey'];
			
			$sql = 'INSERT INTO '.TBL_SBZ_SEF.' (joom_original, sb_sef, component, title, meta_description, meta_keywords,type,sbz_id,link_priority,is_sef,rob_index,follow)';
			$sql .= ' VALUES ("'.$originalURL.'", "'.$strResultURL.'","'.$this->component_type.'","'.$pageTitle.'","'.$metadesc.'","'.$metakey.'","'.$this->pageType.'","'.$this->sbz_id.'","'.$this->link_priority.'","'.$this->is_sef.'","'.$index.'","'.$follow.'")';
							
			$database->setQuery($sql);
			$result = $database->query();    
			if(!$result) {
				echo $database->stderr();
				exit;
			}else{
				$return = true;
			}  
			              
        
		}//if($url_id)
		else
		{
		  $return = true;
		}
		
		return $return;   
     }

    /**
     * @desc Function sbCheckImportSEF - Checks for imported SEF from OpsenSEF
     * @access public
	 * @param string oURL, string strSEF
     * @return string sb_sef
     */
     function sbCheckImportSEF($oURL,$strSEF)
     {
        global $database; 
         
        $sb_sef = "";
        $blFound = false;
                 
        //we need to drop ItemId for comparison
        $oURL = strtolower($this->removeQueryParameters($oURL,'&Itemid='));
        //$strSql = "SELECT sb_sef FROM ".TBL_SBZ_SEF." WHERE joom_original LIKE '$oURL%' AND is_import_sef = 1 AND link_priority = '2' ";
        $strSql = "SELECT sb_sef,joom_original FROM ".TBL_SBZ_SEF." WHERE joom_original LIKE '$oURL%' AND status = 1 AND link_priority = '2' ";
        $database->setQuery($strSql);
        $result = $database->query();                                                                
        if($result)
        {
            $sefData = $database->loadAssocList();
            if(count($sefData)>0){  
                foreach($sefData as $key=>$sData)
                {
                   $data_url = str_replace('&&','&',strtolower($this->removeQueryParameters($sData['joom_original'],'&Itemid=')));
                   if(strcasecmp(trim($oURL),trim($data_url))==0) 
                   {
                        $sb_sef = $sData['sb_sef'];
                        $this->link_priority = 0;
                        $blFound = true;
                   }
                   if(strcasecmp($sData['sb_sef'],$strSEF)==0)
                   {
                        $sb_sef = $sData['sb_sef'];
                        $this->link_priority = 0;
                        $blFound = true;
                   }
                }
            }           
        }
        unset($result);
        
        if($blFound == false)
        {
            $strSql = "SELECT sb_sef,joom_original FROM ".TBL_SBZ_SEF." WHERE sb_sef='$strSEF' AND status = 1 AND link_priority = '2' ";
            $database->setQuery($strSql);
            $result = $database->query();                                                                
            if($result)
            {
                $sefData = $database->loadAssocList();
                if(count($sefData)>0){
                  $sb_sef = $sefData[0]['sb_sef'];
                  $this->link_priority = 0;  
                }
            }
        }
                    
        return $sb_sef;    
     }
    
    /**
     * @desc Function sbCheckPriority - Checks for Link priority of Sef URL 
     * @access public
	 * @param string sef, 
     * @return integer return;
     */
     function sbCheckPriority($sef)
     {
        global $database;
        
        $return = 2;    
                
        $strSql = "SELECT COUNT(*) FROM ".TBL_SBZ_SEF." WHERE sb_sef = '".$sef."' AND status = 1 AND link_priority = '2' ";
        $database->setQuery($strSql);                
        $total_records = $database->loadResult(); 

        if($total_records > 0) {
            $return = 0;    
        }                 
        return $return;
     }
     

    /**
     * @desc Function sbGetMetaInfo - Fetch and returns the array of meta info of section, content or category depending on the page type. 
     * @access public
	 * @param
     * @return array arr;
     */
     function sbGetMetaInfo()
     {
         global $database; 
         global $mosConfig_sitename,$mosConfig_MetaDesc,$mosConfig_MetaKeys;
         
         $arr = array();
         if($this->pageType==0)
         {
            $strSql = "SELECT IF(c.catid != 0, CONCAT(c.title,'{##}',ct.title,'{##}',s.title),c.title) as sbz_title "; 
            $strSql .= ",c.title,c.metakey,c.metadesc";
            $strSql .= " FROM #__content AS c LEFT JOIN #__categories AS ct ON ct.id = c.catid";
            $strSql .= " LEFT JOIN #__sections AS s on s.id = c.sectionid WHERE c.id = '".$this->sbz_id."'";

            $database->setQuery($strSql);
			$result = $database->query();
            if($result) 
            {
                 $sefData = $database->loadObjectList();
                  if(strlen($sefData[0]->metadesc)>0){
                     $arr['metadesc'] = $sefData[0]->metadesc;
                  }else{
                     $arr['metadesc'] = $mosConfig_sitename." ".preg_replace("/[.?!',-]/","",stripcslashes($sefData[0]->title)).". ".$mosConfig_MetaDesc;  
                  }
                  if(strlen($sefData[0]->metakey)>0)
                  {
                     $metakey = $sefData[0]->metakey;
                  }else if(strlen($sefData[0]->sbz_title)>0)
                  {
                      $metakey = stripcslashes(str_replace('{##}',", ",$sefData[0]->sbz_title)).", ";              
                      $metakey = preg_replace("/[.?!'-]/","",$metakey);
                      if(strlen($mosConfig_MetaKeys)>0){
                          $metakey .= $mosConfig_MetaKeys.", ".$mosConfig_sitename;               
                      }else{
                          $metakey .= $mosConfig_sitename;              
                      }
                }
                $arr['metakey'] = $metakey;                
                $arr['title']   = $mosConfig_sitename." ".preg_replace("/[.?!',-]/","",stripcslashes($sefData[0]->title));
            }
         }
         else if($this->pageType==1)
         {
            $strSql = "SELECT CONCAT(ct.`title`,'{##}',s.title) as cs_title, ct.`title` as ct_title FROM `#__categories` AS ct"; 
            $strSql .= " LEFT JOIN `#__sections` AS s on s.id = ct.section";
            $strSql .= " WHERE ct.`id` = '".$this->sbz_id."'";            
            $database->setQuery($strSql);
            $result = $database->query();                                                                
            if($result) 
            {
                $sefData = $database->loadObjectList();
                $arr['title'] = $mosConfig_sitename." ".preg_replace("/[.?!',-]/","",stripcslashes($sefData[0]->ct_title)); 
                $arr['metadesc'] = $mosConfig_sitename." ".stripcslashes($sefData[0]->ct_title).". ".$mosConfig_MetaDesc;
                $metakey = stripcslashes(str_replace('{##}',", ",$sefData[0]->cs_title)).", ";
                $metakey = preg_replace("/[.?!'-]/","",$metakey);                              

                if(strlen($mosConfig_MetaKeys)>0){
                    $metakey .= $mosConfig_MetaKeys.", ".$mosConfig_sitename;               
                }else{
                    $metakey .= $mosConfig_sitename;              
                }
                $arr['metakey'] = $metakey;
            } 
         }
         else if($this->pageType==2)
         {
            $strSql = "SELECT `title` FROM `#__sections` WHERE `id` = '".$this->sbz_id."'";            
            $database->setQuery($strSql);
            $result = $database->query();                                                                
            if($result) 
            {
                $sefData = $database->loadObjectList();
                $arr['title'] = $mosConfig_sitename." ".preg_replace("/[.?!',-]/","",stripcslashes($sefData[0]->title)); 
                $arr['metadesc'] = $mosConfig_sitename." ".stripcslashes($sefData[0]->title).". ".$mosConfig_MetaDesc;
                $metakey = stripcslashes($sefData[0]->title).", ";
                $metakey = preg_replace("/[.?!'-]/","",$metakey);
                if(strlen($mosConfig_MetaKeys)>0){
                    $metakey .= $mosConfig_MetaKeys.", ".$mosConfig_sitename;               
                }else{
                    $metakey .= $mosConfig_sitename;              
                }
                $arr['metakey'] = $metakey;
            } 
         }                  
         else
         {  
             //return default
            $arr['metadesc']    = $mosConfig_sitename.". ".$mosConfig_MetaDesc;
            if(strlen($mosConfig_MetaKeys)>0){
                $arr['metakey'] = $mosConfig_MetaKeys.", ".$mosConfig_sitename;
            }else{
                $arr['metakey'] = $mosConfig_sitename;              
            }
         }
         return $arr;
     }

    /**
     * @desc Function sbThirdPartyComponents - get URLs for the third party component
     * @access public
	 * @param string action
     */
     function sbThirdPartyComponents($action='remove')
     {
        $filepath = $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_serrbizsef/serrbizsef_sef_rules/serrbizsef.patches.php';
        if(file_exists($filepath))
        {
           require_once($filepath);
           $clsName = "SB_".$this->component_type;
           if(class_exists($clsName))
           {
               $objComp = new $clsName();
               $this->originalURL = $this->formattedURL;
               $strURL = $objComp->BuildComponentURL($this->formattedURL,$action);
			   
               if(trim($strURL)!= "")
               {
                   $this->formattedURL = $strURL;
               }

               unset($objComp);                        
           }    
        }
     }//end of func
     
    /**
     * @desc Function removeQueryParameters - remove parameter from a query.
     * @access public
	 * @param string strTempURL, string strToRemove
     * @return string strTempURL;
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


    /**
     * @desc Function sbFormatURLs - format string to make URL.
     * @access public
	 * @param string string
     * @return string string;
     */
    function sbFormatURLs($string)
    {
        $slash = "\/";

        static $LettersFrom = "àáâãäåçèêëìíîïðñòóôûýéõ¸";
        static $LettersTo   = "abvgdeziklmnoprstufyejxe";
        static $Consonant   = "áâãäæçéêëìíïðñòôõö÷øù";
        static $Vowel       = "àå¸èîóûýþÿ";
        static $BiLetters = array(
            "æ" => "zh", "ö"=>"ts", "÷" => "ch", 
            "ø" => "sh", "ù" => "sch", "þ" => "ju", "ÿ" => "ja",
        );

		$tempStr = '';
		$string = trim($string);


		$whitespace = array("\t", "\n", "\f", "\r", "+", "!", '"', "£", "$", "€", "%", "^", "&", "*", "(", ")", "_", "+", "=", "{", "[", "}", "]", ";", ":", "@", "'", "#", "~", "<", ">", ">", ".", "?", "|", "\\", "¬", "`", "¦");
		$string = str_replace($whitespace, " ", $string);

		$string = trim($string);
		for($i=0;$i<strlen($string);$i++)
		{
			if($i!=0 && $string[$i]==" " && $string[$i-1]==" ")
			  continue;
			 
		    $tempStr .= $string[$i];
		}
		$string = $tempStr;
		
		$string =  ereg_replace(" -"," ", $string);
		$string =  ereg_replace("- "," ", $string);
		$string =  ereg_replace("-"," ", $string);
		$string =  ereg_replace("  "," ", $string);

		$tempStr = '';
		$string = trim($string);
		for($i=0;$i<strlen($string);$i++)
		{
			if($i!=0 && $string[$i]==" " && $string[$i-1]==" " )
			  continue;
			 
		    $tempStr .= $string[$i];
		}
		$string = $tempStr;


        $string = preg_replace("/[_\s\.,?!\[\](){}]+/", "-", $string);
        $string = preg_replace("/-{2,}/", "-", $string);
        $string = preg_replace("/_-+_/", "-", $string);
        $string = preg_replace("/[_\-]+$/", "", $string);
        $string = strtolower( $string );



        if (isset($GLOBALS['replacedLetters'])) {
            $string = strtr($string, $GLOBALS['replacedLetters']);
        }
      
        //here we replace ú/ü 
        $string = preg_replace("/(ü|ú)([".$Vowel."])/", "j\\2", $string);
        $string = preg_replace("/(ü|ú)/", "", $string);
        
        //transliterating
        $string = strtr($string, $LettersFrom, $LettersTo );
        $string = strtr($string, $BiLetters );
        $string = preg_replace("/j{2,}/", "j", $string);
        $string = preg_replace("/[^".$slash."0-9a-z_\-]+/", "", $string);
		
        return $string;
     }
  }
?>