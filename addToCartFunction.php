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

    $result = $conn -> query("SELECT CartID FROM Cart WHERE UserID = '" . $_SESSION["userID"] . "' AND FoodID = '" . FOOD_ID . "'");

    if($result -> num_rows > 0){
        $row = $result -> fetch_assoc();
        $conn -> query("UPDATE Cart SET Quantity = Quantity + " . QUANTITY . " WHERE CartID = " . $row["CartID"]);
    }
    else{
        $conn -> query("INSERT INTO Cart (UserID, FoodID, Quantity) VALUES (" . $_SESSION["userID"] . ", " . FOOD_ID . ", " . QUANTITY . ")" );
    }
    
    $_SESSION["addedToCart"] = "true";

    header("Location: specificFoodPage.php?foodID=" . FOOD_ID);


    $conn -> close();

?>