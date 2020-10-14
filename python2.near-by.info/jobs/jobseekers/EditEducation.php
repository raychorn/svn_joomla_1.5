<?
include_once "accesscontrol.php";

if($submit == 'Delete')
{
	$q = "delete from job_education where uname = \"$uname\" and En = \"$En\"  ";
	$r = mysql_query($q) or die(mysql_error());

	$q3 = "select * from job_education where uname = \"$uname\" order by En asc ";
	$r3 = mysql_query($q3) or die(mysql_error());
		
	$q4 = "delete from job_education where uname = \"$uname\" ";
	$r4 = mysql_query($q4) or die(mysql_error());	

	while($a3 = mysql_fetch_array($r3))
	{	
		$vn = $vn + 1;
		$q5 = "insert into job_education set
			uname = \"$a3[uname]\", 
			En = \"$vn\", 
			E_i = \"$E_i\",
			E_Start = \"$a3[E_Start]\",
			E_End = \"$a3[E_End]\",
			E_gr = \"$a3[E_gr]\",
			E_d = \"$a3[E_d]\" ";
		
		$r5 = mysql_query($q5) or die(mysql_error());
	}

include_once "ER4.php";

}

elseif($submit == 'Edit')
{

$qe1 = "select * from job_education where uname = \"$uname\" and En = \"$En\" ";
$re2 = mysql_query($qe1) or die(mysql_error());
$ae2 = mysql_fetch_array($re2);

?>

<SCRIPT LANGUAGE="JavaScript">

function checkFields() {
missinginfo = "";

if (document.form.E_i.value == "") {
missinginfo += "\n     -  Institution name";
}
if (document.form.ESmonth.value == "") {
missinginfo += "\n     -  Start date / Month";
}
if (document.form.ESyear.value == "") {
missinginfo += "\n     -  Start date / Year";
}
if (document.form.EEmonth.value == "") {
missinginfo += "\n     -  End date / Month";
}
if (document.form.EEyear.value == "") {
missinginfo += "\n     -  End date / Year";
}
if (document.form.E_gr.value == "") {
missinginfo += "\n     -  Education level";
}
if (document.form.E_d.value == "") {
missinginfo += "\n     -  Description";
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

<form method=post action=EditEE2.php   name=form onSubmit="return checkFields();"  style="background:none;">
<table align=center width="446">

<tr>
	<td colspan=2 align=center>
	<b>Education #<?=$En?></b>
	</td>
</tr>

<tr>
	<td>
	<b>Institution name: </b> 
	</td>

	<td>
	<input type=text name=E_i size=27 value="<? $ae2[E_i] = stripslashes($ae2[E_i]); echo $ae2[E_i]; ?>">
	</td>
</tr>

<tr>
	<td>
	<b>Start date: </b>
	</td>

	<td>
	<select name=ESmonth>
	<option value=""> Month </option>
	<option value=January> January </option>
	<option value=February> February </option>
	<option value=March> March </option>
	<option value=April> April </option>
	<option value=May> May </option>
	<option value=June> June </option>
	<option value=July> July </option>
	<option value=August> August </option>
	<option value=September> September </option>
	<option value=October> October </option>
	<option value=November> November </option>
	<option value=December> December </option>
	</select>


	<select name=ESyear style=width:74>
	<option value=""> Year &nbsp;&nbsp;&nbsp;&nbsp;</option>
<?
for ($i = 2005; $i >= 1932; $i--)
{
echo "	<option value=$i> $i </option>";
}
?>

	</select>
	</td>
</tr>

<tr>
	<td>
	<b> End date: </b>
	</td>

	<td>
	<select name=EEmonth>
	<option value=""> Month </option>
	<option value=Present class=Pres> Present </option>
	<option value=January> January </option>
	<option value=February> February </option>
	<option value=March> March </option>
	<option value=April> April </option>
	<option value=May> May </option>
	<option value=June> June </option>
	<option value=July> July </option>
	<option value=August> August </option>
	<option value=September> September </option>
	<option value=October> October </option>
	<option value=November> November </option>
	<option value=December> December </option>
	</select>



	<select name=EEyear style=width:75>
	<option value=""> Year </option>
	<option value=Present class=Pres>Present </option>
<?
for ($i = 2005; $i >= 1932; $i--)
{
echo "	<option value=$i> $i </option>";
}
?>
	</select>
	</td>
</tr>

<tr>
	<td>
	<b>Education level: </b>
	</td>
	
	<td>
	<select name="E_gr" style=width:174>
	<option value=""> Select </option>
	<OPTION VALUE="Student (High School)">Student (High School)</OPTION>
	<OPTION VALUE="Collage">Collage</OPTION>
	<OPTION VALUE="Bachelor"> Bachelor </OPTION>
	<OPTION VALUE="Master"> Master </OPTION>	
	<OPTION VALUE="Ph D">Ph D</OPTION>
	</select>
	</td>
</tr>

<tr>
	<td valign=top>
	<b>Description: </b><br><font size=1>(do not use HTML, please </font>)
	</td>

	<td>
	<textarea name=E_d rows=6 cols=32><?=$ae2[E_d]?> </textarea>
	</td>
</tr>

<tr>
	<td align=left>&nbsp;	</td>

	<td align=left>
	<input type=submit name=submit value="Save this and go to Step 3 (Skills)"><br>
	<input type=submit name=submit2 value="Save this and add another one">
    <input type=hidden name=En2 value=<?=$En?>>
<input type=hidden name=En value=<?=$En?>>
	
</table>
</form>	
<?
}

?>
<? include_once('../foother.html'); ?>