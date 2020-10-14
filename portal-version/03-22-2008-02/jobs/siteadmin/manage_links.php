<?

include_once "accesscontrol.php";
include_once "navigation2.htm";
include_once "navigation.html";

$nb = "select count(link_id) from job_link_source";
$rnb = mysql_query($nb) or die;
$anb = mysql_fetch_array($rnb);

echo "<br><br>";
for ($bb = 1; $bb <= $anb[0]; $bb++)
{

$sb = "select * from job_link_source where link_id = \"$bb\" ";
$rsb = mysql_query($sb) or die(mysql_error());
$ab = mysql_fetch_array($rsb);

echo "<table align=center width=446 border=0 cellpadding=3 cellspacing=0 bordercolor=black>";
echo "<tr><td width= 100  class=TD_links>Link ID: $ab[link_id] <br><br> <a href=del_link.php?link_id=$ab[link_id]>delete </a></td><td align=center> $ab[link_code] </td></tr>";
echo "</table><br>";

}


?>
