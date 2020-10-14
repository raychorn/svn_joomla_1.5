<?

session_start();
session_unset("aid");
session_unset("apass");
session_unregister("aid");
session_unregister("apass");
session_destroy();


setcookie("aid","", "0", "/", "", ""); 
setcookie("aid","", "0", "/", "", ""); 



?>

<html>
<head>
<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../index.php">
</head>
</html>