<?php
    $Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
    file_put_contents('UIDContainer.php',$Write);
    
    // Function to get current date
    function getCurrentDate() {
        return date("Y-m-d");
    }

    // Function to get current time
    function getCurrentTime() {
        return date("H:i:s");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <script src="jquery.min.js"></script>
    <script>
        $(document).ready(function(){
             $("#getUID").load("UIDContainer.php");
            setInterval(function() {
                $("#getUID").load("UIDContainer.php");
            }, 500);
        });
    </script>

    <style>
        html {
            font-family: 'Arial', sans-serif;
            display: inline-block;
            margin: 0px auto;
            text-align: center;
        }
        
        body{
            background: url(homebd.jpg);
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
        .center{
            border-radius:5%;
        }
        

        textarea {
            resize: none;
        }

                ul.topnav {
            list-style-type: none;
            margin: auto;
            padding: 0;
            overflow: hidden;
            background-color: #3498db; /* Blue background color for the navigation bar */
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
            padding: 14px 16px;
            text-decoration: none;
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
        
        

        @media screen and (max-width: 600px) {
            ul.topnav li.right, 
            ul.topnav li {float: none;}
        }
    </style>

    <title>Registration</title>
</head>

<body>
    <h1 align="center">GYM Access Management System</h1>
    <ul class="topnav">
        <li><a href="home.php">Home</a></li>
        <li><a href="user data.php">User Data</a></li>
        <li><a class="active" href="registration.php">Registration</a></li>
        <li><a href="read tag.php">Read Tag ID</a></li>
    </ul>

    <div class="container">
        <br>
        <div class="center" style="margin: 0 auto; width:495px; border-style: solid; border-color: #f2f2f2; background-color:#c1dcde;">
            <div class="row">
                <h3 align="center">Registration Form</h3>
            </div>
            <br>
            <form class="form-horizontal" action="insertDB.php" method="post" >
                <div class="control-group">
                    <label class="control-label">ID</label>
                    <div class="controls">
                        <textarea name="id" id="getUID" placeholder="Please Tag your Card / Key Chain to display ID" rows="1" cols="1" required></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Name</label>
                    <div class="controls">
                        <input id="div_refresh" name="name" type="text"  placeholder="" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" >Gender</label>
                    <div class="controls">
                        <select name="gender">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Email Address</label>
                    <div class="controls">
                        <input name="email" type="text" placeholder="" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Mobile Number</label>
                    <div class="controls">
                        <input name="mobile" type="text"  placeholder="+94" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Subscription Plan</label>
                    <div class="controls">
                        <select name="subscription_plan">
                            <option value="select">Select plan</option>
                            <option value="Silver">Silver</option>
                            <option value="Gold">Gold</option>
                            <option value="Platinum">Platinum</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Registration Date</label>
                    <div class="controls">
                        <input type="text" value="<?php echo getCurrentDate(); ?>" readonly>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>

        </div>               
    </div> <!-- /container -->  
</body>
</html>
