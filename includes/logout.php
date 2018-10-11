<?php

session_start();

if(isset($_SESSION['user_logged']))
{
    if ($_SESSION['user_logged'] == "true") {
        session_destroy();
    }
}

header("Location: ../index.php");
exit();

?>