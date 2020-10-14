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
* @desc patches for different components
*/


/* Restricted access */
defined( '_VALID_MOS' ) or die( 'Restricted access' );

/**
* @desc function removeQueryParameters -  removes a value from query string.
* @param string url, string value to remove
* @return string strTempURL
* short description
*
*<p> <strong>How to creaate patch ? </strong>
*		- make a class of SB_componentName for e.g. if component is com_deeppockets then irs class name will be SB_com_deeppockets {} 
*       - save this class in serrbizsef.patches.php
*		- make a constructor, in constructor set variable type of $this->arrParameters as array
*		- create a function SB_ExecProcess($arrParam=array())
*		- now create a function function getValues($arrParam)
*		- call getValues($arrParam) in SB_ExecProcess() e.g.
*				function SB_ExecProcess($arrParam=array())
*				{
*            		return $this->getValues($arrParam);                       
*        		}
*       - in  function getValues() write patch for component if its behavior is different from joomla's default style
*		- in  function getValues()  we can also write some patches for metakeyword, metadesc, title if we want to change it
*		- Create function BuildComponentURL() in this function we can write some special instruction for building the URl for component.
*  	
*</p>
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
# ends

  /*patches for diff components*/
  class SB_com_deeppockets
  {
        var $arrParameters;
        function SB_com_deeppockets()
        {
            $this->arrParameters = array();
        }      
        function SB_ExecProcess($arrParam=array())
        {
            return $this->getValues($arrParam);                       
        }
        function getValues($arrParam)
        {
            global $database;
            $arrResult = array();            
            if(is_array($arrParam) && count($arrParam)>0 && isset($arrParam['id']))
            {
                ##this process is for creating paging sef for url having format
                ///index.php?option=com_deeppockets&task=catShow&id=13&Itemid=103&limitstart_36=2&limit_36=1
                foreach($arrParam as $key=>$value)
                {
                    $arrKey = explode('_',$key);
                    if(count($arrKey)==2) // we want limitstart_36 and  limit_36
                    {
                        if($arrKey[0]=='limit') {
                             $limitValue = $value;
                             $FID = $arrKey[1];  //_36 is FID value
                        }
                        if($arrKey[0]=='limitstart') {
                           $limitStartValue = $value;
                           $FID = $arrKey[1]; 
                        }
                    } 
                    unset($arrKey);  
                }
                //check if these values are set
                if($limitValue!="" && $limitStartValue!="" && $FID!="" && $arrParam['task']=='catShow')
                {
                    //now create SEF for paging.
                    //get category name
                    //$strSql = "SELECT dp.name FROM `#__dp_categories` AS dp WHERE dp.`id` ='".$arrParam['id']."'";
                    $strSql  = "SELECT IF( a.`parent_id` >0, CONCAT(REPLACE ( b.`name`, '/', '-' ), '/', REPLACE( a.`name`, '/' ,'-' ) ) , REPLACE(a.`name`, '/', '-') ) as name ";
                    $strSql .= " FROM `#__dp_categories` AS a,`#__dp_categories` AS b WHERE a.`id`='".$arrParam['id']."'";
                    $strSql .= " AND IF( a.`parent_id` >0, a.`parent_id` = b.`id`, b.`id` = a.`id` )";   
                    $database->setQuery($strSql);
                    $result = $database->query();
                    if(!$result){                        
                        
                    }else{        
                        $arrRecords = $database->loadObjectList();
                        if(count($arrRecords)>0 && isset($arrRecords[0]->name))  {         
                           $catName = clsSBSEF::sbFormatURLs($arrRecords[0]->name);
                        } 
                        unset($result);   
                    }
                    
                    //get name   
                    $strSql = "SELECT dp.name FROM `#__deeppockets` AS dp WHERE dp.`cat` ='".$arrParam['id']."' AND dp.`id` ='".$FID."' AND fid = 0";
                    $database->setQuery($strSql);
                    $result = $database->query();
                    if(!$result){                        
                        
                    }else{        
                        $arrRecords = $database->loadObjectList();
                        if(count($arrRecords)>0 && isset($arrRecords[0]->name))  {         
                           $DPName = clsSBSEF::sbFormatURLs($arrRecords[0]->name);
                        } 
                        unset($result);   
                    }
                    //now create the sef and return it.
                    if(trim($catName)!="" && trim($DPName)!="")
                    {
                        $pagevalue =  ($limitStartValue/$limitValue) + 1;
                        //$strSEF = "/".$catName."/".$DPName."/page-".$pagevalue.".html";
                        if($pagevalue > 1) {                    
                            $strSEF = "/".$catName."-p".$pagevalue.".html";
                        }else{
                           $strSEF = "/".$catName.".html"; 
                        }                                                             
                        $arrResult['strSEF'] = $strSEF;
                        $arrResult['sbz_id'] = 0;
                        $arrResult['type']   = -1;
                        return $arrResult;
                    }                    
                }
                ###  paging process ends ##                             
                
                switch($arrParam['task'])
                {
                    case 'catShow': 
                        if(!isset($arrParam['limitstart']) && !isset($arrParam['limit']))
                        {                    
                            $strSql = "SELECT linkSection,linkCat FROM #__dp_categories WHERE id ='".$arrParam['id']."'";
                            $database->setQuery($strSql);
                            $result = $database->query();
                            if(!$result) {
                                return $arrResult;
                            }        
                            $arrRecords = $database->loadObjectList();                    
                            if($arrRecords[0]->linkSection > 0) {
                                return $this->getSEF($arrRecords[0]->linkSection,2);
                            }else if($arrRecords[0]->linkCat > 0) {
                                return $this->getSEF($arrRecords[0]->linkCat,1);
                            }else{
                                return $arrResult;
                            } 
                        }                                                  
                    break;
                    case 'catContShow':
                        if(!isset($arrParam['limitstart']) && !isset($arrParam['limit']))
                        {
                            return $this->getSEF($arrParam['id'],0);
                        }   
                    break;
                }//switch
            }     
        }
        
        function getSEF($id,$type)
        {
            global $database;  
            $arrResult = array();
            $strSql = "SELECT sb_sef FROM #__serrbizsef_sef WHERE type='".$type."' AND sbz_id='".$id."'";
            $database->setQuery($strSql);
            $result = $database->query();
            if(!$result) 
            {
                return $arrResult;
            }
            else
            {        
                $arrRecords = $database->loadObjectList();
                $strSEF = $arrRecords[0]->sb_sef;
                //update
                $strSql = "UPDATE #__serrbizsef_sef SET link_priority = '0' WHERE sb_sef = '".$strSEF."'";
                $database->setQuery($strSql); 
                $database->query();                                                     
                $arrResult['strSEF'] = $strSEF;
                $arrResult['sbz_id'] = $id;
                $arrResult['type']   = $type;                                
                return $arrResult;
            }    
        }
      
        function BuildComponentURL($strURL,$action)
        {
            // parse url to get the component
            $tempURL = parse_url($strURL);
            // break url into component parts            
            parse_str($tempURL['query'], $parsedURL );       
            if($action=='remove' && $parsedURL['task']=='catShow')
            {
                 $id = $parsedURL['id']; 
                 $strURL = removeQueryParameters($strURL,'&id=');
                 $strURL = $strURL."&cat=".$id;
            }            
            return $strURL;
        }      
  }
  
  class SB_com_hotproperty
  {
        var $arrParameters;
        function SB_com_hotproperty()
        {
            $this->arrParameters = array();
        }      
        function SB_ExecProcess($arrParam=array())
        {
            return $this->getValues($arrParam);                       
        }
        
        function getValues($arrParam)
        {
            global $database; 
            global $mosConfig_sitename,$mosConfig_MetaKeys,$mosConfig_MetaDesc;
            
            $arrResult = array();            
            if(is_array($arrParam) && count($arrParam)>0 && isset($arrParam['id']))
            {
                switch($arrParam['task'])
                {
                    case 'view':                     
                        $strSql = "SELECT * FROM #__hp_properties WHERE id ='".$arrParam['id']."'";
                        $database->setQuery($strSql);
                        $result = $database->query();
                        if(!$result) {
                            return $arrResult;
                        }
                        //get meta info 
                        $sefData = $database->loadObjectList();
                        $sefData[0]->name = str_replace("/","",$sefData[0]->name);
                        $arr = array();
                        if(strlen($sefData[0]->metadesc)>0)
                        {
                         $arr['metadesc'] = $mosConfig_sitename." ".$this->strFormatString($sefData[0]->name).". ".$mosConfig_MetaDesc;                         
                        }
                        else
                        {
                         $arr['metadesc'] = $mosConfig_sitename." ".$this->strFormatString($sefData[0]->name).". ".$mosConfig_MetaDesc;  
                        }
                        
                        if(strlen($sefData[0]->metakey)>0)
                        {
                         $metakey = $this->strFormatString($sefData[0]->metakey,'key').", ".$mosConfig_MetaKeys.", ".$mosConfig_sitename;
                        }
                        else if(strlen($sefData[0]->name)>0)
                        {
                          $metakey = $this->strFormatString($sefData[0]->name,'key').", ";              
                          if(strlen($mosConfig_MetaKeys)>0){
                              $metakey .= $mosConfig_MetaKeys.", ".$mosConfig_sitename;               
                          }else{
                              $metakey .= $mosConfig_sitename;              
                          }
                        }
                        $arr['metakey'] = $this->strFormatString($metakey,'key');                
                        $arr['title']   = $mosConfig_sitename." ".$this->strFormatString($sefData[0]->name);
                    break;
                    
                    case 'viewtype':                     
                        $strSql = "SELECT * FROM #__hp_prop_types WHERE id ='".$arrParam['id']."'";
                        $database->setQuery($strSql);
                        $result = $database->query();
                        if(!$result) {
                            return $arrResult;
                        }
                         //get meta info 
                        $sefData = $database->loadObjectList();
                        $sefData[0]->name = str_replace("/","",$sefData[0]->name);
                        $arr['title'] = $mosConfig_sitename." ".$this->strFormatString($sefData[0]->name); 
                        $arr['metadesc'] = $mosConfig_sitename.". ".$mosConfig_MetaDesc;
                        if(strlen($mosConfig_MetaKeys)>0){
                            $arr['metakey'] = $mosConfig_MetaKeys.", ".$mosConfig_sitename;
                        }else{
                            $arr['metakey'] = $mosConfig_sitename;              
                        }                        
                   break; 
                }//switch
            }
            $arrResult['meta_info'] = $arr;     
            return $arrResult;
        }

        function BuildComponentURL($strURL,$action)
        {
              return $strURL;
        }  
        
        function strFormatString($str,$type="")
        {
            switch($type)
            {
                case 'desc':                
                    $str = str_replace("/","",preg_replace("/[?!#%',-]/","",stripcslashes($str)));
                break;
                case 'key':                
                    $str = str_replace("/","",preg_replace("/[.?!#%'-]/","",stripcslashes($str)));
                break;
                default:
                    $str = str_replace("/","",preg_replace("/[.?!#%()<>:;',-]/","",stripcslashes($str)));    
                break;
            }
            return $str;
        }        
        
  }
  
  
  class SB_com_virtuemart
  {
        var $arrParameters;
        
        function SB_com_virtuemart()
        {
            $this->arrParameters = array();
        }      
        function SB_ExecProcess($arrParam=array())
        {
            return $this->getValues($arrParam);                       
        }
        
        function getValues($arrParam)
        {
            global $database; 
            global $mosConfig_sitename,$mosConfig_MetaKeys,$mosConfig_MetaDesc;
			$arr=array();
            
            $arrResult = array();    
            if(is_array($arrParam) && count($arrParam)>0 && isset($arrParam['page']))
            {
                switch($arrParam['page'])
                {
                    case 'shop.browse':
						
						if(!isset($arrParam['category_id']))
						{
                            return $arrResult;
						}
					
                        $strSql = "SELECT category_name FROM #__vm_category WHERE category_id ='".$arrParam['category_id']."'";
                        $database->setQuery($strSql);
                        $result = $database->query();
                        if(!$result) 
						{
                            return $arrResult;
                        }
                        //get meta info 
                        $sefData = $database->loadObjectList();
                        $sefData[0]->category_name = str_replace("/","",$sefData[0]->category_name);
                        $arr = array();
                        if(strlen($sefData[0]->category_name)>0) 
                        {
                            $arr['title']    = $mosConfig_sitename." ".$this->strFormatString($sefData[0]->category_name);
                            $arr['metadesc'] = $mosConfig_sitename." ".$this->strFormatString($sefData[0]->category_name)." Store. ".$mosConfig_MetaDesc;
                            
                            $metakey = $this->strFormatString($sefData[0]->category_name,'key').", Store, ";              
                            if(strlen($mosConfig_MetaKeys)>0){
                              $metakey .= $mosConfig_MetaKeys.", ".$mosConfig_sitename;               
                            }else{
                              $metakey .= $mosConfig_sitename;              
                            }
                            $arr['metakey'] = $this->strFormatString($metakey,'key').".";
                            
                        }
                        else
                        {
                            $arr['title']       = $mosConfig_sitename;
                            $arr['metadesc']    = $mosConfig_sitename.". ".$mosConfig_MetaDesc;  
                                                                                  
                            if(strlen($mosConfig_MetaKeys)>0){
                                $arr['metakey'] = $mosConfig_MetaKeys.", ".$mosConfig_sitename;
                            }else{
                                $arr['metakey'] = $mosConfig_sitename;              
                            }                            
                        }                        
                    break;
                    
                    case 'shop.product_details':                     
                        $strSql = "SELECT p.product_name,c.category_name FROM #__vm_product as p,#__vm_category as c,#__vm_product_category_xref as pc";
                        $strSql .= " WHERE p.product_id = pc.product_id AND pc.category_id = c.category_id ";
                        $strSql .= " AND p.product_id ='".$arrParam['product_id']."'";
                        
                        $database->setQuery($strSql);
                        $result = $database->query();
                        if(!$result) {
                            return $arrResult;
                        }
                        //get meta info 
                        $sefData = $database->loadObjectList();
                        $sefData[0]->product_name = str_replace("/","",$sefData[0]->product_name);
                        $sefData[0]->category_name = str_replace("/","",$sefData[0]->category_name);
                        $arr = array();
                        if(strlen($sefData[0]->product_name)>0) 
                        {
                            $arr['title']    = $mosConfig_sitename." ".$this->strFormatString($sefData[0]->product_name);
                            $arr['metadesc'] = $mosConfig_sitename." ".$this->strFormatString($sefData[0]->product_name)." ".$this->strFormatString($sefData[0]->category_name)." Store. ".$mosConfig_MetaDesc;
                            $metakey = $this->strFormatString($sefData[0]->product_name,'key').", ".$this->strFormatString($sefData[0]->category_name,'key').", Store, ";
                            if(strlen($mosConfig_MetaKeys)>0){
                              $metakey .= $mosConfig_MetaKeys.", ".$mosConfig_sitename;               
                            }else{
                              $metakey .= $mosConfig_sitename;              
                            }
                            $arr['metakey'] = $this->strFormatString($metakey,'key').".";                            
                        }
                        else
                        {
                            $arr['title']       = $mosConfig_sitename;
                            $arr['metadesc']    = $mosConfig_sitename.". ".$mosConfig_MetaDesc;  
                                                                                  
                            if(strlen($mosConfig_MetaKeys)>0){
                                $arr['metakey'] = $mosConfig_MetaKeys.", ".$mosConfig_sitename.".";
                            }else{
                                $arr['metakey'] = $mosConfig_sitename.".";              
                            }                            
                        }                        
                    break;
                }//switch
            }
            $arrResult['meta_info'] = $arr; 
            return $arrResult;
        }

        function BuildComponentURL($strURL,$action)
        {
              return $strURL;
        }  
        
        function strFormatString($str,$type="")
        {
            switch($type)
            {
                case 'desc':                
                    $str = str_replace("/","",preg_replace("/[?!#%',-]/","",stripcslashes($str)));
                break;
                case 'key':                
                    $str = str_replace("/","",preg_replace("/[.?!#%'-]/","",stripcslashes($str)));
                break;
                default:
                    $str = str_replace("/","",preg_replace("/[.?!#%()<>:;',-]/","",stripcslashes($str)));    
                break;
            }
            return $str;
        }                
  }
  

