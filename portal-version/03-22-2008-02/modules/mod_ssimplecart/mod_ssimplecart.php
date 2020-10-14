<?php
/*
Created using the Mambo Addon Wizard - http://www.PunkSoftware.com
*@ ssimplecart
*@ Package ssimplecart
*@ (C) 2006 Shawn Sandy
*@ Copyright 2006 - Shawn Sandy
*@ version 1.0
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
?>

<?
// Retreive parameters
$cart_image = $params->get( 'cimage', '1' );
$cart_description = $params->get( 'cdesc', '2' );
$cart_price = $params->get( 'cprice', '2' );
$cart_payment = $params->get( 'cpay', '2' );
$cart_longdesc = $params->get( 'clongdesc', '2' );
//$type = strtolower(substr($flv,strrpos($flv,".")));
$type = strtolower(substr($cart_image,strrpos($cart_image,".")));
?>

<!-- "includes/imgsize.php?image=http://extensions.joomla.org/components/com_mtree/img/listings/1335_autocontentbox.jpg" -->
<!--//add code here -->
<!--<a href="http://www.punksoftware.com">Punk Software</a>-->
<style type="text/css">
<!--
.ssimplecart {
	width: 150px;
}
.ssimplecart .cart_img {
	margin: 5px;
	display: block;
	font-size: 12px;
	text-align: left;
}
.ssimplecart .cartdesc {
	font-size: 12px;
	padding: 5px;
	text-align: left;
}
.ssimplecart .cartprice {
	font-size: 14px;
	color: #FF0000;
	text-align: left;
	margin-right: 10px;
}
.ssimplecart .cart_pay {
	text-align: center;
	margin: 5px;
}
-->
</style>

<div class="ssimplecart">
  <div class="cart_img">
  <?php if ($type == '.jpg'){ ?>
    <img src="<?=$mosConfig_live_site?>/modules/imgsize.php?image=<?=$mosConfig_live_site?>/<?=$cart_image?>">
    <?php } else { ?>
     <img src="<?=$mosConfig_live_site?>/<?=$cart_image?>">
<?php } ?>
  </div>

 <div class="cartdesc">Description: <?= $cart_description ?>
  </div>
  <div class="cartprice">Price:<strong> <?= $cart_price ?></strong>
    <?= $cart_payment ?>
  </div>
</p>
  <div id="long_desc">
  
  </div>
</div>
