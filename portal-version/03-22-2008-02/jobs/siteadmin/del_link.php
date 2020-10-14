<?

include_once "accesscontrol.php";
include_once "navigation2.htm";
include_once "navigation.html";

$q1 = "delete from job_link_source where link_id = \"$link_id\" ";
$r1 = mysql_query($q1) or die(mysql_error());

$drop1 = "drop table if exists temp_link";
$dropr1 = mysql_query($drop1) or die(mysql_error());

$tt = "create temporary table temp_link (tlink_id varchar(10) not null, tlink_code text)";
$ttr = mysql_query($tt) or die(mysql_error());

$q2 = "select * from job_link_source order by link_id";
$r2 = mysql_query($q2) or die(mysql_error());

while ($a2 = mysql_fetch_array($r2, MYSQL_ASSOC))
{
if (!$a) $a = 1;

	$qt = "insert into temp_link (tlink_id, tlink_code) values ('$a', '$a2[link_code]') ";
	$rqt = mysql_query($qt) or die(mysql_error());

$a = $a + 1;
}

$q3 = "delete from job_link_source";
$r3 = mysql_query($q3) or die(mysql_error());

$q4 = "select * from temp_link order by tlink_id";
$r4 = mysql_query($q4) or die(mysql_error());

while ($a4 = mysql_fetch_array($r4, MYSQL_ASSOC))
{
if (!$w) $w = 1;

	$qt = "insert into job_link_source (link_id, link_code) values ('$w', '$a4[tlink_code]')";
	$rqt = mysql_query($qt) or die(mysql_error());

$w = $w + 1;
}


$drop = "drop table temp_link";
$dropr = mysql_query($drop) or die(mysql_error());

?>
<? include_once('../foother.html'); ?>