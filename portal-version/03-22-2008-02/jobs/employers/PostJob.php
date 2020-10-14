<?

include_once "accesscontrol.php";

$q1 = "select plan, expiryplan,JS_number, JP_number from job_employer_info where ename = \"$ename\" ";
$r1 = mysql_query($q1) or die(mysql_error());
$a1 = mysql_fetch_array($r1);

if(!empty($a1[plan]))
{
$a11 = $a1[expiryplan];
$a112 = $a1[JP_number];

  if(isset($submit) && $submit == 'Post this job')
  {
	$q2 = "select * from job_employer_info where ename = \"$ename\" ";
	$r2 = mysql_query($q2) or die(mysql_error());
	$a2 = mysql_fetch_array($r2);
	
	if (is_array($JobCategory))
	{
		$JobStr = implode("," , $JobCategory);
	}
	
	$qc = "select job_id from job_post order by job_id desc";
	$rc = mysql_query($qc) or die(mysql_error());
	$ac = mysql_fetch_array($rc);
	$job_id = $ac[0] + 1;

	$position = strip_tags($position);
	$description = strip_tags($description);


	$EXday = date('d', mktime(0,0,0,0, date(d) + $_POST[exdays1], 0));
	$EXmonth = date('m', mktime(0,0,0, date(m), date(d) + $_POST[exdays1], 0));
	$EXyear = date('Y', mktime(0,0,0,date(m) ,date(d) + $_POST[exdays1], date(Y)));

	$q3 = "insert into job_post set
	job_id = \"$job_id\",
	 ename = \"$ename\", 
	CompanyCountry = \"$a2[CompanyCountry]\",
	CompanyState = \"$a2[CompanyState]\",
	Company = \"$a2[CompanyName]\", 
	position = \"$position\", 
	JobCategory = \"$JobStr\", 
	description = \"$description\",  
	j_target = \"$j_target\", 
	salary = \"$salary\", 
	s_period = \"$s_period\",
	EXmonth = \"$EXmonth\",
	EXday = \"$EXday\",
	EXyear = \"$EXyear\"  ";
//	echo $q3;
	$r3 = mysql_query($q3) or die(mysql_error());

	$a112 = $a112 - 1;
	$q4 = "update job_employer_info set JP_number = \"$a112\" where ename = \"$ename\" ";
	$r4 = mysql_query($q4) or die(mysql_error());

$to = $a2[CompanyEmail];
$subject = "Your Job post at $site_name";
$message = "This is an automate sent copy of your Job post.\n\n Details:\n Job ID# $job_id \n Position: $position \n Category: $JobStr \n Description: $description \n Target: $clname \n Salary: $salary/$s_period \n Expire date: $EXmonth/$EXday/$EXyear\n\n\n To edit or delete this job, click here: http://$_SERVER[HTTP_HOST]/employers/DeleteJob.php ";
$from = "From: $email_address";

mail($to, $subject, $message, $from);

echo "<br><br><center> Job offer has been posted successfully. <br><br><br> </center>";

  }
//	this will echo date in this format Jan-23-2006, first i extract month, year and date from date field of sql and then put then in mktime function	
//	echo date("M-d-Y",mktime(0,0,0,substr($a1['expiryplan'],5,2),substr($a1['expiryplan'],8,2),substr($a1['expiryplan'],0,4)));

	$expiryon=mktime(0,0,0,substr($a1['expiryplan'],5,2),substr($a1['expiryplan'],8,2),substr($a1['expiryplan'],0,4));
	$today=mktime(0,0,0,substr(date("Y.m.d"),5,2),substr(date("Y.m.d"),8,2),substr(date("Y.m.d"),0,4));

	if ($today > $expiryon || $a112 < 1)
	{
		echo "<center><br><br><br>You can not post jobs. <br>To do this, you must buy one of our Employer's Plans:</center>";
		include_once "pay10.php";
	}

	else
	{



echo "";
?>

<SCRIPT LANGUAGE="JavaScript">

function checkFields() {
missinginfo = "";

if (document.form.position.value == "") {
missinginfo += "\n     -  Position";
}
if (document.form.description.value == "") {
missinginfo += "\n     -  Description";
}
if (document.form.salary.value == "") {
missinginfo += "\n     -  Salary";
}
//if (document.form.exdays1.value == "") {
//missinginfo += "\n     -  Expire date/Day";
//}

if (missinginfo != "") {
missinginfo ="_____________________________\n" +
"You failed to correctly fill in your:\n" +
missinginfo + "\n_____________________________" +
"\nPlease re-enter and submit again!";
alert(missinginfo);
return false;
}
else return true;
}
</script>
<form action="<?=$PHP_SELF?>" method="post" name="form" onSubmit="return checkFields();"?  style="background:none;">
<table width=446 bgcolor="#FFFFFF">
  <tr>
		<td colspan=2>
		You are using <strong>'<?=$a1[plan]?>'</strong> Package. <br>Your account status is positive.<br>
		Your 	membership is valid till <strong>'<?=date("d-M-Y",mktime(0,0,0,substr($a1['expiryplan'],5,2),substr($a1['expiryplan'],8,2),substr($a1['expiryplan'],0,4)));?>'</strong>.<br>
		<li><strong><?=dateDiff("/",date("m/d/Y",$expiryon),date("m/d/Y"));?> Days</strong> left to expiration.</li>
		<li>You can post <strong><?=$a112?></strong> jobs;</li>
		<li>You can review <strong><?=$a1[JS_number]?></strong> resumes; </li>

		</td>
	<tr>
	
	<tr><td colspan=2 align=center> To post a job, use the form below:</td></tr>

	<tr><td>Position:</td>
	
	<td>
	<input type=text name=position>
	</td>
	</tr>

	<tr>
	<td valign=top>
	Job Category: <br> 
	</td>

	<td valign=top>
	<SELECT NAME="JobCategory[]" multiple size=5>
          <option value="Accounting/Auditing">Accounting/Auditing</option>
          <option value="Administrative and Support Services">Administrative and 
          Support Services</option>
          <option value="Advertising/Public Relations">Advertising/Public Relations</option>
          <option value="Computers, Hardware">Computers, Hardware</option>
          <option value="Computers, Software">Computers, Software</option>
          <option value="Consulting Services">Consulting Services</option>
          <option value="Customer Service and Call Center">Customer Service and 
          Call Center</option>
          <option value="Director">Director</option>
          <option value="Executive Management">Executive Management</option>
          <option value="Finance/Economics">Finance/Economics</option>
          <option value="Human Resources">Human Resources</option>
          <option value="Information Technology">Information Technology</option>
          <option value="Installation, Maintenance and Repair">Installation, Maintenance 
          and Repair</option>
          <option value="Internet/E-Commerce">Internet/E-Commerce</option>
          <option value="Legal">Legal</option>
          <option value="Marketing">Marketing</option>
          <option value="Sales">Sales</option>
          <option value="Supervisor">Supervisor</option>
          <option value="Telecommunications">Telecommunications</option>
          <option value="Transportation and Warehousing">Transportation and Warehousing</option>
          <option value="Other">Other</option>
        </SELECT><br>
	</td>

	<tr><td valign=top>Description:</td>
	<td><textarea rows=6 cols=35 name=description></textarea></td>
	</tr>

	<tr>
	<td>Target: </td>

	<td>
	<select name="j_target">
          <option value="1">Student (School Leaver)</option>
          <option value="2">Student (undergraduate/graduate)</option>
          <option value="3">Entry Level (less than 2 years of experience)</option>
          <option value="4">Mid Career (2+ years of experience)</option>
          <option value="5">Management (Manager/Director of Staff)</option>
          <option value="6">Executive </option>
          <option value="7">Senior Executive (President, CEO)</option>
        </select>
	</td>
	</tr>
	
	<tr><td>Salary: </td>
	<td>
	<input type=text name=salary size=11> 
	<select name=s_period>
	  <option value="Yearly">Yearly </option>
	  <option value="Monthly">Monthly </option>
	</select>
	</td></tr>


<tr>
	<td>

	This job posting will expire in: 
	</td>

	<td>
	<strong><? 

	
		$date2=date("m/d/Y",$expiryon);
		$date1=date("m/d/Y");
//		echo $date1 . "              ". $date2;
//	$expiryon=mktime(0,0,0,substr($a1['expiryplan'],5,2),substr($a1['expiryplan'],8,2),substr($a1['expiryplan'],0,4));
//	$today=mktime(0,0,0,substr(date("Y.m.d"),5,2),substr(date("Y.m.d"),8,2),substr(date("Y.m.d"),0,4));
//	echo date("d.m.y",($expiryon - ($expiryon - $today)));
//	$ar1=mysql_fetch_array(mysql_query("Select * from job_plan where PlanName=\"$a1[plan]\" "));
//	echo $ar1[numdays];
	if (dateDiff("/", $date2, $date1) == 0)  
		echo "Today.";	
	else 
		echo dateDiff("/", $date2, $date1) . " days.";
	?> </strong>
	<input type="hidden" name="exdays1" value="<?=dateDiff("/", $date2, $date1)?>">
<!--	<select name=exdays1>
          <option value="7">7</option>
          <option value="14">14</option>
          <option value="21">21</option>
          <option value="28">28</option> -->
        </select>
 
	</td>
	</tr>


	<tr>
	<td align=left>&nbsp;	</td>
	
	<td align=left>
	  <input type=submit name=submit value="Post this job">
	  <input type=submit name=reset2 value=Reset>
	</td>
	</tr>
</table>
</form>
<?
}
}
else
{
include "pay10.php";
}







?>

<? include_once('../foother.html'); ?>




<?
		function dateDiff($dformat, $endDate, $beginDate)
		{
		$date_parts1=explode($dformat, $beginDate);
		$date_parts2=explode($dformat, $endDate);
		$start_date=gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
		$end_date=gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
		return $end_date - $start_date;
		}
?>