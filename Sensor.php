<?php
require 'database.php';

if (isset($_GET['value'])) {
    $value = $_GET['value'];

    // Update the sensorout table where id = 1
    $query = "UPDATE sensorout SET value = '$value' WHERE id = 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Data updated successfully";
    } else {
        echo "Error updating data: " . mysqli_error($conn);
    }
} else {
    echo "No value received";
}

mysqli_close($conn);
?>
