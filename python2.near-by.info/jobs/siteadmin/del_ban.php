<?
include_once "accesscontrol.php";
include_once "navigation2.htm";
include_once "navigation.html";

$q1 = "delete from job_banners_t where b_id = \"$b_id\" ";
$r1 = mysql_query($q1) or die(mysql_error());

$dir1="banners/";
$userfile = $fn;
unlink($dir1.$userfile);

$drop1 = "drop table if exists temp_ban";
$dropr1 = mysql_query($drop1) or die(mysql_error());


$tt = "create temporary table temp_ban (tb_id varchar(10) not null, tfn varchar(100) not null, tburl varchar(100) not null, talt varchar(255))";
$ttr = mysql_query($tt) or die(mysql_error());

$q2 = "select * from job_banners_t order by b_id";
$r2 = mysql_query($q2) or die(mysql_error());

while ($a2 = mysql_fetch_array($r2, MYSQL_ASSOC))
{
if (!$a) $a = 1;

	$qt = "insert into temp_ban (tb_id, tfn, tburl, talt) values ('$a', '$a2[fn]', '$a2[burl]', '$a2[alt]')";
	$rqt = mysql_query($qt) or die(mysql_error());

$a = $a + 1;
}

$q3 = "delete from job_banners_t";
$r3 = mysql_query($q3) or die(mysql_error());

$q4 = "select * from temp_ban order by tb_id";
$r4 = mysql_query($q4) or die(mysql_error());

while ($a4 = mysql_fetch_array($r4, MYSQL_ASSOC))
{
if (!$w) $w = 1;

	$qt = "insert into job_banners_t (b_id, fn, burl, alt) values ('$w', '$a4[tfn]', '$a4[tburl]', '$a4[talt]')";
	$rqt = mysql_query($qt) or die(mysql_error());

$w = $w + 1;
}


$drop = "drop table temp_ban";
$dropr = mysql_query($drop) or die(mysql_error());

?>
<? include_once('../foother.html'); ?>