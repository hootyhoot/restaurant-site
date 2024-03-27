<?php

    define("FIRST_NAME_FIELD", "firstName");
    define("LAST_NAME_FIELD", "lastName");
    define("EMAIL_FIELD", "email");
    define("USERNAME_FIELD", "username");
    define("PASSWORD_FIELD", "password");
    define("CONFIRM_PASSWORD_FIELD", "confirmPassword");
    define("CONTACT_NUM_FIELD", "contactNum");

    session_start();
    $_SESSION["registerError"] = "None";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "restaurantDB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn -> connect_error){
        die("Connection failed: ". $conn->connect_error);
    }

    $formFirstName = $_POST[FIRST_NAME_FIELD];
    $formLastName = $_POST[LAST_NAME_FIELD];
    $formEmail = $_POST[EMAIL_FIELD];
    $formUsername = $_POST[USERNAME_FIELD];
    $formPassword = $_POST[PASSWORD_FIELD];
    $formConfirmPassword = $_POST[CONFIRM_PASSWORD_FIELD];
    $contactNum = $_POST[CONTACT_NUM_FIELD];

    $stmt = $conn->prepare("SELECT Username FROM User WHERE Username = ?");
    $stmt->bind_param("s", $formUsername);
    $stmt->execute();
    $stmt->bind_result($queryUsername);

    while($stmt->fetch()){
        if($queryUsername == $formUsername){
            $_SESSION["registerError"] = "Username already exists";
            header("Location: registerPage.php");
        }
    }

    if($_SESSION["registerError"] == "None" && $formPassword != $formConfirmPassword){
        $_SESSION["registerError"] = "Passwords do not match";
        header("Location: registerPage.php");
    }
    else if($_SESSION["registerError"] == "None" && (!is_numeric($contactNum) || str_contains($contactNum, '-')) ){
        $_SESSION["registerError"] = "Invalid Contact Number";
        header("Location: registerPage.php");
    }
    else if($_SESSION["registerError"] == "None" && ($formFirstName == "" || $formLastName == "" || $formEmail == "" || $formUsername == "" || $formPassword == "" || $formConfirmPassword == "" || $contactNum == "")){
        $_SESSION["registerError"] = "Empty fields";
        header("Location: registerPage.php");
    }
    else{
        $stmt = $conn->prepare("INSERT INTO User (Username, Password, FirstName, LastName, Email, ContactNo, UserType) VALUES (?, ?, ?, ?, ?, ?, 'Customer')");
        $stmt->bind_param("ssssss", $formUsername, $formPassword, $formFirstName, $formLastName, $formEmail, $contactNum);
        $stmt->execute();
    }


    header("Location: registerPage.php");

    $conn->close();

?>