<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'database.php';

if (isset($_GET['UIDresult'])) {
    $uid = $_GET['UIDresult'];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve the current access status
    $currentAccessStatus = getCurrentAccessStatus($pdo, $uid);

    // Toggle the access status
    $newAccessStatus = !$currentAccessStatus;

    // Update the access status in the database
    updateAccessStatus($pdo, $uid, $newAccessStatus);

    // Get phone number from the database
    $phoneNumber = getPhoneNumberFromDatabase($pdo, $uid);

    // Return the updated access status and phone number as JSON
    $response = array(
        'access_status' => $newAccessStatus,
        'phone_number' => $phoneNumber
    );
    echo json_encode($response);
}

// Check if the RFID ID exists in the database
function isRFIDRegistered($pdo, $uid) {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Adjust the query based on your database schema
    $sql = "SELECT COUNT(*) FROM table_nodemcu_rfidrc522_mysql WHERE id = ?";

    $q = $pdo->prepare($sql);
    if (!$q) {
        die("Prepare failed: " . $pdo->errorInfo()[2]);
    }

    if (!$q->execute(array($uid))) {
        die("Execute failed: " . $q->errorInfo()[2]);
    }

    $count = $q->fetchColumn();

    return ($count > 0); // Returns true if the RFID ID exists, false otherwise
}

// Function to get RFID result from GET parameters
$UIDresult = $_GET['UIDresult'];

// Check if the RFID ID is registered
if (isRFIDRegistered($pdo, $UIDresult)) {
    echo "RFID_ID_REGISTERED";
} else {
    echo "RFID_ID_NOT_REGISTERED";
}

// Function to get the current access status
function getCurrentAccessStatus($pdo, $uid) {
    $sql = "SELECT access_status FROM table_nodemcu_rfidrc522_mysql WHERE id = ?";
    $q = $pdo->prepare($sql);
    if (!$q) {
        die("Prepare failed: " . $pdo->errorInfo()[2]);
    }

    if (!$q->execute(array($uid))) {
        die("Execute failed: " . $q->errorInfo()[2]);
    }

    $result = $q->fetch(PDO::FETCH_ASSOC);
    return $result['access_status'];
}

// Function to update the access status
function updateAccessStatus($pdo, $uid, $newAccessStatus) {
    // Convert boolean to integer (0 or 1)
    $newAccessStatus = ($newAccessStatus) ? 1 : 0;

    $sql = "UPDATE table_nodemcu_rfidrc522_mysql SET access_status = ? WHERE id = ?";
    $q = $pdo->prepare($sql);

    if (!$q) {
        die("Prepare failed: " . $pdo->errorInfo()[2]);
    }

    if (!$q->execute(array($newAccessStatus, $uid))) {
        die("Execute failed: " . $q->errorInfo()[2]);
    }
}


// Function to get phone number from database
function getPhoneNumberFromDatabase($pdo, $uid) {
    $sql = "SELECT mobile FROM table_nodemcu_rfidrc522_mysql WHERE id = ?";
    $q = $pdo->prepare($sql);
    if (!$q) {
        die("Prepare failed: " . $pdo->errorInfo()[2]);
    }

    if (!$q->execute(array($uid))) {
        die("Execute failed: " . $q->errorInfo()[2]);
    }

    $result = $q->fetch(PDO::FETCH_ASSOC);
    return $result['mobile'];
}



// Close the database connection
Database::disconnect();
?>
