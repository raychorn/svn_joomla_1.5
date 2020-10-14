<?
include_once "../main.php";

if(isset($fu))
{
	$q1 = "select epass, CompanyEmail from job_employer_info where ename = \"$_POST[ename]\"";
	$r1 = mysql_query($q1) or die(mysql_error());
	$a1 = mysql_fetch_array($r1);

	if(empty($a1[0]) || empty($a1[1]))
	{
	echo "<table width=446><tr><td><br><br><br><center> There is no registered user with username: <b> $_POST[ename] </b></center></td></tr></table>";
	}
	else
	{
		$to = $a1[CompanyEmail];
		$subject = "Your username/password for $site_name";
		$message = "Hello,\n here is your login information for http://$_SERVER[HTTP_HOST] \n\n Username: $_POST[ename] \n Password: $a1[epass]";
		$from = "From: $email_address";

		mail($to, $subject, $message, $from);
		echo "<table width=446><tr><td><br><br><br><center> Your login information was sent to $to </center></td></tr></table>";
	}
}
elseif(isset($fm))
{

	$q2 = "select ename, epass from job_employer_info where CompanyEmail = \"$_POST[EEmail]\"";
	$r2 = mysql_query($q2) or die(mysql_error());
	$a2 = mysql_fetch_array($r2);

	if(empty($a2[0]) || empty($a2[1]))
	{
	echo "<table width=446><tr><td><br><br><br><center> There is no registered user with email: <b> $_POST[EEmail] </b></center></td></tr></table>";
	}
	else
	{
		$to = $_POST[EEmail];
		$subject = "Your username/password for $site_name";
		$message = "Hello,\n here is your login information for http://$_SERVER[HTTP_HOST] \n\n Username: $a2[ename] \n Password: $a2[epass]";
		$from = "From: $email_address";

		mail($to, $subject, $message, $from);

		echo "<table width=446><tr><td><br><br><br><center> Your login information was sent to $to </center></td></tr></table>";
	}
}
else
{
?>
<br>
<br>

<form action="<?=$PHP_SELF?>" method="post"  style="background:none;">
<table align=center width=446>
<tr>
	  <td>If you remember your username, but have forgot your password enter your 
        username and in a few second will receive your password directly into 
        the email you used at our site registration form.</td>
</tr>

<tr>
	<td>Username: <br> <input type=text name=ename> </td>
</tr>

<tr>
	<td><input type=submit name=fu value=Submit>
</tr>
</table>
</form>

<form action=<?=$PHP_SELF?> method=post  style="background:none;">
<table align=center width=446>
<tr>
	  <td>If you have forgot all your login information (username & password) 
        but still remember the email you used at our site registration form, just 
        enter it into the box and in a few seconds you will receive your login 
        information. </td>
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