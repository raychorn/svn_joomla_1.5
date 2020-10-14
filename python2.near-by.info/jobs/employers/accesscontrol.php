<?php

session_start();

require_once "../conn.php";
include_once "../main.php";

if(!isset($ename) && !isset($epass)) {
  ?>
  <h1><font face=arial color=#000000>Employers  Login  </h1>
  <p>You must log in to access this area of the site.<br> If you are
     not a registered user, <a href="employer_registration.php" style="text-decoration:none; color:#000000"><b>click here</b></a>
     to sign up.</p>
  <p><form method="post" action="<?=$PHP_SELF?>"  style="background:none;">
<table width="446" bgcolor="#FFFFFF">
<tr>
	<td width="150">Username:</td>
	<td align=left> <input type="text" name="ename" size="8" style="border-color:black"></td>
</tr>

<tr>
	<td width="150">Password:</td>
	<td align=left><input type="password" name="epass" SIZE="8" style="border-color:black"></td>
</tr>

<tr>
	<td align=right>&nbsp;</td>
    <td align=left><input name="submit" type="submit" style="border-color:black; background-color:#e0e7e9; color:#000000; font-weight:normal" value=" Login "></td>
</tr>

<tr><td align=center></td>
  <td align=left> <a class=TN href=forgot.php> Forgot your username/password? </a>&nbsp;</td>
</tr>

</table>
  </form></p>
  </center>
  <?php
  include("../foother.html");
  exit;
}



session_register("ename");
session_register("epass");


$sql = "SELECT * FROM job_employer_info WHERE
        ename = '$ename' AND epass = '$epass'";
$result = mysql_query($sql);
if (!$result)
{
  echo "A database error occurred while checking your login details. <br>If this error persists, please <br>contact $email_address";
}

elseif (mysql_num_rows($result) == 0) {
  session_unregister("ename");
  session_unregister("epass");
  ?>
  <table width="446"><tr><td>
  <font face=verdana>
  <h1> Access Denied </h1>
  <p>Your user ID or password is incorrect, or you are not a
     registered user on this site.<br><br> To try logging in again, click
     <a href="<?=$PHP_SELF?>">here</a>. <br><br>To register for instant
     access, click <a href="employer_registration.php">here</a>.</p>
	 </td></tr></table>
  <?php
  include("../foother.html");  
  exit;
}

?>