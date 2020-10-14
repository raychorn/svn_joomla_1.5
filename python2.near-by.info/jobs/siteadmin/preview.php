<?
include_once "accesscontrol.php";
include_once "navigation2.htm";
if(isset($SubmitTitle))
{
	if(!empty($_POST[NewTitle]))
	{
		$qt = "update job_seeker_info set rTitle = \"$_POST[NewTitle]\" where uname = \"$_GET[uname]\"";
		$rqt = mysql_query($qt) or die(mysql_error());
		unset($_GET[action]);
	}
	else
	{
		echo "<center><forn color=red><b> You forgot to enter the new title.</b></font> </center>";
	}
}





if($_GET[action] == 'EditTitle')
{
?>
	<form method=post style="background:none;">
	<center>Enter the new title: <input type=text name=NewTitle size=50 value="<?=$_GET[title]?>"><input type=submit name=SubmitTitle value=submit></form></center>
	</form>
<?
}

if(isset($SubmitPar))
{
	if(!empty($_POST[NewParagraph]))
	{
		$qp2 = "update job_seeker_info set rPar = \"$_POST[NewParagraph]\" where uname = \"$_GET[uname]\"";
		$rqp2 = mysql_query($qp2) or die(mysql_error());
		unset($_GET[action]);
	}
	else
	{
		echo "<center><forn color=red><b> You forgot to enter the new paragraph.</b></font> </center>";
	}
}



if($_GET[action] == 'EditParagraph')
{
	$qp1 = "select rPar from job_seeker_info where uname =\"$_GET[uname]\" ";
	$rqp1 = mysql_query($qp1) or die(mysql_error());
	$aqp1 = mysql_fetch_array($rqp1);
?>
	<form method=post style="background:none;">
	<center>Enter the new paragraph: <textarea wors=4 cols=30 name=NewParagraph><?=$aqp1[0]?></textarea><input type=submit name=SubmitPar value=submit></form></center>
	</form>
<?
}

if(isset($SubmitPersonal))
{
	if(!empty($_POST[NewFN]) && !empty($_POST[NewLN]) && !empty($_POST[NewPhone]) && !empty($_POST[NewEmail]) && !empty($_POST[NewAddress]) && !empty($_POST[NewCity]) && !empty($_POST[NewZip]))
	{
		if($_POST[NEWcl] == 'Student (High School)')
		{
			$clnumber = 1;
		}
		elseif($_POST[NEWcl] == 'Student (undergraduate/graduate)')
		{
			$clnumber = 2;
		}
		elseif($_POST[NEWcl] == 'Entry Level (less than 2 years of experience)')
		{
			$clnumber = 3;
		}
		elseif($_POST[NEWcl] == 'Mid Career (2+ years of experience)')
		{
			$clnumber = 4;
		}
		elseif($_POST[NEWcl] == 'Management (Manager/Director of Staff)')
		{
			$clnumber = 5;
		}
		elseif($_POST[NEWcl] == 'Executive (SVP, EVP, VP)')
		{
			$clnumber = 6;
		}
		elseif($_POST[NEWcl] == 'Senior Executive (President, CEO)')
		{
			$clnumber = 7;
		}


	$qp = "update job_seeker_info set
		fname = 	\"$_POST[NewFN]\",
		lname = \"$_POST[NewLN]\",
		bmonth = \"$_POST[NEWbm]\",
		bday = \"$_POST[NEWbd]\",
		byear = \"$_POST[NEWby]\",
		phone = \"$_POST[NewPhone]\",
		phone2 = \"$_POST[NewPhone2]\",
		job_seeker_email = \"$_POST[NewEmail]\",
		address = \"$_POST[NewAddress]\",
		city = \"$_POST[NewCity]\",
		zip = \"$_POST[NewZip]\",
		country = \"$_POST[NewCountry]\",
		state = \"$_POST[NewState]\",
		careerlevel = \"$clnumber\"

		where uname = \"$_POST[uname]\"";	

	$rqp = mysql_query($qp) or die(mysql_error());

	$qp2 = "update job_careerlevel set clnumber = \"$clnumber\", clname = \"$_POST[NEWcl]\" where uname = \"$_POST[uname]\" ";
	$rqp2 = mysql_query($qp2) or die(mysql_error());

	unset($_GET[action]);
	}
	
}


