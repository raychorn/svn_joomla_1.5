<?

include_once "accesscontrol.php";


if(isset($submit) && $submit =  "Login" )
{
$q = "select * from job_post where job_id = \"$_POST[job_id]\" ";
$r = mysql_query($q) or die(mysql_error());
$a = mysql_fetch_array($r);

$nv = $a[nv] + 1;

$qn = "update job_post set nv = \"$nv\" where job_id = \"$_POST[job_id]\" ";
$rn = mysql_query($qn) or die(mysql_error());

$js = $_POST[job_id];
}
else
{
$q = "select * from job_post where job_id = \"$_GET[job_id]\" ";
$r = mysql_query($q) or die(mysql_error());
$a = mysql_fetch_array($r);

$nv = $a[nv] + 1;

$qn = "update job_post set nv = \"$nv\" where job_id = \"$_GET[job_id]\" ";
$rn = mysql_query($qn) or die(mysql_error());

$js = $_GET[job_id];
}
$q2 = "select * from job_employer_info where ename = \"$a[ename]\"";
$r2 = mysql_query($q2) or die(mysql_error());
$a2 = mysql_fetch_array($r2);

?>

<br><br><br>
<table align=center width=446>
<tr>
	<td colspan=2 align=center> <b> Details about Job ID# <?=$a[job_id]?> </b></td>
</tr>

<tr>
	<td width=200><b> Position: </b></td>
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
	<td valign=top><b> Description: </b></td>
	<td> <?=$a[description]?> </td>
</tr>

<tr>
	<td><b>Company: </b></td>
	<td><?=$a[Company]?></td>
</tr>

<tr>
<? 

	$day = date(d);
	$month = date(m);
	$year = date(Y);

	$EXdate = "$a[EXyear]"."-"."$a[EXmonth]"."-"."$a[EXday]";
	$dnes = "$year"."-"."$month"."-"."$day";

	$qd = "select to_days('$EXdate') - to_days('$dnes')";
	$rqd = mysql_query($qd) or die(mysql_error());
	$ex13 = mysql_fetch_array($rqd);


//$ex13 = date('j', mktime(0,0,0, $a[EXmonth] - date(m), $a[EXday] - date(d), $a[EXyear] - date(Y)));
?>
	<td colspan=2><b>This job offer expire after <?=$ex13[0]?> day(s).</td>
</tr>

<form action=Send.php method=post  style="background:none;">
<tr>
	<td colspan=2 align=center>
	<input type=hidden name=job_id value=<?=$a[job_id]?>>
	<input type=hidden name=ename value=<?=$a[ename]?>>
	<input type=submit name=ok value="Send my application">
	<input type=submit name=friend value="Send to a friend"><br><br>
	</td>
</tr>
</form>
</table>

<? include_once('../foother.html'); ?>