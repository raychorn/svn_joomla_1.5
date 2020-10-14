<?

include_once "accesscontrol.php";
include_once "navigation2.htm";
include_once "navigation.html";

$q1 = "select * from job_banners_m";
$r1 = mysql_query($q1) or die(mysql_error());
$a1 = mysql_fetch_array($r1);
$a = $a1[0];
global $a;

if($a == '1')
{
$ch = 'banners';
}
elseif($a == '2')
{
$ch = 'link codes';
}

?>


<center><br>At the banner management system you can use banners or link exchange codes. <br> At this time you are using <b> <?
if (empty($a))
{
echo 'nothing';
}
else
{
echo $ch;
}
?></b>. If you want to change this, click on your choice:<br> <b>What will you use: <br><a class=links2 href=ych2.php?nch=banners&b=<?=$a?>> banners </a> OR <a class=links2 href=ych2.php?nch=linkcodes&b=<?=$a?>> link codes </a></b></center>
<br><center> You have these banners: </center>
<? include_once "manage_banners.php" ?>
<center>You have these links: </center>
<? include_once "manage_links.php" ?>
<? include("../foother.html"); ?>

