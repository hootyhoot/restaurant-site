<?php
    session_start();
    
    $foodID = $_GET["FoodID"];
    $quantity = $_GET["Quantity"];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "restaurantDB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn -> connect_error){
        die("Connection failed: " . $conn -> connect_error);
    }

    $conn -> query("UPDATE Cart SET Quantity = " . $quantity . " WHERE FoodID = " . $foodID . " AND UserID = '" . $_SESSION["userID"] . "'");

    $conn -> close();

    header("Location: cartPage.php");
?>