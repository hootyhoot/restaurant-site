<?php
    //initializing constants for the field names in the form
    define("FOOD_NAME_FIELD", "foodName");
    define("FOOD_CATEGORY_FIELD", "foodCategory");
    define("FOOD_PRICE_FIELD", "foodPrice");
    define("FOOD_AVAILABILITY_FIELD", "foodAvailability");
    define("FOOD_DESCRIPTION_FIELD", "foodDescription");
    define("FOOD_PIC_FIELD", "foodPic");
    
    //load up session variables to be used globally
    session_start();

    //declaring variables for the database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "restaurantDB";

    //connecting to the sql database
    $conn = new mysqli($servername, $username, $password, $dbname);

    //if connection fails, display error message
    if($conn -> connect_error){
        die("Connection failed: ". $conn->connect_error);
    }

    $_SESSION["foodUploadError"] = "None";

    //declaring variables that stores the form inputs from the addFoodPage.php
    $formFoodName = $_POST[FOOD_NAME_FIELD];
    $formFoodCategory = $_POST[FOOD_CATEGORY_FIELD];
    $formFoodPrice = $_POST[FOOD_PRICE_FIELD];
    $formFoodAvailability = $_POST[FOOD_AVAILABILITY_FIELD];
    $formFoodDescription = $_POST[FOOD_DESCRIPTION_FIELD];
    $formFoodPicType = $_FILES[FOOD_PIC_FIELD]['type'];

    //if the image type is not jpeg, or no image is uploaded, 
    //set the 'foodUploadError' session variable and redirect to addFoodPage.php
    if($formFoodPicType != "image/jpeg" || 
        $_FILES[FOOD_PIC_FIELD]['error'] == 4 || 
        ($_FILES[FOOD_PIC_FIELD]['size'] == 0 && $_FILES[FOOD_PIC_FIELD]['error'] == 0) ){
        
        $_SESSION["foodUploadError"] = "imageTypeError";
        header("Location: addFoodPage.php");
    }

    //if the price input is not numeric, set the 'foodUploadError' session variable and redirect to addFoodPage.php
    else if(!is_numeric($formFoodPrice)){
        $_SESSION["foodUploadError"] = "priceError";
        header("Location: addFoodPage.php");
    }

    //if any fields are empty, set the 'foodUploadError' session variable and redirect to addFoodPage.php
    else if($formFoodName == "" || $formFoodDescription == "" || $formFoodPrice == ""){
        $_SESSION["foodUploadError"] = "emptyFields";
        header("Location: addFoodPage.php");
    }

    //if validation passed with no errors, insert the new food item into the database
    //then redirect back to addFoodPage.php
    else{
        $formFoodPic = file_get_contents($_FILES[FOOD_PIC_FIELD]['tmp_name']);

        $stmt = $conn->prepare("INSERT INTO Food (FoodName, Price , Availability , FoodPic , Description , CategoryID ) VALUES (?, ?, ?, ?, ?, ?) ");
        $stmt -> bind_param("ssssss", $formFoodName, $formFoodPrice, $formFoodAvailability, $formFoodPic, $formFoodDescription, $formFoodCategory);

        $stmt -> execute();

        header("Location: addFoodPage.php");
    }

    //close the connection
    $conn->close();

    
?>