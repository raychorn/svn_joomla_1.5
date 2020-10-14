<?
include_once "accesscontrol.php";

$q0 = "update  job_employer_info set JS_accessed = JS_accessed + 1 where ename = \"$ename\" ";
$sql = "SELECT plan,JS_number,JP_number,JS_accessed,JP_accessed,expiryplan FROM job_employer_info WHERE ename = '$ename' ";
$result = mysql_query($sql);
$res=mysql_fetch_array($result);
$resume_accessed=$res['JS_accessed'];
$resume_limit=$res['JS_number'];
$expiryon=mktime(0,0,0,substr($res['expiryplan'],5,2),substr($res['expiryplan'],8,2),substr($res['expiryplan'],0,4));
$today=mktime(0,0,0,substr(date("Y.m.d"),5,2),substr(date("Y.m.d"),8,2),substr(date("Y.m.d"),0,4));

if ($resume_accessed >= $resume_limit || $today > $expiryon)
 {
 
  ?>
  <table width="446"><tr><td>
  <font face=verdana>
  <h1> Access Denied </h1>
  <p><h5>Your Quota has crossed the limit please renew your Employer Plan to view the resumes:
     <br><br>To register for instant
     access, click <a href="pay1.php">here</a>.</h5></p>
	 </td></tr></table>
   <?php
   include ("../foother.html");
   
  exit;
}


$r2 = mysql_query($q0) or die(mysql_error());

$q = "select * from job_seeker_info where uname = \"$uname\"";
$r = mysql_query($q) or die(mysql_error());
$a = mysql_fetch_array($r);

$q1 = "select * from job_work_experience where uname = \"$uname\" order by WEn desc ";
$r2 = mysql_query($q1) or die(mysql_error());

$q3 = "select * from job_careerlevel where uname = \"$uname\" ";
$r3 = mysql_query($q3) or die(mysql_error());
$a3 = mysql_fetch_array($r3);

?>
<a href="EmployerSearch.php">Go Back</a><h3 align="center"> <? echo "$a[fname] $a[lname]'s Resume"; ?> </h3>
<table align=center width="446"><tr><td>
<table width=400 align=center cellpadding=0 border="0">
<caption align=center><b><? echo "$a[rTitle] <br><p align=left><font size=2 style=\"font-weight:normal\"> $a[rPar] </font></p>"; ?> </b> 
</caption>
<tr>
<td valign=top>
	

	<table width=400 align=center  cellspacing=0 border=0 bordercolor=e0e7e9>		
		<tr>
		<td>
		<b>Name:</b>
		</td>
		<td  width=275 valign=top>
		<? echo "$a[fname] $a[lname]"; ?>
		</td>
		</tr>

		<tr>
		<td>
		<b>Age: </b>
		</td>
		<td  valign=top>
		<?
		if((date(m) > $a[bmonth]) || (date(m) == $a[bmonth] && date(d) < $a[bday]))
		{
		    echo date(Y) - $a[byear];
		}
		else
		{
		  echo date(Y) - $a[byear] - 1;
		}
		?>

		</td>
		</tr>


		<tr>
		<td>
		<b>Phone:</b>
		</td>
		<td  valign=top>
		<? echo "$a[phone] \n $a[phone2]"; ?>
		</td>
		</tr>

		<tr>
		<td>
		<b>E-mail: </b>
		</td>
		<td >
		<?= $a[job_seeker_email]?>
		</td>
		</tr>
	</table>
</td></tr><tr>

