<?

include_once "conn.php";



$day = date(d);

$month = date(m);

$year = date(Y);

		

$del = "delete from job_post where EXday = \"$day\" and EXmonth = \"$month\" and EXyear = \"$year\" ";

$rdel = mysql_query($del) or die(mysql_error());
$configuration=mysql_query("Select * from configuration") or die(mysql_error());
$configuration2=mysql_fetch_array($configuration);
$paypal_email_address=$configuration2["paypal_email"];
$vendor_id=$configuration2["vendorid"];
$active_account=$configuration2["active_account"];
$site_name=$configuration2["site_name"];
$email_address=$configuration2["email"];
$site_address=$configuration2["address"];


$_SERVER["HTTP_HOST"] = "$site_address";

?>



<html>
<head>
	<title><?=$site_name?> Jobs</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="stylesheet" href="http://<?=$_SERVER[HTTP_HOST]?>/style.css" type="text/css">

<SCRIPT LANGUAGE="JavaScript">

function popUp(URL) {

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=yes,location=0,statusbar=0,menubar=0,resizable=yes,width=600,height=400,left = 100,top = 50');");

}

</script>

</head>

<body bgcolor="#FFFFFF" style="text-align: center">


<table width="664" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td height="25" colspan="0" valign="top" align="center">
	<? include("header2.php"); ?>
	</td>
	<TABLE WIDTH=550 BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
          <TR> 
          <TD ROWSPAN=2 background="http://<?=$_SERVER[HTTP_HOST]?>/images/body_01.gif">&nbsp;</TD>
          <TD height="325" bgcolor="#ffffff">&nbsp;</TD>
          <TD width="100" valign="top" bgcolor="#ffffff"><? include("left2.php"); ?></TD>
          <TD width="446" valign="top" bgcolor="#ffffff">
