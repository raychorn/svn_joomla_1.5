<?
include_once "accesscontrol.php";

$WE_d = strip_tags($WE_d);

$d1 = array();
$d1[0] = $WSmonth;
$d1[1] = $WSyear;

if (is_array($d1))
	{
		$WE_Start = implode("/" , $d1);
	}

$d2 = array();
$d2[0] = $WEmonth;
$d2[1] = $WEyear;

if (is_array($d2))
	{
		$WE_End = implode("/" , $d2);
	}

$WE_p = stripslashes($WE_p);

$q1 = "update job_work_experience set 
	WE_Start = \"$WE_Start\",
	WE_End = \"$WE_End\",
	WE_p = \"$WE_p\",
	WE_d = \"$WE_d\"

	where uname = \"$uname\" and WEn = \"$WEn\"";

$r2 = mysql_query($q1) or die(mysql_error());

include "ER3.php";

?>

