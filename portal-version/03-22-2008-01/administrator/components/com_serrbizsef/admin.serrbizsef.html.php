<?php
/**
* @version $Id: admin.serrbizsef.html.php 2007-10-19 11:19:30 facedancer $
* @package Joomla
* @subpackage SerrBizSEF
* @copyright Copyright (C) Serr.biz. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* SerrBizSEF is a released under the terms of the GNU General Public License;
* Warranty : This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
* FITNESS FOR A PARTICULAR PURPOSE. 
* @desc This class HTML_sb used for dispaly administrator GUI
* @author Serr.biz
* @version 1.0 Complete
*/
defined( '_VALID_MOS' ) or die( 'Restricted access' );
/**
* includes 
*/
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');
global $mainframe;
require_once($mosConfig_absolute_path."/administrator/components/com_serrbizsef/admin.serrbizsef.class.php");
?>
<style type="text/css" title="ddd">
        .config_panel {
            background:url(./components/com_serrbizsef/images/header-configuration-bk.jpg) no-repeat scroll left center;
        }
</style>
<?php

	/**
	* @desc Validate the URL supplied
	* @param string $url , boolean $absolute
	* @return boolean
	*/
	function validateURL($url, $absolute = TRUE) 
	{
	  $allowed_characters = '[a-z0-9\/:_\-_\.\?\$,;~=#&%\+]';
	  if ($absolute) 
	  {
		return preg_match("/^(http|https|ftp):\/\/". $allowed_characters ."+$/i", $url);
	  }
	  else 
	  {
		return preg_match("/^". $allowed_characters ."+$/i", $url);
	  }
	}

    function TestSbf($fun)
	{
	   $newObj = new HTML_sb();
	   if($fun==1)
	     $newObj->addSpecialUrlHTML();
	   if($fun==2)
	     $newObj->sbDisplaySpecialSefList(12);
	}

class HTML_sb 
{
    /**
     * @access private
     * @var boolean 
     */
	 var $checked_out;

