<?php
define('DBSERVER','localhost');  //Database server
define('DBUSERNAME','root');     // Database username
define('DBPASSWORD', 'root');    // Database password
define('DBNAME', 'todolist');   // Database name

// create connection to MYSQL databse
$conn = mysqli_connect(DBSERVER,DBUSERNAME,DBPASSWORD,DBNAME);

//check the connection
if (!$conn) {
   die("Sorry connection failed: ".mysqli_connect_error());
}

?>