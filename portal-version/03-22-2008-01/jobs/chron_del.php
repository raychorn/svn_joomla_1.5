<?
include_once "conn.php";

$day = date(d);
$month = date(m);
$year = date(Y);
		
$del = "delete from job_post where EXday = \"$day\" and EXmonth = \"$month\" and EXyear = \"$year\" ";
$rdel = mysql_query($del) or die(mysql_error());

?>