class SB_login
{
    var $arrParameters;

    function SB_login()
    {
        $this->arrParameters = array();
    }
          
    function SB_ExecProcess($arrParam=array())
    {
        return $this->getValues($arrParam);                       
    }
    
    function getValues($arrParam)
    {
        $arrResult = array();    
        if(is_array($arrParam) && count($arrParam)>0 && isset($arrParam['option']) && $arrParam['option'] == 'login')
        {
            $arrResult['strSEF'] = "/customer-login.html";
            $arrResult['sbz_id'] = '0';
            $arrResult['type']   = '-1';         
        }// 
        return $arrResult;
    }

    function BuildComponentURL($strURL,$action)
    {
          return $strURL;
    }  
    
}
 

class SB_logout
{
    var $arrParameters;

    function SB_logout()
    {
        $this->arrParameters = array();
    }
          
    function SB_ExecProcess($arrParam=array())
    {
        return $this->getValues($arrParam);                       
    }
    
    function getValues($arrParam)
    {
        $arrResult = array();    
        if(is_array($arrParam) && count($arrParam)>0 && isset($arrParam['option']) && $arrParam['option'] == 'logout')
        {
            $arrResult['strSEF'] = "/customer-logout.html";
            $arrResult['sbz_id'] = '0';
            $arrResult['type']   = '-1';         
        }// 
        return $arrResult;
    }

