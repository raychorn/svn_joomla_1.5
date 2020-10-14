<?
include_once "../main.php";

if(isset($fu))
{
	$q1 = "select apass, email from job_admin_login where aid = \"$_POST[adname]\"";
	$r1 = mysql_query($q1) or die(mysql_error());
	$a1 = mysql_fetch_array($r1);

	if(!empty($a1))
	{
	$to = $a1[email];
	$subject = "Your Admin info for $site_name";
	$message = "Hello,\n here is your login information for $_SERVER[HTTP_HOST]\n\n Admin ID: \t $_POST[adname] \n Password: \t $a1[apass]";
	$from = "From: $email_address";

	mail($to, $subject, $message, $from);
	echo "<table align=center width=446><tr><td><br><br><br><center> Your login information was sent to $to </center></td></tr></table>";
	}
	else
	{
		echo "<table align=center width=446><tr><td><br><br><br><center> There is no one registered admin with username $_POST[adname] </center></td></tr></table>";
	}
}
elseif(isset($fm))
{

	$q2 = "select aid, apass from job_admin_login where email = \"$_POST[EEmail]\"";
	$r2 = mysql_query($q2) or die(mysql_error());
	$a2 = mysql_fetch_array($r2);

	if(!empty($a2))
	{
	$to = $_POST[EEmail];
	$subject = "Your username/password for $site_name";
	$message = "Hello,\n here is your login information for $_SERVER[HTTP_HOST] \n\n AdminID:\t $a2[aid] \n Password: \t $a2[apass]";
	$from = "From: $email_address";

	mail($to, $subject, $message, $from);

	echo "<table align=center width=446><tr><td><br><br><br><center> Your login information was sent to $to </center></td></tr></table>";
	}
	else
	{
		echo "<table align=center width=446><tr><td><br><br><br><center> There is no one registered admin with email $_POST[EEmail]</center></td></tr></table>";
	}
}
else
{
?>

<form action=<?=$PHP_SELF?> method=post style="background:none;">
<table align=center width=446>
<tr>
	<td>If you remember your username, but have forgot your password enter your username and in a few second will receive your password directly into the email you used for our site registration.</td>
</tr>

<tr>
	<td>Username: <br> <input type=text name=adname> </td>
</tr>

<tr>
	<td><input type=submit name=fu value=Submit>
</tr>
</table>
</form>

<form action=<?=$PHP_SELF?> method=post style="background:none;">
<table align=center width=446>
<tr>
	<td>If you have forgot all your login information (username & password) but still remember the email you used for our site registration, just enter it into the box and in a few seconds you will receive your login informstion. </td>
</tr>
<tr>
	<td>Email: <br> <input type=text name=EEmail> </td>
</tr>

<tr>
	<td><input type=submit name=fm value=Submit>
</tr>
</table>
</form>

<?
}
?>
<? include_once('../foother.html'); ?>