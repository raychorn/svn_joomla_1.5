<?php
/*
* SerrBizSEFSocialBookmark is a released under the terms of the GNU General Public License;
* Warranty : This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
* FITNESS FOR A PARTICULAR PURPOSE. 
*/
defined( '_VALID_MOS' ) or die( 'Restricted access' );
class SerrBizSEFSocialBookmark
{
    var $action;        
    var $objParams;
    var $icon_path;
    var $arrSiteInfo;
    var $window_position;
    
    function SerrBizSEFSocialBookmark()
    {
        
    }
    
    function LoadBookmarks($action)
    {
        $return = false;
        
        if($this->ConstructBookmarks($action))
        {
            $return  = true;
        }             
        return $return;
    }
                           
    function ConstructBookmarks($action)
    {
        global $database,$mosConfig_live_site;              
        
        $return = false;
        if(!$action) return $return;            
        $this->action = $action;                
        switch($this->action)
        {
            case 'loadParam':
            $sql = "SELECT params FROM #__modules WHERE module = 'mod_serrbizsef_bookmark'";
            $database->setQuery($sql);
            $result = $database->query();
            if($result) {                
                $database->loadObject($social);
                $this->objParams = new mosParameters($social->params);    
                $return = true;
            }  
            break;

            case 'showicons':
            if(isset($this->objParams)) {
                $i=0;
                $objLinks = new GetLinks(); 
                foreach($this->objParams->_params as $name=>$value) {
                    if($objLinks->getBookmarkLink($name) && $value=='1') {
                        $this->arrSiteInfo[$i]['link'] = $this->FormatURL($objLinks->sitelink);
                        $this->arrSiteInfo[$i]['icon'] = $mosConfig_live_site.'/modules/mod_serrbizsef_bookmark/images/'.$name.'.png';    
                        $this->arrSiteInfo[$i]['tooltip'] = $name;                        
                        $i++;                       
                    }
                    if($name == 'win_position'){
                        $this->window_position = $value;                                                                           
                    }                            
                }
                $this->arrSiteInfo[$i]['link']  = "http://www.serr.biz";
                $this->arrSiteInfo[$i]['tooltip'] = "Social book marking functionality provided by Serr.biz, an SEO company.";
                $this->arrSiteInfo[$i]['icon'] = $mosConfig_live_site.'/modules/mod_serrbizsef_bookmark/images/serrbizbookmark.gif';
                if(!isset($this->window_position)) {
                    $this->window_position = 'bottom';
                }
                $return = true;
                unset($objLinks);
            }   
            break;
        }
        return $return;
    }   
    
    function FormatURL($strURL)
    {
        global $SBZ_PTITLE,$mosConfig_sitename;
        
        if(strlen($SBZ_PTITLE)){
            $strTitle = $SBZ_PTITLE;  
        }else{
            $strTitle = $mosConfig_sitename;  
        } 
        
        $strURL = str_replace('{title}',urlencode($strTitle),$strURL);         
        $link = sefRelToAbs($_SERVER['REQUEST_URI']);
        $strURL = str_replace('{url}',urlencode($link),$strURL);         
        return $strURL;
    }                                                   
}

class GetLinks 
{
  var $sitelink;  
  
  function GetLinks(){   
    /* */   
  }     
  
  function getBookmarkLink($case)
  {
      $return = false;
      switch($case)
      {
          case 'blinkbits':
          $this->sitelink = "http://www.blinkbits.com/bookmarklets/save.php?v=1&amp;source_url={url}&amp;title={title}&amp;body={title}";
          $return = true;
          break;          
          case 'blinklist':
          $this->sitelink = "http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Description=&amp;Url={url}&amp;Title={title}";
          $return = true;
          break;
          case 'blogmarks':
          $this->sitelink = "http://blogmarks.net/my/new.php?mini=1&amp;simple=1&amp;url={url}&amp;title={title}";
          $return = true;
          break;                    
          case 'digg':
          $this->sitelink = "http://digg.com/submit?url={url}";
          $return = true;
          break; 
          case 'delicious':
          $this->sitelink = "http://del.icio.us/post?v=4&noui&jump=close&url={url}&title={title}";
          $return = true;
          break;
          case 'fark':
          $this->sitelink = "http://cgi.fark.com/cgi/fark/edit.pl?new_url={url}&amp;new_comment={title}&amp;linktype=Misc";
          $return = true;
          break;          
          case 'feedmelinks':
          $this->sitelink = "http://feedmelinks.com/categorize?from=toolbar&amp;op=submit&amp;url={url}&amp;name={title}";
          $return = true;
          break;   
          case 'furl':
          $this->sitelink = "http://www.furl.net/storeIt.jsp?t={title}&u={url}";
          $return = true;
          break; 
          case 'linkagogo':
          $this->sitelink = "http://www.linkagogo.com/go/AddNoPopup?url={url}&amp;title={title}";
          $return = true;
          break;
          case 'magnolia':
          $this->sitelink = "http://ma.gnolia.com/beta/bookmarklet/add?url={url}&amp;title={title}&amp;description={title}";
          $return = true;
          break;
          case 'netvouz':
          $this->sitelink = "http://www.netvouz.com/action/submitBookmark?url={url}&amp;title={title}&amp;description={title}";
          $return = true;
          break;          
          case 'newsvine':
          $this->sitelink = "http://www.newsvine.com/_tools/seed&amp;save?u={url}&amp;h={title}";
          $return = true;
          break;          
          case 'rawsugar':
          $this->sitelink = "http://www.rawsugar.com/tagger/?turl={url}&amp;tttl={title}";
          $return = true;
          break;                                    
          case 'shadows':
          $this->sitelink = "http://www.shadows.com/features/tcr.htm?url={url}&amp;title={title}";
          $return = true;
          break;          
          case 'simpy':
          $this->sitelink = "http://www.simpy.com/simpy/LinkAdd.do?href={url}&amp;title={title}";
          $return = true;
          break;        
          case 'smarking':
          $this->sitelink = "http://smarking.com/editbookmark/?url={url}&amp;description={title}";
          $return = true;
          break;          
          case 'spurl':
          $this->sitelink = "http://www.spurl.net/spurl.php?v=3&title={title}&url={url}";
          $return = true;
          break;          
          case 'stumble':
          $this->sitelink = "http://www.stumbleupon.com/newurl.php?url={url}&rating=1";
          $return = true;
          break;          
          case 'tailrank':
          $this->sitelink = "http://tailrank.com/share/?text=&amp;link_href={url}&amp;title={title}";
          $return = true;
          break;          
          case 'technorati':
          $this->sitelink = "http://technorati.com/faves?add={url}";
          $return = true;
          break;          
          case 'wists':
          $this->sitelink = "http://wists.com/r.php?c=&amp;r={url}&amp;title={title}";
          $return = true;
          break;          
          case 'yahoo':
          $this->sitelink = "http://myweb2.search.yahoo.com/myresults/bookmarklet?u={url}&amp;={title}";
          $return = true;
          break;
          case 'reddit':
          $this->sitelink = "http://reddit.com/submit?url={url}&amp;title={title}";
          $return = true;
          break;
      }      
      return $return;  
  }  
}  
?> 