<?

unset($step);
$step = '2';

include_once "accesscontrol.php";

$E_d = strip_tags($E_d);

if ( $submit == 'Add Another')
{

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

$qs1 = "insert into job_education set uname = \"$uname\", E_i = \"$E_i\", En = \"$En\", E_Start = \"$E_Start\", E_End = \"$E_End\", E_gr = \"$E_gr\", E_d = \"$E_d\" ";

$rs1 = mysql_query($qs1) or die(mysql_error());

include "2s.php";

}
elseif ($submit == 'Save and go to Step 3 (Skills)')
{

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

$qs1 = "insert into job_education set uname = \"$uname\", E_i = \"$E_i\", En = \"$En\", E_Start = \"$E_Start\", E_End = \"$E_End\", E_gr = \"$E_gr\", E_d = \"$E_d\" ";

$rs1 = mysql_query($qs1) or die(mysql_error());

?><script language="JavaScript">location.href='3.php';</script>


<?
}

elseif(empty($En))
{
include "2s.php";
}




?>

