<?
include_once "accesscontrol.php";
include_once "navigation2.htm";


if(isset($submit) && $submit == "Search by name")
{
$q1 = "select * from job_seeker_info where $name_type like '%$name%'  order by $name_type";
$r1 = mysql_query($q1);
if (!$r1)  
{
	echo '<table align=center width=446 cellspacing=0 border=0><tr><td><center><br><br><br>Select <b>order by </b> option </center></td></tr></table>';
	include ("../foother.html");
	exit;
}
	

	if(mysql_num_rows($r1) == '0')
	{
		echo "<table align=center width=446 cellspacing=0><tr><td><center><br><br><br> No results. </center></td></tr></table>";
		include("../foother.html");
	exit;
	}

echo "<br><br><table align=center width=400 cellspacing=0>\n";
echo "<tr bgcolor=6699cc style=\"font-family:arial; font-weight:bold; color:white\">\n <td>Username </td> <td> Name </td><td>Resume</td><td align=center>Delete  </td></tr>";
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

echo "<tr bgcolor=\"$col\"><td> $a1[uname] </td><td><a class=TN href=\"preview.php?uname=$a1[uname]\"> $a1[fname] $a1[lname] </a></td>";
if ($a1[isupload]==1) 
	echo "<td><a href=\"../jobseekers/$a1[resume]\">Download</a></td>";
else
	echo "<td>N/A</td>";
echo "<td align=center><a class=TN href=\"ADR.php?uname=$a1[uname]\">resume</a>/<a class=TN href=\"ADU.php?uname=$a1[uname]\">user </a></td></tr>";
}

echo "</table>\n";
include ("../foother.html");
exit;
}

elseif(isset($submit) && $submit == "List users")
{
if (!$ByPage) $ByPage=25;  
if (!$Start) $Start=0; 

$q1 = "select * from job_seeker_info  order by $order_type   limit $Start,$ByPage";
$r1 = mysql_query($q1);
if (!$r1) 
{
	echo '<table align=center width=446 cellspacing=0><tr><td><center><br><br><br>Select <b>order by </b> option </center></td></tr></table>';
	include ("../foother.html");
	exit;
}

echo "<br><br><table align=center width=400 cellspacing=0>\n";
echo "<tr bgcolor=6699cc style=\"font-family:arial; font-weight:bold; color:white\">\n <td>Username </td> <td> Name </td><td align=center>Delete  </td></tr>";
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

echo "<tr bgcolor=\"$col\"><td> $a1[uname] </td><td><a class=TN href=\"javascript:popUp('preview.php?uname=$a1[uname]')\"> $a1[fname] $a1[lname] </a></td> <td align=center><a class=TN href=\"ADR.php?uname=$a1[uname]\">resume</a>/<a class=TN href=\"ADU.php?uname=$a1[uname]\">user </a></td></tr>";
}

echo "</table>\n";



$cp = "select count(uname) from job_seeker_info";
$rcp = mysql_query($cp) or die (mysql_error());
$ap = mysql_fetch_array($rcp);
$a = $ap[0];

echo "<table width=446 align=center cellspacing=0><tr>";

if ($a <= $ByPage && $Start == '0')
{

}

elseif ($a > $Start + $ByPage && $Start + $ByPage >= $a || $Start == 0 )
{
	$nom = $Start + $ByPage;
	echo "<td align=right><a class=TN href=\"jobseekers.php?submit=$submit&order_type=$order_type&Start=$nom\">next</a></td>";
}
elseif ( ($Start < $a && $Start > $ByPage) || ($Start + $ByPage >= $a))
{
	$nom1 = $Start - $ByPage;
	echo "<td align=left><a class=TN href=\"jobseekers.php?submit=$submit&order_type=$order_type&Start=$nom1\">previous</a></td>";
}
else
{
	$nom1 = $Start - $ByPage;
	echo "<td align=left><a class=TN href=\"jobseekers.php?submit=$submit&order_type=$order_type&Start=$nom1\">previous</a></td>";	
	$nom = $Start + $ByPage;
	echo "<td align=right><a class=TN href=\"jobseekers.php?submit=$submit&order_type=$order_type&Start=$nom\">next</a></td>";
}

echo "</tr></table>";


include ("../foother.html");


exit;
}



?>

<br><br><br>
<form method=post style="background:none;">
<table align=center width=400>
<tr>
	<td colspan=2 align=center><b>Explore Jobseekers database </b><br><br></td>
</tr>

<tr>
	<td valign=top>Search for a Jobseeker by first name, last name or username</td>
	<td><font size=2><input type=text name=name><br>
	      <input type=radio name=name_type value="fname">First name<br>
	      <input type=radio name=name_type value="lname">Last name<br>
	      <input type=radio name=name_type value="uname">Username<br>
	      <input type=submit name=submit value="Search by name">
	</td>
</tr>
<tr><td colspan=2></td></tr>
<tr>
	<td valign=top>Give me a list of all the Jobseekers order by:</td>
	<td><font size=2>
	      <input type=radio name=order_type value="fname">First name<br>
	      <input type=radio name=order_type value="lname">Last name<br>
	      <input type=radio name=order_type value="uname">Username<br>
	      <input type=submit name=submit value="List users">
	</td>
</tr>
<tr><td colspan=2></td></tr>
</table>
</form>
<? include_once('../foother.html'); ?>