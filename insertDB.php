<?php
     
    require 'database.php';
 
    if (!empty($_POST)) {
        // අයිතියක් තෝරා ගත් විට හිස් තත්ත්වය අලුත් කරන්න
        $name = $_POST['name'];
        $id = $_POST['id'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        
        // Truncate the 'mobile' data if it exceeds the maximum allowed length
        $mobile = substr($_POST['mobile'], 0, 13); // Adjust the length (10) as per your database column definition
        
        $subscription_plan = $_POST['subscription_plan'];
        
        // ආරම්භ දිනය සඳහා නිර්දේශ දිනය නිර්මාණය කරන්න
        $registration_date = date('Y-m-d');
        
        // ලියාපදිංචි දත්ත අංකය සඳහා access_status ඇතුලත් කරන්න
        $access_status = 0;
        
        // අංක විනාඩිය සඳහා සදහා නිර්දේශ දිනය අලුත් කරන්න
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
        
        // දත්තගබඩා විස්තර ඇතුලත් කිරීම
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO table_nodemcu_rfidrc522_mysql (name, id, gender, email, mobile, subscription_plan, registration_date, expiry_date, access_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($name, $id, $gender, $email, $mobile, $subscription_plan, $registration_date, $expiry_date, $access_status));
        Database::disconnect();
        header("Location: user data.php");
    }
?>
