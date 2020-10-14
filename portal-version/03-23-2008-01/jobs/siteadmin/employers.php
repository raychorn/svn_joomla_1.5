<?
include_once "accesscontrol.php";
include_once "navigation2.htm";


if(isset($submit))
{
	if($submit == 'Search by name')
	{
	$q1 = "select * from job_employer_info where $_POST[name_type] like '%$_POST[name]%' order by $_POST[name_type]";
	$r1 = mysql_query($q1);
	if (!$r1) 
	{
		echo '<table align=center width=446 cellspacing=0 border=0><tr><td><center><br><br><br>Select <b>order by </b> optionzzzz </center></td></tr></table>';
		include ("../foother.html");
		exit;
	}

		if(mysql_num_rows($r1) == '0')
		{
			echo "<table align=center width=446 cellspacing=0><tr><td><center><br><br><br> No results. </center></td></tr></table>";
			 include_once('../foother.html');
		exit;
		}
	}

	if($submit == 'List users')
	{
	$q1 = "select * from job_employer_info order by $_POST[order_type]";
	$r1 = mysql_query($q1);
		if (!$r1) 
	{
		echo '<table align=center width=446 cellspacing=0 border=0><tr><td><center><br><br><br>Select <b>order by </b> optionzzzz </center></td></tr></table>';
		include ("../foother.html");
		exit;
	}


		if(mysql_num_rows($r1) == '0')
		{
			echo "<table align=center width=446 cellspacing=0 border=0><tr><td><center><br><br><br> No results. </center></td></tr></table>";
			 include_once('../foother.html');
		exit;
		}
	}

echo "<br><br><table align=center width=400 cellspacing=0>\n";
echo "<tr bgcolor=6699cc style=\"font-family:arial; font-weight:bold; color:white; font-size:12\">\n <td>Username </td> <td>Company name / profile</td><td align=center>Action  </td></tr>";
$col = "e0e7e9"; 
while($a1 = mysql_fetch_array($r1))
{
 if($col == "e0e7e9")
	    { 
	     $col = "ffffff"; 
	    }
	         	 else
		{ 
		$col = "e0e7e9"; 
		} 

echo "<tr bgcolor=\"$col\"><td style=\"font-size:12\"> $a1[ename] </td><td><a class=TN href=\"cinfo.php?ename=$a1[ename]\"> $a1[CompanyName] </a></td> <td align=center><a class=TN href=\"ALO.php?ename=$a1[ename]\">list offers</a></td></tr>";
}
?>
</table>
<?
 include_once('../foother.html');
exit;
}

?>



<br><br><br>
<form method=post style="background:none;">
<table align=center width=400>
<tr>
	<td colspan=2 align=center><b>Explore Employers database </b><br><br></td>
</tr>

<tr>
	<td valign=top>Search for an Employer by Company name or username</td>
	<td><font size=2><input type=text name=name><br>
	      <input type=radio name=name_type value="CompanyName">Company name<br>
	      <input type=radio name=name_type value="ename">Username<br>
	      <input type=submit name=submit value="Search by name">
	</td>
</tr>
<tr><td colspan=2></td></tr>
<tr>
	<td valign=top>Give me a list of all the Employers order by:</td>
	<td><font size=2>
	      <input type=radio name=order_type value="CompanyName">Company name<br>
	      <input type=radio name=order_type value="ename">Username<br>
	      <input type=submit name=submit value="List users">
	</td>
</tr>
<tr><td colspan=2></td></tr>
</table>
</form>
<? include_once('../foother.html'); ?>