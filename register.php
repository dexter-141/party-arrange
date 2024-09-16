<?php
session_start();

require "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(strlen($_POST["username"])<1||strlen($_POST["username"])>50){
        $error="Username is invalid";
        
    }else{
        $username=$_POST["username"];
    }
    if(strlen($_POST["password"])<1||strlen($_POST["password"])>255){
        $error="Username is invalid";
        
    }else{
        $password=$_POST["password"];
    }
    if(strlen($_POST["email"])<1||strlen($_POST["email"])>100){
        $error= "Invalid email address";
        
    }else{
        $result = search("SELECT * FROM users WHERE email = '".$_POST["email"]."'");
        if ($result && $result->num_rows > 0) {
            $error = "Email already exists";
        } else {
            $email = $_POST["email"];
        }

    }
    if(strlen($_POST["phone_number"])<1||strlen($_POST["phone_number"])>15){
        $error= "Invalid phone number";
        
    }else{
        $phone_number = $_POST["phone_number"];
    }
    
    if(empty($error)){
        $sql = "INSERT INTO users (username, password, email, phone_number) 
            VALUES ('$username', '$password', '$email', '$phone_number')";

        if ($conn->query($sql) === TRUE) {
            // Get the user ID of the newly registered user
            $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
            if($result && $result->num_rows === 1) {
                $user = $result->fetch_assoc();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit(); // Ensure no further code runs after redirection
            }
        } else {
            $error = "Failed to register: " . $conn->error;
        }

        
        
        // if() {
        //     $user = $result->fetch_assoc();
            
        //     $_SESSION['user_id'] = $user['id'];
        //     $_SESSION['username'] = $user['username'];
        //     header("Location: index.php");
        //     exit();
        // }else{
        //     $error="Failed to register";
        // }  
    }

}


?>
<!DOCTYPE html>

<html>

<head>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
    <div class="login-container">
        <div class="login-form">
            <h2>Registration</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form action="register.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" class="form-control" name="username" default="" required>

                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" default="" required>

                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" name="email" required>

                <label for="phone_number">Mobile Number:</label>
                <input type="text" id="phone_number" class="form-control" name="phone_number" required>

                <button class="btn" type="submit">Register</button>
            </form>
        </div>
    </div>
    <script src="js/scripts.js"></script>
</body>

</html>