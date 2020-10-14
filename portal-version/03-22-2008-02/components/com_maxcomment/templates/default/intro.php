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
if (file_exists($mosConfig_absolute_path."/components/com_maxcomment/templates/default/languages/".$mosConfig_lang.".php")){
	include_once($mosConfig_absolute_path."/components/com_maxcomment/templates/default/languages/".$mosConfig_lang.".php");
}else{
	include_once($mosConfig_absolute_path."/components/com_maxcomment/templates/default/languages/english.php");
}

?>
<link href="<?php echo $mosConfig_live_site;?>/components/com_maxcomment/templates/default/css/default_css.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="contentpaneopen<?php echo $params->get( 'pageclass_sfx' ); ?>">
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mxcdefault_dotted">
	  <?php if ( $_MXC->AUTHORARTICLE || $_MXC->DATECREATED ) { ?>
      <tr>
        <td><?php if ( $_MXC->AUTHORARTICLE ){ ?><strong><?php echo _MXC_TPL_WRITTEN_BY ?></strong> <?php echo $_MXC->AUTHORARTICLE ?>, <?php } ?><?php if ( $_MXC->DATECREATED ){ ?><?php echo _MXC_TPL_ON ?> <?php echo $_MXC->DATECREATED ?><?php } ?></td>
      </tr>
	  <?php } ?>
	  <?php if ( $_MXC->EDITORRATING ) { ?>
      <tr>
        <td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mxcdefault_clean">
            <tr>
             <td width="32%"><strong><?php echo _MXC_TPL_EDITORS_RATING ?></strong></td>
              <td width="68%"><?php echo $_MXC->EDITORRATING ?></td>
            </tr>
        </table>
		</td>
      </tr>
	  <?php } ?>
	  <?php if ( $_MXC->USERSRATING ) { ?>
      <tr>
        <td>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="mxcdefault_clean">
            <tr>
              <td width="32%"><strong><?php echo _MXC_TPL_AVERAGE_USER_RATING ?></strong></td>
              <td width="68%"><?php echo $_MXC->USERSRATING ?></td>
            </tr>
        </table>
		</td>
      </tr>
	  <?php } ?>
	  <?php if ( $_MXC->HITS ) { ?>
      <tr>
        <td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mxcdefault_clean">
            <tr>
              <td width="32%"><strong><?php echo _MXC_TPL_VIEWS ?></strong></td>
              <td width="68%"><?php echo $_MXC->HITS ?></td>
            </tr>
        </table>
		</td>
      </tr>
	  <?php } ?>
	  <?php if ( $_MXC->COUNTFAVOURED ) { ?>
      <tr>
        <td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mxcdefault_clean">
            <tr>
              <td width="32%"><strong><?php echo _MXC_TPL_FAVOURED ?></strong></td>
              <td width="68%"><?php echo $_MXC->COUNTFAVOURED ?></td>
            </tr>
        </table>
		</td>
      </tr>
	  <?php } ?>
    </table>	
	<?php echo $_MXC->CONTENT ?>
	<?php if ( $_MXC->LASTUPDATE ) { ?>
	<p class="small"><?php echo _MXC_TPL_LAST_UPDATE ?>: <?php echo $_MXC->LASTUPDATE ; ?></p>
	<?php } ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mxcdefault_dotted">
	<?php if ( $_MXC->SECTION || $_MXC->CATEGORY ) { ?>
	<tr>
	  <td><strong><?php echo _MXC_TPL_PUBLISHED_IN ?></strong> : <?php echo $_MXC->SECTION ?>, <?php echo $_MXC->CATEGORY ?></td>
	</tr>
	<?php } ?>
	<?php if ( $_MXC->KEYWORDS ) { ?>
	<tr>
	  <td><strong><?php echo _MXC_TPL_KEYWORDS ?></strong> : <?php echo $_MXC->KEYWORDS ?></td>
	</tr>
	<?php } ?>
	<tr>
	  <td>
	  <div align="left">
		<table border="0" cellspacing="2" cellpadding="5" class="mxcdefault_clean">
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
	</div>
	</td>
	</tr>
	</table>	
	</td>
  </tr>
</table>