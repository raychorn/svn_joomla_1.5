<?

include_once "accesscontrol.php";
include_once "navigation2.htm";
include_once "navigation.html";

$nb = "select count(b_id) from job_banners_t";
$rnb = mysql_query($nb) or die;
$anb = mysql_fetch_array($rnb);

echo "<br><br>";
for ($bb = 1; $bb <= $anb[0]; $bb++)
{

$sb = "select * from job_banners_t where b_id = \"$bb\" ";
$rsb = mysql_query($sb) or die(mysql_error());
$ab = mysql_fetch_array($rsb);

echo "<table align=center width=446 border=0 cellpadding=3 cellspacing=0 bordercolor=black>";
echo "<tr><td width= 100  class=TD_links>Banner ID: $ab[b_id] <br><br> File name: $ab[fn] <br><br><a href=del_ban.php?b_id=$ab[b_id]&fn=$ab[fn]>delete </a></td><td align=center> <img src=banners/$ab[fn] alt=\"$ab[alt]\"> </td></tr>";
echo "</table><br>";

}

?>