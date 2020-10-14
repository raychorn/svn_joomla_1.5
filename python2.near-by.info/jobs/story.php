<?

include_once "main.php";


if (isset($submit) && !empty($story))
{
	$q1 = "select WS_id from job_story_waiting";
	$r1 = mysql_query($q1)or die(mysql_error());
	$a1 = mysql_num_rows($r1);

	$story_id = $a1 + 1;

$story2 = strip_tags($_POST[story]);

	$q2 = "insert into job_story_waiting set WS_id = \"$story_id\", story = \"$story2\"";
	$r2 = mysql_query($q2) or die(mysql_error());
	
	echo "<table align=center width=446 cellpadding=10><tr><td>Thank you.<br>We will incude your story on the firs page of our site, so every one can read it</td></tr></table>";
}
else
{

?>


<form action="<?=$PHP_SELF?>" method="post"  style="background:none;"> 
<table align=center width="446" cellpadding="10" bgcolor="#FFFFFF">
<tr>
	<td>Tell us your success story while using <b><?=$site_name?> </b></td>
</tr>

<tr>
	<td>
	<textarea name=story rows=6 cols=80></textarea>	
	</td>
</tr>

<tr>
	<td align=center>
	<input type=submit name=submit value=Send>
	</td>
</tr>
</table>
</form>

<?
}
?>
<? include_once('foother.html'); ?>