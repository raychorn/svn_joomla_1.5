<?

include_once "accesscontrol.php";

$qs = "select rTitle from job_seeker_info where uname = \"$uname\" ";
$rs = mysql_query($qs) or die(mysql_error());
$as = mysql_fetch_array($rs);

if(!empty($as[0]))
{
	echo "<table width=446><tr><td><br><br><center> You already had posted your resume.<br>If you want to edit it, click <a href=ER1.php>here </a></center></td></tr></table>";
}
else
{
?>

<html>
<head>
<title> <?=$site_name?> </title>
<SCRIPT LANGUAGE="JavaScript">

function checkFields() {
missinginfo = "";
if (document.form.rTitle.value == "") {
missinginfo += "\n     -  Resume titie";
document.form.rTitle.focus();
}

if (missinginfo != "") {
missinginfo ="Choose a title for your resume.";
alert(missinginfo);
return false;
}
else return true;
}

</script>


<br>

<table align=center width=446>
<tr>
	<td>
	There are only three easy steps to build your powerfull resume:
	<ul>
	<li><b> Work experience. </b> Enter all your jobs - previous and presents. Let the employers know what you already done before and let they estimate your experience.</li>
	<li><b> Education. </b> Enter the information about your education. Start from Highschool and finish with the university. You may choose as many education instittution as you need.</li>
	<li><b> Skills. </b> You have some additional skills? They help you to work most successfull and easy to comunicate with people? You must be proud. Let the employers know this. </li>
	</ul>
	</td>
</td>

<tr>
	<td>
	Start building your resume now. Choose the resume title and write a short paragraph about you.
	</td>
</tr>

<tr>
<form action=1.php method=post  name=form onSubmit="return checkFields();"  style="background:none;">
	<td align=center>
	<b>Title </b><font size=1> (choose a title for your resume, 2 - 3 words)</font><br>
	<input type=text name=rTitle size=35>
	</td>
</tr>

<tr>
	<td align=center>
	Introduce yourself to the employers
	<font size=1> (a short paragraph about you) </font><br>
	<textarea cols=46 rows=4 name=rPar></textarea>
	</td>
</tr>
<tr><td align=center><input type=submit value="Go to Step 1 (Work experience)"></td></tr>
</form>
</table>	

<?
}
?>
<? include_once('../foother.html'); ?>