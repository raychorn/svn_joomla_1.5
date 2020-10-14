<?

include_once "accesscontrol.php";
include_once "navigation2.htm";

if (isset($_POST["sub"]))
{
	$res=mysql_query("UPDATE `configuration` SET `active_account` = '" . $_POST["activeaccnt"] . "', `vendorid` = '" . $_POST["vendorid"] . "', `paypal_email` = '" . $_POST["paypal_email"] . "', `site_name` = '" . $_POST["site_name"] . "' , `email` = '" . $_POST["email"] . "', `address` = '" . $_POST["address"] . "' WHERE `conf_id` =" . $_POST["conf_id"]);
	echo "<br><br><center>Successfully Updated</center><br><br>";
}
else
{
$res=mysql_query("Select * from configuration");
$res2=mysql_fetch_array($res);
?>

 

<form action="<? echo $PHP_SELF;?>" method="post" style="background:none;">
<table width="440" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td width="152" height="21" align="left" valign="middle"><strong>Site Name</strong></td>
    <td width="288" align="left" valign="middle"><input type="text" name="site_name" value="<? echo $res2["site_name"];?>"></td>
  </tr>
  <tr>
    <td height="21" align="left" valign="middle"><strong>Site Address</strong></td>
    <td align="left" valign="middle"><input type="text" name="address" value="<? echo $res2["address"];?>"></td>
  </tr>
  <tr>
    <td height="21" align="left" valign="middle"><strong>Email Address</strong></td>
    <td align="left" valign="middle"><input type="text" name="email" value="<? echo $res2["email"];?>"></td>
  </tr>
  <tr>
    <td height="21" align="left" valign="middle"><strong>Paypal ID</strong></td>
    <td align="left" valign="middle"><input type="text" name="paypal_email" value="<? echo $res2["paypal_email"];?>"></td>
  </tr>
  <tr>
    <td height="21" align="left" valign="middle"><strong>2Checkout Vendor ID</strong></td>
    <td align="left" valign="middle"><input type="text" name="vendorid" value="<? echo $res2["vendorid"];?>"></td>
  </tr>
  <tr>
    <td height="21" align="left" valign="middle"><strong>Active Account</strong></td>
    <td align="left" valign="middle"><select name="activeaccnt">
	  <option value="pptc" <? if ($res2["active_account"]=="pptc") { echo "selected";}?>>Us Both (PayPal & Checkout)</option>
      <option value="pp" <? if ($res2["active_account"]=="pp") { echo "selected";}?>>PayPal</option>
      <option value="tc" <? if ($res2["active_account"]=="tc") { echo "selected";}?>>2CheckOut</option>
    </select></td>
  </tr>
  <tr>
    <td height="21" align="left" valign="middle"><!--DWLayoutEmptyCell-->&nbsp;</td>
    <td align="left" valign="middle"><input type="submit" value="Update" name="sub" style="border-color:black; background-color:#e0e7e9; color:#000000; font-weight:normal">
    <input type="hidden" name="conf_id" value="<? echo $res2["conf_id"];?>"></td>
  </tr>
</table>
</form>			  
<?
}
?>

<? include_once('../foother.html'); ?>