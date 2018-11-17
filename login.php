<html>
<body>
<style>
.error {color: #FF0000;}
</style>

<?php
include("credentials.php");

$result = $conn->query("select * from config");
$row = $result->fetch_assoc();

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$nameErr=$passErr=$name=$password=$genError="";
	$success = false;
		
	if(empty($_POST["txtUsername"])){
		$nameErr = "Name is required";
	} 
	else{
		$name = $_POST["txtUsername"];
	}
	if(empty($_POST["txtPassword"])){
		$passErr = "Password is required";
	}
	else{
		$password = $_POST["txtPassword"];
	}

	$stmt = $conn->prepare("select username,password from credentials where username=? and password=password(?)");
	$stmt->bind_param("ss",$name,$password);
	$stmt->execute();
	$stmt->bind_result($resultUsername,$resultPassword);
	while($stmt->fetch()){
		$success = true;
	}
	if($success){
		session_start();
		$_SESSION['username'] = $name;
		if($_SESSION['username'] == "admin"){
			header("location:adminFilter.php");
		}
		else{
			if($row['stage'] == 3){
				$tempResult = $conn->query("select shortlisted from application where username='".$_SESSION['username']."'");
				$tempRow = $tempResult->fetch_assoc();
				include("header.php");
				if($tempRow['shortlisted'] == 1){
					exit("<center><h2>Congratulations! You have been shortlisted. Written test will be conducted at Hyatt, Mumbai.</h2></center>");
				}
				else{
					exit("<center><h2>Sorry. Candidature is not accepted. Please participate in next recruitment drive.</h2></center>");
				}
			}
			header("location:application.php");
		}
		
	}
    else if($nameErr == "" && $passErr == ""){
       	$genError = "Please enter a valid username and password";
    }
}
		
?>
<?php include("header.php");

if($row['stage'] == 0){
	exit("<center><h2>Online application submission not started yet. Kindly visit on or after ".$row['startDate']."</h2></center>");
}
else if($row['stage'] == 2){
	exit("<center><h2>Online application submission is over. Shortlisting is in progress.</h2></center>");
}
?>
<br><br>
<form method="POST" action="login.php">
<table border="1" cellspacing="0" align="center" cellpadding="10">
	<tr>
		<td>
			<table align="center">
<tr>
	<td colspan="2" class="header">Login</td>
</tr>
<tr>
<td valign="top">Username</td>
<td><input type="text" name="txtUsername" id="username"/><br>
	<span class="error"> <?php 
		if(isset($nameErr) && $nameErr != "") echo $nameErr;?></span>
</td>
</tr>
<tr>
<td valign="top">Password</td>
<td><input type="password" name="txtPassword" id="password"/><br>
	<span class="error"><?php 
	if(isset($passErr) && $passErr != "") echo $passErr;?></span>
</td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" name="submit" value="Submit"></td>
</tr>
<tr>
	<td colspan="3"><?php if(isset($genError) && $genError != "") echo $genError; ?></td>
</tr>
</table>
		</td>
	</tr>
</table>

</form>
</body>
</html>