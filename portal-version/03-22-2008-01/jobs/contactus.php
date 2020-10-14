<?

include_once "main.php";

if(isset($submit))
{
?>
<body bgcolor="#FFFFFF">

<table width="446" bgcolor="#FFFFFF"><tr><td>
<?
	if(!empty($_POST[name]))
	{
		$name1 = strip_tags($_POST[name]);
	}
	else
	{
		echo "<center> You forgot to enter your name.</center>";
	}

	if(!empty($_POST[email]))
	{
		$email1 = strip_tags($_POST[email]);
	}
	else
	{
		echo "<center> You forgot to enter your email.</center>";
	}

	if(!empty($_POST[status]))
	{
		$status1 = $_POST[status];
	}
	else
	{
		echo "<center> You forgot to select your status.</center>";
	}

	if(!empty($_POST[subject]))
	{
		$subject1 = strip_tags($_POST[subject]);
	}
	else
	{
		echo "<center> The subject field is empty.</center>";
	}

	if(!empty($_POST[message]))
	{
		$message1 = strip_tags($_POST[message]);
	}
	else
	{
		echo "<center> You forgot to write the messgae.</center>";
	}

	if(!empty($name1) && !empty($email1) && !empty($status1) && !empty($subject1) && !empty($message1))
	{
		//I use the email for official corespondence
		$to = "$email_address";

		//display the message author and his email
		$from = "From: $name1 <$email1>";

		//this subject will be visible only for you
		$sub = "Contact form message";

		//fit together all the post information into one message
		$message = "$subject1 \n\n"."$message1 \n\n"."$name1\n$status1";

		//if a user has insert some html/javascript/php tags
		//we will remove them for security reasons
		$message = stripslashes($message);

		//now send the message to $email_address
		mail($to, $sub, $message, $from);


		//display "thank you" message. You can edit it and write what you want.
		//if you want to use quotes at this message, use this format:     \"text here\"
		//you can use any html tags
		echo "<br><br><br><center> Thanks for your message. <br>We will contact you as soon as possible.</center>";
		
//		exit();
	}

?>
</td></tr></table>
<?
}


?>

<br><br><br>
<form method=post style="background:none;">
<table align=center width="446" bgcolor="#FFFFFF">
<tr>
	<td colspan=2>Use this form to send us a message</td>
</tr>

<tr>
	<td>Your name:</td>
	<td><input type=text name=name></td>
</tr>

<tr>
	<td>Your email:</td>
	<td><input type=text name=email></td>
</tr>

<tr>
	<td>Your status:</td>
	<td>	
		<select name=status>
		<option value="">select</option>
		<option value="Jobseeker">Jobseeker </option>
		<option value="Employer">Employer </option>
		<option value="Visitor">Visitor </option>
		</select>
	</td>
</tr>

<tr>
	<td>Subject: </td>
	<td><input type=text name=subject></td>
</tr>

<tr>
	<td valign=top>Message: </td>
	<td><textarea name=message rows=4 cols=30></textarea></td>
</tr>

<tr>
	<td colspan=2 align=center>
	<input type=submit name=submit class=SRT value=Send>
	&nbsp;&nbsp;&nbsp;
	<input type=reset class=SRT>
	</td>
</tr>
</table>
</form>

<? include_once('foother.html'); ?>