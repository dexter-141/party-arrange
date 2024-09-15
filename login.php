<?php
session_start();

require 'db_connect.php';

// iud("INSERT INTO users(username,password,email,phone_number) VALUES ('pasidu','123','pasidu@gmail.com','0714710856')");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    iud("SELECT * FROM users WHERE username=$username");

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("location: index.php");
                exit();
            } else {
                $error = "Invalid password or username.";
            }
        } else {
            $error = "Invalid password or username.";
        }
    } else {
        $error = "Database error";

    }
    $stmt->close();
    $mysqli->close();
}


?>

<!DOCTYPE html>

<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
    <div class="login-container">
        <div class="login-form">
            <h2>Login</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form action="login.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" class="form-control" name="username" required>

                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>

                <button class="btn" type="submit">Login</button>
            </form>
        </div>
    </div>
    <script src="js/scripts.js"></script>
</body>

</html>