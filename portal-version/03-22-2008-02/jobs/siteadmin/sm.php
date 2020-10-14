<?
include "accesscontrol.php";
include "navigation2.htm";

if(isset($submit))
{
$from = "From: $email_address";

mail($email, $subject, $message, $from);

echo "<table width=446><tr><td><br><br><br><center><font face=verdana size=2>The message to $email was send successfully.<br><br></td></tr></table>";
include("../foother.html");
exit;
}

?>

<html>
<head>
<title>Send email to <?=$email?> </title>
</head>
<body><font face=verdana size=2>
<br><br><br><br>
<form method=post style="background:none;">
<table align=center width=400>
<tr>
	<td> <b> To: </b></td>
	<td> <?=$email?> </td>
</tr>

<tr>
	<td><b> Subject: </b></td>
	<td> <input type=text name=subject size=35></td>
</tr>

<tr>
	<td valign=top><b>Message: </b></td>
	<td><textarea name=message rows=6 cols=30></textarea></td>
</tr>
<tr>
	<td align=left>
	<input type=hidden name=email value=<?=$email?>>
	<input type=submit name=submit value=Send></td>
	<td align=right><input type=reset></td>
</tr>
</table>
</form>
</body>
</html>
<? include_once('../foother.html'); ?>