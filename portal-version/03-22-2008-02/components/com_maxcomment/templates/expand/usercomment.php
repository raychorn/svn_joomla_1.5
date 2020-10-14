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
?>
<script language="JavaScript" type="text/JavaScript">
<!--//--><![CDATA[//><!--
function mxctoggleComment(currcmt, prevcmt) {
	if (document.getElementById) {
		thisComment = document.getElementById(currcmt).style;
		thatComment = document.getElementById(prevcmt).style;
		if(thisComment.display == "block") {
			thisComment.display = "none";
			thatComment.display = "block";
		}else {
			thisComment.display = "block";
			thatComment.display = "none";
		}
		return false;
	}else {
		return true;
	}
}
//--><!]]>
</script>
<?php
	if (!isset($limitstart)) $limitstart=0;

	$line=1; // use for alternate color
	global $COMMENT;
	
	//start loop
	for ($i=0, $n=count($rowUserComments); $i < $n; $i++) {
	
		$COMMENT = $rowUserComments[$i];		
				
?>
		<div id="<?php echo _getAnchor() ?>" width="100%">
		<a name="<?php echo _getAnchor() ?>"></a>	
		<div id="usercomment" width="100%">
			<div id="collapsed-comment<?php echo $COMMENT->id ?>" class="usrcomment" width="100%">
				<div class="expand-collapse"><a onMouseOver="this.style.cursor='pointer'" onMouseOut="this.style.cursor='default'" onClick="return mxctoggleComment('expanded-comment<?php echo $COMMENT->id ?>', 'collapsed-comment<?php echo $COMMENT->id ?>')"><?php echo _MXC_TPL_EXPAND_COMMENT ?></a>
				</div>
				<?php if ( $mxc_ratinguser ) { ?>
					<p class="rating"><?php _getUserRating() ?></p>
				<?php } ?>
				<?php if ( $mxc_displaytitle ) { ?>
					<p class="title"><a onMouseOver="this.style.cursor='pointer'" onMouseOut="this.style.cursor='default'" onClick="return mxctoggleComment('expanded-comment<?php echo $COMMENT->id ?>', 'collapsed-comment<?php echo $COMMENT->id ?>')"><?php _getTitleComment() ?></a></p>
				<?php } ?>
				<p class="author"><?php echo _MXC_TPL_WRITTEN_BY ?>: <?php _getAuthorComment() ?> (<?php _getStatusUserComment() ?>) <?php echo _MXC_TPL_ON ?> <?php _getDateComment() ?></p>
			</div>
			<div id="expanded-comment<?php echo $COMMENT->id ?>" class="usrcomment-expand" width="100%">
				<div class="expand-collapse">
				<a onMouseOver="this.style.cursor='pointer'" onMouseOut="this.style.cursor='default'" onClick="return mxctoggleComment('collapsed-comment<?php echo $COMMENT->id ?>', 'expanded-comment<?php echo $COMMENT->id ?>')"><?php echo _MXC_TPL_COLLAPSE_COMMENT ?></a>
				</div>
				<?php if ( $mxc_ratinguser ) { ?>
					<p class="rating"><?php _getUserRating() ?></p>
				<?php } ?>
				<?php if ( $mxc_displaytitle ) { ?>
					<p class="title"><a onMouseOver="this.style.cursor='pointer'" onMouseOut="this.style.cursor='default'" onClick="return mxctoggleComment('expanded-comment<?php echo $COMMENT->id ?>', 'collapsed-comment<?php echo $COMMENT->id ?>')"><?php _getTitleComment() ?></a></p>
				<?php } ?>
				<p class="author"><?php echo _MXC_TPL_WRITTEN_BY ?>: <?php _getAuthorComment() ?> <?php if ( $mxc_showstatus || $mxc_showIp ){ ?>(<?php _getStatusUserComment() ?> <?php if ( $mxc_showIp ){ ?><?php echo _MXC_TPL_IP ?> <?php echo _getIpComment() ?><?php } ?>)<?php } ?> <?php echo _MXC_TPL_ON ?> <?php _getDateComment() ?></p>
				<table><tr><td>
				<p class="comment">
				<?php if ( $mxc_ShowAvatarCBProfile || $mxc_use_gravatar ) { ?>
				<div class="avatar"><?php _getAuthorAvatar() ?></div>
				<?php } ?>
				<?php _getCommentText()?></p>
				</td></tr></table>
				<div id="separat">&nbsp;</div>
				<?php if ( $mxc_report ) { ?>
				<p class="report">&#187;&nbsp;<?php _getReportComment() ?></p>
				<?php } ?>
		  	    <?php if ( $mxc_reply ) { ?>
				<p class="reply">&#187;&nbsp;<?php _getReplyComment() ?></p>
				<?php } ?>
				<?php if ( _getCountAllReplies() ) { ?>
					<p class="seeallreplies">&#187;&nbsp;<?php _getSeeAllReplies() ?></p>
				<?php } ?>
			</div>
		</div>
		</div>
<?php 
	} // end for	
?>
