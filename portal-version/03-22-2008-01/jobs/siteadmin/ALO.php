<?
include "accesscontrol.php";
include_once "navigation2.htm";

$ename=$_GET[ename];


$q = "select * from job_post where ename = '$ename' order by job_id";
$r = mysql_query($q) or die(mysql_error());
echo "<br>";



$aa = mysql_num_rows($r);

if($aa > '0')
{
while($a = mysql_fetch_array($r))
{

?>

<br>
<table align=center width=446>
<tr>
	<td colspan=2 align=center> <b> Details about Job ID# <?=$a[job_id]?> </b> <br> <a class=TN href=AEO.php?job_id=<?=$a[job_id]?>> edit </a> / <a class=TN href=ADO.php?job_id=<?=$a[job_id]?>> delete </a></td>
</tr>

<tr>
	<td><b> Position: </b></td>
	<td> <?=$a[position]?> </td>
</tr>

<tr>
	<td><b>Employer: </b></td>
	<td>  <?=$a[Company]?> </td>
</tr>

<tr>
	<td width=100><b> Job category: </b></td>
	<td> <?=$a[JobCategory]?> </td>
</tr>

<tr>
	<td><b> Target: </b></td>
	<td>
<?

		if($a[j_target] == '1')
		{
			echo   'Student (High School)';
		}
		elseif($a[j_target] == '2')
		{
			echo   'Student (undergraduate/graduate)';
		}
		elseif($a[j_target] == '3')
		{
			echo   'Entry Level (less than 2 years of experience)';
		}
		elseif($a[j_target] == '4')
		{
			echo  'Mid Career (2+ years of experience)';
		}
		elseif($a[j_target] == '5')
		{
			echo   'Management (Manager/Director of Staff)';
		}
		elseif($a[j_target] == '6')
		{
			echo   'Executive (SVP, EVP, VP)';
		}
		elseif($a[j_target] == '7')
		{
			echo   'Senior Executive (President, CEO)';
		}
?>

 </td>
</tr>

<tr>
	<td><b> Salary: </b> </td>
	<td> <?=$a[salary]?> / <?=$a[s_period]?> </td>
</tr>

<tr>
	<td valign=top><b> Description: </b></td>
	<td> <?=$a[description]?> </td>
</tr>

<tr><td colspan=2></td></tr>
</table>
<?
}
}
else
{
	echo "<br><br><br><center>There are no one job offer from this employer. </center>";
      
}
?>
<? include_once('../foother.html'); ?>