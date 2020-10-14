<?
include_once "accesscontrol.php";

if($submit == 'Delete')
{
	$q = "delete from job_work_experience where uname = \"$uname\" and WEn = \"$WEn\"  ";
	$r = mysql_query($q) or die(mysql_error());

	//$q2 = "select count(WEn) from job_work_experience where uname = \"$uname\" ";
	//$r2 = mysql_query($q2) or die(mysql_error());
	//$a2 = mysql_result($r2, 0, 0);

	$q3 = "select * from job_work_experience where uname = \"$uname\" order by WEn asc ";
	$r3 = mysql_query($q3) or die(mysql_error());
		
	$q4 = "delete from job_work_experience where uname = \"$uname\" ";
	$r4 = mysql_query($q4) or die(mysql_error());	

	while($a3 = mysql_fetch_array($r3))
	{	
		$vn = $vn + 1;
		$q5 = "insert into job_work_experience set
			uname = \"$a3[uname]\", 
			WEn = \"$vn\", 
			WE_Start = \"$a3[WE_Start]\",
			WE_End = \"$a3[WE_End]\",
			WE_p = \"$a3[WE_p]\",
			WE_d = \"$a3[WE_d]\" ";
		
		$r5 = mysql_query($q5) or die(mysql_error());
	}

unset($submit);
include_once "ER3.php";

}

