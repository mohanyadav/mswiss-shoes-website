<?php 
    include_once("config.php");

    session_start();
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $type = "user";
    
    $stmtEmail = $db_conn->prepare("SELECT * FROM users where user_email = :user_email");
    $stmtEmail->bindParam(':user_email', $email);
    $stmtEmail->execute();

    $user_row = $stmtEmail->fetch(PDO::FETCH_ASSOC);

    $password_verified = password_verify($password, $user_row['user_password']);

    if (empty($email) && empty($password)) {
        echo "Please fill all fields!";
    } elseif (empty($email)) {
        echo "Please enter an email!";
    } elseif (empty($password)) {
        echo "Please enter password!";
    } elseif ($user_row['user_email'] == $email && $password_verified) {
        echo "products.php";
        $token = $password + time();
        $token = password_hash($token, PASSWORD_BCRYPT);

        $sql = "UPDATE users SET user_token = '$token' WHERE user_email = '$email'";
        $updateStmt = $db_conn -> prepare($sql);
        $updateStmt -> execute();

        $_SESSION['email'] = $email;
        $_SESSION['token'] = $token;
        
        exit();
        
    } elseif (!$user_row['user_email'] == $email || !$password_verified) {
        echo "Please check your email/password!";
    } else {
        echo "Please open an account first!";
    }

?>