    function BuildComponentURL($strURL,$action)
    {
          return $strURL;
    }
} 



class SB_com_akocomment
  {
        var $arrParameters;
        function SB_com_akocomment()
        {
            $this->arrParameters = array();
        }      
        function SB_ExecProcess($arrParam=array())
        {
            return $this->getValues($arrParam);
        }
        
        function getValues($arrParam)
        {
            global $database; 
            global $mosConfig_sitename,$mosConfig_MetaKeys,$mosConfig_MetaDesc;

            $arrResult = array();
            if(is_array($arrParam) && count($arrParam)>0 && isset($arrParam['id']))
            {
                switch($arrParam['task'])
                {
                    case 'quote':                     
                        $strSql = "SELECT * FROM #__content WHERE id ='".$arrParam['id']."'";
                        $database->setQuery($strSql);
                        $result = $database->query();
                        if(!$result) {
                            return $arrResult;
                        }
                        //get meta info 
                        $sefData = $database->loadObjectList();
                        $sefData[0]->title = str_replace("/","",$sefData[0]->title);
                        $arr = array();
                        if(strlen($sefData[0]->metadesc)>0)
                        {
                         $arr['metadesc'] = $mosConfig_sitename." ".$this->strFormatString($sefData[0]->title).". ".$mosConfig_MetaDesc;                         
                        }
                        else
                        {
                         $arr['metadesc'] = $mosConfig_sitename." ".$this->strFormatString($sefData[0]->title).". ".$mosConfig_MetaDesc;  
                        }
                        $arr['metadesc']  = $arr['metadesc']." - quote on website";
                        if(strlen($sefData[0]->metakey)>0)
                        {
                         $metakey = $this->strFormatString($sefData[0]->metakey,'key').", ".$mosConfig_MetaKeys.", ".$mosConfig_sitename;
                        }
                        else if(strlen($sefData[0]->title)>0)
                        {
                          $metakey = $this->strFormatString($sefData[0]->title,'key').", ";              
                          if(strlen($mosConfig_MetaKeys)>0){
                              $metakey .= $mosConfig_MetaKeys.", ".$mosConfig_sitename;               
                          }else{
                              $metakey .= $mosConfig_sitename;
                          }
                        }
                        $arr['metakey'] = $this->strFormatString($metakey." - quote on website",'key');                
                        $arr['title']   = $mosConfig_sitename."  ".$this->strFormatString($sefData[0]->title)." - quote on website";
                    break;
                    
                    case 'favoured':
                        $strSql = "SELECT * FROM #__content WHERE id ='".$arrParam['id']."'";
                        $database->setQuery($strSql);
                        $result = $database->query();
                        if(!$result) {
                            return $arrResult;
                        }
                        //get meta info 
                        $sefData = $database->loadObjectList();
                        $sefData[0]->title = str_replace("/","",$sefData[0]->title);
                        $arr = array();
                        if(strlen($sefData[0]->metadesc)>0)
                        {
                         $arr['metadesc'] = $mosConfig_sitename." ".$this->strFormatString($sefData[0]->title).". ".$mosConfig_MetaDesc;                         
                        }
                        else
                        {
                         $arr['metadesc'] = $mosConfig_sitename." ".$this->strFormatString($sefData[0]->title).". ".$mosConfig_MetaDesc;  
                        }
                        $arr['metadesc']  = $arr['metadesc']." - add to favorites";
                        if(strlen($sefData[0]->metakey)>0)
                        {
                         $metakey = $this->strFormatString($sefData[0]->metakey,'key').", ".$mosConfig_MetaKeys.", ".$mosConfig_sitename;
                        }
                        else if(strlen($sefData[0]->title)>0)
                        {
                          $metakey = $this->strFormatString($sefData[0]->title,'key').", ";              
                          if(strlen($mosConfig_MetaKeys)>0){
                              $metakey .= $mosConfig_MetaKeys.", ".$mosConfig_sitename;               
                          }else{
                              $metakey .= $mosConfig_sitename;              
                          }
                        }
                        $arr['metakey'] = $this->strFormatString($metakey." - add to favorites",'key');
                        $arr['title']   = $mosConfig_sitename." ".$this->strFormatString($sefData[0]->title)." - add to favorites";
					/*
					  As "add to favorites" link on the website will generate the duplicate content issue for 
					  search engines so on "add to favorites" page we will give <meta name="robots" value="noindex,follow">
					*/
                   $arrResult['robot_index'] = 0;
                   $arrResult['robot_follow'] = 1;
				   
                   break; 
                }//switch
            }

            $arrResult['meta_info'] = $arr;
            return $arrResult;
        }

        function BuildComponentURL($strURL,$action)
        {
              return $strURL;
        }  
        
        function strFormatString($str,$type="")
        {
            switch($type)
            {
                case 'desc':                
                    $str = str_replace("/","",preg_replace("/[?!#%',-]/","",stripcslashes($str)));
                break;
                case 'key':                
                    $str = str_replace("/","",preg_replace("/[.?!#%'-]/","",stripcslashes($str)));
                break;
                default:
                    $str = str_replace("/","",preg_replace("/[.?!#%()<>:;',-]/","",stripcslashes($str)));    
                break;
            }
            return $str;
        }        
}
  