   /**
    * @desc Function addSpecialUrlHTML - Display HTML to add redirect URL  
    * @access public
    */
   function addSpecialUrlHTML()
   {
      ?>
<table cellspacing="0"  cellpadding="0"  >
  <tr valign="top">
    <td align="left" width="51"><table width="500"  cellpadding="0" cellspacing="0" >
        <tr>
          <td><TABLE cellpadding="0" cellspacing="0" width="100%">
              <TR>
                <TD colspan="2" align="center" nowrap="nowrap"><!--<strong>Add Special SEF</strong> --></TD>
                <TD align="left" nowrap="nowrap"><span style="color:#FF0000; font-weight:bold; font-size:10px;">*</span>
                  <samll>indicates required fields</samll></TD>
              </TR>
			 <!-- 
			  <tr>
			    <td>Select Target</td>
			    <td colspan="2">
				  <select name="sef_type">
				    <option></option>
				    <option></option>
				  </select>
				</td>
			  </tr>-->
         <!-- <TR>
                <TD width="24%" nowrap="nowrap">Select Target </TD>
                <TD width="38%"><input type="radio" name="sef_type" id="sef_type1" checked="checked" value="1"   onChange="javascript:if(document.adminForm.sef_type[0].checked){document.getElementById('add-notice').style.visibility='hidden';}">
                  <label for="sef_type1">Add Special SEF</label></TD>
                <TD width="38%"><input type="radio" name="sef_type" id="sef_type2" value="2" onChange="javascript:if(document.adminForm.sef_type[1].checked){document.getElementById('add-notice').style.visibility='visible';}">
                  <label for="sef_type2" >Add 301 Redirect</label></TD>
              </TR>-->
              <TR>
                <TD width="24%" nowrap="nowrap">&nbsp;</TD>
                <TD colspan="2">&nbsp;</TD>
              </TR>
              <TR>
                <TD width="24%" nowrap="nowrap">Old URL<span style="color:#FF0000; font-weight:bold; font-size:10px;">*</span></TD>
                <TD colspan="2"><input type="text" size="55" name="internal_url" style="width:300px;" ></TD>
              </TR>
              <TR>
                <TD height="29" nowrap="nowrap" >Select Redirect Target <!--<span style="color:#FF0000; font-weight:bold; font-size:10px;">*</span>--></TD>
                <TD colspan="2">
				<?php
			        $sbDisplay = new sbAdmin();
           			$DataRows = $sbDisplay->sbGetSEFURL(0);
				?>
				 <select name="select_redirect" onchange="javascript:if(document.adminForm.select_redirect.value!=-1) { document.adminForm.redirect_to_url.value=document.adminForm.select_redirect.value;} else { document.adminForm.redirect_to_url.value='';} ">
				    <option value="-1" >Select Redirect Target...</option>
					<?php
			            if(is_array($DataRows) && count($DataRows)>0)
						{
		                   foreach($DataRows as $Row)
						   {
				    			if(trim($Row['raw_sef'])=='')
								  continue;
								echo '<option value="'.$Row['raw_sef'].'" title="'.$Row['raw_sef'].'">'.$Row['raw_sef'].'</option>';
						   }//foreach($DataRows as $Row)
						}
					?>
				 </select>
				</TD>
              </TR>
              <TR>
                <TD height="29" nowrap="nowrap">Redirect Target<span style="color:#FF0000; font-weight:bold; font-size:10px;">*</span></TD>
                <TD colspan="2"><input type="text" style="width:300px;"  size="55" name="redirect_to_url" ></TD>
              </TR>
              <TR>
                <TD width="24%" nowrap="nowrap">&nbsp;</TD>
                <TD colspan="2">&nbsp;</TD>
              </TR>
  <tr>
    <td style="" colspan="3"><div style="color:#FF0000; font-weight:200; visibility:hidden" id="add-notice"><!--Redirect To URL" should be a valid URL i.e. http://google.com or http://www.google.com <br> It should be in format google.com or www.google.com--></div></td>
  </tr>

            </table></td>
        </tr>
      </table></td>
  </tr>
  
</table>

<?php   

   }
      /**
      * @desc Function sbDisplaySpecialSefList - Display List of redirect URL
      * @access public
      * @param integer $sef_url_type 
      */
    function sbDisplaySpecialSefList($sef_url_type=0) 
    {
        global $CHARSET, $mosConfig_live_site, $mainframe, $mosConfig_absolute_path, $database;   
        //create obj
        $sbDisplay = new sbAdmin();
            //get search controls. 
?>
<!-- SEARCH ENDS -->
<style type="text/css">
            <!--
            .hidden
            {
              color:#f0f0f0;
            }
            -->
            </style>

<?php
  if(isset($_REQUEST['task']) && ( $_REQUEST['task']=='special_sef' || $_REQUEST['task']=='remove_special' || $_REQUEST['task']=='save_special_sef' || $_REQUEST['task']=='add_special_sef')  )
    //$backGroundUrl = "background:url(./components/com_serrbizsef/images/header-redirects-manage.jpg);";
	$backGroundUrl='';
  else	
    $backGroundUrl = "background:url(./components/com_serrbizsef/images/header-SEFURLS-bk.jpg);";

?>

<table class="adminlist" border="1">
  <TR>
    <TH><?php echo '#';  ?></TH>
    <TH width="1%"><input type="checkbox" name="toggle" value=""  onclick="checkAll(100);" /></TH>
    <!-- <TH width="7%" align="center">Link Priority</TH> -->
    <TH width="45%">Old URL</TH>
    <TH>Redirect To URL</TH>
    <TH width="10%" align="center">Sef Type</TH>
  </TR>
  <style type="text/css" title="ddd">
                table.url td {
                    border-bottom:0px none #E5E5E5;
                    padding: 2px 4px 2px 0px;
                }
                .url {
                    border: 1px solid #DFDFDF;
                    padding: 0px 0px 0px 8px;
                }
                table.ttl td {
                    padding: 0px 0px 0px 0px;
                }
                .ttl {
                    padding: 0px 0px 0px 0px;
                }
            </style>
  <?php

            unset($html_controls);
            $DataRows = $sbDisplay->sbGetSEFURL($sef_url_type); 
            if(is_array($DataRows) && count($DataRows)>0)
            {
               $x = 1; 
               $i = 1;
               $k=0;
               foreach($DataRows as $Row)
               {
                   $x = $x - 1;
        ?>
  <tr class="<?php echo "row$x"; ?>">
    <td align="center"><?php echo $i; ?></td>
    <td align="center"><?php echo $Row['chk_box'];?></td>


    <td align="left">&nbsp;&nbsp; <a title="<?php echo $Row['raw_original'];?>" href="<?php echo $mosConfig_live_site;?>/administrator/index2.php?option=com_serrbizsef&cmb_component=<?php echo mosGetParam($_REQUEST,'cmb_component')?>&task=edit&id=<?php echo $Row['id']; ?>"><?php echo $Row['joom_original'];?></a> </td>
	<td align="left">&nbsp;&nbsp; 
	
	<?php if( validateURL($Row['sb_sef'], TRUE) ) { ?><a href="<?php echo $Row['raw_sef']; ?>" title="<?php echo $Row['raw_sef']?>" target="_blank"><?php $Row['raw_sef'];?></a> 
	<?php } else { 
	    
	    if($Row['raw_sef'][0]!='/')
		   $urlLink = $mosConfig_live_site.'/'.$Row['raw_sef'];
		else
		   $urlLink = $mosConfig_live_site.$Row['raw_sef'];
		   
	?>
	   <a href="<?php echo $urlLink;?>" title="<?php echo $urlLink; ?>" target="_blank"><?php echo $Row['sb_sef']; ?></a> 
	<?php } ?>
	
	</td>
    <Td width="10%" align="center"><?php echo "<img src='components/com_serrbizsef/images/icons-16x16-R.jpg' border=0/>"; ?>
    </Td>
  </tr>
  <?php     
                $x = $x + 1;
                $i++;
                $k++;
               }//foreach                
            }            
        ?>

<tr>
  <td colspan="5" align="center" width="100%" style="padding:0px;">
  <?php
        if(is_array($DataRows) && count($DataRows)>0) 
		{
            print $sbDisplay->getNavigation();
        }
        unset($sbDisplay);    
  ?>
  </td>
</tr>

</table>
<?php

	}//end of fnc

