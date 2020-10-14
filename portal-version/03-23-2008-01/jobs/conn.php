<?

//	'server'     'database_username'		'database_password' 
$connection = mysql_connect("74.54.166.152", "nearbyin_admin", "peekab00")
 or die (mysql_error());

 //	'database_name' 
 $db = mysql_select_db("nearbyin_pythonjobs", $connection) or die (mysql_error());
?>