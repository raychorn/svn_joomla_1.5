<?

include_once "../main.php";
?>
<table width="446" bgcolor="#FFFFFF"><tr><td>
<?

   if ($act=="success")
  { 
//	foreach($_POST as $key=>$value)
//	{
//		echo $key . " => " . $value . "<br>";
//	}
  include ("pay222.php");
  
 $q = "select * from job_plan where PlanName = \"$plan\"";
$r = mysql_query($q) or die(mysql_error());
$a = mysql_fetch_array($r);



$qm = "select CompanyEmail from job_employer_info where ename = \"$epayname\" ";
$rqm = mysql_query($qm) or die(mysql_error());
$am = mysql_fetch_array($rqm);

$to = "$am[0]";
$subject = "Your employer plan at $site_name";
$message = "Hello,\n here is your employer plan information at $site_name:\n\n Plan name: $plan\n Membership valid until $expireon $a[postings]\n\n <?=$site_name?> Team";
$from = "From: $email_address";
	if ($invalidtxn == "false")
	{
		echo "<br><br><br><center> <strong>Now you can view $a[reviews] resumes<br> and can post $a[postings] job offers.</strong> </center>";
		mail($to, $subject, $message, $from);
	}
}
else
{
$qm = "select CompanyEmail from job_employer_info where ename = \"$epayname\" ";
$rqm = mysql_query($qm) or die(mysql_error());
$am = mysql_fetch_array($rqm);

$to = "$am[0]";
$subject = "Paypal problem";
$message = "there was a problem with a Paypal.com payment.\n\n this is the referer url: $ar\n User ID: $epayname\n plan: $plan";
$from = "From: $email_address";

mail($to, $subject, $message, $from);

	echo "<center>  There is a problem with your account. <br>The site administrator already know this <br>and will contact you as soon as possible.</center>";
}
?>
</td></tr></table>
<? include_once('../foother.html'); ?>