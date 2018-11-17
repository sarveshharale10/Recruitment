<?php
session_start();
include("credentials.php");

$result = $conn->query(" select fatherName,path,university from application a, education b where a.username=b.username and a.username='".$_SESSION['username']."' and exam='SSC'");
$row = $result->fetch_assoc();

if($row['fatherName'] == "" || $row['path'] == "" || $row['university'] == ""){
	exit("<center><h2>Application is incomplete to submit. Kindly confirm all necessary details in personal, education and photo upload is completed.</h2></center>");
}
$result = $conn->query("select count(*) as acount from  application where stage=3");
$row = $result->fetch_assoc();
$nextCount = $row['acount'] + 1;
$applicationId = "A-".date("Y")."-".$nextCount;
$conn->query("update application set applicationId='".$applicationId."',stage=3 where  username='".$_SESSION['username']."'");
exit("<center><h2>Application is successfully submitted. Kindly use ".$applicationId." in future correspondence.</h2></center>");
?>