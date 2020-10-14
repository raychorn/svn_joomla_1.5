<?

include_once "accesscontrol.php";

	$day = date(d);
	$month = date(m);
	$year = date(Y);
		
	$del = "delete from job_post where EXday = \"$day\" and EXmonth = \"$month\" and EXyear = \"$year\" ";
	$rdel = mysql_query($del) or die(mysql_error());

if(!empty($job_del))
{
	$q1 = "delete from job_post where job_id = \"$job_del\" and ename = \"$ename\" ";
	$r1 = mysql_query($q1) or die(mysql_error());

	echo "<table width=446><tr><td><br><br><br><center> The job was deleted successfull.</center></td></tr></table>";
}
else
{
$qm = "select * from job_post where ename = \"$ename\" order by job_id";
$rqm = mysql_query($qm) or die(mysql_error());

echo "<br><br><table align=center border=0 cellspacing=5 width=446>\n<tr><td colspan=3>Your current job offers:</td>";

	while($aqm = mysql_fetch_array($rqm))
	{

	$day = date(d);
	$month = date(m);
	$year = date(Y);

	$EXdate = "$aqm[EXyear]"."-"."$aqm[EXmonth]"."-"."$aqm[EXday]";
	$dnes = "$year"."-"."$month"."-"."$day";

	$qd = "select to_days('$EXdate') - to_days('$dnes')";
	$rqd = mysql_query($qd) or die(mysql_error());
	$adate = mysql_fetch_array($rqd);

	$qempl = "select CompanyName, CompanyCountry, CompanyCity from job_employer_info where ename = \"$ename\" ";
	$rempl = mysql_query($qempl) or die(mysql_error());
	$ae = mysql_fetch_array($rempl);

		if($aqm[j_target]  == '1')
		{
			$clname = 'Student (High School)';
		}
		elseif($aqm[j_target]  == '2')
		{
			$clname = 'Student (undergraduate/graduate)';
		}
		elseif($aqm[j_target]  == '3')
		{
			$clname = 'Entry Level (less than 2 years of experience)';
		}
		elseif($aqm[j_target]  == '4')
		{
			$clname = 'Mid Career (2+ years of experience)';
		}
		elseif($aqm[j_target]  == '5')
		{
			$clname = 'Management (Manager/Director of Staff)';
		}
		elseif($aqm[j_target]  == '6')
		{
			$clname = 'Executive (SVP, EVP, VP)';
		}
		elseif($aqm[j_target] == '7')
		{
			$clname = 'Senior Executive (President, CEO)';
		}

	echo "<tr>
		<td>
		<b>Job ID: </b> $aqm[job_id] <br>
		<b>Position:</b> $aqm[position]  <br> 
		<b>Deascription: </b> $aqm[description] <br>
		<b>Salary: </b> $aqm[salary] / $aqm[s_period]<br>
		<b>Job category: </b> $aqm[JobCategory] <br>
		<b>Target: </b> $clname <br>
		<b>The job expire after: </b> $adate[0] day(s)<br>
		<b>Country & City </b> $ae[CompanyCountry] - $ae[CompanyCity]<br>
		view <a href=\"ManageAplicants.php?job_id=$aqm[job_id]&job_id=$aqm[job_id]&position=$aqm[position]\" class=TN> aplicants list </a> for this position
		</font></td></tr>
		<tr><td align=center><a href=\"DeleteJob.php?job_del=$aqm[job_id]\">Delete</a>&nbsp;&nbsp;<a href=\"EditJob.php?job_ed=$aqm[job_id]\">Edit</a></td>

		</tr>";
	
	}

}
?>
</table>
<? include_once('../foother.html'); ?>