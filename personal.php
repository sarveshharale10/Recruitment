<?php
session_start();
include('credentials.php');
include('validate.php');
include('getStates.php');

if(!isset($_SESSION['username'])){
	header("location:new.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$valid = true;

	$username = $_SESSION['username'];
	$fatherName = $_POST['txtFatherName'];
	$motherName = $_POST['txtMotherName'];
	$dob = $_POST["txtDob"];
	$address = $_POST['txtAddress'];
	$gender = $_POST["selectGender"];
	$state = $_POST['selectState'];
	$city = $_POST['selectCity'];

	$gender = ($gender=="Male")?"M":"F";

	if(isEmpty($fatherName)){
		$valid = false;

	}
	if(isEmpty($dob)){
		$valid = false;
	}
	if(isEmpty($address)){
		$valid = false;
	}

	if($valid){
		$stmt = $conn->prepare("update application set fatherName=?,motherName=?,dateOfBirth=?,gender=?,address=?,state=?,city=?,stage=2 where username='".$_SESSION['username']."'");
		$stmt->bind_param("sssssss",$fatherName,$motherName,$dob,$gender,$address,$state,$city);
		$stmt->execute();
	}

}
$result = $conn->query("select * from application where username='".$_SESSION['username']."'");
$row = $result->fetch_assoc();

?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/recruitment.css">
	<script src="js/validate.js"></script>
	<script type="text/javascript">
		function getCities(){
			var stateSelect = document.getElementById("state");
			var stateName = stateSelect.options[stateSelect.selectedIndex].value;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
        	if(this.readyState == 4 && this.status == 200){
            		document.getElementById("spanCity").innerHTML = this.responseText;
       			}
    		};
			xhttp.open("GET","getCities.php?stateName="+stateName);
			xhttp.send();
		}
		function validateForm(){

			var fatherName = document.getElementById("fatherName");
			var motherName = document.getElementById("motherName");
			var dob = document.getElementById("dob");
			var address = document.getElementById("address");
			var stateSelect = document.getElementById("state");
			var stateName = stateSelect.options[stateSelect.selectedIndex].value;
			var citySelect = document.getElementById("city");
			var cityName = citySelect.options[citySelect.selectedIndex].value;

			if(isEmpty(fatherName.value)){
				document.getElementById("fatherNameError").innerHTML = "Father's name required";
				return false;
			}
			if(isEmpty(dob.value)){
				document.getElementById("dateError").innerHTML = "Date of Birth required";
				return false;
			}
			if(isEmpty(address.value)){
				document.getElementById("addressError").innerHTML = "Address required";
				return false;
			}
			if(isEmpty(stateName)){
				document.getElementById("stateError").innerHTML = "Please select State";
				return false;
			}
			if(isEmpty(cityName)){
				document.getElementById("cityError").innerHTML = "Please select City";
				return false;
			}
			var pattern = /^[a-zA-Z]*$/;
			if(!pattern.test(fatherName.value)){
				document.getElementById("fatherNameError").innerHTML = "Name can contain only alphabets";
				return false;
			}

			pattern = /^[a-zA-Z0-9\s]*$/;
			if(!pattern.test(address.value)){
				document.getElementById("addressError").innerHTML = "Address can contain only alphanumeric";
				return false;
			}
			return true;
		}
	</script>
</head>
<body onload="getCities()">
<form action="personal.php" method="POST" onsubmit="return validateForm()">
<table align="center" cellspacing="0" border="1" cellpadding="10">
		<tr>
			<td>


	<table>
		<tr>
			<td colspan="2" class="header">Personal Details</td>
			<td></td>
		</tr>
		<tr>
			<td>First Name</td>
			<td><input type="text" name="txtFname" size="30" maxlength="30"  
				value = "<?php echo $row['fname'];  ?>" disabled /></td>
			<td></td>
		</tr>
		<tr>
			<td>Last Name</td>
			<td colspan="2"><input type="text" name="txtLname" size="30" maxlength="30" 
				value = "<?php echo $row['lname']; ?>" disabled/></td>
			<td></td>
		</tr>
		<tr>
			<td>Father's name</td>
			<td><input type="text" name="txtFatherName" id="fatherName" size="30" maxlength="30" 
				value = "<?php echo $row['fatherName']; ?>"/><br>
				<span id="fatherNameError"></span></td>
		</tr>
		<tr>	
			<td>Mother's name</td>
			<td><input type="text" name="txtMotherName" id="motherName" size="30" maxlength="30"
				 value = "<?php echo $row['motherName']; ?>"/></td>
		</tr>
		<tr>
			<td>Date of Birth</td>
			<td><input type="date" name="txtDob" id="dob" 
			value = "<?php echo $row['dateOfBirth']; ?>" /><br>
				<span id="dateError"></span>
		</tr>
		<tr>	
			<td>Gender</td>
			<td><select id="gender" name="selectGender">
				<option value="Male" <?php if($row['gender'] == 'M') echo "selected";?>>Male</option>
				<option value="Female" <?php if($row['gender'] == 'F') echo "selected";?>>Female</option>
			</select></td>
		</tr>
		<tr>
			<td colspan="3">Street Address</td>
		</tr>
		<tr>
			<td colspan="2"><input type="text" name="txtAddress" id="address" size="98" maxlength="80"
				value = "<?php echo $row['address']; ?>"/><br>
				<span id="addressError"></span></td>
		</tr>
		<tr>
			<td>State</td>
			<td><select name="selectState" id="state" onchange="getCities()"><?php listStates($conn,$row['state']); ?></select>
			<br><span id="stateError"></td>
		</tr>
		<tr>
			<td>City</td>
			<td><span id="spanCity"></span><br>
				<span id="cityError"></span></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type="submit" value="Save"/>
			</td>
		</tr>
	</table>

	</td>
</tr>
</table>
</form>
</body>
</html>