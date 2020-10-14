<?

include_once "accesscontrol.php";


$q1 = "select * from job_aplicants t1, job_careerlevel t2 where t1.aplicant = t2.uname and t1.job_id = \"$_GET[job_id]\" order by t2.clnumber desc";
$r1 = mysql_query($q1) or die(mysql_error());

//number of offer rerviews
$q22 = "select nv from job_post where job_id = \"$_GET[job_id]\" ";
$r22 = mysql_query($q22) or die(mysql_error());
$a22 = mysql_fetch_array($r22);

//number of offer aplicants
$q33 = "select count(aplicant) from job_aplicants where job_id = \"$_GET[job_id]\" ";
$r33 = mysql_query($q33) or die(mysql_error());
$a33 = mysql_fetch_array($r33);


echo "<br><br><br><table align=center width=446 cellspacing=0>
	<caption align=center><b> Aplicants list for Job ID# $_GET[job_id] / position $position </b><br><font size=2> This offer was reviewed $a22[0] time(s) and there are $a33[0] aplicant(s). </font> </caption>
	<tr bgcolor=red style=\"font-family:arial; font-size:12; color:white; font-weight:bold\"><td width=150>Name </td><td>Career level </td></tr>";

$col = "cococo";

while ($a1 = mysql_fetch_array($r1))
{
	$q2 = "select fname, lname from job_seeker_info where uname = \"$a1[uname]\" ";
	$r2 = mysql_query($q2) or die(mysql_error());
	$a2 = mysql_fetch_array($r2);

	 if($col == "cococo")
	    { 
	     $col = "dddddd"; 
	    }
	         	 else
		{ 
		$col = "cococo"; 
		} 

	echo "<tr bgcolor=\"$col\"><td><a class=TN href=\"javascript:popUp('EmployerView2.php?uname=$a1[uname]&ename=$ename')\"> $a2[0] $a2[1] </a></td><td> $a1[clname] </td></tr>";
}

echo "</table><center><br><a class=TN href=DeleteJob.php> << go back </a></center>";

?>
<? include_once('../foother.html'); ?>