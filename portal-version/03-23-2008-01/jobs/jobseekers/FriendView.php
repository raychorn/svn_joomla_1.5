<?
include_once "../main.php";

$q = "select * from job_post where job_id = \"$job_id\" ";
$r = mysql_query($q) or die(mysql_error());
$a = mysql_fetch_array($r);

?>


<table align=center width="446">
<tr>
	<td colspan=2 align=center> <b> Details about Job ID# <?=$a[job_id]?> </b></td>
</tr>

<tr>
	<td><b> Position: </b></td>
	<td> <?=$a[position]?> </td>
</tr>

<tr>
	<td><b> Job category: </b></td>
	<td> <?=$a[JobCategory]?> </td>
</tr>

<tr>
	<td><b> Target: </b></td>
<?

		if($a[j_target] == '1')
		{
			$clname = 'Student (High School)';
		}
		elseif($a[j_target] == '2')
		{
			$clname = 'Student (undergraduate/graduate)';
		}
		elseif($a[j_target] == '3')
		{
			$clname = 'Entry Level (less than 2 years of experience)';
		}
		elseif($a[j_target] == '4')
		{
			$clname = 'Mid Career (2+ years of experience)';
		}
		elseif($a[j_target] == '5')
		{
			$clname = 'Management (Manager/Director of Staff)';
		}
		elseif($a[j_target] == '6')
		{
			$clname = 'Executive (SVP, EVP, VP)';
		}
		elseif($a[j_target] == '7')
		{
			$clname = 'Senior Executive (President, CEO)';
		}
?>	
	<td><?=$clname?> </td>
</tr>

<tr>
	<td><b> Salary: </b> </td>
	<td> <?=$a[salary]?> / <?=$a[s_period]?> </td>
</tr>

<tr>
	<td><b> Description: </b></td>
	<td> <?=$a[description]?> </td>
</tr>

<form action=Send.php method=post  style="background:none;">
<tr>
	<td colspan=2 align=center>
	<input type=hidden name=job_id value=<?=$a[job_id]?>>
	<input type=submit name=ok value="Send my application">
	<input type=submit name=friend value="Send to a friend">
	</td>
</tr>
<tr><td colspan=2> </td></tr>
</form>
</table>
<? include_once('../foother.html'); ?>