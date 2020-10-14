<?php

session_start();

require_once "../main.php";

if(!isset($aid)) {
  ?>


  <font face="Tahoma, Arial, sans-serif" color="#000000"><strong>Admin  Login</strong>
  <p><form method="post" action="<?=$PHP_SELF?>" style="background:none;">
<table width="446" cellspacing="5">
<tr>
	<td width="150"> Admin ID:</td>
	<td> <input type="text" name="aid" size="8" style="border-color:black"></td>
</tr>

<tr>
	<td width="150">Password:</td>
	<td><input type="password" name="apass" SIZE="8" style="border-color:black"></td>
</tr>

<tr><td>&nbsp;</td>
	<td align=left><input type="submit" value=" Login " style="border-color:black; background-color:#e0e7e9; color:#000000; font-weight:normal"></td>
</tr>
<tr><td colspan=2 align=center> <a class=TN href=forgot.php> Forgot your password? </a></td></tr>
</table>
  </form></p>
  </center>
  <?php
    include ("../foother.html");
  exit;
}



session_register("aid");
session_register("apass");


$sql = "SELECT * FROM job_admin_login WHERE
        aid = '$aid' AND apass = '$apass'";
$result = mysql_query($sql);
if (!$result)
{
  echo "A database error occurred while checking your login details. <br>If this error persists, please contact $email_address";
}

elseif (mysql_num_rows($result) == 0) {
  session_unregister("aid");
  session_unregister("apass");
  ?>
  <table width="446"><tr><td>
    <strong>Access Denied</strong> 
	   <p>Your user ID or password is incorrect, or you are not a
     registered user on this site. To try logging in again, click
     <a href="<?=$PHP_SELF?>">here</a>. </p>
</td></tr></table>
  <?php
  include ("../foother.html");
  exit;
}

?>