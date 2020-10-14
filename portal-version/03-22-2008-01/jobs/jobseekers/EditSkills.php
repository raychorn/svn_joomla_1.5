<?
include_once "accesscontrol.php";


$q1 = "select * from job_skills where uname = \"$uname\" ";
$r1 = mysql_query($q1) or die(mysql_error());
$a1 = mysql_fetch_array($r1);

$a11 = stripslashes($a1[SK_d]);
?>


<SCRIPT LANGUAGE="JavaScript">

function checkFields() {
missinginfo = "";

if (document.form.SK_d.value == "") {
missinginfo += "\n     -  Institution name";
}


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
<form method=post action=EditSkills2.php   name=form onSubmit="return checkFields();"  style="background:none;">
<table align=center width=446 bgcolor="#FFFFFF">

<tr>
  <td valign=top align="center"><b>Skills: </b><br>
    <font size=1>(describe your skills - languages, courses, seminars, etc.) To
    insert new row, use &lt;BR&gt; </font></td>
  </tr>
<tr>
	<td valign=top align="center"><textarea name=SK_d rows=6 cols=70><?=$a11?>
    </textarea>  	
	</td>
  </tr>

<tr>
	<td align=center>
	<input type=submit name=submit value="Save and finish">
	</td>
</tr>
</table>
</form>

<? include_once('../foother.html'); ?>