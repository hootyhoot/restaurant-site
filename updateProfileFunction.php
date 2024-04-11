<?php
    session_start();

    $_SESSION["updateProfileError"] = "None";
    $formPassword = $_POST["password"];
    $formFirstName = $_POST["firstName"];
    $formLastName = $_POST["lastName"];
    $formEmail = $_POST["email"];
    $contactNum = $_POST["contactNum"];


    if($_SESSION["updateProfileError"] == "None" && (!is_numeric($contactNum) || str_contains($contactNum, '-')) ){
        $_SESSION["updateProfileError"] = "Invalid Contact Number";
        header("Location: editProfilePage.php");
    }
    else if($_SESSION["updateProfileError"] == "None" && ($formFirstName == "" || $formLastName == "" || $formEmail == "" || $formPassword == "" || $contactNum == "")){
        $_SESSION["updateProfileError"] = "Empty fields";
        header("Location: editProfilePage.php");
    }
    else{

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "restaurantDB";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if($conn -> connect_error){
            die("Connection failed: " . $conn -> connect_error);
        }

        $conn -> query("UPDATE User SET Password = '" . $formPassword . "', FirstName = '" . $formFirstName . "', LastName = '" . $formLastName . "', Email = '" . $formEmail . "', ContactNo = '" . $contactNum . "' WHERE UserID = '" . $_SESSION["userID"] . "'");


        header("Location: editProfilePage.php");
    }

    $conn -> close();

?>