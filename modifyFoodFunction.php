<?php
    //defining constants for form fields from modifyFoodPage.php
    define("FOOD_ID_FIELD", "foodID");
    define("FOOD_NAME_FIELD", "foodName");
    define("FOOD_CATEGORY_FIELD", "foodCategory");
    define("FOOD_PRICE_FIELD", "foodPrice");
    define("FOOD_AVAILABILITY_FIELD", "foodAvailability");
    define("FOOD_DESCRIPTION_FIELD", "foodDescription");
    define("FOOD_PIC_FIELD", "foodPic");

    //load up session variables to be used globally
    session_start();

    $_SESSION["foodModifyError"] = "None";

    //declaring variables for the input fields from modifyFoodPage.php
    $formFoodID = $_POST[FOOD_ID_FIELD];
    $formFoodName = $_POST[FOOD_NAME_FIELD];
    $formFoodCategory = $_POST[FOOD_CATEGORY_FIELD];
    $formFoodPrice = $_POST[FOOD_PRICE_FIELD];
    $formFoodAvailability = $_POST[FOOD_AVAILABILITY_FIELD];
    $formFoodDescription = $_POST[FOOD_DESCRIPTION_FIELD];
    $formFoodPicType = $_FILES[FOOD_PIC_FIELD]['type'];
    //variable to determine if the food pic is to be replaced
    $replacePic = 0;

    //if a new image was uploaded to the form
    if(!($_FILES[FOOD_PIC_FIELD]['size'] == 0)){
        
        //check if uploaded image was jpeg, if yes, store contents of uploaded image in formFoodPic
        //set replacePic to 1 to indicate that the image is to be replaced
        if($formFoodPicType == "image/jpeg"){
            $formFoodPic = file_get_contents($_FILES[FOOD_PIC_FIELD]['tmp_name']);
            $replacePic = 1;
        }
        //if not jpeg, set 'foodModifyError' session variable and redirect to modifyFoodPage.php
        else{
            $_SESSION["foodModifyError"] = "imageTypeError";
            header("Location: modifyFoodPage.php?FoodID=" . $formFoodID);
        }
    }



    //if the price input is not numeric, set the 'foodModifyError' session variable and redirect to modifyFoodPage.php
    if($_SESSION["foodModifyError"]=="None" && !is_numeric($formFoodPrice)){
        $_SESSION["foodModifyError"] = "priceError";
        header("Location: modifyFoodPage.php?FoodID=" . $formFoodID);
    }

    //if any fields are empty, set the 'foodModifyError' session variable and redirect to modifyFoodPage.php
    else if($_SESSION["foodModifyError"]=="None" && ($formFoodName == "" || $formFoodDescription == "" || $formFoodPrice == "")){
        $_SESSION["foodModifyError"] = "emptyFields";
        header("Location: modifyFoodPage.php?FoodID=" . $formFoodID);
    }
    
    //if validation passed with no errors, update the food item in the database
    else if($_SESSION["foodModifyError"] == "None"){

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

        //if the image is to be replaced, update the Food table with new input along with new image
        if($replacePic){
            $stmt = $conn->prepare("UPDATE Food SET FoodName = '$formFoodName', Price = '$formFoodPrice', 
                                        Availability = '$formFoodAvailability', FoodPic = ?, Description = '$formFoodDescription', 
                                        CategoryID = '$formFoodCategory' WHERE FoodID = '$formFoodID'");

            $stmt -> bind_param("s", $formFoodPic);

            $stmt -> execute();

        }

        //else, just update the Food table with new input and keep the old image
        else{
            $conn -> query("UPDATE Food SET FoodName = '$formFoodName', Price = '$formFoodPrice', 
                                Availability = '$formFoodAvailability', Description = '$formFoodDescription', 
                                CategoryID = '$formFoodCategory' WHERE FoodID = '$formFoodID'");
        }


        //to remove all the food items from the cart if the food is changed to 'unavailable'
        if($formFoodAvailability == "Not Available"){
            $conn -> query("DELETE FROM Cart WHERE FoodID = '$formFoodID'");
        }
        
        //close the database connection
        $conn -> close();

        //redirect to modifyFoodPage.php
        header("Location: modifyFoodPage.php?FoodID=" . $formFoodID);
    }

?>