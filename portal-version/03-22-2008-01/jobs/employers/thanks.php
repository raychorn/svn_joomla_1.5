<?
include_once "accesscontrol.php";
?>

<table align=center width=595>
<tr>
<td align="center">
<br>
<br>
<br>
<br>
<?
//foreach ($_POST as $key=>$value)
//{
//	echo $key . " => " . $value;
//}
if ($_POST["submit"]=="Buy Now" && $_POST["sid"]==$paypal_email_address && $_POST["demo"] !="Y") 
//if ($_POST["submit"]=="Buy Now" && $_POST["sid"]=="522701" && $_POST["demo"] !="Y") 
{

//	echo $_SERVER['HTTP_REFERRER'];
	
//		foreach ($_POST as $key=>$value)
//		{
//			echo $key .  " => " . $value .  "<br>";
//		}
		$plan=mysql_fetch_array(mysql_query("Select * from job_plan where PlanName='".$_REQUEST["PlanName"]."'"));
		mysql_query("update job_employer_info set JS_number='".$plan["reviews"]."' , JP_number='".$plan["postings"]."' , plan='".$plan["PlanName"]."' where ename=\"$ename\" ") or die(mysql_error());
//		echo ("update job_employer_info set JS_number='".$plan["reviews"]."' , JP_number='".$plan["postings"]."' , plan='".$plan["PlanName"]." where ename=\"$ename\" ");
		echo "You have Successfully purchased the  <strong>" . $_REQUEST["PlanName"] ."</strong> package.<br><br>Now you can post jobs and search resumes.";
}
?>

</td>
</tr>
</table>

<? include_once('../foother.html'); ?>
