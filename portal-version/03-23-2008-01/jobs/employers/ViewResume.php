<?

include_once "../conn.php";

$q1 = "select JS_number from job_employer_info where ename = \"$ename\" ";
$r1 = mysql_query($q1) or die(mysql_error());
$a1 = mysql_fetch_array($r1);

if($a1[0] > 0)
{

$aup = $a1[0] - 1;

$qup = "update job_employer_info set JS_number = \"$aup\" where ename = \"$ename\" ";
$rup = mysql_query($qup) or die(mysql_error());

	include "ereview.php";

}
else
{
	echo "You resume view limit is depleted. ";
 include_once('../foother.html'); 
}

?>