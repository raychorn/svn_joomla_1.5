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
if (file_exists($mosConfig_absolute_path."/components/com_maxcomment/templates/bubbles_acid/languages/".$mosConfig_lang.".php")){
	include_once($mosConfig_absolute_path."/components/com_maxcomment/templates/bubbles_acid/languages/".$mosConfig_lang.".php");
}else{
	include_once($mosConfig_absolute_path."/components/com_maxcomment/templates/bubbles_acid/languages/english.php");
}

?>
<link href="<?php echo $mosConfig_live_site;?>/components/com_maxcomment/templates/bubbles_acid/css/bubbles_acid_css.css" rel="stylesheet" type="text/css" />
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
			  <?php if ( $_MXC->KEYWORDS ) { ?>
				<tr>
				  <td><p class="keywords_title"><?php echo _MXC_TPL_KEYWORDS ?> : <span class="keywords"><?php echo $_MXC->KEYWORDS ?></span></p></td>
				</tr>
			  <?php } ?>			  
            </table>			
			  <?php echo $_MXC->CONTENT ?>
			  <?php if ( $_MXC->LASTUPDATE ) { ?>
			  <p class="small"><?php echo _MXC_TPL_LAST_UPDATE ?> : <?php echo $_MXC->LASTUPDATE ; ?></p>
			  <?php } ?>
			</td>
          </tr>
        </table>	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	  <td>
		<table border="0" cellspacing="6" cellpadding="0">
		  <tr>
		    <?php if ( $_MXC->EDITORCOMMENT ) { ?>
			<td><?php echo $_MXC->EDITORCOMMENT ?></td>
			<?php } ?>
			
			<?php if ( $_MXC->USERCOMMENTS ) { ?>
			<td><?php echo $_MXC->USERCOMMENTS ?></td>
			<?php } ?>
			
			<?php if ( $_MXC->QUOTETHIS ) { ?>
			<td><?php echo $_MXC->QUOTETHIS ?></td>
			<?php } ?>
			
			<?php if ( $_MXC->FAVOURED ) { ?>
			<td><?php echo $_MXC->FAVOURED ?></td>
			<?php } ?>
			
			<?php if ( $_MXC->PRINT ) { ?>
			<td><?php echo $_MXC->PRINT ?></td>
			<?php } ?>
			
			<?php if ( $_MXC->SEND ) { ?>
			<td><?php echo $_MXC->SEND ?></td>
			<?php } ?>
			
			<?php if ( $_MXC->DELICIOUS ) { ?>
			<td><?php echo $_MXC->DELICIOUS ?></td>
			<?php } ?>
			
			<?php if ( $_MXC->RELATEDARTICLES ) { ?>
			<td><?php echo $_MXC->RELATEDARTICLES ?></td>
			<?php } ?>
			
			<?php if ( $_MXC->READMORE ) { ?>
			<td><?php echo $_MXC->READMORE ?></td>
			<?php } ?>			
			
		  </tr>
	  </table>
		</td>
	</tr>
	</table>
	</td>
  </tr>
</table>
</div>
