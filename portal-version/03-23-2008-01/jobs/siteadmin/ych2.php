<?
include_once "accesscontrol.php";
include_once "navigation2.htm";
include_once "navigation.html";


if ($nch == banners)
{
	if ($b > '0')
	{
	$q2 = "update job_banners_m set bc = '1' ";
	$r2 = mysql_query($q2) or die(mysql_error());
	}
	else
	{
	$q2 = "insert into job_banners_m set bc = '1' ";
	$r2 = mysql_query($q2) or die(mysql_error());
	}
}
elseif ($nch == linkcodes)
{

	if ($b > '0')
	{
	$q2 = "update job_banners_m set bc = \"2\" ";
	$r2 = mysql_query($q2) or die(mysql_error());
	}
	else
	{
	$q2 = "insert into job_banners_m set bc = '2' ";
	$r2 = mysql_query($q2) or die(mysql_error());
	}
}

include_once "your_choice.php";

?>
<? include_once('../foother.html'); ?>