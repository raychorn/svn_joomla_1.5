<?

include_once "../conn.php";

?>

<html>
<head>
<title> <?=$site_name?> </title>
<style>

caption {font-family:verdana; font-size:16; color:#000000; font-weight:bold}

body {font-family:verdana; font-size:12}

select {font-family:verdana; font-size:12}

input {font-size:11; border-color:black}

input.s2 {font-size:11; border-color:black; background-color:white; color:051dba; font-weight:bold}

a.NavCol {font-family:verdana; font-size:11; color:white; text-decoration:none}
a.NavCol:hover {text-decoration:underline}

.Nav {text-align:center}

a.ERR {font-family:verdana; font-size:15; color:black; text-decoration:none}
a.ERR:hover {text-decoration:underline}

a {font-family:verdana; font-size:11; font-weight:bold; color:000000; text-decoration:none}
a:hover {text-decoration:underline}

.BRes {font-family:verdana; font-size:10; font-weight:bold; color:white; text-decoration:none}
a.BRes:hover {text-decoration:none; color:orange}

.Pres {color:red}

</style>
<SCRIPT LANGUAGE="JavaScript">
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=yes,location=0,statusbar=0,menubar=0,resizable=yes,width=600,height=400,left = 100,top = 50');");
}
</script>
</head>

<body>

<table align=center bgcolor=#000000 width=500>
<caption align=center> <?=$_SERVER[HTTP_HOST]?> </caption>
<tr>
	<td  class=Nav><a class=NavCol href=employer_registration.php> Registration </a></td>
	<td class=Nav><a class=NavCol href=PostJob.php> Post a job </a> </td>
	<td class=Nav><a class=NavCol href=DeleteJob.php> Manage jobs </a> </td>
	<td class=Nav><a class=NavCol href=EmployerSearch.php> Search  </a></td>
	<td class=Nav><a class=NavCol href=logout.php> Logout </a></td>
</tr>
</table>
