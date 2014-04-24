<?php
include ("config.php");
// users is table what we created at the register tutorial!

if(mysql_num_rows(mysql_query("SELECT * FROM register where id ='".$_POST['id']."' and password ='".$_POST['password']."'"))==1){
// session_register("id"); //If matches, creates session!
session_start("id");
$_SESSION['id']=$id;
// echo "Success!";
header('Location: index.php'); //Will lead to index.php!
}
else {
   echo "Wrong username or password!";
}
?> 

