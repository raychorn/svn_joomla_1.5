<?
include "accesscontrol.php";
include "navigation2.htm";

$q1 = "select * from job_employer_info where ename = \"$ename\" ";
$r1 = mysql_query($q1) or die(mysql_error());
$a1 = mysql_fetch_array($r1);

?>

<html>
<head>
<title>Company profile for <?=$a1[CompanyName]?></title>
</head>
<body>
<br><br><br><font face=verdana size=2>
<table align=center cellspacing=2 cellpadding="2" border=0 bordercolor=black width=446>
<caption align=center><b>Company profile for <?=$a1[CompanyName]?> </b><br><br></caption>
<tr>
	<td  width=180><b> Company: </b></td>
	<td> <?=$a1[CompanyName]?> </td>
</tr>

<tr>
	<td ><b> Country: </b></td>
	<td> <?=$a1[CompanyCountry]?> </td>
</tr>

<tr>
	<td ><b> City/State/Zip: </b></td>
	<td> <? 
		echo "$a1[CompanyCity]/";
		if(!empty($a1[CompanyState]))
		{
		echo "$a1[CompanyState]/";
		}
		echo "$a1[CompanyZip]";
	       ?>
	 </td>
</tr>

<tr>
	<td ><b> Address: </b></td>
	<td> <?=$a1[CompanyAddress]?> </td>
</tr>

<tr>
	<td ><b> Phone/Phone2: </b></td>
	<td> <?
		echo "$a1[CompanyPhone]";
		if(!empty($a1[CompanyPhone2]))
		{
		echo "/$a1[CompanyPhone2]";
		}
	       ?> 
	</td>
</tr>

<tr>
	<td ><b> Email: </b></td>
	<td> <a href=sm.php?email=<?=$a1[CompanyEmail]?>> <?=$a1[CompanyEmail]?> </a> </td>
</tr>

<tr>
	<td ><b> Posting plan: </b></td>
	<td> <?
		if(!empty($a1[plan]))
		{
		echo "$a1[plan]";
		}
		else
		{
		echo "not selected yet";
		}
	       ?>
	 </td>
</tr>

<tr>
	<td ><b> This employer can view: </b></td>
	<td> <?=$a1[JS_number]?> resume(s)</td>
</tr>

<tr>
	<td ><b> This employer can post: </b></td>
	<td> <?=$a1[JP_number]?> job offer(s)</td>
</tr>
</table>
<? include_once('../foother.html'); ?>