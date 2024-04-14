<?php
require 'database.php';

if (isset($_POST["submit"])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $contact = $_POST['contact'];
    $mail = $_POST['mail'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Basic email validation
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
    } else {
        // Check if email already exists
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM form WHERE mail = :mail");
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Email has already been registered');</script>";
        } else {
            // Contact number validation (exactly 10 digits)
            if (!preg_match('/^\d{10}$/', $contact)) {
                echo "<script>alert('Contact number must be exactly 10 digits');</script>";
            } else {
                // Password validation (minimum 8 characters)
                if (strlen($_POST['password']) < 8) {
                    echo "<script>alert('Password must be at least 8 characters long');</script>";
                } else {
                    // Truncate the password to fit into the database column
                    $truncatedPassword = substr($password, 0, 255);

                    // Insert new user into the database
                    $stmt = $pdo->prepare("INSERT INTO form (fname, lname, contact, mail, password) VALUES (:fname, :lname, :contact, :mail, :password)");
                    $stmt->bindParam(':fname', $fname);
                    $stmt->bindParam(':lname', $lname);
                    $stmt->bindParam(':contact', $contact);
                    $stmt->bindParam(':mail', $mail);
                    $stmt->bindParam(':password', $truncatedPassword);
                    $stmt->execute();

                    echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
                }
            }
        }

        Database::disconnect();
    }
}
?>

<!-- HTML form for user registration -->
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Form Login and Register</title>
    <link rel="stylesheet" href="singin.css">
</head>
<body>
<div class="singin">
    <div class="layer2">
        <h1>Sign Up</h1>
        <form method="post" action="">
            <label>First Name</label>
            <input type="text" name="fname" placeholder="Enter your first name" required>
            <label>Last Name</label>
            <input type="text" name="lname" placeholder="Enter your last name" required>
            <label>Contact Number</label>
            <input type="text" name="contact" placeholder="Enter your contact number (10 digits)" pattern="\d{10}" title="Contact number must be exactly 10 digits" required>
            <label>Email</label>
            <input type="email" name="mail" placeholder="Enter your email" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password (at least 8 characters)" minlength="8" required>
            <input type="submit" name="submit" value="Submit">
        </form>
        <p>Already have an account? <a href="login.php">Login Here</a></p>
    </div>
</div>
</body>
</html>
