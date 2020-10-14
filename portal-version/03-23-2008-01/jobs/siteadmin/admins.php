<?

include_once "accesscontrol.php";
include_once "navigation2.htm";

$q1 = "select * from job_admin_login order by binary aid";
$r1 = mysql_query($q1) or die(mysql_error());

echo "<table align=center width=446 border=1 cellspacing=0 bordercolor=e0e7e9>";
echo "<tr style=\"background-color:e0e7e9; font-family:arial; color:maroon; font-weight:normal;font-size:11px;\"><td> Admin ID </td><td> Admin pass </td> <td>Name </td> <td>Email </td> <td align=center> Manage</td></tr>";
while($a1 = mysql_fetch_array($r1))
{
echo "	
	<tr>
	<td> $a1[aid] </td>
	<td> $a1[apass] </td>
	<td> $a1[name]</td>
	<td> $a1[email]</td>
	<td align=center> <a class=TN href=\"delete_admin.php?daid=$a1[aid]\">Delete </a></td>
	</tr>";
}
echo "</table>";
?>

<br><center> To add a new admin at your level, <a class=TN href=add_admin.php> click here </a></center>
<? include_once('../foother.html'); ?>