class SB_com_fireboard
{
        var $arrParameters;
	function SB_com_akocomment()
	{
		$this->arrParameters = array();
	}      
	function SB_ExecProcess($arrParam=array())
	{
		return $this->getValues($arrParam);
	}

	function getValues($arrParam)
	{
		global $database; 
		global $mosConfig_sitename,$mosConfig_MetaKeys,$mosConfig_MetaDesc;
		$arr = array();
		$arrResult = array();
		
		if( isset($arrParam['func']) ) 
		{
		   switch($arrParam['func'])
		   {
				case 'showcat';
					
					if(isset($arrParam['catid']))
					{						
						$strSql = " SELECT concat(`id`,'/',`name`) FROM `#__fb_categories` WHERE `id` =  '".$arrParam['catid']."'";
						$database->setQuery( $strSql );
						$catName = $database->loadResult();
	
						$arr['metadesc'] = $mosConfig_sitename." - ".$this->strFormatString($catName).". ".$mosConfig_MetaDesc;
						$arr['metakey'] = $this->strFormatString( $catName );
						$arr['title']   = $mosConfig_sitename." - ".$this->strFormatString($catName);
						
						$arrResult['robot_index'] = 1;
						$arrResult['robot_follow'] = 1;
					}	
	
				break;
	
				case 'view';

					if(isset($arrParam['id']))
					{						
						$strSql = "SELECT concat( `subject` ,'-',`id` ) FROM `#__fb_messages` where `id`='".$arrParam['id']."'" ;
						$database->setQuery( $strSql );
						$catName = $database->loadResult();
	
						$arr['metadesc'] = $mosConfig_sitename." - ".$this->strFormatString($catName).". ".$mosConfig_MetaDesc;
						$arr['metakey'] = $this->strFormatString( $catName );
						$arr['title']   = $mosConfig_sitename." - ".$this->strFormatString($catName);
						
						$arrResult['robot_index'] = 1;
						$arrResult['robot_follow'] = 1;
					}	

				break;

				
		   }
		}
		
		$arrResult['meta_info'] = $arr;
		return $arrResult;
	}

