<?
include_once "accesscontrol.php";
include_once "navigation2.htm";
?>
<table width="446"><tr><td>
<?
$q1 = "select * from job_plan";
$r1 = mysql_query($q1) or die(mysql_error());
$nr = mysql_num_rows($r1);

echo "<br><br><br><table align=center width=300>\n";

if($nr < 1)
{
echo "<table width=440><tr><td><tr><td> You do not have any Price Plans. <br>To add a plan <a class=TNA href=AddPlan.php>click here</a></td></tr></table>";
}
else
{
	while($a1 = mysql_fetch_array($r1))
	{
	   echo "<table width=240 align=center><tr><td>

		<b> $a1[PlanName] </b>  (<a class=TN href=\"DelPlan.php?PlanName=$a1[PlanName]\">delete </a> / <a class=TN href=\"EditPlan.php?PlanName=$a1[PlanName]\"> edit </a>)
		<ul>
		<li>Valid for $a1[numdays] days</li>\n
		<li>$a1[postings] postings</li>\n
		<li>$a1[reviews] reviews </li>\n		
		<li>price <b>$$a1[price] </li>\n
		</ul>

		</td></tr></table>";
	}

echo "To add a new plan <a class=TNA href=AddPlan.php>click here</a>";
}

?>
</td></tr></table>
<? include_once('../foother.html'); ?>