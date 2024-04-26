<?php
    //load up session variables to be used globally
    session_start();

    $_SESSION["updateProfileError"] = "None";

    //declaring variables for the form inputs from editProfilePage.php
    $formPassword = $_POST["password"];
    $formFirstName = $_POST["firstName"];
    $formLastName = $_POST["lastName"];
    $formEmail = $_POST["email"];
    $contactNum = $_POST["contactNum"];

    //if contact number from input field is not numeric or contains '-', set updateProfileError and redirect to editProfilePage.php
    if($_SESSION["updateProfileError"] == "None" && (!is_numeric($contactNum) || str_contains($contactNum, '-')) ){
        $_SESSION["updateProfileError"] = "Invalid Contact Number";
        header("Location: editProfilePage.php");
    }
    //if any fields from input field are empty, set updateProfileError and redirect to editProfilePage.php
    else if($_SESSION["updateProfileError"] == "None" && ($formFirstName == "" || $formLastName == "" || $formEmail == "" || $formPassword == "" || $contactNum == "")){
        $_SESSION["updateProfileError"] = "Empty fields";
        header("Location: editProfilePage.php");
    }
    //if validation passed, update the user details in the database and redirect to editProfilePage.php
    else if($_SESSION["updateProfileError"] == "None"){
        //declaring variables for the database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "restaurantDB";

        //connecting to the sql database
        $conn = new mysqli($servername, $username, $password, $dbname);

        //if connection fails, display error message
        if($conn -> connect_error){
            die("Connection failed: " . $conn -> connect_error);
        }

        //execute sql query to update the user details in the User table based on user input in the form
        $conn -> query("UPDATE User SET Password = '" . $formPassword . "', FirstName = '" . $formFirstName . "', LastName = '" . $formLastName . "', Email = '" . $formEmail . "', ContactNo = '" . $contactNum . "' WHERE UserID = '" . $_SESSION["userID"] . "'");

        //redirect to editProfilePage.php
        header("Location: editProfilePage.php");
    }

    //close the database connection
    $conn -> close();

?>