<?
include_once "accesscontrol.php";

$q1 = "select * from job_seeker_info where uname = \"$uname\" ";
$r1 = mysql_query($q1) or die(mysql_error());
$a1 = mysql_fetch_array($r1);
?>


<SCRIPT LANGUAGE="JavaScript">

function checkFields() {
missinginfo = "";
if (document.form.rTitle.value == "") {
missinginfo += "\n     -  Resume title";
document.form.rTitle.focus();
}

if (document.form.NewEmail.value == "") {
missinginfo += "\n     -  Your email address";
document.form.NewEmail.focus();
}

if (document.form.NewAddress.value == "") {
missinginfo += "\n     -  Your address";
document.form.NewAddress.focus();
}

if (document.form.NewPhone.value == "") {
missinginfo += "\n     -  Your new phone";
document.form.NewPhone.focus();
}

if (document.form.NewCity.value == "") {
missinginfo += "\n     -  Your City";
document.form.NewCity.focus();
}

if (document.form.NewZip.value == "") {
missinginfo += "\n     -  Zip code";
document.form.NewZip.focus();
}

if (missinginfo != "") {
missinginfo ="_____________________________\n" +
"You failed to correctly fill in:\n" +
missinginfo + "\n_____________________________" +
"\nPlease re-enter and submit again!";
alert(missinginfo);
return false;
}
else return true;
}

</script>


<form action=ER2.php method=post name=form onSubmit="return checkFields();"  style="background:none;">
<table align=center width="446" bgcolor="#FFFFFF">
<tr>
	<td class=RB align=center>
	<b>Title </b><br> <font size=1> choose a title for your resume </font><br>
	<input type=text name=rTitle size=45 value="<?=$a1[rTitle]?>">
	</td>
</tr>

<tr>
	<td class=RB align=center>
	<b>Introduce yourself to the employers</b>
	<br> <font size=1> a short paragraph about you </font><br>
	<textarea cols=80 rows=6 name=rPar><?=$a1[rPar]?></textarea>
	</td>
</tr>

<tr>
	<td>
	<table align=center width=350>
	<tr>
		<td>Email: </td><td><input type=text name=NewEmail value="<?=$a1[job_seeker_email]?>"></td>
	</tr>
	<tr>
		<td>Address: </td><td><input type=text name=NewAddress value="<?=$a1[address]?>"></td>
	</tr>
	<tr>
		<td>Phone: </td><td><input type=text name=NewPhone value="<?=$a1[phone]?>"></td>
	</tr>
	<tr>
		<td>Phone 2: </td><td><input type=text name=NewPhone2 value="<?=$a1[phone2]?>"></td>
	</tr>
	<tr>
		<td>City: </td>
		<td><input type=text name=NewCity value="<?=$a1[city]?>"></td>
	</tr>

	<tr>
		<td>Zip: </td>
		<td><input size=10 type=text name=NewZip value="<?=$a1[zip]?>"></td>
	</tr>
	
	<tr>
		<td>State: </td>
		<td><select name=NewState>
		<?
		$state1 = array('Not in US', 'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'District of Columbia', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Puerto Rico', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virgin Islands', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming');
		
		for($i = 0; $i <= (count($state1) - 1); $i++)
		{
			if(empty($a1[state]))
			{
			echo "<option value=\"$state1[$i]\"> $state1[$i] </option>";
			}
			elseif($state1[$i] == $a1[state])
			{
			echo "<option selected value=\"$state1[$i]\"> $state1[$i] </option>";
			}
			else
			{
			echo "<option value=\"$state1[$i]\"> $state1[$i] </option>";
			}
		}
		?>
		</select>
		</td>
	</tr>
	</table>
	</td>
</tr>

<tr>
	<td align=center>
	<input type=submit name=submit value="Save changes">
	<b> OR </b>
	<input type=submit name=submit value="Go to Step 1 (Work experience)">
	</td>
</tr>
</table>
</form>


</body>

<? include_once('../foother.html'); ?>