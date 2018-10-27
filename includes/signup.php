<?php 
    include_once("config.php");

    session_start();
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $type = "user";

    $stmtEmail = $db_conn->prepare("SELECT * FROM users where user_email = :user_email");
    $stmtEmail->bindParam(':user_email', $email);
    $stmtEmail->execute();

    $user_row_email = $stmtEmail->fetch(PDO::FETCH_ASSOC);

    if (empty($name) && empty($email) && empty($password) && empty($address)) {
        echo "Please fill all fields!";
    } elseif (empty($name)) {
        echo "Please enter your name!";
    } elseif (empty($email)) {
        echo "Please enter an email!";
    } elseif (empty($password)) {
        echo "Please enter an password!";
    } elseif (empty($address)) {
        echo "Please enter address!";
    } elseif ($user_row_email['user_email'] == $email) {
        echo "You are already a registered user!";
    } else {
        # Generate a unique token
        $token = $password + time();
        $token = password_hash($token, PASSWORD_BCRYPT);

        $insertStmt = $db_conn->prepare("INSERT INTO users (user_name, user_email, user_password, user_address, user_type, user_token) VALUES (:name, :email, :password, :address, :type, :token);");
        
        $insertStmt->bindParam(':name', $name);
        $insertStmt->bindParam(':email', $email);
        $insertStmt->bindParam(':password', $hashed_password);
        $insertStmt->bindParam(':address', $address);
        $insertStmt->bindParam(':type', $type);
        $insertStmt->bindParam(':token', $token);
        $insertStmt->execute();

        $arr = explode("@", $email, 2); 
        $cartName = $arr[0] . '_cart';

        $createTableSql = "CREATE TABLE $cartName (
        cart_id INT(40) AUTO_INCREMENT PRIMARY KEY,
        product_id INT(40) NOT NULL,
        product_name VARCHAR(60) NOT NULL,
        product_price FLOAT(50) NOT NULL,
        product_image VARCHAR(255) NOT NULL,
        product_quantity INT(20) NOT NULL,
        product_total FLOAT(50) NOT NULL
        );";

        $db_conn -> exec($createTableSql);

        echo "products.php";
        
        $_SESSION['email'] = $email;
        $_SESSION['token'] = $token;

        exit();
    }

?>