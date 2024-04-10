<?php
    session_start();
    
    $servername = "localhost";
    $username ="root";
    $password = "";
    $dbname = "restaurantDB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn -> connect_error){
        die("Connection failed: " . $conn -> connect_error);
    }

    $conn -> query("DELETE FROM Cart WHERE FoodID = '" . $_GET["FoodID"] . "' AND UserID = '" . $_SESSION["userID"] . "'");

    header("Location: cartPage.php");

    $conn -> close();
?>