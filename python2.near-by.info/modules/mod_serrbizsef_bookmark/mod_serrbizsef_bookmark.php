<?php
/*
* SerrBizSEFSocialBookmark is a released under the terms of the GNU General Public License;
* Warranty : This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
* FITNESS FOR A PARTICULAR PURPOSE. 
*/
defined( '_VALID_MOS' ) or die( 'Restricted access' );
include($GLOBALS['mosConfig_absolute_path'].'/modules/mod_serrbizsef_bookmark/sites.php'); 

global $SBZ_PTITLE, $SBZ_MKEYWORDS, $SBZ_MDESC;
global $mosConfig_sitename,$mosConfig_MetaDesc,$mosConfig_MetaKeys;
global $SB_Active,$SB_SEF_Active;
    
    if($SB_Active!=1 && $SB_SEF_Active!=1)
	{
        return;
    }
        
    if(strlen($SBZ_PTITLE)){
       $strTitle = $SBZ_PTITLE;  
    }else{
       $strTitle = $mosConfig_sitename;  
    }
    if(strlen($SBZ_MKEYWORDS)){
       $strKeyw = $SBZ_MKEYWORDS;  
    }else{
       $strKeyw = $mosConfig_MetaKeys;  
    }
    if(strlen($SBZ_MDESC)){
       $strDesc = $SBZ_MDESC;  
    }else{
       $strDesc = $mosConfig_MetaDesc;  
    }
   
    $objbook = new SerrBizSEFSocialBookmark();    
    
    if($objbook->LoadBookmarks('loadParam'))
    {
        $objbook->LoadBookmarks('showicons');
        if(isset($objbook->arrSiteInfo) && count($objbook->arrSiteInfo)>0)
        {  
            $fpath = $mosConfig_live_site.'/modules/mod_serrbizsef_bookmark/';
?>
            <link rel="stylesheet" href="<?php echo $fpath?>css/floating-window.css" media="screen" type="text/css">
            <script type="text/javascript" src="<?php echo $fpath?>js/ajax.js"></script>
            <script type="text/javascript" src="<?php echo $fpath?>js/floating-window.js"></script>
              <div id="book_detail" class="book_detail">
                    <b>Suggested Bookmark title, description and tags:</b><br>
                    <b>Title:</b>&nbsp;<?php echo $strTitle?><br>
                    <b>Description:&nbsp;</b><?php echo $strDesc?><br>
                    <b>Tags:</b>&nbsp;<?php echo $strKeyw?>
                    <br><br>
                    <?php foreach($objbook->arrSiteInfo as $key=>$book) { ?>
                        <a href="<?php echo $book['link']?>" target="_blank"><img src="<?php echo $book['icon']?>" border=0 title="<?php echo $book['tooltip']?>"></a>&nbsp;
                    <?php
                        }
                    ?>                     
              </div>
              <div id=CloseDiv style='display:none;'>
                    <p align="right"><a href="javascript:MyhideWindow();" class="bookmark_close">Close</a></p>
              </div>                
            <div class="bookmark_container">        
                <a href="javascript:void(0);" id="bookmark_link" onclick="fnShowBookContainer(event,'<?php echo $objbook->window_position?>','<?php echo $fpath; ?>');" ><img src="modules/mod_serrbizsef_bookmark/images/bookmark.png" id="bookimg" border="0"></a>
            </div>                                    
<?php
        }
    }
?>                        