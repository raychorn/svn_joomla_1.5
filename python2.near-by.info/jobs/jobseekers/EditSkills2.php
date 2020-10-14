<?

include_once "accesscontrol.php";

$SK_d = strip_tags($SK_d, "<br>");
$SK_d = addslashes($SK_d);

if ( $submit == 'Save and finish')
{

$q1 = "update job_skills set SK_d = \"$SK_d\" where  uname = \"$uname\" ";
$r2 = mysql_query($q1) or die(mysql_error());

$q12 = "select * from job_skills where uname = \"$uname\" ";
$r12 = mysql_query($q12) or die(mysql_error());
$a12 = mysql_fetch_array($r12);

$a111 = stripslashes($a12[SK_d]);

echo "<table width=446 bgcolor=#FFFFFF><tr><td><br><br><br><center>Your resume has been updated successfully.</center></td></tr></table>";


unset($submit);
include_once('../foother.html');
}

else
{
include "EditSkills.php";
}
?>
