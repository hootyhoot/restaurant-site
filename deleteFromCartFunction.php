<?php
    //load up session variables to be used globally
    session_start();
    
    //declaring variables for the database connection
    $servername = "localhost";
    $username ="root";
    $password = "";
    $dbname = "restaurantDB";

    //connecting to database
    $conn = new mysqli($servername, $username, $password, $dbname);

    //if connection failed, display error message
    if($conn -> connect_error){
        die("Connection failed: " . $conn -> connect_error);
    }

    //execute sql query to delete the selected item from the cart table
    $conn -> query("DELETE FROM Cart WHERE FoodID = '" . $_GET["FoodID"] . "' AND UserID = '" . $_SESSION["userID"] . "'");

    //redirect to the cartPage.php
    header("Location: cartPage.php");

    //close the connection
    $conn -> close();
?>