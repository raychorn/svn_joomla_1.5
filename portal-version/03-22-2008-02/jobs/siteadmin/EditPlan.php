<?
include_once "accesscontrol.php";
include_once "navigation2.htm";

if(isset($submit) && $submit == 'Update')
{
	$q1 = "update job_plan set
		PlanName = \"$PlanName\",
		postings = \"$postings\",
		reviews = \"$reviews\",
		numdays = \"$numdays\",
		price = \"$price\" 

		where PlanName = \"$OldName\"";
	$r1 = mysql_query($q1) or die(mysql_error());
}
else
{
	$q2 = "select * from job_plan where PlanName = \"$PlanName\"";
	$r2 = mysql_query($q2) or die(mysql_error());
	$a2 = mysql_fetch_array($r2);

?>
<br>
<table align=center width=300>
<form action=<?=$PHP_SELF?> method=post>
<caption> Edit plan <b><?=$a2[PlanName]?> </b></caption>
<tr>
	<td><b> Plan name:</b></td>
	<td>&nbsp;&nbsp;<input type=text name=PlanName value="<?=$a2[PlanName]?>"></td>
</tr>

<tr>
	<td><b>Number of Days: </b></td>
	<td>&nbsp;&nbsp;<input type=text name=numdays size=5 value=<?=$a2[numdays]?>></td>
</tr>
<tr>
	<td><b>Postings: </b></td>
	<td>&nbsp;&nbsp;<input type=text name=postings size=5 value=<?=$a2[postings]?>></td>
</tr>

<tr>
	<td><b> Reviews: </b></td>
	<td>&nbsp;&nbsp;<input type=text name=reviews size=5 value=<?=$a2[reviews]?>></td>
</tr>
<tr>
	<td><b> Price: </b></td>
	<td><b>$</b><input type=text name=price size=5 value=<?=$a2[price]?>></td>
</tr>

<tr>
	<td></td>
	<td><input type=hidden name=OldName value="<?=$a2[PlanName]?>">&nbsp;&nbsp;
	<input type=submit name=submit value=Update>&nbsp;&nbsp;<input type=reset></td>
</tr>
</form>
</table>

<?
}
?>
<? include_once('../foother.html'); ?>