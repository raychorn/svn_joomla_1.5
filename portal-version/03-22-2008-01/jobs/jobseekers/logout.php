<?

session_start();
session_unset("uname");
session_unset("upass");
session_unregister("uname");
session_unregister("upass");
session_destroy();


setcookie("uname","", "0", "/", "", ""); 
setcookie("upass","", "0", "/", "", ""); 


?>

<html>
<head>
<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../index.php">
</head>
</html>