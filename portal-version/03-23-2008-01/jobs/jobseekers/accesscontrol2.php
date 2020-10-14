<?php

session_start();

require_once "../conn.php";
include_once "../main.php";

if(!isset($uname) && !isset($upass)) {
  ?>
  <body bgcolor="#FFFFFF">

  <h1><font face=arial color=#000000>JobSeekers  Login  </h1>
  <p>You must log in to access this area of the site.<br> If you are
     not a registered user, <a href="jobseeker_registration.php" style="text-decoration:none; color:#000000"><b>click here</b></a>
     to sign up.</p>
  <p><form name=jsl method="post" action="<?=$PHP_SELF?>"  style="background:none;">
<table width="446" cellpadding="5" cellspacing="0" border="0" align="center" bgcolor="#FFFFFF">
<tr>
	<td width="103">Username:</td>
	<td width="323" align=left> <input type="text" name="uname" size="8" style="border-color:black"></td>
</tr>

<tr>
	<td width="103">Password:</td>
	<td align=left><input type="password" name="upass" SIZE="8" style="border-color:black"></td>
</tr>

<tr align="center">
<td width="103">&nbsp;</td>
	<td align="left">
	<input type=hidden name=job_id value="<?=$job_id?>">
	<input type="submit" value=" Login " style="border-width:1; border-color:black; font-family:verdana; font-weight:normal; color:#000000; background-color: #e0e7e9"></td>
</tr>

<tr><td colspan=2 align=center> <a class=TN href=forgot.php> Forgot your username/password? </a></td></tr>
</table>
  </form></p>
  </center>
  <?php
  include ("../foother.html");
  exit;
}



session_register("uname");
session_register("upass");


$sql = "SELECT * FROM job_seeker_info WHERE
        uname = '$uname' AND upass = '$upass'";
$result = mysql_query($sql);
if (!$result)
{
  error("A database error occurred while checking your ".
        "login details.\\nIf this error persists, please ".
        "contact $email_address");
}

elseif (mysql_num_rows($result) == 0) {
  session_unregister("uname");
  session_unregister("upass");
  ?>
  <table width="446"><tr><td>
  <font face=verdana>
  <h1> Access Denied </h1>
  <p>Your user ID or password is incorrect, or you are not a
     registered user on this site.<br><br> To try logging in again, click
     <a href="<?=$PHP_SELF?>">here</a>. <br><br>To register for instant
     access, click <a href="jobseeker_registration.php">here</a>.</p>
	</td></tr></td></table>
  <?php
   include ("../foother.html");
  exit;
}

?>