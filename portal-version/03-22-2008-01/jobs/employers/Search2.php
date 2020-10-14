<?

include_once "accesscontrol.php";


$sql = "SELECT plan,JS_number,JP_number,expiryplan FROM job_employer_info WHERE
        ename = '$ename' AND epass = '$epass'";
$result = mysql_query($sql);
$res=mysql_fetch_array($result);
$plan=$res[0];
if ($plan != "") 
{
	$expiryon=mktime(0,0,0,substr($res['expiryplan'],5,2),substr($res['expiryplan'],8,2),substr($res['expiryplan'],0,4));
	$today=mktime(0,0,0,substr(date("Y.m.d"),5,2),substr(date("Y.m.d"),8,2),substr(date("Y.m.d"),0,4));
	if ($today > $expiryon)		
			{
			?>
			<br>
			<table width="446" bgcolor="#FFFFFF"><tr><td>
			  <font face=verdana>
			  <h1> Access Denied </h1>
			  <p><h5>Your package has expired, please renew your Employer Plan to view the resumes <br><br>To register for instant access, click <a href="pay1.php">here</a>.</h5></p>
				 </td></tr></table>
			  <?php
			  include("../foother.html");
			  exit;
			}
}
else
{
?>	
<br>
<h3>Access Denied2</h1>
<table width="446"><tr><td>
  <font face=verdana>
  <h1> Access Denied </h1>
  <p><h5>To access this feature we offer, choose your Employer Plan:
     <br><br>To register for instant
     access, click <a href="pay1.php">here</a>.</h5></p>
	 </td></tr></table>
  <?php
  include("../foother.html");
  exit;
}

$day = date(d);
$month = date(m);
$year = date(Y);
		
$del = "delete from job_post where EXday = \"$day\" and EXmonth = \"$month\" and EXyear = \"$year\" ";
$rdel = mysql_query($del) or die(mysql_error());


$sch = array(); 
if (!empty($_POST[JobCategory])) 
{
$sch[] = "job_category like '%$_POST[JobCategory]%'";
}
if (!empty($_POST[careerlevel])) 
{
$sch[] = "careerlevel = \"$_POST[careerlevel]\" ";
}
if (!empty($_POST[target_company])) 
{
$sch[] = "target_company = \"$_POST[target_company]\" ";
}
if (!empty($_POST[relocate])) 
{
$sch[] = "relocate = \"$_POST[relocate]\" ";
}
if (!empty($_POST[country])) 
{
$sch[] = "country = \"$_POST[country]\" ";
}
if (!empty($_POST[city])) 
{
$sch[] = "city like '%$_POST[city]%'";
}
if (!empty($_POST[state])) 
{
$sch[] = "state = \"$_POST[state]\" ";
}
if (!empty($_POST[kw])) 
{
$sch[] = "rTitle like '%$_POST[kw]%' or rPar like '%$_POST[kw]%' ";
}

if (!$ByPage) $ByPage=5;  
if (!$Start) $Start=0; 

if($_POST[sm] == 'or')
{
$qs = "select * from job_seeker_info ".(($sch)?"where ".join(" or ", $sch):"")." limit $Start,$ByPage";
$qss = "select * from job_seeker_info ".(($sch)?"where ".join(" or ", $sch):"");
}
elseif($_POST[sm] == 'and')
{
$qs = "select * from job_seeker_info ".(($sch)?"where ".join(" and ", $sch):"")." limit $Start,$ByPage";
$qss = "select * from job_seeker_info ".(($sch)?"where ".join(" and ", $sch):"");
}
$rqs = mysql_query($qs) or die(mysql_error());

$rqss = mysql_query($qss) or die(mysql_error());
$rr = mysql_num_rows($rqss);



echo "<table align=center border=0 width=446><tr><td>";
if($rr == '0')
{
	echo "<br><br><center> No results found.</center>";
}
elseif($rr == '1')
{
	echo "<br><br><center> Your search return one result. </center>";
}
elseif($rr > '1')
{
	echo "<br><br><center> Your search return $rr results. </center>";
}
while($as = mysql_fetch_array($rqs))
{
$q3 = "select * from job_careerlevel where uname = \"$as[uname]\" ";
$r3 = mysql_query($q3) or die(mysql_error());
$a3 = mysql_fetch_array($r3);

		if($as[careerlevel] == '0')
		{
			$clname = 'N/A';
		}
		if($as[careerlevel] == '1')
		{
			$clname = 'Student (High School)';
		}
		elseif($as[careerlevel] == '2')
		{
			$clname = 'Student (undergraduate/graduate)';
		}
		elseif($as[careerlevel] == '3')
		{
			$clname = 'Entry Level (less than 2 years of experience)';
		}
		elseif($as[careerlevel] == '4')
		{
			$clname = 'Mid Career (2+ years of experience)';
		}
		elseif($as[careerlevel] == '5')
		{
			$clname = 'Management (Manager/Director of Staff)';
		}
		elseif($as[careerlevel] == '6')
		{
			$clname = 'Executive (SVP, EVP, VP)';
		}
		elseif($as[careerlevel] == '7')
		{
			$clname = 'Senior Executive (President, CEO)';
		}

	echo "<br><table align=center width=420 cellspacing=0 border=0 bordercolor=e0e7e9>
		<tr>
		<td><strong>Name</strong>:</td><td bgcolor=ffffff><a class=TN href=\"EmployerView2.php?uname=$as[uname]&ename=$ename\"> $as[fname] $as[lname] </a></td>
		</tr>

		<tr><td><strong>Career level</strong>: </td>
		<td bgcolor=ffffff> $as[careerlevel] </td></tr>
		<tr>
		<td width=100 valign=top><strong>Prefered jobs</strong>:</td>
		<td bgcolor=ffffff>
		$as[job_category] 
		</td>
		</tr>";
		if ($as["isupload"]==1)
		{
		echo "<tr>
		<td width=100 valign=top>Download Resume</td>
		<td bgcolor=ffffff><a  href=\"http://$_SERVER[HTTP_HOST]/jobseekers/$as[resume]\">Download Now</a></td>
		</tr>";
		}

		echo "</table>";
		
}


if($_POST[sm] == 'or')
{
$qs2 = "select * from job_seeker_info ".(($sch)?"where ".join(" or ", $sch):"");
}
elseif($_POST[sm] == 'and')
{
$qs2 = "select * from job_seeker_info ".(($sch)?"where ".join(" and ", $sch):"");
}
$rqs2 = mysql_query($qs2) or die(mysql_error());
$rr2 = mysql_num_rows($rqs2);

echo "<table align=center width=400><tr>";


	if ($rr2 <= $ByPage && $Start == '0')
	{

	}

	if ( $Start > 0 )
	{
		$nom1 = $Start - $ByPage;
		echo "<td align=left><a class=TN href=\"Search2.php?sm=$sm&JobCategory=$JobCategory&careerlevel=$careerlevel&target_company=$target_company&relocate=$relocate&country=$country&city=$city&kw=$kw&Start=$nom1\">previous</a></td>";
	}

	if ($rr2 > $Start + $ByPage  || ($Start == 0 && $rr2 > $ByPage))
	{
		$nom = $Start + $ByPage;
		echo "<td align=right><a class=TN href=\"Search2.php?sm=$sm&JobCategory=$JobCategory&careerlevel=$careerlevel&target_company=$target_company&relocate=$relocate&country=$country&city=$city&kw=$kw&Start=$nom\">next</a></td>";
	}

echo "</tr></table>";

echo "</td></tr></table>";



?>

<? include_once('../foother.html'); ?>