    /**
     * @desc Function sbDisplayPageList - Display List of URL generatedf by SerrBizSEF
     * @access public
     * @param integer $sef_url_type 
     */
    function sbDisplayPageList($sef_url_type=0) 
    {
		$sef_url_type=0;
        global $CHARSET, $mosConfig_live_site, $mainframe, $mosConfig_absolute_path, $database;   
        //create obj
        $sbDisplay = new sbAdmin();
            //get search controls. 
        
		if($sef_url_type==0)//display the search box iff URL is created by SerrBisSEF  i.e. its not 301 redirect
		 {
            $html_controls = $sbDisplay->sbGetSearch();                
		?>
		<table width="100%" align="center" border="0" cellpadding="4">
		  <TR>
			<TD align="right" width="50%"> Select component : </b>&nbsp;
			  <?php echo $html_controls['cmb_components']; ?>
			  &nbsp;&nbsp;
			  Search SEF &nbsp;
			  <?php echo $html_controls['cmb_search']; ?>
			  &nbsp;
			  <?php echo $html_controls['input_search']; ?>
			</TD>
		  </TR>
		  <TR>
			<TD align="right" width="50%"><?php echo $html_controls['cmb_settings']; ?>
			</TD>
		  </TR>
		</table>
		<?php } ?>
<!-- SEARCH ENDS -->
<style type="text/css">
            <!--
            .hidden
            {
              color:#f0f0f0;
            }
            -->
            </style>

<?php
    $backGroundUrl = "background:url(./components/com_serrbizsef/images/header-SEFURLS-bk.jpg);";
?>

<table class="adminheading" border="0" style="<?php echo $backGroundUrl; ?>background-repeat: no-repeat;" >
<?php if($sef_url_type<1)  { ?>
  <TR>
    <TD height="58"></TD>
  </TR>
<?php } ?>  
</table>

<table class="adminlist" border="1">
  <TR>
    <TH><?php echo '#';  ?></TH>
    <TH width="1%"><input type="checkbox" name="toggle" value=""  onclick="checkAll(100);" /></TH>
    <!-- <TH width="7%" align="center">Link Priority</TH> -->
    <?php if($sef_url_type==0) { ?>
    <TH>Component</TH>
    <TH>Non SEF URL</TH>
    <TH>SEF URL</TH>
    <TH>Set Link</TH>
    <TH width="3%" align="center">Index</TH>
    <TH width="3%" align="center">Follow</TH>
    <?php }?>
  </TR>
  <style type="text/css" title="ddd">
                table.url td {
                    border-bottom:0px none #E5E5E5;
                    padding: 2px 4px 2px 0px;
                }
                .url {
                    border: 1px solid #DFDFDF;
                    padding: 0px 0px 0px 8px;
                }
                table.ttl td {
                    padding: 0px 0px 0px 0px;
                }
                .ttl {
                    padding: 0px 0px 0px 0px;
                }
            </style>
  <?php

            unset($html_controls);
            $DataRows = $sbDisplay->sbGetSEFURL($sef_url_type); 
            if(is_array($DataRows) && count($DataRows)>0)
            {
               $x = 1; 
               $i = 1;
               $k=0;
               foreach($DataRows as $Row)
               {
                   $x = $x - 1;
        ?>
  <tr class="<?php echo "row$x"; ?>">
    <td align="center"><?php echo $i;?></td>
    <td align="center"><?php echo $Row['chk_box'];?></td>
    <?php if($sef_url_type==0) { ?>
    <td align="left">&nbsp;&nbsp;<?php echo $Row['component']; ?></td>
    <td align="left">&nbsp;&nbsp; <a title="<?php echo $Row['raw_original'];?>" href="<?php echo $mosConfig_live_site;?>/administrator/index2.php?option=com_serrbizsef&cmb_component=<?php echo mosGetParam($_REQUEST,'cmb_component')?>&task=edit&id=<?php echo $Row['id']; ?>"><?php echo $Row['joom_original']; ?></a> </td>
	<td align="left">&nbsp;&nbsp; <a href="<?php echo $mosConfig_live_site.$Row['raw_sef']?>" title="<?php echo $mosConfig_live_site.$Row['raw_sef'];?>" target="_blank"><?php echo $Row['sb_sef'];?></a> </td>
    <td align="center"><?php
                        $count = $sbDisplay->sbCheckSameSEF($Row['raw_sef'],$Row['id']);
                        if($count>0){
                    ?>
      <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $k;?>','set_link')" title= "Set new internal link of this SEF"><img src='components/com_serrbizsef/images/sbz_info.png' border=0/></a>
      <?php }else{
                            print "--";
                        }
                    ?>
    </td>
    <td align="center">&nbsp;&nbsp;
      <?php $arrIndex = $sbDisplay->IndexStatus($Row['index']);?>
      <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $k;?>','<?php echo $arrIndex['task']?>')" title="<?php $arrIndex['act'];?>"><img src='components/com_serrbizsef/images/<?php echo $arrIndex['img'];?>' border=0/></a> </td>
    <td align="center">&nbsp;&nbsp;
      <?php $arrIndex = $sbDisplay->FollowStatus($Row['follow']);?>
      <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $k;?>','<?php $arrIndex['task']; ?>')" title="<?php $arrIndex['act']; ?>"><img src='components/com_serrbizsef/images/<?php echo $arrIndex['img'];?>' border=0/></a> </td>
    <?php } ?>
  </tr>
  <?php     
                $x = $x + 1;
                $i++;
                $k++;
               }//foreach                
            }            
        ?>
</table>
<?php
        if(is_array($DataRows) && count($DataRows)>0) {
            print $sbDisplay->getNavigation();
        }
        unset($sbDisplay);    
	}//end of fnc

