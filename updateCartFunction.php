<?php
    //load up session variables to be used globally
    session_start();
    
    //declaring variables to get the FoodID and Quantity from the previous URL
    $foodID = $_GET["FoodID"];
    $quantity = $_GET["Quantity"];
    
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

    //execute sql query statement to update the quantity of the selected food item in the cart
    $conn -> query("UPDATE Cart SET Quantity = " . $quantity . " WHERE FoodID = " . $foodID . " AND UserID = '" . $_SESSION["userID"] . "'");

    //close the database connection
    $conn -> close();

    //redirect to the cartPage.php
    header("Location: cartPage.php");
?>