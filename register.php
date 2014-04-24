<?php 
require 'dev.php';
$login= $_POST['login'];
$firstname= $_POST['firstname'];
$lastname= $_POST['lastname'];
$mail= $_POST['mail'];
$password= $_POST['password'];

$val= $client->api('user')->create(array(
    'login'     => 'test',
    'firstname' => 'test',
    'lastname'  => 'rest',
    'mail'      => 'test@rest.com',
   'password'   => 'secret'
));
if ($val== true) {
   echo "success!";
} else echo "failed!!";

// if(isset($_POST["create"])) {
// 	$_POST = array('login'=> '','firstname' => '','lastname'  => '','mail' => '','password'=> '');
	
// 	// if($_POST['login'] && $_POST['firstname'] && $_POST['lastname'] && $_POST['mail'] && $_POST['password']){
// 		echo "Successfully created!!";	
// 	// } else echo "again!!";
 
// }
// if(isset($_POST["create"])) {
// 	$id= $_POST['id'];
// 	$uname= $_POST['uname'];
// 	$email= $_POST['email'];
// 	$password= $_POST['password'];
// 	$conpassword= $_POST['conpassword'];
//     if($password==$conpassword){
// 		$sql="INSERT INTO `imeet_wp`.`register` (`id`, `uname`, `email`, `password`, `conpassword`) VALUES ('$id','$uname','$email','$password','$conpassword')";
// 		$result=mysql_query($sql,$conn) or die(mysql_error());
	
// 		if($result){
// 			echo "Account Successfully Created.";
// 		} else{echo "Failure!";}
// 	}else {echo "Password doesn't match.";}
// }

?>