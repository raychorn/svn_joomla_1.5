<?php
/**
* @version $Id: admin.serrbizsef.class.php 2007-10-19 11:19:30 $
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
 *includes com_serrbizsef/serrbizsef.config.php
 */
require_once( $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_serrbizsef/serrbizsef.config.php');  

/**
* @desc Admninistrator class to handle all serrBizSef administrative function
*/
class sbAdmin
{
  	/**
     * A Whether SerrBizSEF is active or inactive
     * @access private
     * @var integer
     */
    var $isSBActive;
	/**
     * A Whether SEF is active or inactive
     * @access private
     * @var integer
     */
    var $isSEFActive;
	/**
     * A Whether SerrBizSEF Meta info ia active
     * @access private
     * @var integer
     */
    var $isMetaInfoActive;   
	/**
     * A Whether 301 redirect is active
     * @access private
     * @var integer
     */
    var $isRedirectActive; 
	/**
     * A Whether error redirect is active
     * @access private
     * @var integer
     */
    var $strCustomError;
	/**
     * Joomla's original URL
     * @access private
     * @var integer
     */
    var $joom_original;
	/**
     * A SerrBizSEF URL
     * @access private
     * @var string
     */
    var $sb_sef;
	/**
     * A SerrBizSEF URL
     * @access private
     * @var string
     */
    var $sbz_id;
	/**
     * A Link Priority Of URL
     * @access private
     * @var string
     */
    var $link_priority;
	/**
     * A whether it is a SEF URL
     * @access private
     * @var string
     */
    var $is_sef;         
	/**
     * value for robot Index
     * @access private
     * @var string
     */
    var $rbIndex;
	/**
     * value for robot follow
     * @access private
     * @var string
     */
    var $rdFollow;    
	/**
     * value for meta keyword
     * @access private
     * @var string
     */
    var $mKeyword;
	/**
     * value for meta Description
     * @access private
     * @var string
     */
    var $mDesc;
	/**
     * value for Meta Title
     * @access private
     * @var string
     */
    var $mMTitle;
	/**
     * value for personal title
     * @access private
     * @var string
     */
    var $mPTitle;    
	/**
     * value for special keyword
     * @access private
     * @var string
     */
    var $sKeyword;
	/**
     * value for special description
     * @access private
     * @var string
     */
    var $sDesc;
	/**
     * value for special Meta Title
     * @access private
     * @var string
     */
    var $sMTitle;
	/**
     * value for special sPTitle
     * @access private
     * @var string
     */
    var $sPTitle;    
	/**
     * value for component
     * @access private
     * @var string
     */
    var $component;
	/**
     * value for page navigation
     * @access private
     * @var string
     */
    var $PageNav;
	/**
     * value for settings
     * @access private
     * @var array
     */
    var $arrSettings;
	/**
	* Constructor
	*/
    function sbAdmin()
    {  

    } 

	/**
	*@desc saves Redirect Url In database
	*/	
	function sbSaveSpecialSefURL()
	{
		global $database;
        $arrHTML = array();
        $internal_url = mosGetParam( $_REQUEST, 'internal_url', '');
        $redirect_to_url = mosGetParam( $_REQUEST, 'redirect_to_url', '');
		//$special_sef_type =  mosGetParam( $_REQUEST, 'sef_type', '');
		$special_sef_type =  1;
		
		
			if(trim($internal_url)=='' || trim($redirect_to_url)=='' )
			{
				echo " Required Fields cannot be left blank ";
				return false;
			}
			$sql = 'INSERT INTO '.TBL_SBZ_SEF.' (joom_original, sb_sef, sef_type, link_priority )';
			$sql .= ' VALUES ("'.$internal_url.'", "'.$redirect_to_url.'" , "'.$special_sef_type.'", "2" )';
			
			$database->setQuery($sql);
			$result = $database->query();    
			if(!$result) {
				echo $database->stderr();
				exit;
			}else{
				$return = true;
			}                
		
	}
		
  /**
  * @desc Function sbGetSearch - HTML for search SefUrls
  * @access public
  * @return array $arrHTML
  */
    function sbGetSearch()
    {
        global $database;
        $arrHTML = array();
        //create the html control and store the html code in array.        
        //create dropdown for selecting comparison  type
        $arrCompare[] = mosHTML::makeOption('like','Like','lk','le');
        $arrCompare[] = mosHTML::makeOption('equal','Equal','lk','le');        
        //get alue from request
        $cmb_compare  = mosGetParam( $_REQUEST, 'cmb_compare');
        $arrHTML['cmb_search'] = mosHTML::selectList( $arrCompare, 'cmb_compare','class="inputbox" size="1"','lk', 'le',$cmb_compare);
        //create text box for search.        
        $search_text = mosGetParam($_REQUEST,'search_text');
        $strSearchInput = "<INPUT type=\"text\" name=\"search_text\" value='".$search_text."'>&nbsp;<INPUT type=\"button\" class=\"button\" value=\"Go\" onclick=\"javascript:submitbutton('sef_list')\">";
        $arrHTML['input_search'] = $strSearchInput;      
        //create component dropdown
        $strsql = "SELECT DISTINCT component FROM ".TBL_SBZ_SEF." ORDER BY component ASC";
        $database->setQuery($strsql);
        $comp_rows = $database->loadObjectList();        
        //default option
        $comp_list[] = mosHTML::makeOption( null, ('-- Select Component --'), 'i', 'index' );
        //if component are present create the list        
        if(count($comp_rows) > 0)
        {
           foreach($comp_rows as $component)
           {
                $comp_list[] = mosHTML::makeOption( $component->component, 'Component'.' '.$component->component , 'i', 'index' );
            }
        }  
        //bet value from request
        $cmb_component =  mosGetParam($_REQUEST, 'cmb_component');                
        //get components dropdown   
        $arrHTML['cmb_components'] = mosHTML::selectList($comp_list, 'cmb_component', 'class="inputbox" size="1" onChange="javascript:submitform(\'sef_list\')"','i', 'index',$cmb_component);
        unset($arrCompare);
        //create dropdown for selecting settings type
        $arrCompare[] = mosHTML::makeOption(null,('-- Select Parameter --'),'lk','le');                
        $arrCompare[] = mosHTML::makeOption('rbIndex','Robot Index','lk','le');   
        $arrCompare[] = mosHTML::makeOption('rbNoIndex','No Index','lk','le');   
        $arrCompare[] = mosHTML::makeOption('rbFollow','Robot Follow','lk','le');                
        $arrCompare[] = mosHTML::makeOption('rbNoFollow','No Follow','lk','le');                
        //get alue from request
        $cmb_settings  = mosGetParam( $_REQUEST, 'cmb_settings');
        $arrHTML['cmb_settings'] = mosHTML::selectList( $arrCompare, 'cmb_settings','class="inputbox" size="1" onChange="javascript:submitform(\'sef_list\')"','lk', 'le',$cmb_settings);
        unset($arrCompare); 
        return $arrHTML;
    }

    /**
    * @desc Function sbGetSEFURL - Gets list of all sef
    * @param int $sef_url_type
    * @return array
    */
    function sbGetSEFURL($sef_url_type=0)
    {
        global $database,$mainframe, $mosConfig_live_site,$mosConfig_absolute_path;        
		$where=''; 
        #check if component is selected
        $component = mosGetParam( $_REQUEST, 'cmb_component', '');
        $default_link = " AND link_priority = '2' ";
        if($component != '' && $sef_url_type==0)//display the search box iff URL is created by SerrBisSEF  i.e. its not 301 redirect
		{
            $where .= " AND `component` = '{$component}' ";
			$ig = " AND (`joom_original` NOT LIKE '%shop.downloads%' AND `joom_original` NOT LIKE  '%account.order_details%'  AND `joom_original` NOT LIKE  '%order.order_print%' )";
			$where .= $ig;         
        }        
        #any value to search
        $search_text = mosGetParam($_REQUEST, 'search_text');   
        if(trim($search_text)!="")
        {
            //remove escape char          
            $search_text = $database->getEscaped($search_text);
            //get compare value              
            $compare_val = mosGetParam($_REQUEST,'cmb_compare');
            switch($compare_val)
            {
                case 'like':
                            $s = ' AND sb_sef LIKE "%'.$search_text.'%"';
                            break;
                case 'equal':
                            $s = ' AND sb_sef = "'.$search_text.'"';                  
                            break;
                default:
                            break;
            }         
            //get search condition
            $where .= $s;              
        }
        
        #settings param
        $settings = mosGetParam($_REQUEST, 'cmb_settings');   
        if(trim($settings)!="")
        {
          switch($settings)
            {
              case 'rbNoIndex':
                                $p = ' AND rob_index = 0 ';
                                break;    
              case 'rbIndex': 
                                $p = ' AND rob_index = 1 ';
                                break;    
              case 'rbFollow':
                                $p = ' AND follow = 1 ';
                                break;    
              case 'rbNoFollow':
                                $p = ' AND follow = 0 ';
                                break;    
              case 'link_high': 
                                $p = " AND link_priority = '2' ";
                                $default_link = '';
                                break;    
              case 'link_med':
                                $p = " AND link_priority = '1' ";
                                break;    
              case 'link_low':
                                $p = " AND link_priority = '0' ";
                                $default_link = '';
                                break;
            }
            //get param
            $where .= $p;
        }
        //sefs to hide
        $where .= $default_link;
        //now get the record count from table
		
		if($sef_url_type==0)
             $where .= " AND `sef_type` = '0' ";

		if($sef_url_type==1)
             $where .= " AND `sef_type` = '1' ";

		if($sef_url_type==2)
             $where .= " AND `sef_type` = '2' ";

		if($sef_url_type==12)
             $where .= " AND ( `sef_type`  = '1' or `sef_type`  = '2' ) ";
		
        $sql = "SELECT count(*) FROM ".TBL_SBZ_SEF." WHERE 1 $where";        
        $database->setQuery($sql);                                        
        $total_records = $database->loadResult();
                
        //get the record list limit values
        $limit = $mainframe->getUserStateFromRequest("limit", 'limit', $mainframe->getCfg('list_limit') );
        $limitstart = $mainframe->getUserStateFromRequest("com_serrbizsef.limitstart", 'limitstart',0 );
        if($total_records < $limitstart) $limitstart = 0;
        //get all records from table
		
        $sqlStr = "SELECT * FROM ".TBL_SBZ_SEF." WHERE 1 $where ORDER BY sb_sef"; 
		
		//echo "<br>".$sqlStr."<br>";
		
        if(isset($limit) && isset($limitstart)){
            $database->setQuery($sqlStr , $limitstart, $limit);
        }else{
            $database->setQuery($sqlStr);
        }
        //load records
        $records = $database->loadObjectList();
        //create navigation 
        require_once($mosConfig_absolute_path.'/administrator/includes/pageNavigation.php');        
        $this->PageNav = new mosPageNav($total_records, $limitstart, $limit);
        if(count($records) <= 0)
        {
            return;
        }
        else
        {
            return $this->sbDisplayRows($records);
        }                
    }

    /**
    * @desc Function sbDisplayRows - creates an array of sef records.
    * @param array DataRows
    * @return array
    */
    function sbDisplayRows($DataRows)
    {
       $arrDisplay  = array();
       if(is_array($DataRows) && count($DataRows)>0)
       {
           $i = 0;
            foreach($DataRows as $row=>$data)
            {
               //format the urls 
               $arrDisplay[$i]['joom_original'] = str_replace('&','&amp;',$this->sbTrimStr(stripcslashes($data->joom_original),50)); 
               $arrDisplay[$i]['raw_original']  = $data->joom_original;
               $arrDisplay[$i]['sb_sef']        = str_replace('&','&amp;',$this->sbTrimStr(stripcslashes($data->sb_sef),50));               
               $arrDisplay[$i]['raw_sef']       = $data->sb_sef;
               $arrDisplay[$i]['priority']      = $data->link_priority;                              
               $arrDisplay[$i]['follow']        = $data->follow;                              
               $arrDisplay[$i]['index']         = $data->rob_index;                                             
               $arrDisplay[$i]['is_sef']        = $data->is_sef;                                             
               $arrDisplay[$i]['component']     = $data->component;              
               $arrDisplay[$i]['chk_box']       = @mosCommonHTML::CheckedOutProcessing($data,$i);
               $arrDisplay[$i]['id']            = $data->id;              
               $arrDisplay[$i]['sef_type']      = $data->sef_type;              
               $i++;
            }            
            unset($DataRows);
        }
        return $arrDisplay;
    }  
    
    function getNavigation()
    {
        return $this->PageNav->getListFooter();
    }
    
    /**
    * @desc Function sbLoadDetails - gets details of a sef.
    * @param integer sfID
    * @return array
    */
    function sbLoadDetails($sfID)
    {
        global $database;
        global $mosConfig_sitename,$mosConfig_MetaDesc,$mosConfig_MetaKeys;

        if($sfID < 0 || !$sfID) return 0; 

        $strSQL = "SELECT * FROM ".TBL_SBZ_SEF." WHERE id = '".$sfID."'";
        $database->setQuery($strSQL);
        $sefData = $database->loadObjectList();
        if(count($sefData) > 0 && isset($sefData))
        {
            $this->joom_original = str_replace('&','&amp;',stripcslashes($sefData[0]->joom_original)); 
            $this->sb_sef        = str_replace('&','&amp;',stripcslashes($sefData[0]->sb_sef));                           
            $this->mPTitle       = stripcslashes($sefData[0]->title);    
            $this->mMTitle       = stripcslashes($sefData[0]->meta_title);    
            $this->mDesc         = stripcslashes($sefData[0]->meta_description);    
            $this->mKeyword      = stripcslashes($sefData[0]->meta_keywords);
            $this->component     = $sefData[0]->component;              
            $this->is_sef        = $sefData[0]->is_sef;              
            $this->link_priority = $sefData[0]->link_priority;                           
            $this->rbIndex       = $sefData[0]->rob_index;               
            $this->rdFollow      = $sefData[0]->follow;      
            $this->sef_type      = $sefData[0]->sef_type;      
			         
            //check if current record is a content
            if(isset($sefData[0]->sbz_id) && $sefData[0]->type == '0' || $sefData[0]->type == '-1')
            {
                //get suggestion
                $this->sbGetSuggestion($sefData[0]->sbz_id);
                $this->sbz_id = $sefData[0]->sbz_id;
            }else{
                //get default values.
                $this->sMTitle  = $this->sPTitle = $mosConfig_sitename;
                $this->sDesc = $mosConfig_sitename." ".$mosConfig_MetaDesc;
                if(strlen($mosConfig_MetaKeys)>0){
                    $this->sKeyword = $mosConfig_MetaKeys.", ".$mosConfig_sitename;
                }else{
                    $this->sKeyword = $mosConfig_sitename;              
                }
            }
            $arrCompare[] = mosHTML::makeOption('1','Yes','lk','le');
            $arrCompare[] = mosHTML::makeOption('0','No','lk','le');                                                                                               
            $this->arrSettings['cmb_rbIndex'] = mosHTML::selectList( $arrCompare, 'cmb_rbIndex','class="inputbox" size="1"','lk', 'le',$this->rbIndex);
            $this->arrSettings['cmb_rbFollow'] = mosHTML::selectList( $arrCompare, 'cmb_rbFollow','class="inputbox" size="1"','lk', 'le',$this->rdFollow);
            unset($arrCompare);

            $arrCompare[] = mosHTML::makeOption('2','High','lk','le');            
            $arrCompare[] = mosHTML::makeOption('0','Low','lk','le'); 
            $this->arrSettings['cmb_LinkPriority'] = mosHTML::selectList( $arrCompare, 'cmb_LinkPriority','class="inputbox" size="1"','lk', 'le',$this->link_priority);
            unset($arrCompare);
            unset($sefData);
        }
    }
    
    /**
    * @desc Function sbCheckDuplicate - checks for duplicate sef
    * @param int id
    * @return 1 on success, 0 on fail
    */
    function sbCheckDuplicate($id)
    {
       global $database;
       if(!$id || $id < 0) return; 
       //get sef value 
       $sefURL = mosGetParam( $_REQUEST, 'sef_url', FALSE);
       //check if sef is empty        
       if(trim($sefURL)=="") return 2;
       
       if($sefURL[0]!="/"){
           $sefURL = "/".$sefURL;

       }        
       $strSql = "SELECT count(*) FROM ".TBL_SBZ_SEF." WHERE id!='".$id."' AND sb_sef = '".trim($sefURL)."'"; 
       $database->setQuery($strSql);                                        
       $total_records = $database->loadResult();
       if($total_records>0){
           return 1;
       }else{
           return 0;
       }
    }
    
	
    /**
    * @desc Function sbGetSingleRecord - fetch single record from #_serrbizsef_sef table depending on id
    * @param int id
    */
	function sbGetSingleRecord($id)
	{
		global $database;
		$strSql = " select  
		`id` , `joom_original` , `sb_sef` , `title` , `meta_title` , `meta_description` , `meta_keywords` , 
		`component` , `type` , `sbz_id` , `link_priority` , `rob_index` , `follow` , `is_sef` , `is_import_sef` , 
		`import_from` , `sef_type` , `status` from ".TBL_SBZ_SEF." WHERE  `id` = '".$id."' ";

        $database->setQuery($strSql);
        $database->query();
        $result = $database->loadObjectList();
        if(! $result) {
            echo $database->stderr();
            exit;
        }
		return $result;
	}
	
    /**
    * @desc Function sbUpdateSEF - updates sef details
    * @param int id
    * return 
    */
    function sbUpdateSEF($id)
    {
        global $database,$mosConfig_live_site;

        if($id < 0 || !$id) return;
        
        $mKeyword    = mosGetParam( $_REQUEST, 'meta_key', FALSE);
        $mDesc       = mosGetParam( $_REQUEST, 'meta_desc', FALSE);
        $mMtitle     = mosGetParam( $_REQUEST, 'meta_title', FALSE);        
        $mPageTitle  = mosGetParam( $_REQUEST, 'page_title', FALSE);
        $sefURL      = mosGetParam( $_REQUEST, 'sef_url', FALSE);
        $cid         = mosGetParam( $_REQUEST, 'CID', FALSE);
        $linkP       = mosGetParam( $_REQUEST, 'cmb_LinkPriority', FALSE);
        $rbInd       = mosGetParam( $_REQUEST, 'cmb_rbIndex', FALSE);
        $rbFw        = mosGetParam( $_REQUEST, 'cmb_rbFollow', FALSE);
        $sef_type    = mosGetParam( $_REQUEST, 'sef_type', FALSE);
		
		
		if($sef_type==0)
		{
		
		 /**Create new function in the SEF control panel that records changes to SEF urls.  
		    If a user CHANGES and existing SEF, the change is noted, and the 
		    OLD SEF is added to the REDIRECT control panel.
		 */
		  $singleSEFURLInfo = sbAdmin::sbGetSingleRecord($id);
		  if($singleSEFURLInfo)
		  {
		    $valuesToInsert = $singleSEFURLInfo[0];
		    unset($singleSEFURLInfo);
			$saveValues = 1;
			//echo $valuesToInsert->sb_sef.' = '.$sefURL."<br>";
			if( ($valuesToInsert->sb_sef == $sefURL) ||  ('/'.$valuesToInsert->sb_sef == $sefURL) || ($valuesToInsert->sb_sef == '/'.$sefURL) || ($mosConfig_live_site.$valuesToInsert->sb_sef == $sefURL ) || ($mosConfig_live_site.'/'.$valuesToInsert->sb_sef == $sefURL ) || ($valuesToInsert->sb_sef == $mosConfig_live_site.'/'.$sefURL ) || ($valuesToInsert->sb_sef == $mosConfig_live_site.$sefURL ) )
			{
				$saveValues = 0;
			}
			
			if($saveValues==1)
			{
				$strSqlInsert = $strSqlInsert." INSERT INTO ".TBL_SBZ_SEF." ";
				$strSqlInsert = $strSqlInsert." ( 
									`id` , `joom_original` , `sb_sef` , `title` , 
									`meta_title` , `meta_description` , `meta_keywords` , `component` , 
									`type` , `sbz_id` , `link_priority` , `rob_index` , 
									`follow` , `is_sef` , `is_import_sef` , `import_from` , 
									`sef_type` , `status` 
								  ) ";
				$strSqlInsert = $strSqlInsert." VALUES (  NULL , '".$valuesToInsert->sb_sef."', '".$sefURL."', '".$valuesToInsert->title."', 
											'".$valuesToInsert->meta_title."', '".$valuesToInsert->meta_description."', '".$valuesToInsert->meta_keywords."', '".$valuesToInsert->component."',
											'".$valuesToInsert->type."', '".$valuesToInsert->sbz_id."', '".$valuesToInsert->link_priority."', '".$valuesToInsert->rob_index."', 
											'".$valuesToInsert->follow."', '".$valuesToInsert->is_sef."', '".$valuesToInsert->is_import_sef."', '".$valuesToInsert->import_from."',
											 '1', '".$valuesToInsert->status."' ) ";
				
				$database->setQuery($strSqlInsert);
				$result = $database->query();        
				if(! $result) {
					echo $database->stderr();
					exit;
				}
				unset($result);    
			}	

		  }
		}
		
        if($sefURL[0]!="/") {
           $sefURL = "/".$sefURL;
        }

        $strSql = " UPDATE ".TBL_SBZ_SEF." SET ";
        $strSql .= " sb_sef = '".$sefURL."'";   
        $strSql .= " ,title = '".$mPageTitle."'"; 
        $strSql .= " ,meta_title = '".$mMtitle."'";          
        $strSql .= " ,meta_description = '".$mDesc."'";  
        $strSql .= " ,meta_keywords = '".$mKeyword."'";  
        //$strSql .= " ,link_priority = '".$linkP."'";
        $strSql .= " ,rob_index = '".$rbInd."'"; 
        $strSql .= " ,follow = '".$rbFw."'";         
        $strSql .= " WHERE id = '".$id."'";
      
        $database->setQuery($strSql);
        $database->query();
        $result = $database->query();        
        if(! $result) {
            echo $database->stderr();
            exit;
        }
        unset($result);    
		
        $sqlUpdateAll = " UPDATE ".TBL_SBZ_SEF." SET
					`sb_sef` = '".$sefURL."' WHERE 
					( `sb_sef` = '".$mosConfig_live_site.$valuesToInsert->sb_sef."' OR 
					`sb_sef` = '".$mosConfig_live_site.'/'.$valuesToInsert->sb_sef."' OR 
					`sb_sef` = '".$valuesToInsert->sb_sef."'  OR 
					`sb_sef` = '/".$valuesToInsert->sb_sef."'  
					)
					AND	`link_priority` = '0'  AND `sef_type`='0' ";
				
        $database->setQuery($sqlUpdateAll);
        $database->query();
        $result = $database->query();        
        if(! $result) {
            echo $database->stderr();
            exit;
        }
        unset($result);    
    }

    /**
    * @desc Function sbDeleteSEF - delete a record from table
    * @param int id
    */
    function sbDeleteSEF($sef)
    {
        global $database;

        if(!is_array($sef) || count($sef)==0) return;
		 /*	 
         $strSql = " DELETE FROM ".TBL_SBZ_SEF." WHERE `id` in ('".implode("','",$sef)."')";
         $database->setQuery($strSql);
         $database->query();
		 */
        foreach($sef as $key=>$val)
        {
            //first pull sef.
            $strsql = "SELECT sb_sef,sef_type FROM ".TBL_SBZ_SEF." WHERE id = '".$val."'";
            $database->setQuery($strsql);
            $sefData = $database->loadObjectList();
			
            if(count($sefData) > 0 && isset($sefData))
            {
                $sbsef = trim($sefData[0]->sb_sef);
				
                $strSql = " DELETE FROM  ".TBL_SBZ_SEF." ";
                $strSql .= " WHERE sb_sef = '".$sbsef."'";
                $strSql .= " AND sef_type = '".$sefData[0]->sef_type."'";
                $database->setQuery($strSql);        
                $database->query();                
            }else{
                $strSql = " DELETE FROM  ".TBL_SBZ_SEF." ";
                $strSql .= " WHERE id = '".$val."'";
                $database->setQuery($strSql);        
                $database->query();
            }

        }
		unset($sef);                
		
        
    }       

    /**
    * @desc Function sbUpdateConfig - updates config details
    */
    function sbUpdateConfig()
    {
        global $database;
        
        $sbActive   = mosGetParam( $_REQUEST, 'rdActive', FALSE);
        $sefActive  = mosGetParam( $_REQUEST, 'rdSEFInfo', FALSE);
        $mActive    = mosGetParam( $_REQUEST, 'rdMetaInfo', FALSE);        
        $SEF301     = mosGetParam( $_REQUEST, 'rdSEF301', FALSE);        
        $ErrorPage  = mosGetParam( $_REQUEST, 'txtCustom', FALSE);
                
        $strSql = " UPDATE ".TBL_SBZ_CONFIG." SET ";
        $strSql .= " active = '".$sbActive."'";   
        $strSql .= " ,override_meta = '".$mActive."'";  
        $strSql .= " ,sef_status = '".$sefActive."'";
        $strSql .= " ,allow_redirect = '".$SEF301."'";
        $strSql .= " ,custom_error_page = '".$ErrorPage."'";
        
        $database->setQuery($strSql);
        $database->query();
        $result = $database->query();

        $arrComponents = mosGetParam($_REQUEST,'chkComp',array());
        $strSql = " UPDATE ".TBL_SBZ_COMP." SET status = 0 ";
        $database->setQuery($strSql);
        $database->query();
        if(isset($arrComponents) && count($arrComponents) > 0) 
        {
            foreach($arrComponents as $key=>$value) {
                $user_value = mosGetParam( $_REQUEST, 'txtValue_'.$value, FALSE); 
                $strSql = " UPDATE ".TBL_SBZ_COMP." SET ";
                $strSql .= " user_specific_name = '".trim(addslashes($user_value))."'";   
                $strSql .= " ,status = 1 WHERE id = '".$value."'";  
                $database->setQuery($strSql);
                $database->query();
            }
        }
        
        if(! $result) {
            echo $database->stderr();
            exit;
        }
        unset($result);  
    }

    /**
    * @desc Function sbGetSuggestion - creates meta info suggestion
    * @param integer contentID
    */
    function sbGetSuggestion($contentID)
    {
        global $database;
        global $mosConfig_MetaDesc,$mosConfig_MetaKeys,$mosConfig_sitename;
      
        if($contentID < 0) return 0;

        $sqlSTR = "SELECT IF(c.catid != 0, CONCAT(c.title, '{##}', ct.title, '{##}', s.title), c.title)"; 
        $sqlSTR .= " FROM #__content AS c LEFT JOIN #__categories AS ct ON ct.id = c.catid";
        $sqlSTR .= " LEFT JOIN #__sections AS s on s.id = c.sectionid WHERE c.id = '".$contentID."'";
        $database->setQuery($sqlSTR);
        $result = $database->query();                                                                
        if($result) 
        {
          $valData = $database->loadResult();           
          $arrValues = explode('{##}',$valData);
          $this->sMTitle  = $this->sPTitle = $mosConfig_sitename." ".preg_replace("/[.?!]/","",stripcslashes($arrValues[0]));
          if(strlen($arrValues[0])>0) {
            $this->sDesc = $mosConfig_sitename." ".preg_replace("/[.?!]/","",stripcslashes($arrValues[0])).". ".$mosConfig_MetaDesc; 
          }else{
            $this->sDesc = $mosConfig_sitename." ".$mosConfig_MetaDesc;               
          } 
          if(strlen($valData)>0){
            $this->sKeyword = preg_replace("/[.?!]/","",stripcslashes(str_replace('{##}',", ",$valData))).", ".$mosConfig_MetaKeys;
          }else{
            $this->sKeyword = $mosConfig_MetaKeys.", ".$mosConfig_sitename;              
          }  
          if(strlen($this->sKeyword)>0){
            $this->sKeyword = $this->sKeyword.", ".$mosConfig_sitename;
          }else{
            $this->sKeyword = $mosConfig_sitename;              
          }
          //format string          
          //$this->sKeyword = preg_replace("/[.?!]/","",$this->sKeyword);
          unset($result);
        }                   
    }

    /**
    * @desc Function sbGetConfig - gets config details
    * @param integer contentID
    */
    function sbGetConfig()
    {
        global $database;

        $sqlStr = "SELECT * FROM ".TBL_SBZ_CONFIG." ";
        $database->setQuery($sqlStr);
        $result = $database->query();   
        if(!$result){
            echo $database->stderr();
            exit;
        }else{
            $Rows = $database->loadObjectList();
            $this->isSBActive = $Rows[0]->active;
            $this->isSEFActive = $Rows[0]->sef_status;
            $this->isMetaInfoActive = $Rows[0]->override_meta; 
            $this->isRedirectActive = $Rows[0]->allow_redirect;
            $this->strCustomError = $Rows[0]->custom_error_page;   
            unset($result);
            unset($Rows);      
        }
    }
    
    /**
    * @desc function UpdateSettings - updates details such as robot, index, link priority.
    * @param int id
    */
    function UpdateSettings($id)
    {
        global $database;

        $task = mosGetParam($_REQUEST,'task'); 
        switch($task)
        {
              case 'drop_index':
                $strSql = " UPDATE ".TBL_SBZ_SEF." SET rob_index = 0 WHERE id = '".$id."'";
                break;    
              case 'set_index': 
                $strSql = " UPDATE ".TBL_SBZ_SEF." SET rob_index = 1 WHERE id = '".$id."'";
                break;    
              case 'drop_follow':
                $strSql = " UPDATE ".TBL_SBZ_SEF." SET follow = 0 WHERE id = '".$id."'";
                break;    
              case 'set_follow':
                $strSql = " UPDATE ".TBL_SBZ_SEF." SET follow = 1 WHERE id = '".$id."'";
                break;
              case 'link_high':                
                $strSql = "SELECT sb_sef FROM ".TBL_SBZ_SEF." WHERE id = '".$id."'";
                $database->setQuery($strSql);  
                $result = $database->query();              
                if($result)
                {
                    $sb_sef = $database->loadResult();
                    $strSql = "UPDATE ".TBL_SBZ_SEF." SET link_priority = '0', status = 1 WHERE sb_sef = '".$sb_sef."'";
                    $database->setQuery($strSql); 
                    $database->query();                                         
                }
                $strSql = " UPDATE ".TBL_SBZ_SEF." SET link_priority = '2',status = 1 WHERE id = '".$id."'";
                break;    
              case 'link_med':
                $strSql = " UPDATE ".TBL_SBZ_SEF." SET link_priority = '1',status = 1 WHERE id = '".$id."'";
                break;    
              case 'link_low':
                $strSql = " UPDATE ".TBL_SBZ_SEF." SET link_priority = '0',status = 1 WHERE id = '".$id."'";
                break;
        }
        if(strlen($strSql) > 0)
        {
            $database->setQuery($strSql);
            $database->query();
            $result = $database->query();
            if(! $result) {
                echo $database->stderr();
                exit;
            }
            unset($result);
        }     

    }    
   
    /**
    * @desc function IndexStatus - checks value for robot index, creates array of images, task.
    * @param int id
    */
    function IndexStatus($status) 
    {
        $arrAttributes = array('img'=>'status_x.png','task'=>'set_index','act'=>'Set Robot Index');
        if($status == 1)
        {
           $arrAttributes['img']  = 'status_a.png';
           $arrAttributes['task'] = 'drop_index'; 
           $arrAttributes['act']  = 'Drop Robot Index';
        }
        return $arrAttributes;
    }

    /**
    * @desc function FollowStatus - checks value for follow, creates array of images, task
    * @param int status
    */    
    function FollowStatus($status) 
    {
        $arrAttributes = array('img'=>'status_x.png','task'=>'set_follow','act'=>'Set Robot Follow');
        if($status == 1)
        {
            $arrAttributes['img']  = 'status_a.png';
            $arrAttributes['task'] = 'drop_follow'; 
            $arrAttributes['act']  = 'Drop Robot Follow';
        }
        return $arrAttributes;
    }

    /**
    * @desc function FollowStatus - checks value for link priority, creates array of images, task.
    * @param int id, value
    * @return array
    */
    function ListPriority($k,$v)
    {
        $arrList = array();
        $name = "cb".$k;
        $arrList['H'] = "<a href=\"javascript:void(0);\" onclick=\"return listItemTask('".$name."','link_high')\" title=\"Set High Priority\"><font style=\"font-weight:bold;color:#cccccc;font-size:12px\">H</font></a>";
        $arrList['M'] = "<a href=\"javascript:void(0);\" onclick=\"return listItemTask('".$name."','link_med')\" title=\"Set Medium Priority\"><font style=\"font-weight:bold;color:#cccccc;font-size:12px\">M</font></a>";
        $arrList['L'] = "<a href=\"javascript:void(0);\" onclick=\"return listItemTask('".$name."','link_low')\" title=\"Set Low Priority\"><font style=\"font-weight:bold;color:#cccccc;font-size:12px\">L</font></a>";
        switch($v)
        {
            case 0:
                $arrList['L'] = "<span style=\"font-weight:bold;color:#8B0000;font-size:12px\">L</span>";
            break;
            case 1:
                $arrList['M'] = "<span style=\"font-weight:bold;color:#FF8C00;font-size:12px\">M</span>";
            break;
            case 2:
                $arrList['H'] = "<span style=\"font-weight:bold;color:#006400;font-size:12px\">H</span>";
            break;
        }
        return $arrList;     
    }
    
    /**
    * @desc function sbCheckSameSEF - checks for same sefs
    * @param string sef, int id
    * @return 1 on success, 0 on fail
    */
    function sbCheckSameSEF($sef,$id)
    {
        global $database;

        $return = 0;               
        $strSql = "SELECT COUNT(*) FROM ".TBL_SBZ_SEF." WHERE sb_sef = '".$sef."' AND id != '".$id."'";
        $database->setQuery($strSql);                
        $total_records = $database->loadResult(); 

        if($total_records > 0) {
            $return = 1;    
        }
                                 
        return $return;
    }    

    /**
    * @desc function sbGetLinks - gets same type of sef
    * @param string sef, int id
    * @return string
    */    
    function sbGetLinks($sbid,$sef)
    {
        global $database;
        
        $strSql = "SELECT id, joom_original,component FROM ".TBL_SBZ_SEF." WHERE id != '".$sbid."' AND sb_sef = '".$sef."'";
		$list='';
        $database->setQuery($strSql);
        $sefData = $database->loadAssocList();
        if(count($sefData) > 0 && isset($sefData))
        { 
            $x = 0;       
            $list .= "<th align=left>Component</th>\n";                
            $list .= "<th align=left>Internal URL</th>\n";
            foreach($sefData as $key =>$value) {
                $list .= "<tr>\n";
                $list .= "<td class='row$x' align=left>&nbsp;$value[component]</td>\n";                
                $list .= "<td class='row$x'align=left><input id='lstInternal$value[id]' class='inputbox' type='radio' onclick='javascript:document.adminForm.boxchecked.value=1' value='$value[id]' name='lstInternal'/>&nbsp;$value[joom_original]</td>\n";
                $list .= "</tr>\n";
                $x++;
            } 
            $return = $list;
        }else{
            $return = "";
        }
        return $return;
    }
    
    /**
    * @desc function sbSaveNewLink - saves information related to set link feature
    * @param  
    * @return 
    */        
    function sbSaveNewLink()
    {
        global $database;
         
        $listid   = mosGetParam($_REQUEST,'lstInternal');
        $sb_sef   = mosGetParam($_REQUEST,'sb_sef');
        $old_id   = mosGetParam($_REQUEST,'id');

        if(isset($listid) && $listid > 0 && trim($listid)!= "" && trim($sb_sef)!="")
        {
            //set existing to low
            $strSql = "UPDATE ".TBL_SBZ_SEF." SET link_priority = '0',status = 1 WHERE sb_sef = '".$sb_sef."'";
            $database->setQuery($strSql); 
            $database->query(); 
            
            //set new
            $strSql = "UPDATE ".TBL_SBZ_SEF." SET link_priority = '2',status = 1 WHERE id = '".$listid."'";
            $database->setQuery($strSql); 
            $database->query();
        }   
    }
    
    /**
    * @desc function sbGetImportSEF - gets list of imported sef
    * @param  
    * @return array
    */    
    function sbGetImportSEF()
    {
        global $database,$mainframe, $mosConfig_live_site,$mosConfig_absolute_path;         
        
        $default_link = " AND is_import_sef = 1";
        
        $where .= $default_link;
        //now get the record count from table        
        $sql = "SELECT count(*) FROM ".TBL_SBZ_SEF." WHERE 1 $where";        
        $database->setQuery($sql);                                        
        $total_records = $database->loadResult();
                
        //get the record list limit values
        $limit = $mainframe->getUserStateFromRequest("limit", 'limit', $mainframe->getCfg('list_limit') );
        $limitstart = $mainframe->getUserStateFromRequest("com_serrbizsef.limitstart", 'limitstart',0 );
        if($total_records < $limitstart) $limitstart = 0;
        //get all records from table
        $sqlStr = "SELECT * FROM ".TBL_SBZ_SEF." WHERE 1 $where ORDER BY sb_sef"; 
        if(isset($limit) && isset($limitstart)){
            $database->setQuery($sqlStr , $limitstart, $limit);
        }else{
            $database->setQuery($sqlStr);
        }
        //load records
        $records = $database->loadObjectList();
        //create navigation 
        require_once($mosConfig_absolute_path.'/administrator/includes/pageNavigation.php');        
        $this->PageNav = new mosPageNav($total_records, $limitstart, $limit);
        if(count($records) <= 0)
        {
            return;
        }
        else
        {
            return $this->sbDisplayRows($records);
        }                        
    }
    
    function sbInactiveImportSEF()
    {
        $arrIDs = mosGetParam($_REQUEST,'cid');
        if(is_array($arrIDs) && count($arrIDs)>0) {
            foreach($arrIDs as $key=>$value){
                $this->sbDisableImportSEF($value); 
            }
        }        
    }
    
    /**
    * @desc function sbDisableImportSEF - sets a imported sef as inactive
    * @param  
    * @return
    */    
    function sbDisableImportSEF($id)
    {
       if(!$id || $id < 0 || $id==0)  return 0;
       
       global $database;

       $sqlStr = "SELECT * FROM ".TBL_SBZ_SEF." WHERE id = '".$id."'"; 
       $database->setQuery($sqlStr);       
       //load records
       $records = $database->loadAssocList();
       if(isset($records[0]) && count($records[0])>0)
       {
            $sql = "UPDATE ".TBL_SBZ_SEF." SET status = 0,link_priority = '1' WHERE id = '".$id."'";
            $database->setQuery($sql); 
            $database->query();
            
            $sql = "UPDATE ".TBL_SBZ_SEF." SET status = 0,link_priority = '0' WHERE id != '".$id."' AND sb_sef = '".$records[0]['sb_sef']."'";
            $database->setQuery($sql); 
            $database->query();
            
            //now use the internal url and create a new SEF based on SerrBizSEF rules.                
            $filepath = $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_serrbizsef/serrbizsef.sef.php';
            if(file_exists($filepath))
            {
                //include class file to create SEF URL
                require_once($filepath);
                sefRelToAbs($records[0]['joom_original']);
            }    
       }
       unset($records);
    }
    
    function sbActiveImportSEF()
    {
        $arrIDs = mosGetParam($_REQUEST,'cid');
        if(is_array($arrIDs) && count($arrIDs)>0) {
            foreach($arrIDs as $key=>$value){
                $this->sbEnableImportSEF($value); 
            }
        }            
    }
    
    /**
    * @desc function sbEnableImportSEF - sets a imported sef as active
    * @param int id 
    * @return
    */    
    function sbEnableImportSEF($id)
    {
       if(!$id || $id < 0 || $id==0)  return 0;

       global $database,$mosConfig_live_site;
        
       $sqlStr = "SELECT * FROM ".TBL_SBZ_SEF." WHERE id = '".$id."'"; 
       $database->setQuery($sqlStr);       
       //load records
       $records = $database->loadAssocList();
       if(isset($records[0]) && count($records[0])>0)
       {
            $strSearchURL = $records[0]['joom_original'];
            $strSearchURL = $this->removeQueryParameters($strSearchURL,'&Itemid=');
            $strSearchURL = str_replace("&&","&",$strSearchURL);
            //now get sef for this url.
            $filepath = $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_serrbizsef/serrbizsef.sef.php';
            if(file_exists($filepath))
            {
                //include class file to create SEF URL
                require_once($filepath);
                $strSEF = sefRelToAbs($strSearchURL);                
                $strSEF = trim(str_replace($mosConfig_live_site,'',$strSEF));
                
                $sql = "UPDATE ".TBL_SBZ_SEF." SET status = 0,link_priority = '0' WHERE id != '".$id."' AND sb_sef = '".$strSEF."'";
                $database->setQuery($sql); 
                $database->query();
                
                $sql = "UPDATE ".TBL_SBZ_SEF." SET status = 1,link_priority = '2' WHERE id = '".$id."'";
                $database->setQuery($sql); 
                $database->query();
            }
        }
    } 
    
    /**
    * @desc function ImportSEFStatus - checks value for imported sef, creates array of images, task
    * @param int status
    * @return array
    */     
    function ImportSEFStatus($status) 
    {
        $arrAttributes = array('img'=>'status_x.png','task'=>'active_import','act'=>'Set SEF Active');
        if($status == 2)
        {
            $arrAttributes['img']  = 'status_a.png';
            $arrAttributes['task'] = 'inactive_import'; 
            $arrAttributes['act']  = 'Set SEF Inactive';
        }
        return $arrAttributes;
    }
    
    /**
    * @desc function sbExtraComponents - gets list of 3rd party supported comp
    * @param  
    * @return array
    */    
    function sbExtraComponents()
    {
        global $database;
        $arrDisplay = array();
        
        $sqlStr = "SELECT * FROM ".TBL_SBZ_COMP." ORDER BY ID ASC"; 
        $database->setQuery($sqlStr);       
        //load records
        $Records = $database->loadObjectList();        
        if(is_array($Records) && count($Records) > 0) 
        { 
            $i = 1;  
            foreach($Records as $key=>$data)   
            {
                $arrDisplay[$i]['com_name'] = $data->com_name;              
                $arrDisplay[$i]['default_name'] = $data->default_name;                
                if($data->format!='com_deeppockets'){
                    $arrDisplay[$i]['user_value'] = "<input type=\"text\" name=\"txtValue_$data->id\" class=\"inputbox\" maxlength=20 value=\"$data->user_specific_name\">";
                }
                $checked = "";
                if($data->status==1) $checked = "checked";                
                $arrDisplay[$i]['status'] = "<input type=\"checkbox\" name=\"chkComp[]\" $checked class=\"inputbox\" value=\"$data->id\">";                
                $i++;
            }
        }    
        return $arrDisplay;
    }
    
    /**
    * @desc function removeQueryParameters - removes a value from query string.
    * @param string url, string value to remove
    * @return string
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
    * @desc function sbTrimStr -returns formatted string
    * @param string url, int len
    * @return string
    */        
    function sbTrimStr($str,$intLen)
    {
        return strlen($str) > $intLen ? substr($str,0,50)." ......" : $str;

    }
}

?>