<? include_once "../main.php"; ?>

<table width="446"><tr><td>
<?

if ($_POST['submit'] == "Register me")
{
	$q1 = "insert into job_employer_info set
		 ename = \"". $_POST["ename"] . "\", 
		epass = \"$epass\", 
		CompanyName = \"$CompanyName\", 
		CompanyCountry = \"$CompanyCountry\", 
		CompanyState = \"$CompanyState\",
		CompanyZip = \"$CompanyZip\", 
		CompanyCity = \"$CompanyCity\", 
		CompanyAddress = \"$CompanyAddress\", 
		CompanyPhone = \"$CompanyPhone\", 
		CompanyPhone2 = \"$CompanyPhone2\", 
		CompanyEmail = \"$CompanyEmail\" ";

	$r1 = mysql_query($q1);
	if (!$r1) 
		{
			echo '<table width=440><tr><td> <br><br><center>This username is already in use. Please choose another. </center></td></tr></table></td></tr></table>';
			include ("../foother.html");
			exit;
		}	


$to = $CompanyEmail;
$subject = "Your account at $site_name";
$message = "This is your account information at $site_name\n\n username: " . $_POST["ename"] . "\n password: $epass\n\n\n Keep this information in a secure place. \n\n Thanks for your registration. We believe you will find the staff you need at <a href=http://www.lhrjobs.co.uk>LHR Jobs.co.uk</a>";
$from = "From: <$email_address>";
echo "<br><br>You have successfully completed the registration process <br> <a href=PostJob.php>Click here </a> to post jobs.";
mail($to, $subject, $message, $from);

//	include_once "pay10.php";
   }	
?>
</td></tr></table>
<? 			include ("../foother.html"); ?>

