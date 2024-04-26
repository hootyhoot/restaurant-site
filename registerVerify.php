<?php

    //defining constants to store all the field names from the registration form
    define("FIRST_NAME_FIELD", "firstName");
    define("LAST_NAME_FIELD", "lastName");
    define("EMAIL_FIELD", "email");
    define("USERNAME_FIELD", "username");
    define("PASSWORD_FIELD", "password");
    define("CONFIRM_PASSWORD_FIELD", "confirmPassword");
    define("CONTACT_NUM_FIELD", "contactNum");

    //load up session variables to be used globally
    session_start();

    //set the 'registerError' session variable to 'None'
    //so that if no errors are flag in the validation below, the validation is automatically considered to have passed
    $_SESSION["registerError"] = "None";

    //declaring variables for the database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "restaurantDB";

    //connecting to the sql database
    $conn = new mysqli($servername, $username, $password, $dbname);

    //if connection fails, display error message
    if($conn -> connect_error){
        die("Connection failed: ". $conn->connect_error);
    }

    //declaring variables that stores the form inputs from the registration page
    $formFirstName = $_POST[FIRST_NAME_FIELD];
    $formLastName = $_POST[LAST_NAME_FIELD];
    $formEmail = $_POST[EMAIL_FIELD];
    $formUsername = $_POST[USERNAME_FIELD];
    $formPassword = $_POST[PASSWORD_FIELD];
    $formConfirmPassword = $_POST[CONFIRM_PASSWORD_FIELD];
    $contactNum = $_POST[CONTACT_NUM_FIELD];

    //preparing sql statement to fetch all existing usernames from the database
    $stmt = $conn->prepare("SELECT Username FROM User WHERE Username = ?");
    $stmt->bind_param("s", $formUsername);
    //execute query statement
    $stmt->execute();
    //get the result of the query and store it in queryUsername variable
    $stmt->bind_result($queryUsername);

    //loop through all the rows returned by the query
    while($stmt->fetch()){
        //if the username input by user matches with any of the existing usernames,
        //set the 'registerError' session variable and redirect to registration page
        if($queryUsername == $formUsername){
            $_SESSION["registerError"] = "Username already exists";
            header("Location: registerPage.php");
        }
    }


    //conditions for form validation
    //-----------------------------------------------------------
    //if user's password and confirm password do not match, set the 'registerError' session variable and redirect to registration page
    if($_SESSION["registerError"] == "None" && $formPassword != $formConfirmPassword){
        $_SESSION["registerError"] = "Passwords do not match";
        header("Location: registerPage.php");
    }
    //if user's contact number is not numeric or contains a hyphen, set the 'registerError' session variable and redirect to registration page
    else if($_SESSION["registerError"] == "None" && (!is_numeric($contactNum) || str_contains($contactNum, '-')) ){
        $_SESSION["registerError"] = "Invalid Contact Number";
        header("Location: registerPage.php");
    }
    //if any of the fields are empty, set the 'registerError' session variable and redirect to registration page
    else if($_SESSION["registerError"] == "None" && ($formFirstName == "" || $formLastName == "" || $formEmail == "" || $formUsername == "" || $formPassword == "" || $formConfirmPassword == "" || $contactNum == "")){
        $_SESSION["registerError"] = "Empty fields";
        header("Location: registerPage.php");
    }
    //if no errors are raised, then proceed to insert user registration data into the database
    else if($_SESSION["registerError"] == "None"){
        $stmt = $conn->prepare("INSERT INTO User (Username, Password, FirstName, LastName, Email, ContactNo, UserType) VALUES (?, ?, ?, ?, ?, ?, 'Customer')");
        $stmt->bind_param("ssssss", $formUsername, $formPassword, $formFirstName, $formLastName, $formEmail, $contactNum);
        $stmt->execute();
    }

    //redirect to registration page
    header("Location: registerPage.php");

    //close the connection
    $conn->close();

?>