if($_GET[action] == 'EditPersonal')
{
?>
	<form method=post style="background:none;">
	<table align=center width=446>
	<tr><td>First name: </td><td><input type=text name=NewFN value="<?=$_GET[fname]?>"></td></tr>
	<tr><td>Last name: </td><td><input type=text name=NewLN value="<?=$_GET[lname]?>"></td></tr>
	<tr><td>
	Birth day: </td><td>
	<select name=NEWbd>
	<?
	for($i = 1; $i <= 31; $i++)
	{
		if($i == $_GET[bday])
		{
			echo "<option value=$i selected> $i </option>\n";
		}
		else
		{
			echo "<option value=$i> $i </option>\n";
		}
	}
	?>
	</select>
	</td></tr>
	<tr><td>
	Birth month: </td><td>
	<select name=NEWbm>
	<?
	for($m = 1; $m <= 12; $m++)
	{
		if($m == $_GET[bmonth])
		{
			echo "<option value=$m selected> $m </option>\n";
		}
		else
		{
			echo "<option value=$m> $m </option>\n";
		}
	}
	?>
	</select>
	</td></tr>
	<tr><td>
	Birth year:</td><td> 
	<select name=NEWby>
	<?
	$y = date('Y');
	for($i = $y; $i >= 1920; $i--)
	{
		if($i == $_GET[byear])
		{
			echo "<option value=$i selected> $i </option>\n";
		}
		else
		{
			echo "<option value=$i> $i </option>\n";
		}
	}
	?>
	</select>
	</td></tr>
	<tr><td>Phone: </td><td><input type=text name=NewPhone value="<?=$_GET[phone]?>"></td></tr>
	<tr><td>Phone 2: </td><td><input type=text name=NewPhone2 value="<?=$_GET[phone2]?>"></td></tr>
	<tr><td>Email: </td><td><input type=text name=NewEmail value="<?=$_GET[job_seeker_email]?>"></td></tr>
	<tr><td>Address: </td><td><input type=text name=NewAddress value="<?=$_GET[address]?>"></td></tr>
	<tr><td>City: </td><td><input type=text name=NewCity value="<?=$_GET[city]?>"></td></tr>
	<tr><td>Zip: </td><td><input type=text name=NewZip value="<?=$_GET[zip]?>"></td></tr>
	<tr><td>Country: </td><td>
	<select name=NewCountry>
	<?
	$countries = array('Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antartica', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaidjan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia-Herzegovina', 'Botswana', 'Bouvet Island', 'Brazil', 'British Indian Ocean Territory', 'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos (Keeling) Islands', 'Colombia', 'Comoros', 'Congo', 'Cook Islands', 'Costa Rica', 'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Falkland Islands', 'Faroe Islands', 'Fiji', 'Finland', 'Former USSR', 'France',                 'France (European Territory)', 'French Guyana', 'French Southern Territories', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe (French)', 'Guam', 'Guatemala', 'Guinea', 'Guinea Bissau', 'Guyana', 'Haiti', 'Heard and McDonald Islands', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Israel', 'Italy', 'Ivory Coast', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique (French)', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia', 'Moldavia', 'Monaco', 'Mongolia', 'Montserrat', 'Morocco', 'Mozambique', 'Myanmar, Union of (Burma)', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'Netherlands Antilles', 'Neutral Zone', 'New Caledonia (French)', 'New Zealand', 	  'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'North Korea', 'Northern Mariana Islands', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn Island', 'Poland', 'Polynesia (French)', 'Portugal', 'Qatar', 'Reunion (French)', 'Romania', 'Russian Federation', 'Rwanda', 'S. Georgia & S. Sandwich Islands', 'Saint Helena', 'Saint Kitts & Nevis Anguilla', 'Saint Lucia', 'Saint Pierre and Miquelon', 'Saint Tome and Principe', 'Saint Vincent & Grenadines', 'Samoa', 'San Marino', 'Saudi Arabia', 'Senegal', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Korea', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Svalbard and Jan Mayen Islands', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Tadjikistan', 'Taiwan', 'Tanzania', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 'Tuvalu',   'Uganda', 'UK', 'Ukraine', 'United Arab Emirates', 'Uruguay', 'US', 'USA Minor Outlying Islands', 'Uzbekistan', 'Vanuatu', 'Vatican City', 'Venezuela', 'Vietnam', 'Virgin Islands (British)', 'Virgin Islands (USA)', 'Wallis and Futuna Islands', 'Western Sahara', 'Yemen', 'Yugoslavia', 'Zaire', 'Zambia', 'Zimbabwe');
		
	$cn = count($countries) - 1;
	for($i = 0; $i <= $cn; $i ++)
	{
		if($countries[$i] == $_GET[country])
		{
		echo "<option value=\"$countries[$i]\" selected> $countries[$i] </option>\n";
		}
		else
		{
		echo "<option value=\"$countries[$i]\"> $countries[$i] </option>\n";
		}
	}
	?>
	</select>
	</td></tr>
	<tr><td>
	State: </td><td>
	<select name=NewState>
	<?
	$states = array('Not in US', 'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'District of Columbia', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Puerto Rico', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virgin Islands', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming');
	$nst = count($states) - 1;

	for($i = 0; $i <= $nst; $i++)
	{
		if($states[$i] == $_GET[state])
		{
			echo "<option value=\"$states[$i]\" selected> $states[$i] </option>";
		}
		else
		{
			echo "<option value=\"$states[$i]\"> $states[$i] </option>";
		}
	}
	?>		
	</select>
	</td></tr>
	<tr><td>
	Career level: </td><td>
	<select name=NEWcl>
	<?
	$career = array('Student (High School)', 'Student (undergraduate/graduate)', 'Entry Level (less than 2 years of experience)', 'Mid Career (2+ years of experience)', 'Management (Manager/Director of Staff)', 'Executive (SVP, EVP, VP)', 'Senior Executive (President, CEO)');
	$cn = count($career) - 1;	

	for($c = 0; $c <= $cn; $c++)
	{
		if($career[$c] == $_GET[careerlevel])
		{
			echo "<option value=\"$career[$c]\" selected> $career[$c] </option>";
		}
		else
		{
			echo "<option value=\"$career[$c]\"> $career[$c] </option>";
		}
	}
	
	?>
	</select>
	</td></tr>
	<tr><td colspan=2 align=center>
	<input type=hidden name=uname value="<?=$_GET[uname]?>">
	<input type=submit name=SubmitPersonal value=Submit></td></tr>
	</table>
	</font>
<?	
}

