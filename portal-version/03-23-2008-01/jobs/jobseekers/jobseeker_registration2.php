<?
session_start();
include_once "../main.php";
?>

<table width="446" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"><tr><td align="center"><br>

<?
//echo $_POST;
//foreach ($_POST as $key => $value) {
//	echo "$key = $value<br />\n";
//}

if ($_POST['submit'] == "Register me")
{

	if (is_array($JobCategory))
	{
		$JobStr = implode("," , $JobCategory);
	}

		if($careerlevel == '1')
		{
			$clname = 'Student (High School)';
		}
		elseif($careerlevel == '2')
		{
			$clname = 'Student (undergraduate/graduate)';
		}
		elseif($careerlevel == '3')
		{
			$clname = 'Entry Level (less than 2 years of experience)';
		}
		elseif($careerlevel == '4')
		{
			$clname = 'Mid Career (2+ years of experience)';
		}
		elseif($careerlevel == '5')
		{
			$clname = 'Management (Manager/Director of Staff)';
		}
		elseif($careerlevel == '6')
		{
			$clname = 'Executive (SVP, EVP, VP)';
		}
		elseif($careerlevel == '7')
		{
			$clname = 'Senior Executive (President, CEO)';
		}

	     $query = "insert into job_seeker_info set 
		uname = \"". $_POST["uname"] . "\",
		upass = \"$upass\",
		title = \"$title\",
		fname = \"$fname\",
		lname = \"$lname\",
		bmonth = \"$bmonth\",
		bday = \"$bday\",
		byear = \"$byear\",
		maritalstatus = \"$maritalstatus\",
		income = \"$income\",
		city = \"$city\",
		state = \"$state\",
		country = \"$country\",
		zip = \"$zip\",
		address = \"$address\",
		phone = \"$phone\",
		phone2 = \"$phone2\",
		job_seeker_email = \"$job_seeker_email\",
		job_seeker_web = \"$job_seeker_web\",
		job_category = \"$JobStr\",
		careerlevel = \"$clname\",
		target_company = \"$target_company\",
		relocate = \"$relocate\"
		";
		$result = mysql_query($query);
		if (!$result) 
		{
			echo '<table width=446><tr><td> <br><br><center>This username is already in use. Please choose another. </center></td></tr></table></td></tr></table>';
			include ("../foother.html");
			exit;
		}	


		$qcl = "insert into job_careerlevel set
			uname =\"". $_POST["uname"] . "\",
			clnumber = \"$careerlevel\",
			clname = \"$clname\" ";
		$rcl = mysql_query($qcl) or die(mysql_error());


$to = $job_seeker_email;
$subject = "Your account at $site_name";
$message = "This is your account information at $site_name\n\n username: $uname\n password: $upass\n\n\n Keep this information in a secure place. \n\n Thanks for your registration. We believe you will find a job at \n http://$_SERVER[HTTP_HOST]";
$from = "From: <$email_address>";

mail($to, $subject, $message, $from);

session_register("uname");
session_register("upass");

		echo "<br><br><br> 
		<p align=center>
		Your registration was completed successfully.<br>You can start to <a href=build_resume.php>build your resume </a> or <a href=JobSearch.php> Search for a Job </a>
		</p>
		";

}
else
{
	echo "<center><br><br><br><font color=red><b> You have a mistake filling the password/confirm password fields. <br> Go <a class=ERR href=jobseeker_registration.php> back </a> and fill all them properly, please.</b></font></center>";
}

?>
</td></tr></table>
<? include_once('../foother.html'); ?>