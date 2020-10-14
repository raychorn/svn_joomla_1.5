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


$q1 = "insert into job_work_experience set
	uname = \"$uname\",
	WEn = \"$WEn\",
	WE_Start = \"$WE_Start\",
	WE_End = \"$WE_End\",
	WE_p = \"$WE_p\",
	WE_d = \"$WE_d\" ";

$r1 = mysql_query($q1) or die(mysql_error());


include "ER3.php";

?>
<? include_once('../foother.html'); ?>