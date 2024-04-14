<?php
session_start();
require_once('database.php');

$conn = Database::connect(); // Establish database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST['mail'];
    $password = $_POST['password'];

    if (!empty($mail) && !empty($password) && !is_numeric($mail)) {
        $query = "SELECT * FROM form WHERE mail = ? LIMIT 1";
        $stmt = $conn->prepare($query); // Use $conn for database connection
        $stmt->bindParam(1, $mail);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Verify the hashed password
            if (password_verify($password, $result['password'])) {
                $_SESSION['mail'] = $result['mail'];
                header("Location: home.php");
                exit();
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Please enter valid information";
    }
}

?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Form Login and Register</title>
    <link rel="stylesheet" href="singin.css">
</head>
<body>
<div class="login">
    <div class=layer2>
        <h1>Login</h1>
        <?php if(isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <label>Email</label>
            <input type="email" name="mail" placeholder="Enter your Email" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
            <input type="submit" name="submit" value="Submit">
        </form>
        <p>Don't have an account? <a href="singin.php">Sign Up Here</a></p>
    </div>
</div>
</body>
</html>
