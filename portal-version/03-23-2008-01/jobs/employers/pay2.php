<?

include_once "accesscontrol.php";
?>
<?
if($price == '0')
{
	$qp = "select free, CompanyEmail from job_employer_info where ename = \"$ename\" ";
	$rp = mysql_query($qp) or die(mysql_error());
	$ap = mysql_fetch_array($rp);

	if($ap[0] == '1')
	{
	echo "<table width=446><tr><td><br><br><br><center> You have already used your free trail. <br> Now you know how powerfull our system is.<br> To place a job posting please choose from one<br> of our plans.<br><br>Please, go <a class=TN href=pay1.php> back </a> and choose a plan. <br><br>Thank you.</center></td></tr></table>";
	include ("../foother.html");
	exit;
	}
	else
	{
	$qu = "update job_employer_info set free = '1' ";
	$ru = mysql_query($qu) or die(mysql_error());
	}

// generate EXPIRY DATE for the number of days
$expireon  = mktime(0, 0, 0, date("m")  , date("d")+$numdays, date("Y"));
$expireond=date("d M Y",$expireon);
$q1 = "update job_employer_info set plan = \"$plan\", expiryplan='". date("Y-m-d",$expireon)."', JS_number = \"$reviews\", JP_number = \"$postings\" where ename = \"$ename\"";
//echo $q1;
$r1 = mysql_query($q1) or die(mysql_error());

$to = "$ap[1]";
$subject = "Your employer plan at $site_name";
$message = " Hello,\n here is your employer plan information at $site_name:\n\n Plan name: $plan\n Number of resume viewing: $reviews\n Number of Job Offer postings: $postings\n\n $site_name/resume/resume2 Team";
$from = "From: $email_address";

mail($to, $subject, $message, $from);

echo "<table width=446><tr><td><br><br><br><center> Now you can view <strong>$reviews</strong> resumes<br> and can post job <strong>$postings</strong> offers for $numdays days, your package will expire on $expireond. </center></td></tr></table>";

}
?>
<? include_once('../foother.html'); ?>