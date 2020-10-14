<?
include "conn.php";
if (isset($submit) && !empty($email))
{
$message1 = "$message"." \n\n You can reply to the Employer, by clicking here: \n\n http://<?=$_SERVER[HTTP_HOST]?>/MessageJ.php?Employer=$Employer ";
$from = "From: $email_address";
mail($email, $subject, $message1, $from);
echo "<br><br><br><center><font face=verdana> Your message was send successfull.<br> The jobseeker can not view your email, but can reply to you<br> using our message system. </font><br><br> <a href=javascript:close()> close the window</a></center>";
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
<table align=center width=470>
<tr>
	<td colspan=2><b>Send email</b></td>
</tr>

<tr>
	<td width=200>To: </td>
	<td>";
 if (!empty($email))
 {
 echo "<input type=text name=email value=\"$email\" size=35>";
 }


else
{
 $q1 = "select job_seeker_email from job_seeker_info where uname = \"$Jobseeker\" ";
 $r1 = mysql_query($q1) or die(mysql_error());
 $a1 = mysql_fetch_array($r1);
 $email = $a1[0];
 echo "<input type=text name=email value=\"$email\" size=35>";
}

  echo "</td>
</tr>

<tr>
	<td>Employer's username: </td>
	<td><input type=text name=Employer size=15></td>
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
	<td></td><td><input type=submit value=send name=submit style=\"background-color:white\">
	<input type=reset value=cancel  style=\"background-color:white\"></td>
</tr>
<tr><td colspan=2><font size=1><br>
      * The jobseeker can not view your contact information, but can reply to 
      you using $site_name Message services.<br>
      <br>In this case, we will forward to your email address all the messages from the jobseeker.</td></tr> 
</table>";
}


?>
<? include_once('foother.html'); ?>