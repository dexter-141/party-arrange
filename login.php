<?php
session_start();

require 'db_connect.php';




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = search("SELECT * FROM users WHERE username = '".$username."' AND password = '".$password."'");

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: index.php");
        
    } else {
        $error = "Invalid username or password.";
    }


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