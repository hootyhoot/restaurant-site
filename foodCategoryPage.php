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

<body background="foodcategory.jpg">

    <?php 
        session_start(); 
        include "navigationPanel.php";
        define("FOOD_IMAGE_SIZE", 200);
    ?>
    
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
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "restaurantDB";
    
    
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        if ($conn -> connect_error){
            die("Connection failed: ". $conn->connect_error);
        }

        $result = $conn -> query("SELECT FoodID, FoodName, FoodPic FROM Food WHERE CategoryID=" . $_GET["chosenCategory"]);

        $count = 0;
        $total_count = 0;

        while($row = $result -> fetch_assoc()){
            
            if($total_count == 0){
                echo "<table class='foodCategoryTable'>";
            }

            if($count == 0){
                echo "<tr>";
                echo "<td>";
                echo "<div class='foodContainer'>";
                    echo "<a href='specificFoodPage.php?foodID=" . $row['FoodID'] . "'>";
                        echo "<img src='data:image/jpeg;base64,".base64_encode($row['FoodPic'])."' width=" . FOOD_IMAGE_SIZE . " height=" . FOOD_IMAGE_SIZE . "/>";
                        
                        echo "<h3>".$row['FoodName']."</h3>";
                    echo "</a>";
                echo "</div>";
                echo "</td>";
                $count++;
                $total_count++;
            }
            else if($count > 0 && $count < 5){
                echo "<td>";
                echo "<div class='foodContainer'>";
                    echo "<a href='specificFoodPage.php?foodID=" . $row['FoodID'] . "'>";
                        echo "<img src='data:image/jpeg;base64,".base64_encode($row['FoodPic'])."' width=" . FOOD_IMAGE_SIZE . " height=" . FOOD_IMAGE_SIZE . "/>";
                        echo "<h3>".$row['FoodName']."</h3>";
                    echo "</a>";
                echo "</div>";
                echo "</td>";
                $count++;
                $total_count++;
            }
            else {
                $count = 0;
                echo "</tr>";
                echo "<tr>";
                echo "<td>";
                echo "<div class='foodContainer'>";
                    echo "<a href='specificFoodPage.php?foodID=" . $row['FoodID'] . "'>";
                        echo "<img src='data:image/jpeg;base64,".base64_encode($row['FoodPic'])."' width=" . FOOD_IMAGE_SIZE . " height=" . FOOD_IMAGE_SIZE . "/>";
                        echo "<h3>".$row['FoodName']."</h3>";
                    echo "</a>";
                echo "</div>";
                echo "</td>";
                $count++;
                $total_count++;
            }

            if($total_count == $result -> num_rows){
                echo "</tr>";
                echo "</table>";
            }
            
        }

        $conn -> close();
    ?>



</body>


</html>