<td valign=top>
	<table align=center width=400  cellpadding=0 cellspacing=0 border=0 bordercolor=e0e7e9>

	<tr>
	<td colspan=2><b> Address: </b></td>
	</tr>

	<tr>
	<td  colspan=2>
	<?=$a[address]?>
	</td>
	</tr>

	<tr>
	<td><b> Country: </b></td>
	<td >
	<?=$a[country]?>	
	</td>
	</tr>

	<tr>
	<td><b>City/Zip 
	<? 
	if(!empty($a[state]))
	{
		echo "/State";
	}
	?>
	</b></td>
	<td > <?=$a[city]?>/<?=$a[zip]?> 
	<?
	if(!empty($a[state]))
	{
		echo "/$a[state]";
	}
	?>

	</td>
	</td>
	</tr>
	</table>
</td>
</tr>
</table>

<table align=center width=400 border = 1 bordercolor=e0e7e9  cellspacing=0>
<tr>
	<td>Career level </td>
	<td > <?=$a3[clname]?> </td>
</tr>
</table>

</body>
</html>


<?

echo "<br><br><br>";
while ($a1 = mysql_fetch_array($r2))
{
	echo "
	<form action=EditWorkExperience.php method=post  style=\"background:none;\">
	<table align=center width=400 border=0 bordercolor=e0e7e9 cellspacing=0 cellpadding=0>
	<caption>
	<font size=2> Work experience# $a1[WEn] </font>
	</caption>
	</form>
	<tr>
		<td colspan=4><b>&nbsp; Position: </b> $a1[WE_p] </td>
	</tr>

	<tr>
		<td><b>&nbsp; From date</b></td>
		<td><b>&nbsp; To date</b></td>
	</tr>
	<tr>
		<td >&nbsp;$a1[WE_Start]</td>
		<td >&nbsp;$a1[WE_End]</td>
	</tr>
	<tr>
	<td colspan=4>
			<table cellspacing=0 width=100%>
			<tr>
			
			<td valign=top bgcolor=white>
			<b>&nbsp; Description: </b>
			</td>
			</tr>

			<tr>
			<td >
			$a1[WE_d] 
			</td>
			
			</tr>
			</table>
		</td>
	</td>
	</tr>
	</table>
	";	
}


$q1 = "select * from job_education where uname = \"$uname\" order by En asc ";
$r2 = mysql_query($q1) or die(mysql_error());


echo "<br><br><br>";
while ($a1 = mysql_fetch_array($r2))
{
	echo "
	<form action=EditEducation.php method=post  style=\"background:none;\">
	<table align=center width=446 border=0 bordercolor=e0e7e9 cellspacing=0 cellpadding=0>
	<caption>
	<font size=2> Education# $a1[En] </font>
	</caption>
	</form>
	<tr>
		<td colspan=4><b>&nbsp; Education Institution: </b>";  echo stripslashes($a1[E_i]); echo "</td>
	</tr>

	<tr>
		<td>&nbsp; Graduate Level </td>
		<td  width=100><b>&nbsp; From date </b></td><td width=185 >&nbsp; $a1[E_Start] </td>
	</tr>
	<tr>

		<td > &nbsp; $a1[E_gr] </td>
		<td width=100><b>&nbsp; To date </b></td><td width=185 >&nbsp; $a1[E_End] </td>
	</tr>
	<tr>
	<td colspan=4>
			<table cellspacing=0 width=100%>
			<tr>
			
			<td valign=top bgcolor=white>
			<b>&nbsp; Description: </b>
			</td>
			</tr>

			<tr>
			<td >
			$a1[E_d] 
			</td>
			
			</tr>
			</table>
		</td>
	</td>
	</tr>
	</table><br>
	";	
}


$q4 = "select * from job_skills where uname = \"$uname\" ";
$r4 = mysql_query($q4) or die(mysql_error());

while($a4 = mysql_fetch_array($r4))
{
$aaa = stripslashes($a4[SK_d]);

	echo "
	<table align=center width=446 border=0 bordercolor=e0e7e9 cellspacing=0>
	<caption><b>My additional skills </b></caption>

	<tr>
	<td colspan=2> $aaa </td>
	</tr>
	</table>	

";

}

?>
</td></tr></table>

<? include_once('../foother.html'); ?>