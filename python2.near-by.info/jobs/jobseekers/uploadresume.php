<?
include_once "accesscontrol2.php";
if ($_GET['d']==1 && $_GET['f'] != "")
{
	mysql_query("update job_seeker_info set isupload=0, resume='0' where uname=\"$uname\" ") or die(mysql_error());
	@unlink($_GET['f']);
}

if (isset($_POST['up']))
{
		$uploaddir = 'resumes/';
		$uploadfile = $uploaddir . $uname . "_" . $_FILES['userfile']['name'];
//		echo $uploadfile;
		$pos1 = strpos(strtolower($uploadfile), ".pdf");
		$pos2 = strpos(strtolower($uploadfile), ".doc");
		$pos3 = strpos(strtolower($uploadfile), ".zip");
		$pos4 = strpos(strtolower($uploadfile), ".rar");
		if ($pos1 != 0 || $pos2 != 0 || $pos3 != 0 || $pos4 != 0)
		{
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) 
			{
				mysql_query("update job_seeker_info set isupload=1, resume='$uploadfile' where uname=\"$uname\" ") or die(mysql_error());
				echo "<table width=446><tr><td><center><br><br>File is valid, and was successfully uploaded.<br><br></center></tr></td></table>";
				include_once('../foother.html');
				exit();
			} 
			else 
			{
				print "<table width=446><tr><td><center><br><br>Possible file upload attack! Cannot upload\n</center></tr></td></table>";
				include_once('../foother.html');
				exit();
			}
		}
		else
		{
				print "<table width=446><tr><td><center><br><br>Only files with following extensions are allowed: .PDF, .DOC, .ZIP, .RAR\n</center></tr></td></table>";
//				include_once('../foother.html');
//				exit();
		}
}

$r=mysql_query("select isupload,resume from job_seeker_info where uname=\"$uname\" ");
$r2=mysql_fetch_object($r);
if ($r2->isupload==1)
{?>
	<table width=446 bgcolor="#FFFFFF">
	<tr><td><center><br><br>Resume already Uploaded</center></tr></td>
	<tr><td><center><br><a href="<?=$r2->resume?>">Download Resume</a>&nbsp;|&nbsp;<a href="<?=$PHP_SELF . "?d=1&f=" . $r2->resume?>">Delete Resume</a></center></tr></td>
	</table>
<?	
	include_once('../foother.html');
	exit();
}

?>

<br><br>
<form action="<?=$PHP_SELF?>" method="post" enctype="multipart/form-data"  style="background:none;">
<table align = center width="446" bgcolor="#FFFFFF">
<tr>
	<td colspan=2 align=center><b> Upload your Resume</b></td>
</tr>

<tr>
  <td width="127" height="26" align=center>Upload your resume</td>
  <td width="307" height="26"><input name="userfile" type="file" />
    &nbsp;</td>
  <input type="hidden" value="1" name="up">
</tr>
<tr>
	<td align=left><br><font size=1 face=verdana>&nbsp; </font></td>
    <td align=left><input name="submit" type="submit" style="border-width:1; border-color:black; font-family:verdana; font-weight:normal; color:#000000; background-color:#e0e7e9" value="Upload">
      <br>
</td>
</tr>
</table>
</form>
<? include_once('../foother.html'); ?>