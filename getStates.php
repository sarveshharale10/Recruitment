<?php
include("credentials.php");
function listStates($conn,$name){
	$result = $conn->query("select name from states");
	echo "<option value=''>Select State</option>";
	 while($row = $result->fetch_assoc()){
        echo "<option value='".$row['name']."'";
        if($row['name'] == $name) echo " selected";
        echo ">".$row['name']."</option>";
    }
}
?>