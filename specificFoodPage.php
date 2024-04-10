<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>


<body>

    <?php 
        session_start(); 
        include "navigationPanel.php";
        define("FOOD_IMAGE_SIZE", 400);
        define("FOOD_ID", $_GET["foodID"]);
    ?>

    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "restaurantDB";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if($conn -> connect_error){
            die("Connection failed: " . $conn -> connect_error);
        }

        $result = $conn -> query("SELECT Food.FoodName, Food.Price, Food.Availability, Food.FoodPic, Food.Description, Category.CategoryName
                                    FROM Food INNER JOIN Category ON Food.CategoryID = Category.CategoryID
                                        WHERE Food.FoodID = " . FOOD_ID);

        while($row = $result -> fetch_row()){
            echo "<div class='foodTableContainer'>";
                echo "<table>";
                    echo "<tr>";
                        echo "<td> <img src='data:image/jpeg;base64," . base64_encode($row[3]) . "' width=' ". FOOD_IMAGE_SIZE
                                    . "' height ='" . FOOD_IMAGE_SIZE . "'/> </td>";
                        
                        echo "<td> <div class='foodInfoContainer'>";
                            
                            echo "<h1>" . $row[0] . "</h1>";
                            echo "<p>" . $row[2] . "</p>";
                            echo "<p> Food Category: " . $row[5] . "</p>";
                            echo "<p> Description: " . $row[4] . "</p>";
                            echo "<p></p>";
                            echo "<p> Price: " . $row[1] . "</p>";

                            if($row[2] == "Available"){
                                echo "<form action='addToCartFunction.php' method='post'>";
                                    echo "<input type='hidden' name='foodID' value='" . FOOD_ID . "'>";
                                    echo "<label for 'quantity'>Quantity: </label>";
                                        echo "<input type='number' name='quantity' value='1' min='1'>";
                                    echo "<input type='submit' value='Add to Cart'>";
                                echo "</form>";
                            }
                            else{
                                echo "<p> This item is not available. </p>";
                            }


                            if(isset($_SESSION["addedToCart"])){
                                echo "<h3 style='color: green'>Item added to cart successfully</h3>";
                                unset($_SESSION["addedToCart"]);
                            }

                        echo "</div> </td>";
            
            echo "</div>";
        }

        $conn -> close();
    ?>

</body>


</html>