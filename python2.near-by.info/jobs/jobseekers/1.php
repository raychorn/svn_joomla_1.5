<?

unset($step);
$step = '1';

include_once "accesscontrol.php";

$WE_d = strip_tags($WE_d);

if ($submit2 == 'Add Aonother')
{

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

$qs1 = "insert into job_work_experience set uname = \"$uname\", WEn = \"$n\", WE_Start = \"$WE_Start\", WE_End = \"$WE_End\", WE_p = \"$WE_p\", WE_d = \"$WE_d\" ";

$rs1 = mysql_query($qs1) or die(mysql_error());

include "1s.php";

}
elseif ( $submit == 'Save and go to Step 2 (Education)')
{

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
$qs1 = "insert into job_work_experience set uname = \"$uname\", WEn = \"$n\", WE_Start = \"$WE_Start\", WE_End = \"$WE_End\", WE_p = \"$WE_p\", WE_d = \"$WE_d\" ";
echo $qs1;
$rs1 = mysql_query($qs1) or die(mysql_error());
?><script language="JavaScript">location.href='2.php';</script>




<?
}
elseif(!empty($rTitle) && !empty($rPar))
{
$q1 = "update job_seeker_info set rTitle = \"$rTitle\", rPar = \"$rPar\" where uname = \"$uname\" ";
$r1 = mysql_query($q1) or die(mysql_error());

include "1s.php";
}



?>


