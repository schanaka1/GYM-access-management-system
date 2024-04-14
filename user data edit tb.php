<?php
    require 'database.php';
 
    $id = null;
    if (!empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if (!empty($_POST)) {

        $name = $_POST['name'];
        $id = $_POST['id'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        
        // Truncate the 'mobile' data if it exceeds the maximum allowed length
        $mobile = substr($_POST['mobile'], 0, 13); // Adjust the length (10) as per your database column definition
        
        $subscription_plan = $_POST['subscription_plan'];
        
        // Get the current date for registration
        $registration_date = date('Y-m-d');
        
        // Set access status
        $access_status = 0;
        
        // Calculate expiry date based on subscription plan
        switch ($subscription_plan) {
            case 'Silver':
                $expiry_date = date('Y-m-d', strtotime($registration_date . ' +30 days'));
                break;
            case 'Gold':
                $expiry_date = date('Y-m-d', strtotime($registration_date . ' +180 days'));
                break;
            case 'Platinum':
                $expiry_date = date('Y-m-d', strtotime($registration_date . ' +360 days'));
                break;
            default:
                $expiry_date = date('Y-m-d', strtotime($registration_date . ' +30 days'));
        }
        
        // Update database
        $pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE table_nodemcu_rfidrc522_mysql SET name=?, gender=?, email=?, mobile=?, subscription_plan=?, registration_date=?, expiry_date=?, access_status=? WHERE id=?";
		
		$q = $pdo->prepare($sql);
		$q->execute(array($name, $gender, $email, $mobile, $subscription_plan, $registration_date, $expiry_date, $access_status, $id));
		Database::disconnect();
		header("Location: user data.php");
    }
?>
