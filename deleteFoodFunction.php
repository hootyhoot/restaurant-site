<?php


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "restaurantDB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn -> connect_error){
        die("Connection failed: ". $conn->connect_error);
    }


    $FoodID=$_GET["FoodID"];

    $conn -> query("DELETE FROM Food WHERE FoodID = {$FoodID}");

    header("Location: addFoodPage.php");


?>
