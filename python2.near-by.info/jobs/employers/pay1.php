<?

include_once "accesscontrol.php";
if($action=="")
{
$q1 = "select * from job_plan";
$r1 = mysql_query($q1) or die(mysql_error());


?>


<body bgcolor="#00FF00">


<table align=center width=446 bgcolor="#FFFFFF">

<tr>
	<td colspan=2>
	To access all the features we offer, choose your Employer Plan:<br>

	</td>
</tr>

<?
while($a1 = mysql_fetch_array($r1))
{
	if($a1[price] > 0)
	{
	echo "
	<tr>
	<td>
	<b>$a1[PlanName]</b>
	<ul>
	<li>Valid for $a1[numdays] days; </li>
<li>$a1[postings] job postings; </li>
<li>$a1[reviews] resume reviews; </li>
	<li><b>price: <font color=#000000>$ $a1[price] </font</b></li>
	</ul>
	</td>

	<td>
<form action='$PHP_SELF?action=$active_account' method=post style='background:none;'>
<input type=submit name=paypal value='Continue'>
<input type=\"hidden\" name=\"plan_name\" value=\"$a1[PlanName]\">
<input type=\"hidden\" name=\"action\" value=\"$active_account\">
</form>
   </td>
</tr>";
	}

	else
	{
	echo "
	<tr>
	<td>
	<b>$a1[PlanName]</b>
	<ul>
	<li>Valid for $a1[numdays] days; </li>
<li>$a1[postings] job postings; </li>
<li>$a1[reviews] resume reviews; </li>
	<li><b>price: <font color=#000000>$ $a1[price] </font</b></li>
	</ul>
	</td>

	<td>
	<form action=pay2.php method=post style='background:none;'>
	<input type=hidden name=item_name value=\"$a1[PlanName]\">
	<input type=hidden name=numdays value=\"$a1[numdays]\">
	<input type=hidden name=price value=\"$a1[price]\">
	<input type=submit value=\"Get if free\">
	</form>
	</td>";
	}
	
}

?>

</table>
<?    
}

