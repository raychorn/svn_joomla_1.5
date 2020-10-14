<?

session_start();
session_unset("ename");
session_unset("epass");
session_unregister("ename");
session_unregister("epass");
session_destroy();


setcookie("ename","", "0", "/", "", ""); 
setcookie("epass","", "0", "/", "", ""); 

?>

<html>
<head>
<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../index.php">
</head>
</html>