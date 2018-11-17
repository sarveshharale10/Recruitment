<?php
include("credentials.php");
include('header.php');
if(isset($_GET['username'])){
	$conn->query("update application set deleted=1 where username='".$_GET['username']."'");
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$conn->query("update application set shortlisted=1 where stage=3 and deleted != 1");
	$conn->query("update config set stage=3");
	header("location:index.php");
}
//check for shortlist process and  exit
$result = $conn->query("select stage from config");
$row = $result->fetch_assoc();
if($row['stage'] == 3){
	exit("<center><h2>Shortlisting process is already completed.</h2></center>");
}
$result = $conn->query("select * from application where stage=3 and deleted != 1");
?>
<!DOCTYPE html>
<html>
<head>
	
</head>
<body>
<table width="100%" cellspacing="0" cellpadding="3" border="1">
	<tr>
		<td colspan="6" class="header">Shortlist</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<th>Name</th>
		<th>Father's Name</th>
		<th>Mother's Name</th>
		<th>Address</th>
		<th>&nbsp;</th>
	</tr>
	<?php
		while(($row = $result->fetch_assoc())){
			echo "<tr>";
			echo "<td><img width=50 height=50 src=".$row['path']." /></td>";
			echo "<td>".$row['fname']." ".$row['lname']."</td>";
			echo "<td>".$row['fatherName']."</td>";
			echo "<td>".$row['motherName']."</td>";
			echo "<td>".$row['address']."</td>";
			echo "<td><a href='shortList.php?username=".$row['username']."'>Delete</a></td>";
			echo "</tr>";
		}
	?>
	
</table>
<p>
<center>
<form method="post" action="shortList.php">
		<input type="submit" value="Finalize"/>
	</form>
</center>
</body>
</html>