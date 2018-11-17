<?php
include('credentials.php');
if($_SERVER['REQUEST_METHOD'] == "GET"){
	$usernameToCheck = $_GET['username'];
	$stmt = $conn->prepare("select username from credentials where username=?");
	$stmt->bind_param("s",$usernameToCheck);
	$stmt->execute();
	$stmt->bind_result($fetchedUsername);
	$stmt->fetch();
	if($fetchedUsername == $usernameToCheck){
		echo "This username is used already.Please select another username.";
	}
	else if($fetchedUsername != $usernameToCheck){
		echo "";
	}
}
?>