	function BuildComponentURL($strURL,$action)
	{
		  return $strURL;
	}  
	
	function strFormatString($str,$type="")
	{
		switch($type)
		{
			case 'desc':                
				$str = str_replace("/","",preg_replace("/[?!#%',-]/","",stripcslashes($str)));
			break;
			case 'key':                
				$str = str_replace("/","",preg_replace("/[.?!#%'-]/","",stripcslashes($str)));
			break;
			default:
				$str = str_replace("/","",preg_replace("/[.?!#%()<>:;',-]/","",stripcslashes($str)));    
			break;
		}
		return $str;
	}        

}//class SB_com_fireboard
  
function SBZ_ExtraFormatting(&$originalURL,&$strResultURL)
{
   $strURL  = $originalURL;
   $tempURL = parse_url($originalURL);         
        if(isset($tempURL['query']) && trim($tempURL['query'])!='')
		{
        // break url into component parts            
        parse_str($tempURL['query'], $temp_parts );            
        if(isset($temp_parts['option']) && $temp_parts['option']=='com_virtuemart') {
           SBVM_ADDVALUES($temp_parts,&$originalURL); 
        }
   }            
} 

function SBVM_ADDVALUES($temp_parts,&$originalURL)
{
    if(isset($temp_parts['page']))
    {
       switch($temp_parts['page'])
       {
            case 'shop.browse':
            case 'shop.product_details':
            //if(!$temp_parts['vmcchk'])
            if(!isset($temp_parts['vmcchk']))
			{
                $originalURL = $originalURL."&vmcchk=1";
            }
            break;
            default:
            break;
       } 
    }
}

?>