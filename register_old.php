<?php

// if(isset($_POST["submit"])) {
// 	$id=$_POST['id'];
// 	$uname=$_POST['uname'];
// 	$email=$_POST['email'];
// 	$password=$_POST['password'];
// 	$conpassword=$_POST['conpassword'];

// 	$conn=mysql_connect('localhost', 'imeet_wp', 'lKhe5#aiuy8Yt') _error());
//     mysql_select_db('imeet_wp') or die("cannot select DB");
//     $query=mysql_query("SELECT * FROM register WHERE id= '"$id"'");
//     $numrows=mysql_num_rows($query);
//     if($numrows==0)
//     {
//     	$sql="INSERT INTO `register` (`id`, `uname`, `email`, `password`, `conpassword`) VALUES ('$_POST[id]','$_POST[uname]','$_POST[email]','$_POST[password]','$_POST[conpassword]')";
//     	$result=mysql_query($sql);

//     	if($result){
//     		echo"Account Successfully Created";
//     	} else {echo "Failure!";}
//     } else {echo "Exits!";}

// }


// if($_POST["id"] && $_POST["uname"] && $_POST["email"] && $_POST["password"] && $_POST["conpassword"] )
if(isset($_POST["create"]))
{
	$id= $_POST['id'];
	$uname= $_POST['uname'];
	$email= $_POST['email'];
	$password= $_POST['password'];
	$conpassword= $_POST['conpassword'];
	
	// if($_POST["password"]==$_POST["conpassword"])
	//  {
	 	$servername="localhost";
		$username="imeet_wp";
		$conn= mysql_connect("localhost", "imeet_wp", "lKhe5#aiuy8Yt")or die(mysql_error());
		mysql_select_db("imeet_wp",$conn);
		$sql="INSERT INTO `imeet_wp`.`register` (`id`, `uname`, `email`, `password`, `conpassword`) VALUES ('$id','$uname','$email','$password','$conpassword')";
		$result=mysql_query($sql,$conn) or die(mysql_error());
		print "<h1>you have registered sucessfully</h1>";

		print "<a href='index.php'>go to login page</a>";
	 // }
	 //    else print "password doesn't match";
}
else print"invalid data";
?>