	  /**
	  * @desc Function sbEditPage - Display HTML to edit URL with all the options
	  * @access public
	  * @param integer $sef_id 
	  */
    function sbEditPage($sef_id)
    {
        $sbDisplay = new sbAdmin();
        $sbDisplay->sbLoadDetails($sef_id);
		//echo "<pre>";
		//print_r($sbDisplay);
		//echo "</pre>";
		
    ?>
	<input type="hidden" name="id" value="<?php echo $sef_id;?>">
	<input type="hidden" value="<?php echo mosGetParam($_REQUEST,'cmb_component'); ?>" name="cmb_component">
	<input type="hidden" value="<?php echo $sbDisplay->sef_type; ?>" name="sef_type">
	<table class="adminheading">
	  <tr>
		<th class="config2">&nbsp;Edit SEF ::<?php echo $sbDisplay->component;?>:: </th>
	  </tr>
	</table>
	<table cellspacing="5"  class="adminform">
	  <tr valign="top">
		<td align="center"><table border="0">
			<tr>
			  <td><b><a href="index2.php?option=com_serrbizsef&task=config">Use SerrBizSEF Meta Info</a></b> must be active to override Joomla's default meta details. </td>
			</tr>
		  </table></td>
	  </tr>
	  <tr valign="top">
  
  <td width="60%" align="left" valign="top"><table border="0">
      <tr>
        <td align="left"> URL: <b>
          <?php echo $sbDisplay->joom_original;?>
          </b> </td>
      </tr>
      <tr>
        <td align="left"> SerrBiz SEF URL:
          <input class="inputbox" name="sef_url" type="text" value="<?php echo $sbDisplay->sb_sef; ?>" size="80">
        </td>
      </tr>
    </table></td>
  <td width="40%" align="left" valign="top">
  
  <?php
                        
						if($sbDisplay->sef_type==0 )//show robot info iff $sbDisplay->sef_type==0 i.e if its a redirect URL
						{
						$tab = new mosTabs(1);
                        $tab->startPane('mostab');
                        $tab->startTab('Settings', 'tab-prop');
                ?>
  <table border="0">
    <TR>
      <TD width="10%" nowrap="nowrap">Robot Index:</TD>
      <TD><?php echo $sbDisplay->arrSettings['cmb_rbIndex'];?></TD>
    </TR>
    <TR>
      <TD width="10%" nowrap="nowrap">Robot Follow:</TD>
      <TD><?php echo $sbDisplay->arrSettings['cmb_rbFollow'];?></TD>
    </TR>
  </table>
  <?php } ?>
  </td>
  
  </tr>
  <?php if($sbDisplay->sef_type==0 ) { //show META SETTINGS  info iff $sbDisplay->sef_type==0 i.e if its a redirect URL?>
  <tr valign="top">
    <td valign="top" colspan="2"><table border="0">
        <tr>
          <th>HTML Title</th>
          <th>Meta Description</th>
          <th>Meta Keywords</th>
        </tr>
        <tr>
          <td><textarea class="text_area" name="page_title" cols="40" rows="5" id="ptitle"><?php echo $sbDisplay->mPTitle?></textarea></td>
          <td><textarea class="text_area" name="meta_desc" cols="40" rows="5" id="mdesc"><?php echo $sbDisplay->mDesc?></textarea></td>
          <td><textarea class="text_area" name="meta_key" cols="40" rows="5" id="mkey"><?php echo $sbDisplay->mKeyword?></textarea></td>
        </tr>
        <tr>
          <td><input onclick="GetSuggestion('ptitle','hdSTitle')" align="middle" type="button" value="<?php echo "Suggest" ?>" class="button" />
            <input onclick="Cleanup('ptitle');" align="middle" type="button" value="<?php echo "Clean up" ?>" class="button" />
            <input type="hidden" value="<?php echo $sbDisplay->sPTitle?>" id="hdSTitle">
          </td>
          <td><input onclick="GetSuggestion('mdesc','hdSDesc')" align="middle" type="button" value="<?php echo "Suggest" ?>" class="button" />
            <input onclick="Cleanup('mdesc');" align="middle" type="button" value="<?php echo "Clean up" ?>" class="button" />
            <input type="hidden" value="<?php echo $sbDisplay->sDesc?>" id="hdSDesc">
          </td>
          <td><input onclick="GetSuggestion('mkey','hdSKey')" align="middle" type="button" value="<?php echo "Suggest" ?>" class="button" />
            <input onclick="Cleanup('mkey');" align="middle" type="button" value="<?php echo "Clean up" ?>" class="button" />
            <input type="hidden" value="<?php echo $sbDisplay->sKeyword?>" id="hdSKey">
            <input type="hidden" value="<?php echo $sbDisplay->sbz_id?>" name="CID">
          </td>
        </tr>
      </table></td>
  </tr>
  <?php } ?>
</table>
<script>
         function Cleanup(id)
         {
             document.getElementById(id).value = '';
         }

         function GetOriginal(id,hid,strParam)
         {
            var strVal =  document.getElementById(hid).value;
            if(strVal == '')
            {
               //alert('No value saved for '+strParam+' yet. !!');
            }else{
                document.getElementById(id).value = document.getElementById(hid).value;   
            }                    
         }
         function GetSuggestion(id,hid)
         {
             document.getElementById(id).value = document.getElementById(hid).value;
         }
        </script>
<?php   
        unset($sbDisplay);     
    }