elseif($submit == 'Edit')
{

$qe1 = "select * from job_work_experience where uname = \"$uname\" and WEn = \"$WEn\" ";
$re2 = mysql_query($qe1) or die(mysql_error());
$ae2 = mysql_fetch_array($re2);

?>


<SCRIPT LANGUAGE="JavaScript">

function checkFields() {
missinginfo = "";

if (document.form.WE_p.value == "") {
missinginfo += "\n     -  Position";
}
if (document.form.WSmonth.value == "") {
missinginfo += "\n     -  Start date / Month";
}
if (document.form.WSyear.value == "") {
missinginfo += "\n     -  Start date / Year";
}
if (document.form.WEmonth.value == "") {
missinginfo += "\n     -  End date / Month";
}
if (document.form.WEyear.value == "") {
missinginfo += "\n     -  End date / Year";
}
if (document.form.WE_d.value == "") {
missinginfo += "\n     -  Description";
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
<form method=post action=EditWE2.php   name=form onSubmit="return checkFields();"  style="background:none;">
<table align=center width="446">
<tr>
	<td colspan=2 align=center>
	<b>Work experience #<?=$WEn?></b>
	</td>
</tr>

<tr>
	<td>
	<b>Position: </b> 
	</td>

	<td>
	<input type=text name=WE_p value=<?="$ae2[WE_p]"?> size=27>
	</td>
</tr>

<tr>
	<td>
	<b>Start date: </b>
	</td>

	<td>
	<select name=WSmonth>
	<option value=""> Month </option>
	<option value=January> January </option>
	<option value=February> February </option>
	<option value=March> March </option>
	<option value=April> April </option>
	<option value=May> May </option>
	<option value=June> June </option>
	<option value=July> July </option>
	<option value=August> August </option>
	<option value=September> September </option>
	<option value=October> October </option>
	<option value=November> November </option>
	<option value=December> December </option>
	</select>

	<select name=WSyear>
	<option value=""> Year &nbsp;&nbsp;&nbsp;&nbsp;</option>
	<option value=2002> 2002 </option>
	<option value=2001> 2001 </option>
	<option value=2000> 2000 </option>
	<option value=1999> 1999 </option>
	<option value=1998> 1998 </option>
	<option value=1997> 1997 </option>
	<option value=1996> 1996 </option>
	<option value=1995> 1995 </option>
	<option value=1994> 1994 </option>
	<option value=1993> 1993 </option>
	<option value=1992> 1992 </option>
	<option value=1991> 1991 </option>
	<option value=1990> 1990 </option>
	<option value=1989> 1989 </option>
	<option value=1988> 1988 </option>
	<option value=1987> 1987 </option>
	<option value=1986> 1986 </option>
	<option value=1985> 1985 </option>
	<option value=1984> 1984 </option>
	<option value=1983> 1983 </option>
	<option value=1982> 1982 </option>
	<option value=1981> 1981 </option>
	<option value=1980> 1980 </option>
	<option value=1979> 1979 </option>
	<option value=1978> 1978 </option>
	<option value=1977> 1977 </option>
	<option value=1976> 1976 </option>
	<option value=1975> 1975 </option>
	<option value=1974> 1974 </option>
	<option value=1973> 1973 </option>
	<option value=1972> 1972 </option>
	<option value=1971> 1971 </option>
	<option value=1970> 1970 </option>
	<option value=1969> 1969 </option>
	<option value=1968> 1968 </option>
	<option value=1967> 1967 </option>
	<option value=1966> 1966 </option>
	<option value=1965> 1965 </option>
	<option value=1964> 1964 </option>
	<option value=1963> 1963 </option>
	<option value=1962> 1962 </option>
	<option value=1961> 1961 </option>
	<option value=1960> 1960 </option>
	<option value=1959> 1959 </option>
	<option value=1958> 1958 </option>
	<option value=1957> 1957 </option>
	<option value=1956> 1956 </option>
	<option value=1955> 1955 </option>
	<option value=1954> 1954 </option>
	<option value=1953> 1953 </option>
	<option value=1952> 1952 </option>
	<option value=1951> 1951 </option>
	<option value=1950> 1950 </option>
	<option value=1949> 1949 </option>
	<option value=1948> 1948 </option>
	<option value=1947> 1947 </option>
	<option value=1946> 1946 </option>
	<option value=1945> 1945 </option>
	<option value=1943> 1943 </option>
	<option value=1942> 1942 </option>
	<option value=1941> 1941 </option>
	<option value=1940> 1940 </option>
	<option value=1939> 1939 </option>
	<option value=1938> 1938 </option>
	<option value=1937> 1937 </option>
	<option value=1936> 1936 </option>
	<option value=1935> 1935 </option>
	<option value=1934> 1934 </option>
	<option value=1933> 1933 </option>
	<option value=1932> 1932 </option>
	</select>
	</td>
</tr>

<tr>
	<td>
	<b> End date: </b>
	</td>

	<td>
	<select name=WEmonth>
	<option value=""> Month </option>
	<option value=Present class=Pres> Present </option>
	<option value=January> January </option>
	<option value=February> February </option>
	<option value=March> March </option>
	<option value=April> April </option>
	<option value=May> May </option>
	<option value=June> June </option>
	<option value=July> July </option>
	<option value=August> August </option>
	<option value=September> September </option>
	<option value=October> October </option>
	<option value=November> November </option>
	<option value=December> December </option>
	</select>

	<select name=WEyear>
	<option value=""> Year </option>
	<option value=Present class=Pres>Present </option>
	<option value=2002> 2002 </option>
	<option value=2001> 2001 </option>
	<option value=2000> 2000 </option>
	<option value=1999> 1999 </option>
	<option value=1998> 1998 </option>
	<option value=1997> 1997 </option>
	<option value=1996> 1996 </option>
	<option value=1995> 1995 </option>
	<option value=1994> 1994 </option>
	<option value=1993> 1993 </option>
	<option value=1992> 1992 </option>
	<option value=1991> 1991 </option>
	<option value=1990> 1990 </option>
	<option value=1989> 1989 </option>
	<option value=1988> 1988 </option>
	<option value=1987> 1987 </option>
	<option value=1986> 1986 </option>
	<option value=1985> 1985 </option>
	<option value=1984> 1984 </option>
	<option value=1983> 1983 </option>
	<option value=1982> 1982 </option>
	<option value=1981> 1981 </option>
	<option value=1980> 1980 </option>
	<option value=1979> 1979 </option>
	<option value=1978> 1978 </option>
	<option value=1977> 1977 </option>
	<option value=1976> 1976 </option>
	<option value=1975> 1975 </option>
	<option value=1974> 1974 </option>
	<option value=1973> 1973 </option>
	<option value=1972> 1972 </option>
	<option value=1971> 1971 </option>
	<option value=1970> 1970 </option>
	<option value=1969> 1969 </option>
	<option value=1968> 1968 </option>
	<option value=1967> 1967 </option>
	<option value=1966> 1966 </option>
	<option value=1965> 1965 </option>
	<option value=1964> 1964 </option>
	<option value=1963> 1963 </option>
	<option value=1962> 1962 </option>
	<option value=1961> 1961 </option>
	<option value=1960> 1960 </option>
	<option value=1959> 1959 </option>
	<option value=1958> 1958 </option>
	<option value=1957> 1957 </option>
	<option value=1956> 1956 </option>
	<option value=1955> 1955 </option>
	<option value=1954> 1954 </option>
	<option value=1953> 1953 </option>
	<option value=1952> 1952 </option>
	<option value=1951> 1951 </option>
	<option value=1950> 1950 </option>
	<option value=1949> 1949 </option>
	<option value=1948> 1948 </option>
	<option value=1947> 1947 </option>
	<option value=1946> 1946 </option>
	<option value=1945> 1945 </option>
	<option value=1943> 1943 </option>
	<option value=1942> 1942 </option>
	<option value=1941> 1941 </option>
	<option value=1940> 1940 </option>
	<option value=1939> 1939 </option>
	<option value=1938> 1938 </option>
	<option value=1937> 1937 </option>
	<option value=1936> 1936 </option>
	<option value=1935> 1935 </option>
	<option value=1934> 1934 </option>
	<option value=1933> 1933 </option>
	<option value=1932> 1932 </option>
	</select>
	</td>
</tr>

<tr>
	<td valign=top>
	<b>Description: </b><br><font size=1>(do not use HTML, please) </font>
	</td>

	<td>
	<textarea name=WE_d rows=6 cols=50><?=$ae2[WE_d]?> </textarea>
	</td>
</tr>

<tr>
	<td></td>
	<td align=left>
	<input type=submit name=submit value="Save changes and go back">
	<input type=hidden name=WEn value=<?=$WEn?>>
	</td>

</table>
</form>	
<?
}
unset($submit);
?>
<? include_once('../foother.html'); ?>