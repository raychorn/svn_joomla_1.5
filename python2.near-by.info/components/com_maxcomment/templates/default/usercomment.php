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


	if (!isset($limitstart)) $limitstart=0;

	$line=1; // use for alternate color
	global $COMMENT;
	
	?>
	<link href="<?php echo $mosConfig_live_site;?>/components/com_maxcomment/templates/default/css/default_css.css" rel="stylesheet" type="text/css" />	
	<?php
	
	//start loop
	for ($i=0, $n=count($rowUserComments); $i < $n; $i++) {
	
		$COMMENT = $rowUserComments[$i];				
		
		// for alternate color ------
		$linecolor = ($line % 2) + 1;				
		// --------------------------
		?>		
		<div id="<?php echo _getAnchor() ?>">
		<!-- <a name="maxcommentXXXX"></a> REQUIRED : USED BY MXCOMMENT -->
		<a name="<?php echo _getAnchor() ?>"></a>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="commenttableentry<?php echo $linecolor ?>">
		<?php if ( $mxc_ratinguser ) { ?>
		  <tr>
			<td height="24"><?php _getUserRating() ?></td>
		  </tr>
		  <tr>
		 <?php } ?>
			<td class="mxcdefault_posted"><?php echo _MXC_TPL_POSTED_BY ?> <?php _getAuthorComment() ?>, <?php echo _MXC_TPL_ON ?> <?php _getDateComment() ?>, <?php if ( $mxc_showIp ){ ?><?php echo _MXC_TPL_IP ?> <?php echo _getIpComment() ?><?php } ?><?php if ( $mxc_showstatus ){ ?>, <?php _getStatusUserComment() ?><?php } ?></td>
		  </tr>
		  <?php if ( $mxc_displaytitle ) { ?>
		  <tr>
			<td class="mxcdefault_title"><?php echo ($i+1+$limitstart) . ".  " ?><?php _getTitleComment() ?></td>
		  </tr>
		  <?php } ?>
		  <tr>
			<td class="mxcdefault_comment">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  <tr>
			  	<td>
				<?php if ( $mxc_ShowAvatarCBProfile || $mxc_use_gravatar ) { ?>
				<div class="avatar"><?php _getAuthorAvatar() ?></div>
				<?php } ?>
				<?php _getCommentText()?>
				</td>
			  </tr>
			</table>
			</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <?php if ( $mxc_report ) { ?>
		  <tr>
			<td class="mxcdefault_report">&#187;&nbsp;<?php _getReportComment() ?></td>
		  </tr>
		  <?php } ?>
		  <?php if ( $mxc_reply ) { ?>
		  <tr>
			<td class="mxcdefault_reply">&#187;&nbsp;<?php _getReplyComment() ?></td>
		  </tr>
		  <?php } ?>
		  <?php if ( _getCountAllReplies() ) { ?>
		  <tr>
			<td class="mxcdefault_seeallreplies">&#187;&nbsp;<?php _getSeeAllReplies() ?></td>
		  </tr>
		  <?php } ?>
		</table>
		<br />
		</div>
		<?php 
		$line++; // use for alternate color		
	} // end for
?>