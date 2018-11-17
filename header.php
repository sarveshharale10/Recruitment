<?php
if(!isset($_SESSION))
session_start();
?>
<link rel="stylesheet" type="text/css" href="styles/recruitment.css">
<style type="text/css">
a {
  color: white;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px; 
  line-height: 25px;
  border-radius: 4px;
  background-color: dodgerblue;
}
 a:hover {
  background-color: #ddd;
  color: black;
}
</style>

<table width="100%" cellpadding="5" cellspacing="0">
	<tr bgcolor="#f1f1f1">
		<td><img src="images/logo.png" width="200" height="100" /></td>
		<td align="right">
			<?php if(isset($_SESSION['username']) && $_SESSION['username'] == "admin"){
				echo "Welcome ".$_SESSION['username']."<a href='adminFilter.php'>Search</a>
    				&nbsp;&nbsp;<a href='shortList.php'>Shortlist</a>&nbsp;&nbsp;"."
				 <a href='logout.php'>Logout</a>";
			}
			else if(isset($_SESSION['username'])){
				echo "Welcome ".$_SESSION['username']."
				 <a href='logout.php'>Logout</a>";
			}
			else{
				echo "<a href='regpage.php'>Register</a>
    				&nbsp;&nbsp;<a href='login.php'>Login</a>";
			} ?>
		</td>
	</tr>
</table>