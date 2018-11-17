<?php
session_start();
include('credentials.php');
if(!isset($_SESSION['username'])){
	header("location:new.php");
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$valid = true;
	$errorString = "";
	$username = $_SESSION['username'];
	if($_FILES["fileToUpload"]["size"] > 5000000){
		$errorString = "Photo size limit exceeded";
		$valid = false;
	}
	$targetFile = "uploads/".$_SESSION['username'].".jpeg";
	if($valid){
		move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile);

		$stmt = $conn->prepare("update application set path=? where username='$username'");
		$stmt->bind_param("s",$targetFile);
		$stmt->execute();
	}
	
}
$result = $conn->query("select path from application where username='".$_SESSION['username']."'");
$row = $result->fetch_assoc();
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="styles/recruitment.css">
</head>
<body>
<table align="center" cellspacing="0" border="1" cellpadding="10">
		<tr>
			<td>

				<table>
					<tr>
						<td class="header">Upload Photo</td>
					</tr>
					<tr>
						<td>
							<form method="POST" action="photoUpload.php" enctype="multipart/form-data">
							Select image to upload(Limit 5MB):<br>
							<input type="file" name="fileToUpload"/><span id="imgError">
								<?php if(isset($errorString) && $errorString != "") echo $errorString; ?></span><br>
							<input type="submit" value="Upload Image"/>
							<img width="150" height="150" 
							src="<?php echo $row['path']; ?>" alt="No File Selected"></img>
						</form>
						</td>
					</tr>
				</table>

</td>
</tr>
</table>
</body>
</html>