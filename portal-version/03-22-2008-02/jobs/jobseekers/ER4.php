<?
include_once "accesscontrol.php";

$q1 = "select * from job_education where uname = \"$uname\" order by En asc ";
$r2 = mysql_query($q1) or die(mysql_error());


echo "<br><br><br>";
while ($a1 = mysql_fetch_array($r2))
{
	echo "
	<form action=EditEducation.php method=post  style=\"background:none;\">
	<table align=center width=420 border=0 bordercolor=e0e7e9 cellspacing=0 cellpadding=0>
	<caption>
	<input type=submit name=submit value=Delete style=\"border-width:1; border-color:black; font-family:verdana; font-weight:normal; color:#000000; background-color:#e0e7e9\">
	<input type=hidden name=En value=$a1[En]>
	<font size=2> <strong>Education# $a1[En]</strong> </font>
	<input type=submit name=submit value=Edit style=\"border-width:1; border-color:black; font-family:verdana; font-weight:normal; color:#000000; background-color:#e0e7e9\">
	<input type=hidden name=En value=$a1[En]>
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
			
			<td valign=top>
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

$qs = "select count(En) from job_education where uname = \"$uname\" ";
$rqs = mysql_query($qs) or die(mysql_error());
$aqs = mysql_fetch_array($rqs);

$En = $aqs[0] + 1;
echo "<table width=446><tr><td><center>
	<a href=EEAdd.php?En=$En>Add another </a> 
	OR 
	<a href=EditSkills.php> Go to Step 3 (Skills) </a>
        </center></td></tr></table>";

?>

<? include_once('../foother.html'); ?>