<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
include("header.php");
?>
<style type="text/css">
a.nav {
  color: white;
  text-align: center;
  padding: 2px;
  text-decoration: none;
  font-size: 18px; 
}
	</style>
<table width="100%">
	<tr>
		<td width="15%" valign="top">
			<table width="100%"  cellspacing="2">
				<tr style="background-color: dodgerblue;">
					<td><a href="personal.php"  target="mainframe" class="nav">Personal</a></td>
				</tr>
				<tr style="background-color: dodgerblue;">
					<td><a href="educational.php" target="mainframe" class="nav">Education</a></td>
				</tr>
				<tr style="background-color: dodgerblue;">
					<td><a href="photoUpload.php" target="mainframe" class="nav">Upload Photo</a></td>
				</tr>
				<tr style="background-color: dodgerblue;">
					<td><a href="applicationSubmit.php" class="nav" target="mainframe">Application Submit</a></td>
				</tr>
			</table>
		</td>
		<td width="85%" valign="top"><iframe width="100%" height="450"  src="personal.php" name="mainframe">
 		 <p>Your browser does not support iframes.</p>
		</iframe></td>
	</tr>
	
</table>
</body>
</html>