<?php
/*********************************************
* mXcomment - Component                      *
* Copyright (C) 2007-2008 by Bernard Gilly   *
* --------- All Rights Reserved ------------ *      
* Homepage   : www.visualclinic.fr           *
* Version    : 1.0.7                         *
* License    : Creative Commons              *
*********************************************/

// Don't allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// Get the right language if it exists
if (file_exists($mosConfig_absolute_path."/components/com_maxcomment/templates/expand/languages/".$mosConfig_lang.".php")){
	include_once($mosConfig_absolute_path."/components/com_maxcomment/templates/expand/languages/".$mosConfig_lang.".php");
}else{
	include_once($mosConfig_absolute_path."/components/com_maxcomment/templates/expand/languages/english.php");
}

?>
<link href="<?php echo $mosConfig_live_site;?>/components/com_maxcomment/templates/expand/css/expand_css.css" rel="stylesheet" type="text/css" />
<div id="fullarticle">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="contentpaneopen<?php echo $params->get( 'pageclass_sfx' ); ?>">
  <tr>
    <td>
	    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="100%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <?php if ( $_MXC->AUTHORARTICLE || $_MXC->DATECREATED ) { ?>
              <tr>
                <td><?php if ( $_MXC->AUTHORARTICLE ) { ?>
                    <p class="writtenby"><?php echo _MXC_TPL_WRITTEN_BY ?> <?php echo $_MXC->AUTHORARTICLE ?>,
                        <?php } ?>
                        <?php if ( $_MXC->DATECREATED ) { ?>
                        <?php echo _MXC_TPL_ON ?> <?php echo $_MXC->DATECREATED ?></p>
                    <?php } ?></td>
              </tr>
              <?php } ?>
              <?php if ( $_MXC->HITS ) { ?>
              <tr>
                <td><p class="viewshits"><?php echo _MXC_TPL_VIEWS ?> : <?php echo $_MXC->HITS ?></p></td>
              </tr>
              <?php } ?>
              <?php if ( $_MXC->COUNTFAVOURED ) { ?>
              <tr>
                <td><p class="viewsfavoured"><?php echo _MXC_TPL_FAVOURED ?> : <?php echo $_MXC->COUNTFAVOURED ?></p></td>
              </tr>
              <?php } ?>
			  <?php if ( $_MXC->SECTION || $_MXC->CATEGORY ) { ?>
              <tr>
                <td><p class="publishedin_title"><?php echo _MXC_TPL_PUBLISHED_IN ?> : <span class="publishedsection"><?php echo $_MXC->SECTION ?>,</span> <span class="publishedcategory"><?php echo $_MXC->CATEGORY ?></span></p></td>
              </tr>
			  <?php } ?>
            </table>			
			  <?php echo $_MXC->CONTENT ?>
			  <?php if ( $_MXC->LASTUPDATE ) { ?>
			  <p class="small"><?php echo _MXC_TPL_LAST_UPDATE ?> : <?php echo $_MXC->LASTUPDATE ; ?></p>
			  <?php } ?>
			</td>
            <td width="12" align="top" valign="top">&nbsp;&nbsp;&nbsp;</td>
            <td width="82" align="top" valign="top">
			<div align="right">
			<table border="0" align="right" cellpadding="0" cellspacing="5">
			  <?php if ( $_MXC->QUOTETHIS ) { ?>
              <tr>
                <td><?php echo $_MXC->QUOTETHIS ?></td>
              </tr>
			  <?php } ?>
			  
			  <?php if ( $_MXC->FAVOURED ) { ?>
              <tr>
                <td><?php echo $_MXC->FAVOURED ?></td>
              </tr>
			  <?php } ?>
			  
			  <?php if ( $_MXC->PRINT ) { ?>
              <tr>
                <td><?php echo $_MXC->PRINT ?></td>
              </tr>
			  <?php } ?>
			  
			  <?php if ( $_MXC->SEND ) { ?>
              <tr>
                <td><?php echo $_MXC->SEND ?></td>
              </tr>
			  <?php } ?>			  
			  
			  <?php if ( $_MXC->RELATEDARTICLES ) { ?>
              <tr>
                <td><?php echo $_MXC->RELATEDARTICLES ?></td>
              </tr>
			  <?php } ?>
			  
			  <?php if ( $_MXC->DELICIOUS ) { ?>
              <tr>
                <td><?php echo $_MXC->DELICIOUS ?></td>
              </tr>
			  <?php } ?>
			  
            </table>
			</div>
			</td>
          </tr>
        </table>
		
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<?php if ( $_MXC->KEYWORDS ) { ?>
	<tr>
	  <td><p class="keywordstitle"><?php echo _MXC_TPL_KEYWORDS ?> : <span class="keywords"><?php echo $_MXC->KEYWORDS ?></span></p></td>
	</tr>
	<?php } ?>
	</table>
	<?php if ( $_MXC->E_COMMENT ) { ?>
	<br /><a name="editorcomment"></a>
	<div class="contentheading"><?php echo _MXC_TPL_EDITORS_COMMENT ?></div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td height="24"><?php echo $_MXC->EDITORRATING ?></td>
	  </tr>
	  <tr>
		<td><strong><?php echo $_MXC->E_TITLE ?></strong><br />
		<?php echo $_MXC->E_COMMENT ?></td>
	  </tr>
	</table>
	<?php } ?>
	<br />
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="60%"><a name="usercomments"></a><span class="contentheading"><?php echo _MXC_TPL_USERS_COMMENTS ?>&nbsp;&nbsp;<?php echo $_MXC->RSSCOMMENTS ?></span></td>
        <td width="40%">
          <div align="right">&nbsp;</div></td>
      </tr>
      <tr>
        <td><p class="titleAverageRating"><?php echo _MXC_TPL_AVERAGE_USER_RATING ?></p>
          <p class="averageRating"><?php echo $_MXC->USERSRATING ?></p></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	<?php if ( $_MXC->COUNTCOMMENT ) { ?>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<p class="displayXcomment"><?php echo _MXC_TPL_DISPLAY ?> <?php 
		if ( $_MXC->COUNTCOMMENT < $mxc_numcomments ) {
			echo $_MXC->COUNTCOMMENT; 
		} else echo $mxc_numcomments; 		
		?> <?php echo _MXC_TPL_OF ?> <?php echo $_MXC->COUNTCOMMENT ?> <?php echo _MXC_TPL_COMMENTS ?></p>
		</td>
      </tr>
    </table>
	<?php } ?>
	<?php 
	if ( $_MXC->LANGUAGECHOICE ) { 
		echo $_MXC->LANGUAGECHOICE;
	}
	?>	
	<?php require( 'usercomment.php' ); ?>
	
	<?php if ( $_MXC->COUNTCOMMENT ) { ?>
		<p class="displayXcomment"><?php echo _MXC_TPL_DISPLAY ?> <?php 
		if ( $_MXC->COUNTCOMMENT < $mxc_numcomments ) {
			echo $_MXC->COUNTCOMMENT; 
		} else echo $mxc_numcomments; 		
		?> <?php echo _MXC_TPL_OF ?> <?php echo $_MXC->COUNTCOMMENT ?> <?php echo _MXC_TPL_COMMENTS ?></p>
	<?php } ?>
	<?php if ( $_MXC->COMMENTCLOSED==false )  { ?>
		<br /><br />
		<div class="contentheading"><?php echo _MXC_ADDYOURCOMMENT; $_MXC->LINKADDCOMMENT=""; ?></div>					
		<div id="collapsed-addformcomment" class="usrcomment">
			<div class="expand-collapse"><a onMouseOver="this.style.cursor='pointer'" onMouseOut="this.style.cursor='default'" onClick="return mxctoggleComment('expanded-addformcomment', 'collapsed-addformcomment')"><?php echo _MXC_TPL_SHOW_FORM ?></a></div>
			&nbsp;
		</div>		
		<div id="expanded-addformcomment" class="usrcomment-expand">
			<div class="expand-collapse"><a onMouseOver="this.style.cursor='pointer'" onMouseOut="this.style.cursor='default'" onClick="return mxctoggleComment('collapsed-addformcomment', 'expanded-addformcomment')"><?php echo _MXC_TPL_HIDE_FORM ?></a></div>
			<div style="float:none;clear:both;"><?php echo $_MXC->SHOWFORM ?></div>		
	    </div>
	<?php } ?>
	  </td>
  </tr>
</table>
</div>