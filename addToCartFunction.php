<?php
    session_start();
    
    define("FOOD_ID", $_POST["foodID"]);
    define("QUANTITY", $_POST["quantity"]);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "restaurantDB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn -> connect_error){
        die("Connection failed: " . $conn -> connect_error);
    }

    $conn -> query("INSERT INTO Cart (UserID, FoodID, Quantity) VALUES (" . $_SESSION["userID"] . ", " . FOOD_ID . ", " . QUANTITY . ")" );

    $_SESSION["addedToCart"] = "true";

    header("Location: specificFoodPage.php?foodID=" . FOOD_ID);


    $conn -> close();

?>