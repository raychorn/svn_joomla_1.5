<?
include_once "accesscontrol.php";
include_once "navigation2.htm";

if(isset($submit) && $submit == 'Add')
{
	$q1 = "insert into job_plan set
		PlanName = \"$PlanName\",
		numdays = \"$numdays\",
		postings = \"$postings\",
		reviews = \"$reviews\",
		price = \"$price\"";
	$r1 = mysql_query($q1) or die(mysql_error());
}
?>

<br>
<table align=center width=300 border=0>
<form action=<?=$PHP_SELF?> method=post>

<caption> Add a new plan </caption>
<tr>
	<td><b> Plan name:</b></td>
	<td>&nbsp;&nbsp;<input type=text name=PlanName></td>
</tr>

<tr>
	<td><b>Number of Days</b></td>
	<td>&nbsp;&nbsp;<input type=text name=numdays size=5></td>
</tr>
<tr>
	<td><b>Postings: </b></td>
	<td>&nbsp;&nbsp;<input type=text name=postings size=5></td>
</tr>

<tr>
	<td><b> Reviews: </b></td>
	<td>&nbsp;&nbsp;<input type=text name=reviews size=5></td>
</tr>
<tr>
	<td><b> Price: </b></td>
	<td><b>$</b><input type=text name=price size=5></td>
</tr>

<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;<input type=submit name=submit value=Add>&nbsp;<input type=reset></td>
</tr>
</form>
</table>
<? include_once('../foother.html'); ?>