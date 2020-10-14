<?

include_once "accesscontrol.php";


if(isset($ok) && $ok == 'Send my application')
{
	$q1 = "select CompanyEmail from job_employer_info where ename = \"$_POST[ename]\"";
	$r1 = mysql_query($q1) or die(mysql_error());
	$a1 = mysql_fetch_array($r1);

	$url = "http://$_SERVER[HTTP_HOST]/employers/EmployerView.php?uname=$uname";

        $q2 = "select fname, job_seeker_email, rTitle from job_seeker_info where uname = \"$uname\" ";
        $r2 = mysql_query($q2) or die(mysql_error());
        $a2 = mysql_fetch_array($r2);
	
	if(empty($a2[rTitle]))
	{
		echo "<table width=446><tr><td><br><br><br><center><br> Please, <a class=TN href=build_resume.php> post </a> resume to apply for a job.</center></td></tr></table>";
	exit;
	}

	$qui = "insert into job_aplicants set job_id = \"$_POST[job_id]\", aplicant = \"$uname\"";
	$rui = mysql_query($qui) or die(mysql_error());

	$from = "From: $a2[0] <$a2[1]>";
	$subject = "New job applicant";
	$message = "A job seeker has apliyed for your job offer. <br> To review the applicants resume, go to this address:\n $url\n\n You can access this information from Employers menu/Manage Jobs and then click on the link \"view aplicants list\" for each job offer.";
	mail($a1[0], $subject, $message, $from);

echo "<table width=446><br><br><br><center> Your application has been sent to the employer.</center></td></tr></table>";
}
elseif(isset($friend) && $friend == 'Send to a friend')
{
	$url = "http://$_SERVER[HTTP_HOST]/jobseekers/FriendView.php?job_id=$_POST[job_id]";
?>
<br>
<br>

	<form action=Friend2.php method=post  style="background:none;">
	<table align=center width="446">
		<tr>
		<td><b> Friend's email: </b></td>
		<td><input type=text name=femail size=31></td>
		</tr>
		
		<tr>
		<td valign=top><b>Message: </b></td>
		<td><textarea rows=4 cols=60 name=fmessage>I found a great Job Offer at <?=$site_name?>. Go to this URL to find out more. <?=$url?> </textarea></td>
		</tr>

		<tr>
		<td colspan=2 align=center>
		<input type=submit name=submit value=Send>
		</td>
		</tr>
	</table>
	</form>
<?	
}
?>
<? include_once('../foother.html'); ?>