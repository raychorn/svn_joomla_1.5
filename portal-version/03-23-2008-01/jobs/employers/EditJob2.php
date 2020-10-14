<?

include_once "accesscontrol.php";

	if (is_array($JobCategory2))
	{
		$JobStr = implode("," , $JobCategory2);
	}
	
	$position = strip_tags($position);
	$description = strip_tags($description);

	$q3 = "update job_post set
	position = \"$position\",
	JobCategory = \"$JobStr\", 
	description = \"$description2\",  
	j_target = \"$j_target2\", 
	salary = \"$salary2\", 
	s_period = \"$s_period2\"  
	where job_id = \"$job_id22\" ";
	$r3 = mysql_query($q3) or die(mysql_error());


echo "<table width=446><tr><td><br><br><center>The position $position was updated.</center></td></tr></table>";


?>
<? include_once('../foother.html'); ?>