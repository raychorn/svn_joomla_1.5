<?
include_once "../main.php";
?>
<SCRIPT LANGUAGE="JavaScript">
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=yes,location=0,statusbar=0,menubar=0,resizable=yes,width=600,height=400,left = 100,top = 50');");
}
</script>



<SCRIPT LANGUAGE="JavaScript">

function checkFields() {
missinginfo = "";

if (document.form.Sk_d.value == "") {
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
<form method=post action="<?=$PHP_SELF?>" name="form" onSubmit="return checkFields();"  style="background:none;">
<table align=center width=446 border="0">
<caption align=left><a href="javascript:popUp('preview.php')"> Preview </a> </caption>
<tr>
	<td valign=top>
	<b>Skills: </b><br>
	<font size=1>(describe your skills - languages, courses,
	seminars, etc.)	&nbsp;To insert new row, use &lt;BR&gt;<br>
	</font>
	<center><textarea name=SK_d rows=6 cols=46></textarea></center>
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
