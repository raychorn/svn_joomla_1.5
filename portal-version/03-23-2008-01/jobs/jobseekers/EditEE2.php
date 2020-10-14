<?
include_once "accesscontrol.php";


$E_d = strip_tags($E_d);
$E_i = strip_tags($E_i);

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

$E_i = addslashes($E_i);

$q1 = "update job_education set 
	E_i = \"$E_i\",
	E_Start = \"$E_Start\",
	E_End = \"$E_End\",
	E_gr = \"$E_gr\",
	E_d = \"$E_d\"

	where uname = \"$uname\" and En = \"$_POST[En]\"";

$r2 = mysql_query($q1) or die(mysql_error());

include "ER4.php";

?>
