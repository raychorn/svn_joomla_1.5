<?

include_once "accesscontrol.php";
include_once "navigation2.htm";

$q1 = "delete from job_admin_login where aid = \"$daid\" ";
$r1 = mysql_query($q1) or die(mysql_error());

echo "<br><br><br><center> The deleting process finished successfully.</center>";
?>
<? include_once('../foother.html'); ?>