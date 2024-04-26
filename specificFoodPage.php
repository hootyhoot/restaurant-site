<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>


<body>

    <?php
        //load up session variables to be used globally
        session_start(); 
        //include the navigation panel
        include "navigationPanel.php";
       //define("FOOD_IMAGE_SIZE", 400);
        define("FOOD_ID", $_GET["foodID"]);
    ?>

    <?php
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

        //execute sql query statement to fetch the data of the selected food item
        $result = $conn -> query("SELECT Food.FoodName, Food.Price, Food.Availability, Food.FoodPic, Food.Description, Category.CategoryName
                                    FROM Food INNER JOIN Category ON Food.CategoryID = Category.CategoryID
                                        WHERE Food.FoodID = " . FOOD_ID);

        //loop through the row returned by the query
        while($row = $result -> fetch_row()){

            echo "<div class='foodTableContainer'>";
                //create a table with two columns
                //left column will picture of the food item
                //right column will contain the information of the food item
                echo "<table>";
                    echo "<tr>";
                        //left column - display the picture of the food item
                
                 //new code
                    echo "<div class='centerImage'>";
                    echo "<img src='data:image/jpeg;base64," . base64_encode($row[3]) . "'/>";
                    echo "</div>";
                        
                        //right column - display the information of the food item
                        echo "<td> <div class='foodInfoContainer'>";
                            //display the food name
                            echo "<h1>" . $row[0] . "</h1>";
                            //display the availability of the food item
                            echo "<p>" . $row[2] . "</p>";
                            //display the food category
                            echo "<p> Food Category: " . $row[5] . "</p>";
                            //display the description of the food item
                            echo "<p> Description: " . $row[4] . "</p>";
                            echo "<p></p>";
                            //display the price of the food item
                            echo "<p> Price: " . $row[1] . "</p>";

                            //if the food item is available, display input field for quantity and a button to add to cart
                            if($row[2] == "Available"){
                                echo "<form action='addToCartFunction.php' method='post'>";
                                    echo "<input type='hidden' name='foodID' value='" . FOOD_ID . "'>";
                                    echo "<label for 'quantity'>Quantity: </label>";
                                        echo "<input type='number' name='quantity' value='1' min='1'>";
                                        //new
                                        echo "<div class='buttonContainer'>";
                                        echo "<input type='submit' value='Add to Cart'>";
                                        echo "</div>";
                                        
                                echo "</form>";
                            }
                            //if the food item is not available, display a message to inform user
                            else{
                                echo "<p> This item is not available. </p>";
                            }

                            //display message if the food item is added to cart successfully
                            if(isset($_SESSION["addedToCart"])){
                                echo "<script type='text/javascript'>alert('Item added to cart successfully');</script>";
                                unset($_SESSION["addedToCart"]);
                            }

                        echo "</div> </td>";
            
            echo "</div>";
        }

        //close the connection
        $conn -> close();
    ?>

</body>


</html>