<?php
include('credentials.php');
include('validate.php');
if($_SERVER['REQUEST_METHOD'] == "POST"){

	$valid = true;

	$fname = $_POST['txtFname'];
	$lname = $_POST['txtLname'];
	$username = $_POST['txtUsername'];
	$password = $_POST['txtPassword'];
	$confirmPass = $_POST['txtConfirmPass'];
	$email = $_POST['txtEmail'];
	$nameError  = "";

	$pattern = '[[:alpha:]]';
	if(isEmpty($fname) || isEmpty($lname)){
		$nameError = "First name and Last name required";
		$valid = false;
	}
	else if(!ereg($pattern,$fname) || !ereg($pattern,$lname)){
		$nameError = "Name can contain alphabets only";
		$valid = false;
	}

	$usernameError = "";
	if(isEmpty($username)){
		$usernameError = "Username required";
		$valid = false;
	}
	$passwordError = "";
	if(isEmpty($password)){
		$passwordError = "Password required";
		$valid = false;
	}
	$confirmPassError = "";
	if($password != $confirmPass){
		$confirmPassError = "Password not matching";
		$valid = false;
	}
	$emailError = "";
	if(isEmpty($email)){
		$emailError = "Email required";
		$valid = false;
	}

	/*$stmt = $conn->prepare("select username from credentials where username=?");
	$stmt->bind_param("s",$username);
	$stmt->execute();
	if($stmt->num_rows != 0){
		$usernameError = "Username already exists";
		$valid = false;
	}*/



	if($valid){
		$stmt = $conn->prepare("insert into credentials(username,password) values(?,password(?))");
		$stmt->bind_param("ss",$username,$password);
		$stmt->execute();
		$stmt = $conn->prepare("insert into application(username,fname,lname,email,stage) values(?,?,?,?,1)");
		$stmt->bind_param("ssss",$username,$fname,$lname,$email);
		$stmt->execute();
		$stmt = $conn->prepare("call add_education(?)");
		$stmt->bind_param("s",$username);
		$stmt->execute();
		include('header.php');
		exit("<br><br><center><h2>Registration is successful. Please use credentials to login and submit the application.</h2></center>");
	}

}
?>

