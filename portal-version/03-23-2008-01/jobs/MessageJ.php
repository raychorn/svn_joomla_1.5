<?
include "main.php";


if (isset($submit) && !empty($Jobseeker))
{

$q1 = "select CompanyEmail from job_employer_info where ename = \"$Employer\"";
$r1 = mysql_query($q1) or die(mysql_error());
$email = mysql_fetch_array($r1);

$message1 = "$message"." \n\n You can reply to the Jobseeker, by clicking here:\n\n  http://<?=$_SERVER[HTTP_HOST]?>/MessageE.php?Jobseeker=$Jobseeker ";
$from = "From: $email_address";
mail($email, $subject, $message1, $from);
echo "<br><br><br><center> Your message was send successfull.<br> The employer can reply to you using our message system.</center>";
}

else
{
echo "
<html>
<head>
<title>Send email</title>
<style>
a {font-size:11}
body {font-family:verdana}
input {border-color:black}
textarea {border-color:black}
</style>

<form action=$PHP_SELF method=post  style=\"background:none;\">
<table align=center>
<tr>
	<td colspan=2><b>Send message</b></td>
</tr>



<tr>
	<td>Jobseeker's username: </td>
	<td><input type=text name=Jobseeker size=15></td>
</tr>


<tr>
	<td>Subject: </td>
	<td><input type=text name=subject size=35></td>
</tr>

<tr>
	<td valign=top>Message: </td>
	<td><textarea rows=4 cols=30 name=message></textarea></td>
</tr>

<tr>
	<td>
	<input type=hidden name=Employer value=\"$Employer\">
	<input type=submit value=send name=submit style=\"background-color:white\"></td>
	<td align=right><input type=reset value=cancel  style=\"background-color:white\"></td>
</tr>
</table>";
}

?>
<? include_once('foother.html'); ?>