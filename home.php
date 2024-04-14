<?php
	$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
	file_put_contents('UIDContainer.php',$Write);
?>

<!DOCTYPE html>
<html lang="en">
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
		<style>
		html {
  font-family: 'Arial', sans-serif;
  display: inline-block;
  margin: 0px auto;
  text-align: center;
}

body {
  margin: 0; /* Remove default body margin */
  background: url(homebd.jpg); 
  background-repeat: no-repeat;
    background-size: cover;
}

h1{
    color:#cad0ae;
    margin:50px;
    color: white;
    text-shadow:
    -1px -1px 0 #000,
    1px -1px 0 #000,
    -1px 1px 0 #000,
    1px 1px 0 #000;
}

.container{
    width:90%;
    text-align: center;
    
}

ul.topnav {
  list-style-type: none;
  margin:auto;
  padding:0px;
  overflow: hidden;
 /* background-color: #773e1e;  Blue background color for the navigation bar */
  width: 70%;
  
}

ul.topnav li {
  float: left;
}

ul.topnav li a {
  display: block;
  color: #ffffff; /* White text color */
  font-weight: bold;
  text-align: center;
  padding: 30px 30px ;
  text-decoration: none;
  margin-left:60px;
  background-color: #72a8bf;
}
ul.topnav li a img{
    width:40px;
    height:40px;
}


ul.topnav li a:hover:not(.active) {
  background-color: #ffffff; /* White background on hover */
  color: #3498db; /* Blue text color on hover */
}

ul.topnav li a.active {
  background-color: #508399; /* Greenish background for active link */
  color: #ffffff; /* White text color for active link */
}

ul.topnav li.right {
  float: right;
}

.text {
  position: relative;
  display: block;
  background: black;
  color: white;
  mix-blend-mode: darken;
}

		@media screen and (max-width: 600px) {
			ul.topnav li.right, 
			ul.topnav li {float: none;}
		}
		
		img {
			display: block;
			margin-left: auto;
			margin-right: auto;
		}
		</style>
		
		<title>Home : NodeMCU V3 ESP8266 / ESP12E with MYSQL Database</title>
	</head>
	
	<body>
		<h1>GYM Access Management System</h1><br>
		<div class= "container">
		<ul class="topnav nav nav-pills nav-fill">
			<li><a class="active" href="home.php"><img src ="home.png"><h3>Home</h3></a></li>
			<li><a href="user data.php"><img src ="user data.png"><h3>User Data</h3></a></li>
			<li><a href="registration.php"><img src ="registration.png"><h3>Registration</h3></a></li>
			<li><a href="read tag.php"><img src ="id.png"><h3>Read Tag ID</h3></a></li>
		</ul>
		</div>
		<br>
		<h3 class="text">Welcome </h3>
		
		<img src="home ok ok.jpg" alt="" style="width:55%;">
	</body>
</html>