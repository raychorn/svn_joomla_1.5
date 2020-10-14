<?
include_once "accesscontrol.php";


$E_d = strip_tags($E_d);

$d1 = array();
$d1[0] = $ESmonth;
$d1[1] = $ESyear;

if (is_array($d1))
	{
		$E_Start = implode("/" , $d1);
	}

$d2 = array();
$d2[0] = $EEmonth;
$d2[1] = $EEyear;

if (is_array($d2))
	{
		$E_End = implode("/" , $d2);
	}


$q1 = "insert into job_education set
	uname = \"$uname\",
	En = \"$En\",
	E_i = \"$E_i\",
	E_Start = \"$E_Start\",
	E_End = \"$E_End\",
	E_gr = \"$E_gr\",
	E_d = \"$E_d\" ";

$r1 = mysql_query($q1) or die(mysql_error());


include "ER4.php";

?>
