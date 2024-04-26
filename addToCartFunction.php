<?php
    //load up session variables to be used globally
    session_start();
    
    //declaring constants for the form inputs from the specificFoodPage.php
    define("FOOD_ID", $_POST["foodID"]);
    define("QUANTITY", $_POST["quantity"]);

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

    //execute sql query statement to select the cart item based on the UserID and FoodID of the selected food item
    $result = $conn -> query("SELECT CartID FROM Cart WHERE UserID = '" . $_SESSION["userID"] . "' AND FoodID = '" . FOOD_ID . "'");

    //if query returns a row, means a similar food item is already in the cart
    //update the quantity of the food item in the cart instead of adding a new row
    if($result -> num_rows > 0){
        $row = $result -> fetch_assoc();
        $conn -> query("UPDATE Cart SET Quantity = Quantity + " . QUANTITY . " WHERE CartID = " . $row["CartID"]);
    }
    //if query returns no row, means the food item is not in the cart
    //add the food item into cart as a new row
    else{
        $conn -> query("INSERT INTO Cart (UserID, FoodID, Quantity) VALUES (" . $_SESSION["userID"] . ", " . FOOD_ID . ", " . QUANTITY . ")" );
    }
    
    //set session variable to indicate that the food item has been added to cart
    $_SESSION["addedToCart"] = "true";

    //redirect to the specificFoodPage.php
    header("Location: specificFoodPage.php?foodID=" . FOOD_ID);

    //close the database connection
    $conn -> close();

?>