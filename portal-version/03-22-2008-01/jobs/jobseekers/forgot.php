<?
include_once "../main.php";
?>
<h3 align="center">Forgot Password</h3>
<?
if(isset($fu))
{
	$q1 = "select upass, job_seeker_email from job_seeker_info where uname = \"$_POST[uname]\"";
	$r1 = mysql_query($q1) or die(mysql_error());
	$a1 = mysql_fetch_array($r1);
	
	if(empty($a1))
	{
	echo "<table width=446><tr><td><br><br><br><center> There is no registered user with username $uname at our database. <br> <a class=TN href=forgot.php>Try again. </a></center></td></tr></table>";
	include_once('../foother.html');
	exit;
	}
	

$to = $a1[job_seeker_email];
$subject = "Your username/password for $site_name";
$message = "Hello,\n here is your login information for http://$_SERVER[HTTP_HOST] \n\n Username: $_POST[uname] \n Password:  $a1[upass] ";
$from = "From: $email_address";

mail($to, $subject, $message, $from);
echo "<table width=446><tr><td><br><br><br><center> Your login information was sent to $to </center></tr></td></table>";
}
elseif(isset($fm))
{

	$q2 = "select uname, upass from job_seeker_info where job_seeker_email = \"$_POST[SEmail]\"";
	$r2 = mysql_query($q2) or die(mysql_error());
	$a2 = mysql_fetch_array($r2);

	if(empty($a2))
	{
	echo "<table width=446><tr><td><br><br><br><center> There is no registered user with email $SEmail at our database. <br><a class=TN href=forgot.php> Try again. </a></center></td></tr></table>";
	 include_once('../foother.html');
	 exit;
	}


$to = $_POST[SEmail];
$subject = "Your username/password for $site_name";
$message = "Hello,\n here is your login information for http://$_SERVER[HTTP_HOST] \n\n Username: $a2[uname] \n Password:  $a2[upass] ";
$from = "From: $email_address";

mail($to, $subject, $message, $from);

echo "<br><br><br><center> Your login information was sent to $to </center>";
}
else
{
?>


<form action=<?=$PHP_SELF?> method=post  style="background:none;">
<table align=center width=446>
<tr>
	<td>If you remember your username, but have forgot your password enter your username and in a few seconds will receive your password directly into the email you used at our site registration form.</td>
</tr>

<tr>
	<td>Username: <br> <input type=text name=uname> </td>
</tr>

<tr>
	<td><input type=submit name=fu value=Submit>
</tr>
</table>
</form>

<form action=<?=$PHP_SELF?> method=post  style="background:none;">
<table align=center width=446>
<tr>
	<td>If you have forgot all your login information (username & password) but still remember the email you used at our site registration form, just enter it into the box and in a few seconds you will receive your login informstion. </td>
</tr>
<tr>
	<td>Email: <br> <input type=text name=SEmail> </td>
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