<?php

    define("FOOD_ID_FIELD", "foodID");
    define("FOOD_NAME_FIELD", "foodName");
    define("FOOD_CATEGORY_FIELD", "foodCategory");
    define("FOOD_PRICE_FIELD", "foodPrice");
    define("FOOD_AVAILABILITY_FIELD", "foodAvailability");
    define("FOOD_DESCRIPTION_FIELD", "foodDescription");
    define("FOOD_PIC_FIELD", "foodPic");


    session_start();

    $_SESSION["foodModifyError"] = "None";

    $formFoodID = $_POST[FOOD_ID_FIELD];
    $formFoodName = $_POST[FOOD_NAME_FIELD];
    $formFoodCategory = $_POST[FOOD_CATEGORY_FIELD];
    $formFoodPrice = $_POST[FOOD_PRICE_FIELD];
    $formFoodAvailability = $_POST[FOOD_AVAILABILITY_FIELD];
    $formFoodDescription = $_POST[FOOD_DESCRIPTION_FIELD];
    $formFoodPicType = $_FILES[FOOD_PIC_FIELD]['type'];
    $replacePic = 0;

    if(!($_FILES[FOOD_PIC_FIELD]['size'] == 0)){
        
        if($formFoodPicType == "image/jpeg"){
            $formFoodPic = file_get_contents($_FILES[FOOD_PIC_FIELD]['tmp_name']);
            $replacePic = 1;
        }
        else{
            $_SESSION["foodModifyError"] = "imageTypeError";
            header("Location: modifyFoodPage.php?FoodID=" . $formFoodID);
        }
    }



    if($_SESSION["foodModifyError"] == "None"){

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "restaurantDB";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if($conn -> connect_error){
            die("Connection failed: ". $conn->connect_error);
        }

        if($replacePic){
            $stmt = $conn->prepare("UPDATE Food SET FoodName = '$formFoodName', Price = '$formFoodPrice', 
                                        Availability = '$formFoodAvailability', FoodPic = ?, Description = '$formFoodDescription', 
                                        CategoryID = '$formFoodCategory' WHERE FoodID = '$formFoodID'");

            $stmt -> bind_param("s", $formFoodPic);

            $stmt -> execute();

        }
        else{
            $conn -> query("UPDATE Food SET FoodName = '$formFoodName', Price = '$formFoodPrice', 
                                Availability = '$formFoodAvailability', Description = '$formFoodDescription', 
                                CategoryID = '$formFoodCategory' WHERE FoodID = '$formFoodID'");
        }


        //to remove all the food items from the cart if the food is changed to 'unavailable'
        if($formFoodAvailability == "Not Available"){
            $conn -> query("DELETE FROM Cart WHERE FoodID = '$formFoodID'");
        }
        
        $conn -> close();

        header("Location: modifyFoodPage.php?FoodID=" . $formFoodID);
    }

?>