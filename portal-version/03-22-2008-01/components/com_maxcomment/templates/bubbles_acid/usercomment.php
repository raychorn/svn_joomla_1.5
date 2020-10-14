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
	
	//start loop
	for ($i=0, $n=count($rowUserComments); $i < $n; $i++) {
	
		$COMMENT = $rowUserComments[$i];		

		// for alternate color ------
		$linecolor = ($line % 2) + 1;				
		// --------------------------
						
?>		<div id="<?php _getAnchor() ?>">
		<a name="<?php _getAnchor() ?>"></a>
		<div id="commentbubble">
			<div id="commentheader"><p>
				<span class="commentnumber"><?php echo ($i+1+$limitstart) . ".  " ?></span>
				<?php _getDateComment() ?></p>
			</div>
			<div id="commentbody<?php echo $linecolor; ?>">
				<?php if ( $mxc_ratinguser ) { ?>
				<div id="commentrating"><?php _getUserRating() ?></div>
				<?php } ?>
				<?php if ( $mxc_displaytitle ) { ?>
				<div id="commenttitle"><?php _getTitleComment() ?></div>
				<?php } ?>
				<div id="commenttext">
				<table>
					<tr>
						<td>
						<?php if ( $mxc_ShowAvatarCBProfile || $mxc_use_gravatar ) { ?>
						<div class="avatar"><?php _getAuthorAvatar() ?></div>
						<?php } ?>
						<?php _getCommentText()?>
						</td>
					</tr>
				</table>
				</div>				
				<?php if ( $mxc_showIp || $mxc_showstatus ){ ?>
				<div id="commentusertype"><?php if ( $mxc_showstatus ){ ?><?php _getStatusUserComment() ?><?php } ?><?php if ( $mxc_showIp ){ ?>, <?php echo _MXC_TPL_IP ?>: <?php _getIpComment() ?><?php } ?></div>
				<?php } ?>
				<?php if ( $mxc_report ) { ?>
				<div id="commentreport">&raquo;&nbsp;<?php _getReportComment() ?></div>
				<?php } ?>
				<?php if ( $mxc_reply ) { ?>
				<div id="commentreply">&raquo;&nbsp;<?php _getReplyComment() ?></div>
				<?php } ?>
				<?php if ( _getCountAllReplies() ){ ?>
				<div id="commentseeallreplies">&raquo;&nbsp;<?php _getSeeAllReplies() ?></div>
				<?php } ?>
		    </div>
			<div id="commentfooter<?php echo $linecolor; ?>">
				<?php _getAuthorComment() ?>
			</div>		 
		</div>
		</div>
<?php 
		$line++; // use for alternate color
	} // end for	
?>