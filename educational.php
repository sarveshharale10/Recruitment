<?php
session_start();
include('credentials.php');
include('validate.php');

if(!isset($_SESSION['username'])){
		header("location:new.php");
}

if($_SERVER['REQUEST_METHOD'] == "POST"){

	$valid = true;

	$username = $_SESSION['username'];

	$university = $_POST['txtDUniversity'];
	$instituteName = $_POST['txtDCollege'];
	$yearOfPassing = intval($_POST['txtDYear']);
	$percentage = $_POST['txtDPercent'];
	$percentage = doubleval($percentage);

	if($valid){
		$stmt = $conn->prepare("update education set university=?,institute=?,yearOfPassing=?,percentage=? where username='".$_SESSION['username']."' and exam='Degree'");
		$stmt->bind_param("ssid",$university,$instituteName,$yearOfPassing,$percentage);
		$stmt->execute();
	}

	$university = $_POST['txtHUniversity'];
	$instituteName = $_POST['txtHCollege'];
	$yearOfPassing = intval($_POST['txtHYear']);
	$percentage = $_POST['txtHPercent'];
	$percentage = doubleval($percentage);

	if($valid){
		$stmt = $conn->prepare("update education set university=?,institute=?,yearOfPassing=?,percentage=? where username='".$_SESSION['username']."' and exam='HSC'");
		$stmt->bind_param("ssid",$university,$instituteName,$yearOfPassing,$percentage);
		$stmt->execute();
	}

	$university = $_POST['txtSUniversity'];
	$instituteName = $_POST['txtSCollege'];
	$yearOfPassing = intval($_POST['txtSYear']);
	$percentage = $_POST['txtSPercent'];
	$percentage = doubleval($percentage);

	if($valid){
		$stmt = $conn->prepare("update education set university=?,institute=?,yearOfPassing=?,percentage=? where username='".$_SESSION['username']."' and exam='SSC'");
		$stmt->bind_param("ssid",$university,$instituteName,$yearOfPassing,$percentage);
		$stmt->execute();
	}


}

$result = $conn->query("select * from education where username='".$_SESSION['username']."' and exam='SSC'");
$rowSsc = $result->fetch_assoc();

$result = $conn->query("select * from education where username='".$_SESSION['username']."' and exam='HSC'");
$rowHsc = $result->fetch_assoc();

$result = $conn->query("select * from education where username='".$_SESSION['username']."' and exam='Degree'");
$rowDegree = $result->fetch_assoc();


?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/recruitment.css">
	<script src="js/validate.js"></script>
	<script type="text/javascript">
		function validateForm(){

			var bCollege = document.getElementById("bCollege");
			var bYearPassing = document.getElementById("bYearPassing");
			var bPercent = document.getElementById("bPercent");

			var hCollege = document.getElementById("hCollege");
			var hYearPassing = document.getElementById("hYearPassing");
			var hPercent = document.getElementById("hPercent");

			var sCollege = document.getElementById("sCollege");
			var sYearPassing = document.getElementById("sYearPassing");
			var sPercent = document.getElementById("sPercent");

			if(isEmpty(bCollege.value)){
				document.getElementById("bCollegeError").innerHTML = "Institute name required";
				return false;
			}
			if(isEmpty(bYearPassing.value)){
				document.getElementById("bYearError").innerHTML = "Year of Passing required";
				return false;
			}
			if(isEmpty(bPercent.value)){
				document.getElementById("bPercentError").innerHTML = "Percentage required";
				return false;
			}

			if(isEmpty(hCollege.value)){
				document.getElementById("hCollegeError").innerHTML = "Institute name required";
				return false;
			}
			if(isEmpty(hYearPassing.value)){
				document.getElementById("hYearError").innerHTML = "Year of Passing required";
				return false;
			}
			if(isEmpty(hPercent.value)){
				document.getElementById("hPercentError").innerHTML = "Percentage required";
				return false;
			}

			if(isEmpty(sCollege.value)){
				document.getElementById("sCollegeError").innerHTML = "Institute name required";
				return false;
			}
			if(isEmpty(sYearPassing.value)){
				document.getElementById("sYearError").innerHTML = "Year of Passing required";
				return false;
			}
			if(isEmpty(sPercent.value)){
				document.getElementById("sPercentError").innerHTML = "Percentage required";
				return false;
			}

			return true;
		}
	</script>
</head>
<body>
<form method="POST" action="educational.php" onsubmit="return validateForm()">
<table align="center" cellspacing="0" border="1" cellpadding="10">
		<tr>
			<td>


<table cellpadding="5">
	<tr>
		<td colspan="5" class="header">
			Educational Qualifications
		</td>
	</tr>
	<tr>
		<th>Exam</th>
		<th>University/Board</th>
		<th>Institute</th>
		<th>Year of<br>Passing</th>
		<th>Percentage</th>
	</tr>
	<tr>
		<td>SSC</td>
		<td><input type="text" name="txtSUniversity" id="sUniversity" size="30" maxlength="30"
			value="<?php echo $rowSsc['university']; ?>"/></td>
		<td><input type="text" name="txtSCollege" id="sCollege" size="60" maxlength="60"
			value="<?php echo $rowSsc['institute']; ?>"/></td>
		<td align="center"><input type="text" name="txtSYear" id="sYearPassing" size="4" maxlength="4"
			value="<?php echo $rowSsc['yearOfPassing']; ?>"/></td>
		<td><input type="text" name="txtSPercent" id="sPercent" size="5" maxlength="5"
			value="<?php echo $rowSsc['percentage']; ?>"/></td>
	</tr>
	<tr>
		<td>HSC</td>
		<td><input type="text" name="txtHUniversity" id="hUniversity" size="30" maxlength="30"
			value="<?php echo $rowHsc['university']; ?>"/></td>
		<td><input type="text" name="txtHCollege" id="hCollege" size="60" maxlength="60"
			value="<?php echo $rowHsc['institute']; ?>"/></td>
		<td align="center"><input type="text" name="txtHYear" id="hYearPassing" size="4" maxlength="4"
			value="<?php echo $rowHsc['yearOfPassing']; ?>"/></td>
		<td><input type="text" name="txtHPercent" id="hPercent" size="5" maxlength="5"
			value="<?php echo $rowHsc['percentage']; ?>"/></td>
	</tr>
	<tr>
		<td>Degree</td>
		<td><input type="text" name="txtDUniversity" id="dUniversity" size="30" maxlength="30"
			value="<?php echo $rowDegree['university']; ?>"/></td>
		<td><input type="text" name="txtDCollege" id="dCollege" size="60" maxlength="60"
			value="<?php echo $rowDegree['institute']; ?>"/></td>
		<td align="center"><input type="text" name="txtDYear" id="dYearPassing" size="4" maxlength="4"
			value="<?php echo $rowDegree['yearOfPassing']; ?>"/></td>
		<td><input type="text" name="txtDPercent" id="dPercent" size="5" maxlength="5"
			value="<?php echo $rowDegree['percentage']; ?>"/></td>
	</tr>
	<tr>
		<td colspan="5" align="center"><input type="submit" value="Save"/></td>
	</tr>
	<tr>
		<td colspan="5">
			<span id="sCollegeError"></span><br>
			<span id="sYearError"></span><br>
			<span id="sPercentError"></span><br>
			<span id="hCollegeError"></span><br>
			<span id="hYearError"></span><br>
			<span id="hPercentError"></span><br>
			<span id="dCollegeError"></span><br>
			<span id="dYearError"></span><br>
			<span id="dPercentError"></span>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
</form>
</body>
</html>