<?

include_once "accesscontrol.php";
include_once "navigation2.htm";

if(isset($submit))
{
	if(empty($who))
	{
	echo "<table width=446><tr><td><center><br><br><br> Error.<br> Go <a class=TN href=mail.php> back </a> and make your choice. </center></td></tr></table>";
	include ("../foother.html");
	exit;
	}
	if(empty($message))
	{
	echo "<table width=446><tr><td><center><br><br><br> You are trying to send blank email. <br> Go <a class=TN href=mail.php> back </a> and write some text. </center></td></tr></table>";
	include ("../foother.html");
	exit;
	}
     if($_POST[who] == 'jobseekers')
     {
	$q1 = "select job_seeker_email from job_seeker_info ";
	$r1 = mysql_query($q1) or die(mysql_error());
     }
     elseif($_POST[who] == 'employers')
     {
	$q1 = "select CompanyEmail from job_employer_info ";
	$r1 = mysql_query($q1) or die(mysql_error());
     }

	while($a1 = mysql_fetch_array($r1))
	{
	$from = "From: $email_address";
	mail($a1[0], $subject, $message, $from);
	}
	echo "<table width=446><tr><td><center><br><br><br>The mail was sent successfully. </center></td></tr></table>";
	unset($who);
	include ("../foother.html");
	exit;
}
?>


<br><br><br>
<form action=<?=$PHP_SELF?> method=post style="background:none;">
<table align=center width=446>
<tr>
	<td><b> Send email to all: </b></td>
	<td>
	<select name=who>
		<option value="">Select </option>
		<option value="jobseekers">Jobseekers </option>
		<option value="employers">Employers </option>
	</select>
	</td>
</tr>

<tr>
	<td><b>Subject: </b></td>
	<td><input type=text name=subject></td>
</tr>

<tr>
	<td valign=top><b> Message: </td>
	<td><textarea rows=6 cols=45 name=message></textarea></td>
</tr>

<tr>
	<td colspan=2 align=center>
	<input type=submit name=submit value=Send>
	</td>
</tr>
</table>
</form>
<? include_once('../foother.html'); ?>