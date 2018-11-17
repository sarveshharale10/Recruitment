<?php
include("credentials.php");
$stmt = $conn->prepare("select name from cities where stateId = (select stateId from states where name=?)");
	$stateName = $_GET['stateName'];
	$stmt->bind_param("s",$stateName);
	$stmt->execute();
	$stmt->bind_result($city);
	echo "<select name='selectCity' id='city'>";
	echo "<option value=''>Select City</option>";
	while($stmt->fetch()){
		echo "<option value='".$city."'>".$city."</option>";
	}
	echo "</select>";
?>