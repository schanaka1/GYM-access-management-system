<?php
require 'database.php';

$UIDresult = $_POST["UIDresult"];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM table_nodemcu_rfidrc522_mysql WHERE id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($UIDresult));
$data = $q->fetch(PDO::FETCH_ASSOC);

Database::disconnect();

if ($data) {
    // UID found in the database, send a success response
    echo json_encode(array('status' => 'success', 'message' => 'Access granted'));
} else {
    // UID not found in the database, send a failure response
    echo json_encode(array('status' => 'error', 'message' => 'Access denied'));
}
?>