  /**
  * @desc Function sbCheckDuplicate - Check  whether URL already Exist in table
  * @access public
  * @param integer $id 
  * @return integer 0 || 1 || 2 
  */
    function sbCheckDuplicate($id)
    {
       return 0;       
       // ignore following process 
       if(!$id || $id < 0) return 1;
       $return  = sbAdmin::sbCheckDuplicate($id);
       if($return == 1)
       {
    ?>
<script>
            alert('SEF with this name already exists. Duplicate SEF not allowed.!!!');
        </script>
<?php   
         return $return;       
       }elseif($return == 2)
       {
     ?>
<script>
            alert('Blank SEF not allowed.!!!');
        </script>
<?php      
        return $return;
       }else{
           return 0;
       }
    }

	  /**
	  * @desc Function sbSavePage - Save URL in Database
	  * @access public
	  * @param integer $id 
	  */
    function sbSavePage($id)   
    {
        sbAdmin::sbUpdateSEF($id);        
    }
	
	  /**
	  * @desc Function sbGetSingleRecord - Fetch a row SerrBizSEF URL in Object
	  * @access public
	  * @param integer $id 
	  * @return object $singleSefInfo
	  */
    function sbGetSingleRecord($id)   
    {
        $singleSefInfo = sbAdmin::sbGetSingleRecord($id);
		return $singleSefInfo;
    }

	  /**
	  * @desc Function sbSaveSettings - Saves SerrBizSEF confuguration Setting in databse
	  * @access public
	  * @param integer $id 
	  */
    function sbSaveSettings($id)
    {
        sbAdmin::UpdateSettings($id);
    } 
	
	  /**
	  * @desc Function sbSpecialSEFConfiguration - Shows tab for manage and redirect add URL
	  * @access public
	  */
    function sbSpecialSEFConfiguration()
    {
        $sbDisplay = new sbAdmin(); 
        $sbDisplay->sbGetConfig();

		$tabClass  = "cls_spe_manage";
		if(isset($_REQUEST['task']) && $_REQUEST['task']=='add_special_sef' )
		$tabClass  = "cls_spe_add";
    ?>
	<style type="text/css">
	  .cls_spe_manage
	  {
		  background-image:url(./components/com_serrbizsef/images/header-redirects-manage.jpg);
		  background-repeat:no-repeat;
	  }
	  .cls_spe_add
	  {
		  background-image:url(./components/com_serrbizsef/images/header-redirets-add.jpg);
		  background-repeat:no-repeat;
	  }
	</style>	
	<table cellspacing="0"  cellpadding="0" id="config-tab-type" align="left">
	  <tr>
		<td height="62"></td>
	  </tr>
	  <tr valign="top">
		<td style="text-align:left">
		<table cellpadding="0" cellspacing="0" id="qw" style="width:1000px" align="left">
			<tr>
			  <td>
			  <?php
					$tab = new mosTabs(0);
					$tab->startPane('mostab');
						$tab->startTab('Redirect SEFs','tab-prop-list');
						 	HTML_sb::sbDisplaySpecialSefList(12);
						$tab->endTab();
						
						$tab->startTab('Add', 'tab-prop-list-2');
						 	HTML_sb::addSpecialUrlHTML();
						$tab->endTab(); 
					$tab->endPane();
			  ?>
				  <script>
					function changeBgImg()
					{
					  var backImage = new Array();
					  backImage[0] = "url(./components/com_serrbizsef/images/header-redirects-manage.jpg);";
					  backImage[1] = "url(./components/com_serrbizsef/images/header-redirets-add.jpg);";
					  if(tabPane1.selectedIndex==0)
					  {
						 document.getElementById('config-tab-type').className= 'cls_spe_manage';
					  }	 
					  else if(tabPane1.selectedIndex==1)
					  {
						 document.getElementById('config-tab-type').className= 'cls_spe_add';
					  }	 
					} 
					  changeBgImg();
					  if(document.getElementById('mostab')!=null)
					  {
						document.getElementById('mostab').onclick = changeBgImg;
					  }
				  </script>
			  </td>
			</tr>
		  </table>
		  </td>
	  </tr>
	</table>
<?php  
        unset($sbDisplay);   
    }
	