if(isset($SubmitWork))
{
	if(!empty($_POST[NEWp]))
	{
	$d1 = "$_POST[StartM]"."/"."$_POST[StartY]";
	$d2 = "$_POST[EndM]"."/"."$_POST[EndY]";

		$qw = "update job_work_experience set WE_p = \"$_POST[NEWp]\", WE_d = \"$_POST[NewDesc]\", WE_Start = \"$d1\", WE_End = \"$d2\" where uname = \"$_POST[uname]\" and WEn = \"$_POST[wenumber]\"";
		$rqw = mysql_query($qw) or die(mysql_error());

		unset($_GET[action]);
	}
}

if($_GET[action] == 'EditWE')
{

	$qw = "select * from job_work_experience where uname = \"$_GET[uname]\" and WEn = \"$_GET[we]\" ";
	$rqw = mysql_query($qw) or die(mysql_error());
	$awe = mysql_fetch_array($rqw);
	?>
	
	<form method=post style="background:none;">
	<table align=center width=400>
	<tr>
		<td colspan=2>Work experience # <?=$_GET[we]?> </td>
	</tr>
	<tr>
		<td>Position: </td>
		<td><input type=text name=NEWp value="<?=$awe[WE_p]?>"> </td>
	</tr>	
	<tr>
		<td>From date: </td>
		<td>
		<select name=StartM>
		<?
		$date1 = explode("/", $awe[WE_Start]);

		$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		for($m = 0; $m <=12; $m++)
		{
			if($date1[0] == $months[$m])
			{
				echo "<option value=$months[$m] selected> $months[$m] </option>";
			}
			else
			{
				echo "<option value=$months[$m]> $months[$m] </option>";
			}
		}
		echo "</select>\n <select name=StartY>";
		for($y = date(Y); $y >= 1920; $y--)
		{
			if($date1[2] == $y)
			{
				echo "<option value=$y selected> $y </option>";
			}
			else
			{
				echo "<option value=$y> $y </option>";
			}
		}
		echo "</select></td></tr>";
		?>
<tr>
		<td>To date: </td>
		<td>

		<?
		$date2 = explode("/", $awe[WE_End]);
		echo "<select name=EndM>";
		$months = array('Present', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		for($m = 0; $m <=12; $m++)
		{
			if($date2[0] == $months[$m])
			{
				echo "<option value=$months[$m] selected> $months[$m] </option>";
			 }
			else
			{
				echo "<option value=$months[$m]> $months[$m] </option>";
			}
		}
		echo "</select>\n  ";

		$ay = array();
		for($y = date(Y); $y >= 1920; $y--)
		{
			$ay[] = $y;
		}

		$ay[0] = 'Present';
		$ayn = count($ay) - 1;
		echo "<select name=EndY>\n";
				
		for($y2 = 0; $y2 <= $ayn; $y2++)
		{
			if($date2[2] == $ay[$y2])
			{
				echo "<option value=$ay[$y2] selected> $ay[$y2] </option>";
			}
			else
			{
				echo "<option value=$ay[$y2]> $ay[$y2] </option>";
			}
		}

		echo "</select></td></tr>";
		?>
<tr>
	<td valign=top>Description: </td>
	<td><textarea rows=6 name=NewDesc cols=40><?=$awe[WE_d]?></textarea>
</tr>
<tr><td align=center colspan=2>
<input type=hidden name=uname value="<?=$_GET[uname]?>">
<input type=hidden name=wenumber value="<?=$_GET[we]?>">
<input type=submit name=SubmitWork value=Submit></td></tr>
</table>
</form>

<?	
}


if(isset($SubmitEducation))
{
	$d_start = "$_POST[StartM]"."/"."$_POST[StartY]";
	$d_end = "$_POST[EndM]"."/"."$_POST[EndY]";

	$que = "update job_education set E_i = \"$_POST[NewIns]\", E_Start = \"$d_start\", E_End = \"$d_end\", E_gr = \"$_POST[EduGR]\", E_d = \"$_POST[NewDesc]\" where uname = \"$_POST[uname]\" and En = \"$_POST[EduN]\" ";
	$rue = mysql_query($que) or die(mysql_error());

	unset($_GET[action]);
}


if($_GET[action] == 'EditEducation')
{

	$qe1 = "select * from job_education where uname = \"$_GET[uname]\" and En = \"$_GET[EduN]\" ";
	$re1 = mysql_query($qe1) or die(mysql_error());
	$ae1 = mysql_fetch_array($re1);
?>
	<form method=post style="background:none;">
	<table align=center width=446>
	<tr>
		<td> Education Institution: </td>
		<td> <input type=text name=NewIns value="<?=$ae1[E_i]?>">
	</tr>

	<tr>
		<td> Graduate Level: </td>
		<td>
		<select name=EduGR>
		<?
			$ared = array('Student (High School)', 'College', 'Bachelor', 'Master', 'Ph D');
			for($e = 0; $e <= 4; $e++)
			{
				if($ared[$e] == $ae1[E_gr])
				{
				echo "<option value=\"$ared[$e]\" selected> $ared[$e] </option>";
				}
				else
				{
				echo "<option value=\"$ared[$e]\"> $ared[$e] </option>";
				}
			}
		?>
		</select></td>
	</tr>
	<tr>
		<td>From date: </td>
		<td>
		<select name=StartM>
		<?
		$date1 = explode("/", $ae1[E_Start]);

		$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		for($m = 0; $m <=12; $m++)
		{
			if($date1[0] == $months[$m])
			{
				echo "<option value=$months[$m] selected> $months[$m] </option>";
			}
			else
			{
				echo "<option value=$months[$m]> $months[$m] </option>";
			}
		}
		echo "</select>\n <select name=StartY>";
		for($y = date(Y); $y >= 1920; $y--)
		{
			if($date1[2] == $y)
			{
				echo "<option value=$y selected> $y </option>";
			}
			else
			{
				echo "<option value=$y> $y </option>";
			}
		}
		echo "</select></td></tr>";
		?>


<tr>
		<td>To date: </td>
		<td>

		<?
		$date2 = explode("/", $ae1[E_End]);
		echo "<select name=EndM>";
		$months = array('Present', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		for($m = 0; $m <=12; $m++)
		{
			if($date2[0] == $months[$m])
			{
				echo "<option value=$months[$m] selected> $months[$m] </option>";
			 }
			else
			{
				echo "<option value=$months[$m]> $months[$m] </option>";
			}
		}
		echo "</select>\n ";

		$ay = array();
		for($y = date(Y); $y >= 1920; $y--)
		{
			$ay[] = $y;
		}

		$ay[0] = 'Present';
		$ayn = count($ay) - 1;
		echo "<select name=EndY>\n";
				
		for($y2 = 0; $y2 <= $ayn; $y2++)
		{
			if($date2[2] == $ay[$y2])
			{
				echo "<option value=$ay[$y2] selected> $ay[$y2] </option>";
			}
			else
			{
				echo "<option value=$ay[$y2]> $ay[$y2] </option>";
			}
		}

		echo "</select></td></tr>";

		?>
	<tr>
		<td> Description: </td>
		<td><textarea rows=6 cols=40 name=NewDesc><?=$ae1[E_d]?></textarea></td>
	</tr>
	<tr>
		<td colspan=2 align=center>
		<input type=hidden name=EduN value="<?=$_GET[EduN]?>">
		<input type=hidden name=uname value="<?=$_GET[uname]?>">
		<input type=submit name=SubmitEducation value=Submit>
		</td>
	</tr>
	</table>
	</form>

<?

}

if(isset($ss))
{
	$sk2 = "update job_skills set SK_d = \"$_POST[NewSK]\" where uname = \"$_POST[uname]\" ";
	$rsk2 = mysql_query($sk2) or die(mysql_error());

	unset($_GET[action]);
}

if($_GET[action] == 'EditSkills')
{
	$qsk = "select * from job_skills where uname = \"$_GET[uname]\" ";
	$rsk = mysql_query($qsk) or die(mysql_error());
	$ask = mysql_fetch_array($rsk);
	
	?>
	<form method=post style="background:none;">
	<center>
	Skills:<br><textarea rows=6 cols=40 name=NewSK><?=$ask[SK_d]?></textarea><br>
	<input type=hidden name=uname value="<?=$_GET[uname]?>">
	<input type=submit name=ss value=Submit>
	</center>
	</form>
	<?
}



$q = "select * from job_seeker_info where uname = \"$uname\"";
$r = mysql_query($q) or die(mysql_error());
$a = mysql_fetch_array($r);

$q1 = "select * from job_work_experience where uname = \"$uname\" order by WEn desc ";
$r2 = mysql_query($q1) or die(mysql_error());

$q3 = "select clname from job_careerlevel where uname = \"$uname\"";
$r3 = mysql_query($q3) or die(mysql_error());
$a3 = mysql_fetch_array($r3);

?>

<table width=400 align=center cellpadding=0>
<caption align=center><b><? echo "$a[rTitle] </b><br><center> <a href=\"preview.php?action=EditTitle&title=$a[rTitle]&uname=$uname\"> edit title </a> &nbsp; / &nbsp;<a href=preview.php?action=EditParagraph&uname=$uname> edit paragraph </a></center><p align=left><font size=2 style=\"font-weight:normal\"> $a[rPar] </font></p>"; ?> 
</caption>
<tr>
<td colspan=2>
<center>
<?
	echo "<a href=\"preview.php?action=EditPersonal&uname=$uname&fname=$a[fname]&lname=$a[lname]&bmonth=$a[bmonth]&bday=$a[bday]&byear=$a[byear]&phone=$a[phone]&phone2=$a[phone2]&job_seeker_email=$a[job_seeker_email]&address=$a[address]&country=$a[country]&city=$a[city]&zip=$a[zip]&state=$a[state]&careerlevel=$a3[0]\">"; 
?>
	edit personall information </a>
	</center>
</td>
</tr>
<tr>
<td valign=top>
	
	<table width=400 align=center  cellspacing=0 border=0 bordercolor=black>		
		<tr>
		<td width="133">
		<b>Name:</b>
		</td>
		<td  width=309 valign=top>
		<? echo "$a[fname] $a[lname]"; ?>
		</td>
		</tr>

		<tr>
		<td>
		<b>Age: </b>
		</td>
		<td  valign=top>
		<?
		if((date(m) > $a[bmonth]) || (date(m) == $a[bmonth] && date(d) < $a[bday]))
		{
		    echo date(Y) - $a[byear];
		}
		else
		{
		  echo date(Y) - $a[byear] - 1;
		}
		?>

		</td>
		</tr>


		<tr>
		<td>
		<b>Phone:</b>
		</td>
		<td  valign=top>
		<? echo "$a[phone] \n $a[phone2]"; ?>
		</td>
		</tr>

		<tr>
		<td>
		<b>E-mail: </b>
		</td>
		<td >
		<?= $a[job_seeker_email]?>
		</td>
		</tr>
	</table>
</td>
</tr>
<tr>
<td valign=top>
	<table align=center width=400  cellpadding=0 cellspacing=0 border=0 bordercolor=black>

	<tr>
	<td colspan=2><b> Address: </b></td>
	</tr>

	<tr>
	<td  colspan=2>
	<?=$a[address]?>
	</td>
	</tr>

	<tr>
	<td><b> Country: </b></td>
	<td >
	<?=$a[country]?>	
	</td>
	</tr>

	<tr>
	<td><b>City/Zip 
	<? 
	if(!empty($a[state]) && $a[state] != 'Not in US')
	{
		echo "/State";
	}
	?>
	</b></td>
	<td > <?=$a[city]?>/<?=$a[zip]?> 
	<?
	if(!empty($a[state]) && $a[state] != 'Not in US')
	{
		echo "/$a[state]";
	}
	?>

	</td>
	</td>
	</tr>
	</table>
</td>
</tr>
</table>

<table align=center width=400 border = 0 bordercolor=black  cellspacing=0>
<tr>
	<td>Career level </td>
	<td > <?=$a3[0]?> </td>
</tr>
</table>


<?

echo "<br><br><br>";
while ($a1 = mysql_fetch_array($r2))
{
	echo "
	<table align=center width=400 border=0 bordercolor=black cellspacing=0 cellpadding=0>
	<caption>
	<font size=2> Work experience# $a1[WEn] </font><br><a href=preview.php?action=EditWE&we=$a1[WEn]&uname=$uname> edit </a>
	</caption>
	<tr>
		<td colspan=4><b>&nbsp; Position: </b> $a1[WE_p] </td>
	</tr>

	<tr>
		<td><b>&nbsp; From date</b></td>
		<td><b>&nbsp; To date</b></td>
	</tr>
	<tr>
		<td >&nbsp;$a1[WE_Start]</td>
		<td >&nbsp;$a1[WE_End]</td>
	</tr>
	<tr>
	<td colspan=4>
			<table cellspacing=0 width=100%>
			<tr>
			
			<td valign=top bgcolor=white>
			<b>&nbsp; Description: </b>
			</td>
			</tr>

			<tr>
			<td >
			$a1[WE_d] 
			</td>
			
			</tr>
			</table>
		</td>
	</td>
	</tr>
	</table><br>
	";	
}


$q1 = "select * from job_education where uname = \"$uname\" order by En asc ";
$r2 = mysql_query($q1) or die(mysql_error());


echo "<br><br><br>";
while ($a1 = mysql_fetch_array($r2))
{
	echo "
	<form action=EditEducation.php method=post style=\"background:none;\">
	<table align=center width=400 border=0 bordercolor=black cellspacing=0 cellpadding=0>
	<caption>
	<font size=2> Education# $a1[En] </font><br><a href=preview.php?action=EditEducation&EduN=$a1[En]&uname=$uname> edit</a>
	</caption>
	</form>
	<tr>
		<td colspan=4><b>&nbsp; Education Institution: </b>";  echo stripslashes($a1[E_i]); echo "</td>
	</tr>

	<tr>
		<td>&nbsp; Graduate Level </td>
		<td  width=100><b>&nbsp; From date </b></td><td width=185 >&nbsp; $a1[E_Start] </td>
	</tr>
	<tr>

		<td > &nbsp; $a1[E_gr] </td>
		<td width=100><b>&nbsp; To date </b></td><td width=185 >&nbsp; $a1[E_End] </td>
	</tr>
	<tr>
	<td colspan=4>
			<table cellspacing=0 width=100%>
			<tr>
			
			<td valign=top bgcolor=white>
			<b>&nbsp; Description: </b>
			</td>
			</tr>

			<tr>
			<td >
			$a1[E_d] 
			</td>
			
			</tr>
			</table>
		</td>
	</td>
	</tr>
	</table><br>
	";	
}


$q4 = "select * from job_skills where uname = \"$uname\" ";
$r4 = mysql_query($q4) or die(mysql_error());

while($a4 = mysql_fetch_array($r4))
{
$aaa = stripslashes($a4[SK_d]);

	echo "
	<table align=center width=446 border=0 bordercolor=black cellspacing=0>
	<caption><b>My additional skills </b><br> <a href=preview.php?action=EditSkills&uname=$uname> edit </a></caption>

	<tr>
	<td colspan=2> $aaa </td>
	</tr>
	</table>	

";

}

?>
<table width=446><tr><td>&nbsp;</td></tr></table>
<? include_once('../foother.html'); ?>