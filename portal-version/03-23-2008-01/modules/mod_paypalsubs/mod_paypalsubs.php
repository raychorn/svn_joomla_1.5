<?php
/*
Created using the Mambo Addon Wizard - http://www.PunkSoftware.com
*@ paypalsubs_mod
*@ Package paypalsubs_mod
*@ (C) 2006 Shawn Sandy
*@ Copyright 2006 - Shawn Sandy
*@ version 1.0
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
?>

<?
// Retreive parameters

$saction = $params->get( 'action', 'https://www.paypal.com/cgi-bin/webscr' );
$business = $params->get( 'business', 'email@mail.com' );
$item_name = $params->get( 'item_name', 'item' );
$currency_code = $params->get( 'currency_code', 'USD' );
$a3_1 = $params->get( 'a3_1', '1' );
$a3_2 = $params->get( 'a3_2', '2' );
$a3_3 = $params->get( 'a3_3', '3' );
$a3_4 = $params->get( 'a3_4', '4' );
$a3_5 = $params->get( 'a3_5', '5' );
$a3_6 = $params->get( 'a3_6', '6' );
$return = $params->get( 'return', 'return' );
$cancel_return = $params->get( 'cancel_return', 'http://www.mysite.com' );
$src = $params->get( 'src', '1' );
$sra = $params->get( 'sra', '1' );
$p3 = $params->get( 'p3', '2' );
$t3 = $params->get( 't3', '2' );
$subnotes= $params->get( 'subnotes', '2' );
$psubimg = $params->get( 'psubmig', '2' );
$rn = $params->get( 'rn', 'http://www.mysite.com' );

?>
<div class="paypalsubs">
  <form action="<? echo $saction ; ?>">
    <input type="hidden" name="cmd" value="_xclick-subscriptions">
    <input type="hidden" name="business" value="<? echo $business ; ?>">
    <input type="hidden" name="item_name" value="<? echo $item_name ; ?>">
    <input type="hidden" name="item_number" value="Donations">
    <input type="hidden" name="no_shipping" value="1">
    <input type="hidden" name="return" value="<? echo $return ; ?>">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="currency_code" value="<? echo $currency_code ; ?>">
    <input type="hidden" name="bn" value="PP-SubscriptionsBF">
    Amount<br />
    <select name="a3" size="1">
      <option value="<? echo $a3_1 ; ?>"><? echo $a3_1 ; ?></option>
      <option value="<? echo $a3_2 ; ?>" selected="selected"><? echo $a3_2 ; ?></option>
      <option value="<? echo $a3_3 ; ?>"><? echo $a3_3 ; ?></option>
      <option value="<? echo $a3_4 ; ?>"><? echo $a3_4 ; ?></option>
      <option value="<? echo $a3_5 ; ?>"><? echo $a3_5 ; ?></option>
      <option value="<? echo $a3_6 ; ?>"><? echo $a3_6 ; ?></option>
    </select>
    <br />
    <input type="hidden" name="p3" value="1">
    <input type="hidden" name="t3" value="M">
    <input type="hidden" name="src" value="1">
    <input type="hidden" name="sra" value="1">
    No Months <br />
    <label>
    <select name="srt" size="1">
      <option value="1">One</option>
      <option value="2">Two</option>
      <option value="3">Three</option>
      <option value="4">Four</option>
      <option value="5">Five</option>
      <option value="6">Six</option>
      <option value="7">Seven</option>
      <option value="8">Eight</option>
      <option value="9">Nine</option>
      <option value="10">Ten</option>
      <option value="11">Eleven</option>
      <option value="12">Twleve</option>
    </select>
    </label>
    <p>
    <input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but20.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
    <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
  </form> <strong><?php echo $subnotes ?></strong>
</div>




