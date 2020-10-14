<?

include_once "accesscontrol.php";


$q1 = "select fname, job_seeker_email from job_seeker_info where uname = \"$uname\" ";
$r1 = mysql_query($q1) or die(mysql_error());
$a1 = mysql_fetch_array($r1);

$from = "From:$a1[0] <$a1[1]>";
$subject = "Job offer";
$message = strip_tags($fmessage);
$to = strip_tags($femail);

mail($to, $subject, $message, $from);

echo "<table width=446><tr><td><br><br><br><center>The message was sent to $to </center></td></tr></table>";

?>
<? include_once('../foother.html'); ?>