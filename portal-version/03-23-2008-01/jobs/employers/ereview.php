<?

include_once "../conn.php";

$q = "select * from job_seeker_info where uname = \"$uname\"";
$r = mysql_query($q) or die(mysql_error());
$a = mysql_fetch_array($r);

$q1 = "select * from job_work_experience where uname = \"$uname\" order by WEn desc ";
$r2 = mysql_query($q1) or die(mysql_error());

?>

<html>
<head>
<title> <? echo "$a[fname] $a[lname]'s Resume"; ?> </title>
<style>
body {font-family:verdana}
</style>
</head>
<body>
<a href="javascript:close()">close window</a>
<table width=550 align=center>
<caption align=center><b><? echo "$a[rTitle] <br><p align=left><font size=2 style=\"font-weight:normal\"> $a[rPar] </font></p>"; ?> </b> 
</caption>
<tr>
	<td valign=top>
	<b>Name:</b>
	</td>

	<td  width=175 valign=top>
	<? echo "$a[fname] $a[lname]"; ?>
	</td>

	<td valign=top>
	<b>Address: </b>
	</td>

	<td  valign=top>
	<? echo "$a[address] \n $a[city] - $a[zip]"; if ($a[state] != 'Not in US') {echo $a[state];} ?>
</tr>

<tr>
	<td valign=top>
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

	<td valign=top>
	<b>Country: </b>
	</td>

	<td  valign=top>
	<?=$a[country]?>
	</td>
</tr>

<tr>
	<td valign=top>
	<b>Phone:</b>
	</td>

	<td  valign=top>
	<? echo "$a[phone] \n $a[phone2]"; ?>
	</td>

	<td valign=top>
	<b>E-mail: </b>
	</td>

	<td  valign=top>
	<?= $a[job_seeker_email]?>
	</td>
</tr>

<tr>
	<td valign=top>
	<b> Job category: </b>
	</td>

	<td  valign=top>
	<?=$a[job_category]?>
	</td>

	<td>
	<b>Career level:</b>
	</td>

	<td >
	<?=$a[careerlevel]?>
	</td>
</tr>

<tr>
	<td  colspan=2>
	<b>Willing to relocate?</b>  <?=$a[relocate]?>
	</td>

	
</tr>
</table>


<?
while ($a1 = mysql_fetch_array($r2))
{
	echo "

	<table align=center width=550 border=1 bordercolor=black cellspacing=0 cellpadding=0>
	<caption>Work experience# $a1[WEn] </caption>
	<tr>
		<td colspan=4><b><sup>Position: </b></sup> $a1[WE_p] </td>
	</tr>

	<tr>
		<td  width=80><b><sup>From date: </b></sup></td><td width=150> $a1[WE_Start] </td>
		<td rowspan=2 >
			<table cellspacing=0 width=100%>
			<tr>
			
			<td valign=top bgcolor=white>
			<b><sup>Description: </b></sup
			</td>
			</tr>

			<tr>
			<td >
			$a1[WE_d] 
			</td>
			
			</tr>
			</table>
		</td>
	</tr>
	
	<tr>
		<td><b><sup>To date: </b></sup></td><td > $a1[WE_End] </td>
	</tr>
	</table>
	";	
}


$q3 = "select * from job_education where uname = \"$uname\" order by En asc";
$r3 = mysql_query($q3) or die(mysql_error());

while ($a2 = mysql_fetch_array($r3))
{
	echo "
	<table align=center width=550 border=1 bordercolor=black cellspacing=0>
	<caption>Education# $a2[En] </caption>

	<tr>
	<td width=120><b><sup>Institution: </b></sup></td><td width=190 >  $a2[E_i] </td>
		<td rowspan=4  valign=top>
		
		<table width=100%  cellspacing=0>
		<tr>
		<td bgcolor=white>
		<b><sup> Description: </b></sup> 
		</td>
		</tr>

		<tr>
		<td >
		$a2[E_d] 
		</td>
		
		</tr>
		</table>

		</td>
	</tr>

	<tr>
		<td><b><sup>From date: </b></sup></td><td > $a2[E_Start] </td>
	</tr>
	
	<tr>
		<td><b><sup>To date: </b></sup> </td><td > $a2[E_End] </td>
	</tr>

	<tr><td><b><sup> Graduate level: </b></sup></td><td > $a2[E_gr]</td></tr>
	</table>
	
	";
}


$q4 = "select * from job_skills where uname = \"$uname\" ";
$r4 = mysql_query($q4) or die(mysql_error());

while($a4 = mysql_fetch_array($r4))
{
	echo "
	<table align=center width=550 border=1 bordercolor=black cellspacing=0>
	<caption><b>Skills </b></caption>

	<tr>
	<td colspan=2><b>My additional skills: </b> $a4[SK_d] </td>
	</tr>
	</table>	

";
}


?>
<? include_once('../foother.html'); ?>