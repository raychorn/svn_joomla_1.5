<?

include_once "conn.php";

$sbs = "select * from job_banners_m";
$rsbs = mysql_query($sbs) or die(mysql_error());
$abs = mysql_fetch_array($rsbs);
$bs = $abs[0];

if ($bs == 1)
{

	$q1 = "select * from job_banners_t";
	$r1 = mysql_query($q1) or die (mysql_error());
	$a = mysql_num_rows($r1);

	if ($a > 1)
	{
	mt_srand((double)microtime() * 1000000);
	$ban_n = mt_rand(1,$a);

	$qsb = "select burl, fn, alt from job_banners_t where b_id = \"$ban_n\" ";
	$rsb = mysql_query($qsb) or die (mysql_error());
	$asb = mysql_fetch_array($rsb);

	echo "
	<a href=\"$asb[burl]\" target=_blank alt=\"$asb[alt]\"><img src=\"banners/$asb[fn]\" border=0></a>
	";
	}

	elseif ($a == 1)
	{
	$qsb = "select burl, fn, alt from job_banners_t where b_id = \"1\" ";
	$rsb = mysql_query($qsb) or die (mysql_error());
	$asb = mysql_fetch_array($rsb);

	echo "
	<a href=\"$asb[burl]\" target=_blank alt=\"$asb[alt]\"><img src=\"banners/$asb[fn]\" border=0></a>
	";
	}


}

elseif($bs == 2)
{

	$bc = "select * from job_link_source";
	$rbc = mysql_query($bc) or die(mysql_error());
	$b = mysql_num_rows($rbc);

	if ($b > 1)
	{
	mt_srand((double)microtime() * 1000000);
	$link_id = mt_rand(1,$b);

	$sl = "select link_code from job_link_source where link_id = \"$link_id\" ";
	$rsl = mysql_query($sl) or die(mysql_error());
	$asl = mysql_fetch_array($rsl);

	$link_code = $asl[0];

	echo "< $link_code ";
	}
	elseif($b == 1)
	{
	$sl = "select link_code from job_link_source where link_id = \"1\" ";
	$rsl = mysql_query($sl) or die(mysql_error());
	$asl = mysql_fetch_array($rsl);

	$link_code = $asl[0];

	echo " $link_code ";
	}

}


?>