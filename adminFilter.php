<?php
include("credentials.php");
include("getStates.php");

function getResult($conn){

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$username = $_POST['txtUsername'];
		$firstName = $_POST['txtFname'];
		$lastName = $_POST['txtLname'];
		$gender = $_POST['selectGender'];
		if($gender == "Male"){
			$gender = "M";
		}
		else if($gender == "Female"){
			$gender = "F";
		}
		$state = $_POST['selectState'];
		$city = $_POST['selectCity'];
		$query = "select username,fname,lname,gender,city,state from application where username like concat('%',?,'%') and fname like concat('%',?,'%') and lname like concat('%',?,'%') and gender like concat('%',?,'%') and city like concat('%',?,'%') and state like concat('%',?,'%')";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("ssssss",$username,$firstName,$lastName,$gender,$city,$state);
		$stmt->execute();
		$stmt->bind_result($resultUsername,$resultFname,$resultLname,$resultGender,$resultCity,$resultState);
		echo "<table width='100%' border='1' cellspacing='0' cellpadding='3'>";
		echo "<tr style='background-color: dodgerblue;color: white;'>";
		echo "<th>Username</th>
		<th>FirstName</th>
		<th>LastName</th>
		<th>Gender</th>
		<th>City</th>
		<th>State</th>";
		echo "</tr>";
		$count = 1;
		while($stmt->fetch()){
			if($count % 2 == 0){
				echo "<tr style='background-color: lightgrey;'>";
			}
			else{
				echo "<tr>";
			}
			echo "<td>$resultUsername</td>";
			echo "<td>$resultFname</td>";
			echo "<td>$resultLname</td>";
			echo "<td>";
			if($resultGender == "M"){
				echo "Male";
			}
			else{
				echo "Female";
			}
			echo "</td>";
			echo "<td>$resultCity</td>";
			echo "<td>$resultState</td>";
			echo "</tr>";
			$count = $count + 1;
		}
		echo "</table>";
	}
	
}

?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/recruitment.css">
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
	</script>
</head>
<body onload="getCities()">
<?php
include("header.php");
?>
<form action="adminFilter.php" method="POST">
	<table width="100%">
		<tr>
			<td colspan="6" class="header">
				Search
			</td>
		</tr>
	<tr>
		<td>Username</td>
		<td><input type="text" name="txtUsername" id="username"/></td>
		<td>First Name</td>
		<td><input type="text" name="txtFname" id="fname"></td>
		<td>Last Name</td>
		<td><input type="text" name="txtLname" id="lname"></td>
		
	</tr>
	<tr>
		<td>State</td>
		<td><select name="selectState" id="state" onchange="getCities()">
		<?php listStates($conn); ?></select></td>
		<td>City</td>
		<td><span id="spanCity"></span></td>
		<td>Gender</td>
		<td><select id="gender" name="selectGender">
				<option value="" selected>Select gender</option>
				<option value="Male">Male</option>
				<option value="Female">Female</option>				
			</select></td>
	</tr>
	<tr>
		<td colspan="6"><input type="Submit" value="Search"/></td>
	</tr>
</table>
</form>
<span id="result"><?php getResult($conn); ?></span>
</body>
</html>