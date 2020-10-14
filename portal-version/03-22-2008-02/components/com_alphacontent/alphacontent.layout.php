<?php
/*********************************************
* alphacontent - Mambo/Joomla! Component     *
* Copyright (C) 2005-2008 by Bernard Gilly   *
* Homepage   : www.visualclinic.fr           *
* Version    : 3.0                           *
* License    : DonationWare                  *
* 			 : All Rights Reserved           *
*********************************************/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/* 
vars available for layout

$num      		  : num listing
$title    		  : title of item
$icon_new  		  : icon new
$icon_hot  		  : icon hot
$section_category : section / category
$author   		  : author or alias author if defined in item
$content  		  : content intro
$date     		  : date created
$hits     		  : num hits
$comments 		  : num of comments
$rating   		  : rating bar (native Joomla/Mambo)
$print    		  : link to print
$pdf       		  : link to pdf
$emailthis 		  : link to email this
$readmore  		  : readmore link if exist
$ratingbar        : ajax rating bar integrated in AlphaContent
$googlemaps       : link to Google Maps Location

Miscelleanous 
-------------
If you need adding something, you can use also this 2 vars :
$id_article		  : id of item article
$link_to_article  : link to item

Notes
-----
$rating is disabled if you use ajax rating bar integrated in AlphaContent ($ratingbar)

*/
?>
<div id="title<?php echo $num; ?>">
<?php if ( $num ) { ?><span class="small" style="display:inline;"><?php echo $num; ?>. </span><?php } ?>
<?php if ( $title ) { ?><span style="display:inline;font-size:14px;"><?php echo $title; ?></span><?php } ?>
<?php if ( $icon_new || $icon_hot ) { ?><span style="display:inline;"><?php echo " " . $icon_new . " " . $icon_hot ; ?></span><?php } ?>
</div>
<?php if ( $section_category ) { ?>
	<div class="small"><?php echo $section_category; ?></div>
<?php } ?>
<?php if ( $author ) { ?>
	<div class="small">
	<?php echo  _ALPHACONTENT_AUTHOR . " : " . $author; ?>
	</div>
<?php } ?>
<?php if ( $ratingbar ) echo $ratingbar;  ?>
<?php if ( $content ) { ?>
	<div id="content<?php echo $num; ?>"><?php	echo $content; ?></div>
<?php } ?>
<div id="features<?php echo $num; ?>">
<?php if ( $date ) { ?><span class="small"><?php echo $date; ?></span><?php } ?>
<?php if ( $hits ) { ?> | <span class="small"><?php $labelHit = ( $hits>1 )? _ALPHACONTENT_HITS : _ALPHACONTENT_HIT; echo $hits . " " . $labelHit; ?></span><?php } ?>
<?php if ( $comments ) { ?> | <span class="small"><?php $labelComment = ( $comments>1 )? _ALPHACONTENT_COMMENTS : _ALPHACONTENT_COMMENT; echo $comments . " " . "<a href=\"" . sefRelToAbs( $link_to_article ) . "\">" . $labelComment . "</a>" ; ?></span><?php } ?>
<?php if ( $rating ) { ?> | <span class="small"><?php echo $rating; ?></span><?php } ?>
<?php if ( $print ) { ?> | <span class="small"><?php echo $print; ?></span><?php } ?>
<?php if ( $pdf ) { ?> | <span class="small"><?php echo $pdf; ?></span><?php } ?>
<?php if ( $emailthis ) { ?> | <span class="small"><?php echo $emailthis; ?></span><?php } ?>
<?php if ( $readmore ) { ?> | <span class="small"><?php echo $readmore; ?></span><?php } ?>
<?php if ( $googlemaps ) { ?> | <span class="small"><?php echo $googlemaps; ?></span><?php } ?>
</div>