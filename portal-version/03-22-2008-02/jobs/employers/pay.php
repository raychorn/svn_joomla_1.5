<?

include_once "../main.php";

$q1 = "select * from job_plan";
$r1 = mysql_query($q1) or die(mysql_error());

?>

<html>
<body >


<table align=center width=500 bgcolor="#FFFFFF">

<tr>
	<td colspan=2>
	To access all the features we offer, choose your Employer Plan:
	</td>
</tr>

<?
while($a1 = mysql_fetch_array($r1))
{
echo "
<tr>	
<form action=pay2.php method=post  style=\"background:none;\">
	<td>
	<b>$a1[PlanName]</b>
	<ul>
	<li>$a1[postings] job postings; </li>
	<li>$a1[reviews] resume reviews; </li>
	<li><b>price: <font color=#000000>$ $a1[price] </font</b></li>
	</ul>
	</td>

	<td>
	<input type=submit name=submit value=\"Buy $a1[PlanName]\">
	<input type=hidden name=plan value=\"$a1[PlanName]\">
	<input type=hidden name=postings value=\"$a1[postings]\">
	<input type=hidden name=reviews value=\"$a1[reviews]\">
	<input type=hidden name=price value=\"$a1[price]\">
	<input type=hidden name=ename value=\"$ename\">
	</td>
</form>
</tr>";
}

?>

<html>
</table>


</body>
</html>
<? include_once('../foother.html'); ?>