	  /**
	  * @desc Function sbConfiguration - Displays SerrBizSEF configuration panel
	  * @access public
	  */
    function sbConfiguration()
    {
        $sbDisplay = new sbAdmin(); 
        $sbDisplay->sbGetConfig();

		$MYstatus = ""; 
		$MNstatus = "checked";    
		
		$SBYstatus= ""; 
		$SBNstatus= "checked";   
		
		$SEFYstatus="";  
		$SEFNstatus="checked";    
		
		$SEFY301 = "";
		$SEFN301 = "checked";    


        if($sbDisplay->isMetaInfoActive == 1) 
		{
            $MYstatus = "checked"; 
            $MNstatus = "";    
        }
        $SBNstatus = "checked";
        if($sbDisplay->isSBActive == 1) 
		{
            $SBYstatus = "checked"; 
            $SBNstatus = "";   
        }
        $SEFNstatus = "checked";  
        if($sbDisplay->isSEFActive == 1) 
		{
            $SEFYstatus = "checked";  
            $SEFNstatus = "";    
        }
        $SEFN301 = "checked";
        if($sbDisplay->isRedirectActive == 1) 
		{
            $SEFY301 = "checked";  
            $SEFN301 = "";    
        }             
    ?>
<table cellspacing="0"  cellpadding="0" class="adminheading" style="background:url(./components/com_serrbizsef/images/header-configuration-bk.jpg); background-repeat: no-repeat;" >
  <!-- <th valign="top" class="config_panel">
                <th nowrap="nowrap" class="config2">&nbsp;SerrBizSEF Configuration </th>
        </th> -->
  <tr>
    <td height="62"></td>
  </tr>
  <tr valign="top">
    <td align="left" width="51"><table width="509"  cellpadding="0" cellspacing="0" >
        <tr>
          <td><?php
                        $tab = new mosTabs(1);
                        $tab->startPane('mostab');
                        $tab->startTab('Settings', 'tab-settinf');
                        ?>
            <TABLE class="adminform" cellpadding="0" cellspacing="0" width="100%">
              <TR>
                <TD width="20%" nowrap="nowrap">Activate SerrBizSEF:</TD>
                <TD><input name="rdActive" type="radio" class="inputbox" <?php echo $SBYstatus?> value="1">
                  Yes
                  &nbsp;
                  <input name="rdActive" type="radio" <?php echo $SBNstatus?> class="inputbox" value="0">
                  No </TD>
              </TR>
              <TR>
                <TD width="20%" nowrap="nowrap">Use SerrBizSEF Meta Info:</TD>
                <TD><input name="rdMetaInfo" type="radio" <?php echo $MYstatus?> class="inputbox" value="1">
                  Yes
                  &nbsp;
                  <input name="rdMetaInfo" <?php echo $MNstatus?> type="radio" class="inputbox" value="0">
                  No </TD>
              </TR>
              <TR>
                <TD width="20%" nowrap="nowrap">Activate SEF:</TD>
                <TD><input name="rdSEFInfo" type="radio" <?php echo $SEFYstatus?> class="inputbox" value="1">
                  Yes
                  &nbsp;
                  <input name="rdSEFInfo" type="radio" <?php echo $SEFNstatus?> class="inputbox" value="0">
                  No </TD>
              </TR>
              <TR>
                <TD width="20%" nowrap="nowrap">Allow 301 Redirect:</TD>
                <TD><input name="rdSEF301" type="radio" <?php echo $SEFY301?> class="inputbox" value="1">
                  Yes
                  &nbsp;
                  <input name="rdSEF301" type="radio" <?php echo $SEFN301?> class="inputbox" value="0">
                  No </TD>
              </TR>
              <TR>
                <TD width="20%" nowrap="nowrap">Custom Error Page:</TD>
                <TD><input name="txtCustom" class="inputbox" value="<?php echo $sbDisplay->strCustomError?>" maxlength="150" size="50">
                </TD>
              </TR>
            </table>
            <?php
                            $tab->endTab(); 
                            $tab->startTab('Components','tab-Components');
                            $Records = $sbDisplay->sbExtraComponents();
                         ?>
            <TABLE class="adminform">
              <TR>
                <Th colspan="5">Supported 3rd Party components</Th>
              </TR>
              <TR>
                <TD width="5%">#</TD>
                <TD width="25%">Component Name</TD>
                <TD width="25%">Default Name</TD>
                <TD width="25%">Your Name</TD>
                <TD width="20%">Use</TD>
              </TR>
              <?php
                             if(is_array($Records) && count($Records) > 0) { 
                                $k = 1;  
								$i=1;
                                foreach($Records as $key=>$Data)   
                                { 
                                    $i++;
                                    $k = $k-1;
                          ?>
              <TR class="<?php echo "row$k"; ?>">
                <TD width="5%"><?php echo $i?></TD>
                <TD width="25%"><?php echo $Data['com_name']?></TD>
                <TD width="25%"><?php echo $Data['default_name']?></TD>
                <TD width="25%"><?php if(isset($Data['user_value'])) { echo $Data['user_value']; } ?></TD>
                <TD width="20%"><?php echo $Data['status']?></TD>
              </TR>
              <?php
                                    //$k=$k+1;
                                }///form
                             } //if
                          ?>
            </TABLE>
            <table>
              <tr>
                <td colspan="5"><a href="http://www.serr.biz/contact.html" target="_blank" style="font-size:12px;color:red;">If you use a 3rd party component that is not listed above, please contact Serr.biz to have a custom rule created.</a></td>
              </TR>
            </table>
            <?php $tab->endTab(); ?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<?php  
        unset($sbDisplay);   
    }

	  /**
	  * @desc Function sbSaveConfig - updates SerrBizSEF confuguration 
	  * @access public
	  */
    function sbSaveConfig()
    {
       sbAdmin::sbUpdateConfig(); 
    }

	  /**
	  * @desc Function sbSaveSpecialSefURL - saves Redirect URLs in database
	  * @access public
	  * @param integer $id 
	  */
    function sbSaveSpecialSefURL()
    {
       sbAdmin::sbSaveSpecialSefURL(); 
    }

	  /**
	  * @desc Function sbDeletePage - Deletes SerrBizSEF URLs from database
	  * @access public
	  */
    function sbDeletePage($sef)
    {
        if(is_array($sef) && count($sef)>0) 
		{
           sbAdmin::sbDeleteSEF($sef);
        }
		else
		{
           return;            
        }
    }
    
