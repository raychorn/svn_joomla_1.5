<?
include_once "accesscontrol.php";


$q1 = "select * from job_work_experience where uname = \"$uname\" order by WEn asc ";
$r2 = mysql_query($q1) or die(mysql_error());


echo "<br><br><br>";
while ($a1 = mysql_fetch_array($r2))
{
	echo "
	<form action=EditWorkExperience.php method=post  style=\"background:none;\">
	<table align=center width=420 border=0 bordercolor=e0e7e9 cellspacing=0 cellpadding=0>
	<caption>
	<input type=submit name=submit value=Delete style=\"border-width:1; border-color:black; font-family:verdana; font-weight:normal; color:#000000; background-color:#e0e7e9\">
	<input type=hidden name=WEn value=$a1[WEn]>
	<font size=2> <strong>Work experience# $a1[WEn]</strong> </font>
	<input type=submit name=submit value=Edit style=\"border-width:1; border-color:black; font-family:verdana; font-weight:normal; color:#000000; background-color:#e0e7e9\">
	<input type=hidden name=WEn value=$a1[WEn]>
	</caption>
	</form>
	<tr>
		<td colspan=4><b>Position: </b> $a1[WE_p] </td>
	</tr>

	<tr>
		<td><b>From date</b>&nbsp;&nbsp;&nbsp;$a1[WE_Start]</td>
		<td><b>To date</b>&nbsp;&nbsp;&nbsp;$a1[WE_End]</td>
	</tr>
	<tr>
		<td ></td>
		<td ></td>
	</tr>
	<tr>
	<td colspan=4>
			<table cellspacing=0 width=100%>
			<tr>
			
			<td valign=top>
			<b>Description:&nbsp;</b>&nbsp;$a1[WE_d]
			</td>
			</tr>

			<tr>
			<td >
			 
			</td>
			
			</tr>
			</table>
		</td>
	</td>
	</tr>
	</table><br>
	";	
}

$qs = "select count(WEn) from job_work_experience where uname = \"$uname\" ";
$rqs = mysql_query($qs) or die(mysql_error());
$aqs = mysql_fetch_array($rqs);

$WEn = $aqs[0] + 1;
echo "<table width=446><tr><td><center>
	<a href=EWAdd.php?WEn=$WEn>Add another </a> 
	OR 
	<a href=ER4.php> Go to Step 2 (Education) </a>
        </center></tr></td></table>";

?>

<? include_once('../foother.html'); ?>