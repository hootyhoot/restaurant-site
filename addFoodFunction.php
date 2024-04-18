<?php
    define("FOOD_NAME_FIELD", "foodName");
    define("FOOD_CATEGORY_FIELD", "foodCategory");
    define("FOOD_PRICE_FIELD", "foodPrice");
    define("FOOD_AVAILABILITY_FIELD", "foodAvailability");
    define("FOOD_DESCRIPTION_FIELD", "foodDescription");
    define("FOOD_PIC_FIELD", "foodPic");
    

    session_start();


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "restaurantDB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn -> connect_error){
        die("Connection failed: ". $conn->connect_error);
    }

    $_SESSION["foodUploadError"] = "None";

    $formFoodName = $_POST[FOOD_NAME_FIELD];
    $formFoodCategory = $_POST[FOOD_CATEGORY_FIELD];
    $formFoodPrice = $_POST[FOOD_PRICE_FIELD];
    $formFoodAvailability = $_POST[FOOD_AVAILABILITY_FIELD];
    $formFoodDescription = $_POST[FOOD_DESCRIPTION_FIELD];
    $formFoodPicType = $_FILES[FOOD_PIC_FIELD]['type'];
    $null = NULL;

    if($formFoodPicType != "image/jpeg" || !($formFoodPic = file_get_contents($_FILES[FOOD_PIC_FIELD]['tmp_name'])) ){
        $_SESSION["foodUploadError"] = "imageTypeError";
        header("Location: addFoodPage.php");
    }

    else{
        $stmt = $conn->prepare("INSERT INTO Food (FoodName, Price , Availability , FoodPic , Description , CategoryID ) VALUES (?, ?, ?, ?, ?, ?) ");
        $stmt -> bind_param("ssssss", $formFoodName, $formFoodPrice, $formFoodAvailability, $formFoodPic, $formFoodDescription, $formFoodCategory);

        $stmt -> execute();

        header("Location: addFoodPage.php");
    }

    $conn->close();

    
?>