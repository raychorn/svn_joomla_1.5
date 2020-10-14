<?

include_once "accesscontrol.php";
include_once "navigation2.htm";
include_once "navigation.html";
	
$dir="banners/";


if (isset($submitok) && !empty($userfile))
{
   if (empty($burl))
   {
	echo "<center><font face=verdana size=3 color=red><b> You left blank some of the required fields. </b></font></center>";
   }

  $qcbn = "select fn from job_banners_t";
  $rcn = mysql_query($qcbn) or die(mysql_error());
  $arc = mysql_fetch_array($rcn);

	if ($arc[0] == $userfile_name)
	{
	echo "<br><br><center><font face=verdana>Already exist a banner with file name <b>$userfile_name</b><br>Change the name of the new file and try to upload it again. </center>";
	}
	  else
	  {

	  copy($userfile,$dir.$userfile_name);	

	  $qbn = "select * from job_banners_t";
	  $rbn = mysql_query($qbn) or die (mysql_error());
	  $cbn = mysql_num_rows($rbn);

	  $nbn = $cbn + 1;

	  $q2 = "insert into job_banners_t (b_id, fn, burl, alt) values ('$nbn', '$userfile_name', '$burl', '$alt')";
	  $rq2 = mysql_query($q2) or die(mysql_error());
	

	$sb13 = "select count(bc) from job_banners_m";
	$r13 = mysql_query($sb13) or die(mysql_error());
	$ar13 = mysql_fetch_array($r13);

	if($ar13[0] == 0)
	{
	$ubi = "insert into job_banners_m (bc) values ('1') ";
	$rup = mysql_query($ubi) or die(mysql_error());
	}
	else
	{
	$ubi = "update job_banners_m set bc = '1' ";
	$rup = mysql_query($ubi) or die(mysql_error());
	}
           }
}

unset($submitok);
unset($userfile);
?>

<html>
<head>
<title></title>
</head>
<body>
<br><br>
<center>
<table>

<form method=post action=<?=$PHP_SELF?> enctype="multipart/form-data" style="background:none;">
<tr>
	<td  class=TD_links>
	<font face=verdana>URL to the banner target web site:
	</td>

	<td  class=TD_links>
	<input type=text size=36 name=burl value="http://" style="background-color:white; color:051dba; font-weight:bold; font-size:10; border-color:black">
	</td>
</tr>

<tr>
	<td  class=TD_links>
	<font face=verdana>Alt text:</font>
	</td>

	<td  class=TD_links>
	<input type=text name=alt size=36 maxlenght=255 style="background-color:white; color:051dba; font-weight:bold; font-size:10; border-color:black">
	</td>

<tr>
	<td  class=TD_links>
	<font face=verdana>Browse you local HDD:
	</td>
	<td  class=TD_links>
	<input type=file size=25 name="userfile" style="background-color:white; color:051dba; font-weight:bold; font-size:10; border-color:black">
	</td>
</tr>

<tr>
	<td></td>
	<td class=TD_links>
	<input type=submit name="submitok"  value=" Upload  " style="background-color:white; color:051dba; font-weight:bold; font-size:10; border-color:black" disabled>
	</td>
</tr>
</table>
</form>
</center>
</body>
</html>


<? include_once('../foother.html'); ?>