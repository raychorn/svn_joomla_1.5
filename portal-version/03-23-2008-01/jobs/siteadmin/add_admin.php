<?

include_once "accesscontrol.php";
include_once "navigation2.htm";

if(isset($add))
{

	if(!empty($naid) && !empty($npass) && !empty($nname) && !empty($nemail))
	{
	$q1 = "insert into job_admin_login set aid = \"$naid\", apass = \"$npass\", name = \"$nname\", email = \"$nemail\" ";
	$r1 = mysql_query($q1);
	if (!$r1)
	{
		echo "<table width=446><tr><td><center><br><br><br> The Admin ID is already in use. Go <a class=TN href=add_admin.php>back </a> and try another. </center></td></tr></table>";
		include ("../foother.html");
		exit;
	}
	
		
	
	$to = $nemail;
	$subject = "Your SiteAdmin account";
	$message = "You were added as Site Administrator for $site_name \n\nYour login information is:\n Admin ID: $naid\n AdminPass: $npass\n\n To access the site admin area, go to:\nhttp://$_SERVER[HTTP_HOST]/admin/index.php";
	$from = "From: $email_address";

	mail($to, $subject, $message, $from);

	echo "<table width=446><tr><td><br><br><br><center> $nname was added as Site Administrator. </center></td></tr></table>";
	include("../foother.html");
	exit;
	}
	else
	{
	echo "<center>You miss to fill one or more fields at the registration form.<br> Go <a class=TN htef=add_admin.php> back </a> and fill all the fields.</center>";
	}
}
else
{
?>

<br><br><br>
<center>
<form action=<?=$PHP_SELF?> method=post  style="background:none;">
<table align=center width=446>
<caption align="center">Use this form to add a Site Administrator </caption>
<tr>
	<td>Admin ID </td>
	<td><input type=text name=naid></td>
</tr>

<tr>
	<td>Admin pass </td>
	<td><input type=text name=npass></td>
</tr>

<tr>
	<td>Name </td>
	<td><input type=text name=nname></td>
</tr>

<tr>
	<td>Email </td>
	<td><input type=text name=nemail></td>
</tr>

<tr>
	<td align=center><input type=submit name=add value=Add></td>
	<td align=center><input type=reset></td>
</tr>
</table>
</form>
<?
}
?>
<? include_once('../foother.html'); ?>