	  /**
	  * @desc Function sbSetNewLink - Displays the HTML to change the Link of SEFURL To internal URL
	  * @access public
	  * @param integer $id 
	  */
    function sbSetNewLink($sef_id)
    {
        $sbDisplay = new sbAdmin();
        $sbDisplay->sbLoadDetails($sef_id);
    ?>
<input type="hidden" name="id" value="<?php echo $sef_id?>">
<input type="hidden" name="sb_sef" value="<?php echo $sbDisplay->sb_sef?>">
<input type="hidden" value="<?php echo mosGetParam($_REQUEST,'cmb_component')?>" name="cmb_component">
<INPUT type="hidden" name="search_text" value="<?php echo mosGetParam($_REQUEST,'search_text')?>">
<table class="adminheading">
  <tr>
    <th class="config2">&nbsp;Set New Internal URL</th>
  </tr>
</table>
<table cellspacing="5" class="adminform">
  <tr>
    <th class="edit" colspan="2"> Select one URL from list if you wish to change the current internal URL of this SEF.</th>
  </tr>
  <tr valign="top" class="row0">
    <td align="left" width="18%">Current Internal URL: </td>
    <td align="left"><?php echo $sbDisplay->joom_original?></td>
  </tr>
  <tr class="row0">
    <td align="left"> SerrBiz SEF URL: </td>
    <td align="left"><?php echo $sbDisplay->sb_sef?></td>
  </tr>
</table>
<table class="adminlist" border="1" width="60%">
  <TR align="left">
    <Td colspan="2">Following are other internal URLs having same SEF as above</Td>
  </TR>
  <?php
                $list = $sbDisplay->sbGetLinks($sef_id,$sbDisplay->sb_sef);
                if($list == "") {
                   print "<b>There are no other internal URLs for this SEF</b>";
                }else{
                   print $list;    
                }   
            ?>
  </TR>
  
</table>
<?php   
        unset($sbDisplay);     
    }

	  /**
	  * @desc Function sbSaveNewLink - change the Link of SEFURL To internal URL
	  * @access public
	  * @param integer $id 
	  */
    function sbSaveNewLink()
    {
       sbAdmin::sbSaveNewLink(); 
    }

	  /**
	  * @desc Function sbDisplayImportList - Displays the list of imported URLs from OpenSEF
	  * @access public
	  * @param integer $id 
	  */
    function sbDisplayImportList() 
    {
        global $CHARSET, $mosConfig_live_site, $mainframe, $mosConfig_absolute_path, $database;   
        $sbDisplay = new sbAdmin();
    ?>
<table border="0" class="adminheading" style="background:url(./components/com_serrbizsef/images/header-OpenSEF-bk.jpg); background-repeat: no-repeat;" >
  <tr>
    <td height="60"></td>
  </tr>
</table>
<style type="text/css">
            <!--
            .hidden
            {
              color:#f0f0f0;
            }
            -->
            </style>
<table class="adminlist" border="1" >
  <TR>
    <TH><?php echo '#';  ?></TH>
    <TH width="1%"><input type="checkbox" name="toggle" value=""  onclick="checkAll(100);" /></TH>
    <TH>Component</TH>
    <TH>Non SEF URL</TH>
    <TH>OpenSEF URL</TH>
    <TH>Status</TH>
  </TR>
  <style type="text/css" title="ddd">
                table.url td {
                    border-bottom:0px none #E5E5E5;
                    padding: 2px 4px 2px 0px;
                }
                .url {
                    border: 1px solid #DFDFDF;
                    padding: 0px 0px 0px 8px;
                }
                table.ttl td {
                    padding: 0px 0px 0px 0px;
                }
                .ttl {
                    padding: 0px 0px 0px 0px;
                }
            </style>
  <?php


            unset($html_controls);
            $DataRows = $sbDisplay->sbGetImportSEF(); 
            if(is_array($DataRows) && count($DataRows)>0)
            {
               $x = 1; 
               $i = 1;
               $k=0;
               foreach($DataRows as $Row)
               {
                   $x = $x - 1;
        ?>
  <tr class="<?php echo "row$x"; ?>">
    <td align="center"><?php echo $i;?>
    </td>
    <td align="center"><?php echo $Row['chk_box'];?>
    </td>
    <td align="left">&nbsp;&nbsp;
      <?php echo $Row['component'];?>
    </td>
    <td align="left">&nbsp;&nbsp;
      <?php echo $Row['raw_original'];?>
    </td>
    <td align="left">&nbsp;&nbsp; <a href="<?php echo $mosConfig_live_site.$Row['raw_sef']?>" title="<?php echo $mosConfig_live_site.$Row['raw_sef']?>" target="_blank">
      <?php echo $Row['sb_sef']?>
      </a> </td>
    <td align="center">&nbsp;&nbsp;
      <?php $arrIndex = $sbDisplay->ImportSEFStatus($Row['priority']);?>
      <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $k?>','<?php echo $arrIndex['task']?>')" title="<?php echo $arrIndex['act']?>"><img src='components/com_serrbizsef/images/<?php echo $arrIndex['img']?>' border=0/></a> </td>
  </tr>
  <?php     
                $x = $x + 1;
                $i++;
                $k++;
               }//foreach                
            }else{            
        ?>
  <TR>
    <Td colspan="6" align="center" style="font-size:12px;"> Serr.biz is currently working on an import function for OpenSEF users. Sign up to be notified when it's launched. <a href="http://www.serr.biz/contact.html" target="_blank">Sign up now</a> </Td>
  </TR>
  <?php }  ?>
</table>
<?php
        if(is_array($DataRows) && count($DataRows)>0) {
            print $sbDisplay->getNavigation();
        }
        unset($sbDisplay);    
    }//end of fnc    
    
