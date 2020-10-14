<?
include_once "accesscontrol.php";
?>

<SCRIPT LANGUAGE="JavaScript">

function checkFields() {
missinginfo = "";

if (document.form.E_i.value == "") {
missinginfo += "\n     -  Institution";
}
if (document.form.E_gr.value == "") {
missinginfo += "\n     -  Education Level";
}
if (document.form.ESmonth.value == "") {
missinginfo += "\n     -  Start date / Month";
}
if (document.form.ESday.value == "") {
missinginfo += "\n     -  Start date / Day";
}
if (document.form.ESyear.value == "") {
missinginfo += "\n     -  Start date / Year";
}
if (document.form.EEmonth.value == "") {
missinginfo += "\n     -  End date / Month";
}
if (document.form.EEday.value == "") {
missinginfo += "\n     -  End date / Day";
}
if (document.form.EEyear.value == "") {
missinginfo += "\n     -  End date / Year";
}
if (document.form.E_d.value == "") {
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
</head>
<body>
<form method=post action=EEAdd2.php   name=form onSubmit="return checkFields();"  style="background:none;">
<table align=center width="446">
<tr>
	<td colspan=2 align=center>
	<b>Education#<?=$En?></b>
	</td>
</tr>

<tr>
	<td>
	<b>Education Institution: </b> 
	</td>

	<td>
	<input type=text name=E_i size=27>
	</td>
</tr>

<tr>
	<td>
	<b>Education level: </b>
	</td>
	
	<td>
	<select name="E_gr" style="width:169">
	<option value=""> Select </option>
	<OPTION VALUE="Student (High School)">Student (High School)</OPTION>
	<OPTION VALUE="Collage">Collage</OPTION>
	<OPTION VALUE="Bachelor"> Bachelor </OPTION>
	<OPTION VALUE="Master"> Master </OPTION>	
	<OPTION VALUE="Ph D">Ph D</OPTION>
	</select>
	</td>
</tr>

<tr>
	<td>
	<b>Start date: </b>
	</td>

	<td>
	<select name=ESmonth>
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

	<select name=ESyear>
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
	<select name=EEmonth>
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

	<select name=EEyear>
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
	<textarea name=E_d rows=6 cols=50></textarea>
	</td>
</tr>

<tr>
	<td>
	</td>
	<td>
	<input type=submit name=submit value="Save and go to Step 3 (SKills)">
	<input type=hidden name=En value=<?=$En?>><br>
<br>
<input type=submit name=submit value="Save changes and add another">
	<input type=hidden name=En value=<?=$En?>>
	
	</td>

</table>
</form>
<? include_once('../foother.html'); ?>