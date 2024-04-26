<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<style>
    .foodContainer {
        background-color: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .foodContainer a {
        text-decoration: none;
        color: black;
    }

    .foodContainer a h3 {
        color: black;
    }

    .foodCategoryPageHeader h1 {
        color: black !important;
    }
    
    .foodCategoryPageHeader {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 50%;
        margin: 0 auto;
        padding: 20px;
        background-color: #f2f2f2;
        box-sizing: border-box;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }


</style>

<body>

    <?php
        //load up session variables to be used globally
        session_start();
        //include the navigation panel
        include "navigationPanel.php";
        define("FOOD_IMAGE_SIZE", 200);
    ?>
    
    <!--Display page heading based on food category selected from navigation panel -->
    <?php
        if($_GET["chosenCategory"] == 1){
            echo "<h1 class='foodCategoryPageHeader'>Appetizers</h1>";
        }
        else if($_GET["chosenCategory"] == 2){
            echo "<h1 class='foodCategoryPageHeader'>Main Courses</h1>";
        }
        else if($_GET["chosenCategory"] == 3){
            echo "<h1 class='foodCategoryPageHeader'>Desserts</h1>";
        }
        
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
        if ($conn -> connect_error){
            die("Connection failed: ". $conn->connect_error);
        }

        //execute sql query statement to fetch all food items that belongs to the selected category
        $result = $conn -> query("SELECT FoodID, FoodName, FoodPic FROM Food WHERE CategoryID=" . $_GET["chosenCategory"]);

        //initialize counter variables
        $count = 0;
        $total_count = 0;

        //loop through all the rows returned by the query
        while($row = $result -> fetch_assoc()){
            
            //if it is the first row, echo the <table> tag (create table)
            if($total_count == 0){
                echo "<table class='foodCategoryTable'>";
            }

            //if it is the first food item in the row, echo the <tr> tag (create row)
            if($count == 0){
                echo "<tr>";
                echo "<td>";
                //display the food picture with the food name (hyperlinked to page with detailed description of that food)
                echo "<div class='foodContainer'>";
                    echo "<a href='specificFoodPage.php?foodID=" . $row['FoodID'] . "'>";
                        echo "<img src='data:image/jpeg;base64,".base64_encode($row['FoodPic'])."' width=" . FOOD_IMAGE_SIZE . " height=" . FOOD_IMAGE_SIZE . "/>";
                        echo "<h3>".$row['FoodName']."</h3>";
                    echo "</a>";
                echo "</div>";
                echo "</td>";
                //increment the counter variables
                $count++;
                $total_count++;
            }
            //if it is not the first food item in the row AND the row has less than 5 items displayed,
            //echo the <td> tag (output to next column on the same row)
            else if($count > 0 && $count < 5){
                echo "<td>";
                echo "<div class='foodContainer'>";
                //display the food picture with the food name (hyperlinked to page with detailed description of that food)
                    echo "<a href='specificFoodPage.php?foodID=" . $row['FoodID'] . "'>";
                        echo "<img src='data:image/jpeg;base64,".base64_encode($row['FoodPic'])."' width=" . FOOD_IMAGE_SIZE . " height=" . FOOD_IMAGE_SIZE . "/>";
                        echo "<h3>".$row['FoodName']."</h3>";
                    echo "</a>";
                echo "</div>";
                echo "</td>";
                //increment the counter variables
                $count++;
                $total_count++;
            }
            //if the row has 5 items displayed already, echo the </tr> tag (end the row) and echo the <tr> tag (start a new row)
            else {
                $count = 0;
                echo "</tr>";
                echo "<tr>";
                echo "<td>";
                //display the food picture with the food name (hyperlinked to page with detailed description of that food)
                echo "<div class='foodContainer'>";
                    echo "<a href='specificFoodPage.php?foodID=" . $row['FoodID'] . "'>";
                        echo "<img src='data:image/jpeg;base64,".base64_encode($row['FoodPic'])."' width=" . FOOD_IMAGE_SIZE . " height=" . FOOD_IMAGE_SIZE . "/>";
                        echo "<h3>".$row['FoodName']."</h3>";
                    echo "</a>";
                echo "</div>";
                echo "</td>";
                //increment the counter variables
                $count++;
                $total_count++;
            }

            //if the total food item displayed is same as the number of rows returned by the query, 
            //echo the </tr> tag (end the row) and echo the </table> tag (end the table)
            if($total_count == $result -> num_rows){
                echo "</tr>";
                echo "</table>";
            }
            
        }

        //close the connection
        $conn -> close();
    ?>



</body>


</html>