	  /**
	  * @desc Function sbAddSpecialSef - Displays the HTML to Add Special SEF
	  * @access public
	  * @param integer $special_sef_type 
	  */
    function sbAddSpecialSef($special_sef_type)
    {
        $sbDisplay = new sbAdmin();
        $sbDisplay->sbLoadDetails($sef_id);
    ?>
<input type="hidden" name="id" value="<?php echo $sef_id?>">
<input type="hidden" value="<?php echo mosGetParam($_REQUEST,'cmb_component')?>" name="cmb_component">
<table class="adminheading">
  <tr>
    <th class="config2">&nbsp;Edit SEF ::
      <?php echo $sbDisplay->component?>
      :: </th>
  </tr>
</table>
<table cellspacing="5"  class="adminform">
  <tr valign="top">
    <td align="center"><table border="0">
        <tr>
          <td><b><a href="index2.php?option=com_serrbizsef&task=config">Use SerrBizSEF Meta Info</a></b> must be active to override Joomla's default meta details. </td>
        </tr>
      </table></td>
  </tr>
  <tr valign="top">
  
  <td width="60%" align="left" valign="top"><table border="0">
      <tr>
        <td align="left"> URL: <b>
          <?php echo $sbDisplay->joom_original?>
          </b> </td>
      </tr>
      <tr>
        <td align="left"> SerrBiz SEF URL:
          <input class="inputbox" name="sef_url" type="text" value="<?php echo $sbDisplay->sb_sef?>" size="80">
        </td>
      </tr>
    </table></td>
  <td width="40%" align="left" valign="top">
  
  <?php
                        $tab = new mosTabs(1);
                        $tab->startPane('mostab');
                        $tab->startTab('Settings', 'tab-prop');
                ?>
  <table border="0">
    <TR>
      <TD width="10%" nowrap="nowrap">Robot Index:</TD>
      <TD><?php echo $sbDisplay->arrSettings['cmb_rbIndex']?></TD>
    </TR>
    <TR>
      <TD width="10%" nowrap="nowrap">Robot Follow:</TD>
      <TD><?php echo $sbDisplay->arrSettings['cmb_rbFollow']?></TD>
    </TR>
  </table>
  </td>
  
  </tr>
  
  <tr valign="top">
    <td valign="top" colspan="2"><table border="0">
        <tr>
          <th>HTML Title</th>
          <th>Meta Description</th>
          <th>Meta Keywords</th>
        </tr>
        <tr>
          <td><textarea class="text_area" name="page_title" cols="40" rows="5" id="ptitle"><?php echo $sbDisplay->mPTitle?>
</textarea></td>
          <td><textarea class="text_area" name="meta_desc" cols="40" rows="5" id="mdesc"><?php echo $sbDisplay->mDesc?>
</textarea></td>
          <td><textarea class="text_area" name="meta_key" cols="40" rows="5" id="mkey"><?php echo $sbDisplay->mKeyword?>
</textarea></td>
        </tr>
        <tr>
          <td><input onclick="GetSuggestion('ptitle','hdSTitle')" align="middle" type="button" value="<?php echo "Suggest" ?>" class="button" />
            <input onclick="Cleanup('ptitle');" align="middle" type="button" value="<?php echo "Clean up" ?>" class="button" />
            <input type="hidden" value="<?php echo $sbDisplay->sPTitle?>" id="hdSTitle">
          </td>
          <td><input onclick="GetSuggestion('mdesc','hdSDesc')" align="middle" type="button" value="<?php echo "Suggest" ?>" class="button" />
            <input onclick="Cleanup('mdesc');" align="middle" type="button" value="<?php echo "Clean up" ?>" class="button" />
            <input type="hidden" value="<?php echo $sbDisplay->sDesc?>" id="hdSDesc">
          </td>
          <td><input onclick="GetSuggestion('mkey','hdSKey')" align="middle" type="button" value="<?php echo "Suggest" ?>" class="button" />
            <input onclick="Cleanup('mkey');" align="middle" type="button" value="<?php echo "Clean up" ?>" class="button" />
            <input type="hidden" value="<?php echo $sbDisplay->sKeyword?>" id="hdSKey">
            <input type="hidden" value="<?php echo $sbDisplay->sbz_id?>" name="CID">
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<script>
         function Cleanup(id)
         {
             document.getElementById(id).value = '';
         }

         function GetOriginal(id,hid,strParam)
         {
            var strVal =  document.getElementById(hid).value;
            if(strVal == '')
            {
               //alert('No value saved for '+strParam+' yet. !!');
            }else{
                document.getElementById(id).value = document.getElementById(hid).value;   
            }                    
         }
         function GetSuggestion(id,hid)
         {
             document.getElementById(id).value = document.getElementById(hid).value;
         }
        </script>
<?php   
        unset($sbDisplay);     
    }

	  /**
	  * @desc Function sbSetImportSEFInactive - Deactivate Imported SEF
	  * @access public
	  */
    function sbSetImportSEFInactive()
    {
        //create obj
        $sbDisplay = new sbAdmin();
        $sbDisplay->sbInactiveImportSEF();
    }
    
	  /**
	  * @desc Function sbSetImportSEFActive - Activate Imported SEF
	  * @access public
	  */
    function sbSetImportSEFActive()
    {
        //create obj
        $sbDisplay = new sbAdmin();
        $sbDisplay->sbActiveImportSEF();
    }
    

    
} //class HTML_sb 


?>