if($action=='pp')
{
  $time=time();
 
$q1 = "select * from job_plan where PlanName='$plan_name'";
 $r1 = mysql_query($q1) or die(mysql_error());
 $a1 = mysql_fetch_array($r1);




 
print <<<HTML

<center>
<table width=446>
  <tr><td align=center>&nbsp;</td></tr>
   <tr><td align=center>&nbsp;</td></tr>
    <tr><td align=center>&nbsp;</td></tr>
 <tr><td align=center>&nbsp;</td></tr>
 <tr><td align=center><b>Click Here To Pay</b></td></tr>

<tr><td align=center>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="background:#FFFFFF">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="$paypal_email_address">
<input type="hidden" name="item_name" value="$a1[PlanName]">
<input type="hidden" name="item_number" value="$ename">
<input type="hidden" name="amount" value="$a1[price]">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="return" value="http://$_SERVER[HTTP_HOST]/employers/pay22.php?plan=$a1[PlanName]&price=$a1[price]&epayname=$ename&act=success">
<input type="hidden" name="cancel_return" value="http://$_SERVER[HTTP_HOST]/employers/cancel.php">


<input type="image" src="http://$_SERVER[HTTP_HOST]/images/x-click-but01.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
</td></tr></table>
</body>
</html>
HTML;
}elseif($action=="tc")
{
  $time=time();
 
$q1 = "select * from job_plan where PlanName='$plan_name'";
 $r1 = mysql_query($q1) or die(mysql_error());
 $a1 = mysql_fetch_array($r1);




$crt_id=substr(md5($ename),0,12);
$_SESSION["crt_id"]=$crt_id;
print <<<HTML

<center>
<table width=446>
  <tr><td align=center>&nbsp;</td></tr>
   <tr><td align=center>&nbsp;</td></tr>
    <tr><td align=center>&nbsp;</td></tr>
 <tr><td align=center>&nbsp;</td></tr>
 <tr><td align=center><b>Click Here To Pay</b></td></tr>

<tr><td align=center>

<form action="https://www2.2checkout.com/2co/buyer/purchase" method="post" style="background:none">
<input type="hidden" name="cart_order_id" value="$crt_id" />
<input type="hidden" name="PlanName" value="$a1[PlanName]" />
<input type="hidden" value="$vendor_id" name="sid" />
<input type="hidden" name="total" value="$a1[price]" />
<input type="hidden" name="id_type" value="1" />
<input type="hidden" name="c_prod" value="$a1[PlanName],1" />
<input type="hidden" name="c_name" value="$a1[PlanName]" />
<input type="hidden" name="c_description" value="$a1[PlanName]" />
<input type="hidden" name="c_price" value="$a1[price]" />
<input type="hidden" name="x_Receipt_Link_URL" value="http://$_SERVER[HTTP_HOST]/employers/thanks.php">
<input type="hidden" name="return_url" value="http://$_SERVER[HTTP_HOST]/employers/cancel.php">
<input type="image" src="http://$_SERVER[HTTP_HOST]/images/2checkout.gif" name="submit" alt="Make payments with 2Checkout - it's fast,free and secure!">
</form>

</td></tr></table>
</body>
</html>
HTML;
}elseif($action=="pptc")
{
  $time=time();
 
$q1 = "select * from job_plan where PlanName='$plan_name'";
 $r1 = mysql_query($q1) or die(mysql_error());
 $a1 = mysql_fetch_array($r1);




$crt_id=substr(md5($ename),0,12);
$_SESSION["crt_id"]=$crt_id;
print <<<HTML

<center>
<table width=446>
  <tr><td align=center>&nbsp;</td></tr>
   <tr><td align=center>&nbsp;</td></tr>
    <tr><td align=center>&nbsp;</td></tr>
 <tr><td align=center>&nbsp;</td></tr>
 <tr><td align=center><b>Click Here To Pay</b></td></tr>

<tr><td align=center>

<form action="https://www2.2checkout.com/2co/buyer/purchase" method="post" style="background:none">
<input type="hidden" name="cart_order_id" value="$crt_id" />
<input type="hidden" name="PlanName" value="$a1[PlanName]" />
<input type="hidden" value="$vendor_id" name="sid" />
<input type="hidden" name="total" value="$a1[price]" />
<input type="hidden" name="id_type" value="1" />
<input type="hidden" name="c_prod" value="$a1[PlanName],1" />
<input type="hidden" name="c_name" value="$a1[PlanName]" />
<input type="hidden" name="c_description" value="$a1[PlanName]" />
<input type="hidden" name="c_price" value="$a1[price]" />
<input type="hidden" name="x_Receipt_Link_URL" value="http://$_SERVER[HTTP_HOST]/employers/thanks.php">
<input type="hidden" name="return_url" value="http://$_SERVER[HTTP_HOST]/employers/cancel.php">
<input type="image" src="http://$_SERVER[HTTP_HOST]/images/2checkout.gif" name="submit" alt="Make payments with 2Checkout - it's fast,free and secure!">
</form>

</td></tr></table>
</body>
</html>
HTML;





  $time=time();
 
$q1 = "select * from job_plan where PlanName='$plan_name'";
 $r1 = mysql_query($q1) or die(mysql_error());
 $a1 = mysql_fetch_array($r1);




 
print <<<HTML

<center>
<table width=446>
  <tr><td align=center>&nbsp;</td></tr>
   <tr><td align=center>&nbsp;</td></tr>
    <tr><td align=center>&nbsp;</td></tr>
 <tr><td align=center>&nbsp;</td></tr>
 <tr><td align=center><b>Click Here To Pay</b></td></tr>

<tr><td align=center>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="background:#FFFFFF">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="$paypal_email_address">
<input type="hidden" name="item_name" value="$a1[PlanName]">
<input type="hidden" name="item_number" value="$ename">
<input type="hidden" name="amount" value="$a1[price]">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="return" value="http://$_SERVER[HTTP_HOST]/employers/pay22.php?plan=$a1[PlanName]&price=$a1[price]&epayname=$ename&act=success">
<input type="hidden" name="cancel_return" value="http://$_SERVER[HTTP_HOST]/employers/cancel.php">


<input type="image" src="http://$_SERVER[HTTP_HOST]/images/x-click-but01.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
</td></tr></table>
</body>
</html>
HTML;



}

include_once('../foother.html');
?>