<html>
<head>
	<script src="js/validate.js"></script>
	<title>Registration Page</title>
	<script type="text/javascript">
	function checkPasswordStrength(){
		var password = document.getElementById("password").value;
		var strength = document.getElementById("strength");
		var alpha = /[a-zA-Z]*/;
		var digit = /[0-9]/;
		var special = /[!@#$%^&*]/;
		if(password.length <= 7 && !digit.test(password)){
			strength.innerHTML = "Low";
			return;
		}
		else if(digit.test(password) && !special.test(password)){
			strength.innerHTML = "Medium";
			return;
		}
		else if(digit.test(password) && special.test(password)){
			strength.innerHTML = "High";
			return;
		}
	}

	function validateForm(){
		var username = document.getElementById("username");
		//var usernameUnique = true;
		/*var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
        	if(this.readyState == 4 && this.status == 200){
            	if(this.responseText == "This username is used already.Please select another username."){
            		usernameUnique = false;
            	}
            	document.getElementById("usernameMsg").innerHTML = this.responseText;
            	
       		}
    	};
		xhttp.open("GET","checkUsername.php?username="+username.value);
		xhttp.send();*/

		var fname = document.getElementById("fname");
		var lname = document.getElementById("lname");
		if(isEmpty(fname.value) || isEmpty(lname.value)){
			document.getElementById("nameMsg").innerHTML = "First name and Last name required";
			fname.focus();
			return false;
		}
		else{
			document.getElementById("nameMsg").innerHTML = "";
		}
		if(isEmpty(username.value)){
			document.getElementById("usernameMsg").innerHTML = "Username required";
			username.focus();
			return false;
		}
		var password = document.getElementById("password");
		if(isEmpty(password.value)){
			document.getElementById("strength").innerHTML = "Password required";
			password.focus();
			return false;
		}
		var confirmPass = document.getElementById("confirmPass");
		if(password.value != confirmPass.value){
			document.getElementById("confirmPassMsg").innerHTML = "Password not matching";
			confirmPass.focus();
			return false;
		}
		else{
			document.getElementById("confirmPassMsg").innerHTML = "";
		}
		email = document.getElementById("email");
		if(isEmpty(email.value)){
			document.getElementById("emailMsg").innerHTML = "Email required";
			email.focus();
			return false;
		}
		var pattern = /[a-zA-Z]+/;
		if(!pattern.test(fname.value) || !pattern.test(lname.value)){
			document.getElementById("nameMsg").innerHTML = "Name can contain alphabets only";
			fname.focus();
			return false;
		}
		if(!usernameUnique){
			return false;
		}
		var emailPattern = /^[a-zA-Z0-9\.]+@[a-zA-Z]+\.[a-zA-Z]{2,3}$/;
		if(!emailPattern.test(email.value)){
			document.getElementById("emailMsg").innerHTML = "Invalid Email Address";
			return false;
		}
		else{
			document.getElementById("emailMsg").innerHTML = "";
		}
		if(document.getElementById("strength").innerHTML != "High"){
			return false;
		}
		return true;
	}
</script>
</head>
<body>
<?php include("header.php");
?>
<form method = "POST" action = "regpage.php" onsubmit="return validateForm()">
	<br><br>
	<table align="center" cellspacing="0" border="1" cellpadding="10">
		<tr>
			<td>
				
				<table weight="100%" align="center">
		<tr>
			<td class="header">Registration</td>
		</tr>
		<tr>
			<td>Name*</td>
		</tr>
		<tr>
			<td><input type="text" name = "txtFname" id="fname" placeholder="First"
				size="30" maxlength="30" value = "<?php 
				if(isset($fname)) echo $fname; ?>"/>
			&nbsp;<input type="text" name = "txtLname" id="lname" placeholder="Last"
			size="30" maxlength="30" value="<?php 
			if(isset($lname)) echo $lname; ?>"/><br>
			<span id="nameMsg" class="error"><?php
			if(isset($nameError) && $nameError != "") echo $nameError; ?></span></td>
		</tr>
		<tr>
			<td>Choose your username*</td>
		</tr>
		<tr>
			<td><input type="text" name="txtUsername" id="username" size = "65" maxlength="30"
				value="<?php if(isset($username)) echo $username; ?>" /><br>
			<span id="usernameMsg" class="error"><?php 
			if(isset($usernameError) && $usernameError != "") echo $usernameError; ?></span></td>
		</tr>
		<tr>
			<td>Create a password*</td>
		</tr>
		<tr>
			<td><input type = "password" name = "txtPassword" id="password" size = "65" maxlength="30" 
				oninput="checkPasswordStrength()" value="<?php 
				if(isset($password)) echo $password; ?>"/><br>
			<span id="strength" class="error"><?php 
			if(isset($passwordError) && $passwordError != "") echo $passwordError; ?></span></td>
		</tr>
		<tr>
			<td>Confirm your password</td>
		</tr>
		<tr>
			<td><input type="password" name="txtConfirmPass" id="confirmPass" size = "65" maxlength="30" 
				value="<?php 
				 ?>"/><br>
			<span id="confirmPassMsg" class="error"><?php 
			if(isset($confirmPassError) && $confirmPassError != "") echo $confirmPassError; ?></span></td>
		</tr>
		<tr>
			<td>Email Address*</td>
		</tr>
		<tr>
			<td><input type="email" name = "txtEmail" id = "email" size = "65" maxlength="30"/><br>
			<span id="emailMsg" class="error"><?php
			if(isset($emailError) && $emailError != "") echo $emailError; ?></span></td>
		</tr>
		<tr>
			<td align = "center"><input type = "submit" value = "Register" class="button"/></td>
		</tr>
	</table>
			</td>
		</tr>
	</table>
	
</body>
</html>