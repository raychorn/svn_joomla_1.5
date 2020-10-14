<?
include_once "accesscontrol.php";

if(isset($submit) && $submit == 'Save changes')
{
$rTitle = strip_tags($_POST[rTitle]);
$rPar = strip_tags($_POST[rPar]);
$NC = strip_tags($_POST[NewCity]);
$phone11 = strip_tags($_POST[NewPhone]);
$phone22 = strip_tags($_POST[NewPhone2]);
$NewAddr = strip_tags($_POST[NewAddress]);
$NewMail = strip_tags($_POST[NewEmail]);

if($_POST[NewState] == 'Not in US')
{
	$ns = "";
}
else
{
	$ns = $_POST[NewState];
}

$q1 = "update job_seeker_info set
	rTitle = \"$rTitle\", 
	rPar = \"$rPar\", 
	state = \"$ns\",
	zip = \"$_POST[NewZip]\",
	city = \"$NC\",
	phone = \"$phone11\",
	phone2 = \"$phone22\",
	address = \"$NewAddr\",
	job_seeker_email = \"$NewMail\"

	where uname = \"$uname\" ";

$r1 = mysql_query($q1) or die(mysql_error());

include "ER3.php";

}
elseif(isset($submit) && $submit == 'Go to Step 1 (Work experience)')
{
include "ER3.php";
}

?>