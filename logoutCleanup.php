<?php
    //load up session variables
    session_start();
    //unset all session variables
    session_unset();
    //destroy the session
    session_destroy();
    //redirect to login page
    header("Location: loginPage.php");
?>