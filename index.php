<?php
    //load up session variables to be used globally
    session_start();

    if(isset($_SESSION["userID"])){
        header("Location: homePage.php");
    }
    else{
        header("Location: loginPage.php");
    }

?>