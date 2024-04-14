<?php
    // Write PHP variable to a file
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

        h3{
            color:#f6f6f6;
            text-shadow:
                    -1px -1px 0 #000,
                    1px -1px 0 #000,
                    -1px 1px 0 #000,
                    1px 1px 0 #000;
        }

        table{
            background-color:#c1dcde;
            border-radius: 5px;
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
        
        .chart{
            height:10%;
            width:40%;
            background-color:#c1dcde;
            border-radius: 5px;
            margin-left:30%;
        }

        @media screen and (max-width: 600px) {
            ul.topnav li.right,
            ul.topnav li {
                float: none;
            }
        }

        .table {
            margin: auto;
            width: 90%;
        }

        thead {
            color: #ffffff; /* White text color for table header */
        }
    </style>

    <title>User Data</title>
</head>

<body>
<h1>GYM Access Management System</h1>
<ul class="topnav">
    <li><a href="home.php">Home</a></li>
    <li><a class="active" href="user data.php">User Data</a></li>
    <li><a href="registration.php">Registration</a></li>
    <li><a href="read tag.php">Read Tag ID</a></li>
</ul>
<br>
<div class="container">
    <div class="row">
        <h3>User Data Table</h3>
    </div>
    <div class="row">
        <table class="table table-hover ">
            <thead>
            <tr bgcolor="#10a0c5" color="#FFFFFF">
                <th>Name</th>
                <th>ID</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Mobile Number</th>
                <th>Subscription Plan</th>
                <th>Registration Date</th>
                <th>Expiry Date</th>
                <th>Access Status</th> <!-- New column added -->
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include 'database.php';
            $pdo = Database::connect();
            $sql = 'SELECT * FROM table_nodemcu_rfidrc522_mysql ORDER BY name ASC';
            foreach ($pdo->query($sql) as $row) {
                // Calculate expiry date based on subscription plan
                $expiry_date = date('Y-m-d', strtotime($row['registration_date']));
                switch($row['subscription_plan']) {
                    case 'Silver':
                        $expiry_date = date('Y-m-d', strtotime($expiry_date . ' +30 days'));
                        break;
                    case 'Gold':
                        $expiry_date = date('Y-m-d', strtotime($expiry_date . ' +180 days'));
                        break;
                    case 'Platinum':
                        $expiry_date = date('Y-m-d', strtotime($expiry_date . ' +360 days'));
                        break;
                }
                // Check if subscription has expired
                if (date('Y-m-d') <= $expiry_date) {
                    echo '<tr>';
                    echo '<td>'. $row['name'] . '</td>';
                    echo '<td>'. $row['id'] . '</td>';
                    echo '<td>'. $row['gender'] . '</td>';
                    echo '<td>'. $row['email'] . '</td>';
                    echo '<td>'. $row['mobile'] . '</td>';
                    echo '<td>'. $row['subscription_plan'] . '</td>';
                    echo '<td>'. $row['registration_date'] . '</td>';
                    echo '<td>'. $expiry_date . '</td>';
                    echo '<td>'. $row['access_status'] . '</td>'; // Display access status
                    echo '<td><a class="btn btn-success" href="user data edit page.php?id='.$row['id'].'">Edit</a>';
                    echo ' ';
                    echo '<a class="btn btn-danger" href="user data delete page.php?id='.$row['id'].'">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                } else {
                    // Subscription expired, delete the row from the database
                    $delete_sql = 'DELETE FROM table_nodemcu_rfidrc522_mysql WHERE id = ?';
                    $delete_statement = $pdo->prepare($delete_sql);
                    $delete_statement->execute([$row['id']]);
                }
            }
            Database::disconnect();
            ?>
            </tbody>
        </table>
    </div>
</div> <!-- /container -->

<!-- Chart.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

<!-- PHP script to generate chart -->
<?php
    // Include the database connection file
    require_once 'database.php';

    // Query to count the number of users who entered
    $pdo = Database::connect();
    $sqlEntered = "SELECT COUNT(*) AS enteredCount FROM table_nodemcu_rfidrc522_mysql WHERE access_status = 1";
    $stmtEntered = $pdo->query($sqlEntered);
    $resultEntered = $stmtEntered->fetch(PDO::FETCH_ASSOC);
    $enteredCount = $resultEntered['enteredCount'];

    // Query to count the number of users who exited
    $sqlExited = "SELECT COUNT(*) AS exitedCount FROM table_nodemcu_rfidrc522_mysql WHERE access_status = 0";
    $stmtExited = $pdo->query($sqlExited);
    $resultExited = $stmtExited->fetch(PDO::FETCH_ASSOC);
    $exitedCount = $resultExited['exitedCount'];
    
        // Query to count the total number of registered users
            $sql_total = "SELECT COUNT(*) AS totalCount FROM table_nodemcu_rfidrc522_mysql";
            $stmt_total = $pdo->query($sql_total);
            $result_total = $stmt_total->fetch(PDO::FETCH_ASSOC);
            $totalCount = $result_total['totalCount'];

    Database::disconnect();
?>
  <!-- Info box to display total registered users -->
 <br>
<div class="info-box" style="color: white; font-weight: bold;">
    <h4>Total Registered Users</h4>
    <p><?php echo $totalCount; ?></p>
</div>
<!-- Canvas to display the chart -->
<div class="chart">
<canvas id="accessChart" width="20" height="15"></canvas>
</div>
<!-- Script to generate chart -->
<script>
    var ctx = document.getElementById('accessChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Entered', 'Exited'],
            datasets: [{
                label: 'Number of Users',
                data: [<?php echo $enteredCount; ?>, <?php echo $exitedCount; ?>],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>


</body>
</html>
