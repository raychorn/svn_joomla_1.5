<?

unset($step);
$step = '3';

include_once "accesscontrol.php";

$SK_d = strip_tags($SK_d, "<br>");

if ( $submit == 'Save and finish')
{

$q1 = "insert into job_skills set uname = \"$uname\", SK_d = \"$SK_d\" ";
$r2 = mysql_query($q1) or die(mysql_error());

echo "<table width=446 border=0><tr><td><br><br><br><center> Please click here to view your resume <a class=TN href=\"javascript:popUp('preview.php?uname=$uname')\"> click here </a></center></td></tr></table>";
 include_once('../foother.html');
}

else
{
include "3s.php";
}
?>