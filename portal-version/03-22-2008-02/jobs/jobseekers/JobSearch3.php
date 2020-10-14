<?

include_once "../main.php";

$day = date(d);
$month = date(m);
$year = date(Y);
		
$del = "delete from job_post where EXday = \"$day\" and EXmonth = \"$month\" and EXyear = \"$year\" ";
$rdel = mysql_query($del) or die(mysql_error());

$sch = array(); 
if (!empty($position)) 
{
$sch[] = "position like '%$_POST[position]%'";
}
if (!empty($country)) 
{
$sch[] = "CompanyCountry = \"$_POST[country]\" ";
}
if (!empty($state))
{
$sch[] = "CompanyState = '$_POST[state]' "; 
}
if (!empty($JobCategory)) 
{
$sch[] = "JobCategory like '%$_POST[JobCategory]%' "; 
}
if (!empty($careerlevel))
{
$sch[] = "j_target = '$_POST[careerlevel]'"; 
}
if (!empty($kw))
{
$sch[] = "description like '%$_POST[kw]%'"; 
}


if (!$ByPage) $ByPage=25;  
if (!$Start) $Start=0; 

if($sm == 'or')
{
$qs = "select * from job_post ".(($sch)?"where ".join(" or ", $sch):"")." limit $Start,$ByPage";
$qss = "select * from job_post ".(($sch)?"where ".join(" or ", $sch):"");
}
elseif($sm == 'and')
{
$qs = "select * from job_post ".(($sch)?"where ".join(" and ", $sch):"")." limit $Start,$ByPage";
$qss = "select * from job_post ".(($sch)?"where ".join(" and ", $sch):"");
}
$rqs = mysql_query($qs) or die(mysql_error());
$rqss = mysql_query($qss) or die(mysql_error());

$rr = mysql_num_rows($rqss);

if($rr == '0')
{
	echo "<table width=446><tr><td><br><br><center> No results found.</center></td></tr></table>";
	include ("../foother.html");
exit;
}
elseif($rr == '1')
{
	echo "<br><br><center> Your search return one result. </center>";
}
elseif($rr > '1')
{
	echo "<br><br><center> Your search return $rr results. </center>";
}

$col = "cococo"; 

echo "<br><table align=center width=446 cellspacing=0>
	<tr style=\"font-family:arial; color:#000000; font-weight:bold; font-size:11\">
		<td>Position </td><td>Job Category </td><td width=85>Days to expire </td></tr>";

while($as = mysql_fetch_array($rqs))
{
	//$ex13 = date('d', mktime(0,0,0, $as[EXmonth] - date(m), $as[EXday] - date(d),  $as[EXyear] - date(Y)));

	$day = date(d);
	$month = date(m);
	$year = date(Y);

	$EXdate = "$as[EXyear]"."-"."$as[EXmonth]"."-"."$as[EXday]";
	$dnes = "$year"."-"."$month"."-"."$day";

	$qd = "select to_days('$EXdate') - to_days('$dnes')";
	$rqd = mysql_query($qd) or die(mysql_error());
	$ex13 = mysql_fetch_array($rqd);

	 if($col == "FFCC99")
	    { 
	     $col = "FFFFCC"; 
	    }
	         	 else
		{ 
		$col = "FFCC99"; 
		} 
	echo "<tr bgcolor=\"$col\" style=\"font-size:12\">
		<td><a class=TN href=\"JobInfo.php?job_id=$as[job_id]\">  $as[position] </a></td><td> $as[JobCategory] </td><td align=center> $ex13[0] </td>
	        </tr>";
}


if($sm == 'or')
{
$qs2 = "select * from job_post ".(($sch)?"where ".join(" or ", $sch):"");
}
elseif($sm == 'and')
{
$qs2 = "select * from job_post ".(($sch)?"where ".join(" and ", $sch):"");
}
$rqs2 = mysql_query($qs2) or die(mysql_error());
$rr2 = mysql_num_rows($rqs2);

echo "</table>";

echo "<table width=446 align=center><tr>";


	if ($rr2 <= $ByPage && $Start == '0')
	{

	}

	if ( $Start > 0 )
	{
		$nom1 = $Start - $ByPage;
		echo "<td align=left><a class=TN href=\"JobSearch3.php?sm=$sm&position=$position&CompanyCountry=$CompanyCountry&CompanyState=$CompanyState&JobCategory=$JobCategory&careerlevel=$careerlevel&target_company=$target_company&relocate=$relocate&country=$country&city=$city&kw=$kw&Start=$nom1\">previous</a></td>";
	}

	if ($rr2 > $Start + $ByPage  || ($Start == 0 && $rr2 > $ByPage))
	{
		$nom = $Start + $ByPage;
		echo "<td align=right><a class=TN href=\"JobSearch3.php?sm=$sm&position=$position&CompanyCountry=$CompanyCountry&CompanyState=$CompanyState&JobCategory=$JobCategory&careerlevel=$careerlevel&target_company=$target_company&relocate=$relocate&country=$country&city=$city&kw=$kw&Start=$nom\">next</a></td>";
	}

echo "</tr></table>";


?>
<? include_once('../foother.html'); ?>