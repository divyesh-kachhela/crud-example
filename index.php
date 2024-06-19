<?php
	include "config.php";
	session_start();

	#Function to authenticate users
	function authenticate_user($user, $password, $connection){
		$query_data = $connection ->prepare("SELECT * FROM Users WHERE username = ? AND password = ?");
		$query_data->bind_param("ss", $user, md5($password));
		$query_data->execute();
		$result = $query_data->get_result();

		#Check if user is found
		if ($result->num_rows > 0) {

			#Set session variables
			$_SESSION['username'] = $user;
			header("Location:dashboard.php");
			exit();

		} else {

			return "Invalid password or username";
		}
		#Close the database connection
		$connection->close();
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		#Retrieve username and password from form submission
		$user = $_POST['username'];
		$password = $_POST['password'];

		$msg = authenticate_user($user, $password, $connection);
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Authentication</title>
<style>
* {
	margin: 0;
	padding: 0;
	font-family: sans-serif;
	/* background-color: #2f4f4f; */
	color: white;
}

.form-box {
	display: flex;
	justify-content: space-around;
}

.msg{
	display: flex;
	justify-content: center;
}

.form-box h3 {
	text-align: center;
	margin-bottom: 15px;
}

label {
	display: block;
}

.form-box input {
	width: 100%;
	height: 30px;
	margin-inline: auto;
	border: none;
	border-bottom: 1px solid aliceblue;
	margin-bottom: 10px;
	padding-left: 10px;
	transition: 0.5s;
}

input:focus {
	outline: none;
	border-bottom: 1px solid #2f4f4f;
}	

.form-box button {
	font-size: 16px;
	padding: 5px 15px;
	border: none;
	margin-top: 10px;
	color: white;
	border-bottom: 1px solid aliceblue;
	border-left: 1px solid aliceblue;

	transition: 0.5s;
}

button:hover {
	box-shadow: 5px 3px 8px #0009;
}

form,
button,
input,
label,
h3 {
	background-color: transparent;
}

.msg {
	background-color: transparent;
	color: #ff6a6a;
}

.wrapper {
	display: flex;
	background-color: transparent;
	justify-content: space-between;
	align-items: first baseline;
}

.img-wrapper{
	width: 150px;
}

.img-wrapper img{
	width: 100%;
}

.form-box-wrapper{
	width: 600px;
	margin-inline: auto;
	position: absolute;	
	top: 50%;
	left: 50%;
	width: 600px;
	padding: 40px;
	transform: translate(-50%, -50%);
	background: rgb(29, 42, 53);
	background: linear-gradient(319deg, rgba(29, 42, 53, 1) 35%, rgba(47, 79, 79, 1) 100%);
	box-sizing: border-box;
	box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
	border-radius: 10px;
	color: white;
}


</style>
</head>

<body>
	<div class="from-container">
		<div class="form-box-wrapper">
			<div class="form-box">
				<div class="img-wrapper">
					<h3>Login</h3>
					<img src="images/additional_images/login-icon.png" alt="login_icon">
				</div>
				<form method='post'>
					<label for="namefield">Username</label>
					<input type="text" id="namefield" name='username'>
					<label for="passwordfield">Password</label>
					<input type="password" id="passwordfield" name='password'>
					<div class="wrapper">
						<button>Login</button>
					</div>
				</form>
			</div>
			<span class="msg"><?php echo(isset($msg)? "$msg" : "" )?></span>
		</div>
	</div>
</body>
</html>



