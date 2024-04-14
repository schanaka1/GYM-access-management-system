<?php
// Include database connection file
require 'database.php';

// Check if UID is provided via GET request
if (isset($_GET['UID'])) {
    // Get the UID from the GET request
    $uid = $_GET['UID'];

    try {
        // Connect to the database
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to select phone number based on UID
        $sql = "SELECT mobile FROM table_nodemcu_rfidrc522_mysql WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$uid]);

        // Fetch the phone number from the database
        $phoneNumber = $stmt->fetchColumn();

        // If phone number found, return it
        if ($phoneNumber) {
            echo $phoneNumber;
        } else {
            echo "Phone number not found for the provided UID.";
        }

        // Disconnect from the database
        Database::disconnect();
    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // Error message if UID is not provided
    echo "Error: UID parameter is missing.";
}
?>
