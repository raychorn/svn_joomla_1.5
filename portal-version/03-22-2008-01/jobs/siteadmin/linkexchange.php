<?

include_once "accesscontrol.php";
include_once "navigation2.htm";
include_once "navigation.html";

if(isset($submit) && !empty($link_id) && !empty($link_code))
{

	$il = "insert into job_link_source (link_id, link_code) values ('$link_id', '$link_code') ";
	$ril = mysql_query($il) or die(mysql_error());

	$sb13 = "select * from job_banners_m";
	$r13 = mysql_query($sb13) or die(mysql_error());
	$ar13 = @mysql_result($r13,0,bc);

	if(empty($ar13))
	{
	$ubi = "insert into job_banners_m (bc) values ('2') ";
	$rup = mysql_query($ubi) or die(mysql_error());
	}
	else
	{
	$ubi = "update job_banners_m set bc = '2' ";
	$rup = mysql_query($ubi) or die(mysql_error());
	}
}


$lid = "select count(link_id) from job_link_source";
$rlid = mysql_query($lid) or die(mysql_error());
$alid = mysql_fetch_array($rlid);
$link_id = $alid[0] + 1;

?>


<html>
<head>
<title>Add links</title>
</head>
<body>
<br><br>
<form method=post action=<?=$PHP_SELF?> style="background:none;">
<table align=center>
<tr>
	<td  class=TD_links>Link ID: </td>
	<td  class=TD_links> <b> <?=$link_id?> </b></td>
</tr>

<tr>
	<td valign=top  class=TD_links> Paste the link-code: </td>
	<td  class=TD_links> <textarea name=link_code rows=4 cols=40 style=border-color:black></textarea> </td>
</tr>
<tr><td></td><td><input type=submit name=submit value=Submit style="background-color:white; border-color:black">
</table>
<input type=hidden name=link_id value=<?=$link_id?>>
</form>
</body>
</html>
<? include_once('../foother.html'); ?>