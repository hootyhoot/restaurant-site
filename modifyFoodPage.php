<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body style ="background-color:#D4D4D4  ;">

        <?php 
            //load up session variables to be used globally
            session_start();


            //condition check to see if user is properly logged in
            if(!isset($_SESSION["userID"])){
                header("Location: loginPage.php");
            }

            //include the navigation panel
            include "navigationPanel.php";

            //declaring variables for the database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "restaurantDB";

            //connecting to the sql database
            $conn = new mysqli($servername, $username, $password, $dbname);

            //if connection fails, display error message
            if($conn -> connect_error){
                echo"failed";
                die("Connection failed: ". $conn->connect_error);
            }

            //execute sql query statement to fetch the data of the selected food item
            $result = $conn -> query("SELECT * FROM Food WHERE FoodID = " . $_GET["FoodID"]);
            $row = $result -> fetch_assoc();

            //execute sql query statement to fetch all the categories labels
            $catResult = $conn -> query("SELECT * FROM Category");

            //display page header title
            echo "Modify Food: " . $row["FoodName"];
        ?>

<div class="modifyFoodTitle">Modify Food: <?= $row["FoodName"] ?></div>

            <!--form to modify the food item details-->
            <!--form will be populated with existing data of the selected food item upon loading the page-->
<form class="modifyFoodForm" name="modifyFoodForm" action="modifyFoodFunction.php" method="post" enctype="multipart/form-data">

    <input type="hidden" id="foodID" name="foodID" value="<?= $row['FoodID']?>">
            <!--form field for food name-->
                    <div class="formField foodNameField">
                        <label class="formLabel foodNameLabel" for="foodName">Food Name</label>
                        <input class="formInput foodNameInput" type="text" id="foodName" name="foodName" value="<?= $row['FoodName']?>"> 
                    </div>
                    <!--hidden input field to store the FoodID of the selected food item-->
                    <!--to be passed to next page for validation-->
                    <div>
                        <input type="hidden" id="foodID" name="foodID" value="<?= $row['FoodID']?>">
                    </div>

                   

                    <!--form field for food category-->    <div class="formField foodCategoryField">
        <label class="formLabel foodCategoryLabel" for="foodCategory">Food Category</label>
        <select class="formInput foodCategoryInput" name="foodCategory">
                            <?php
                                while($catRow = $catResult -> fetch_assoc()){
                                    //check if the category is the same as the selected food item's category
                                    //if same, set the option as default selected
                                    if($catRow["CategoryID"] == $row["CategoryID"]){
                                        echo "<option value='" . $catRow["CategoryID"] . "' selected>" . $catRow["CategoryName"] . "</option>";
                                    }
                                    //if not, display the category as an option
                                    else{
                                        echo "<option value='" . $catRow["CategoryID"] . "'>" . $catRow["CategoryName"] . "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    
                    <!--form field for food price-->
                    <div class="formField foodPriceField">
            <label class="formLabel foodPriceLabel" for="foodPrice">Price</label>
            <input class="formInput foodPriceInput" type="number" step="0.01" name="foodPrice" value="<?= $row['Price'] ?>">
        </div>

                    <!--form field for food availability-->        <div class="formField foodAvailabilityField">
            <label class="formLabel foodAvailabilityLabel" for="foodAvailability">Availability</label>
            <select class="formInput foodAvailabilityInput" name="foodAvailability">
                            <?php
                                //check if the food item is currently set as available or not
                                //if available, set 'Available' as default selected
                                if($row['Availability'] == 'Available'){
                                    echo "<option value='Available' selected>Available</option>";
                                    echo "<option value='Not Available'>Unavailable</option>";
                                }
                                //if not available, set 'Not Available' as default selected
                                else{
                                    echo "<option value='Available'>Available</option>";
                                    echo "<option value='Not Available' selected>Unavailable</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <!--form field for food description-->
                    <div class="formField foodDescriptionField">
                        <label class="formLabel foodDescriptionLabel" for="foodDescription">Description</label>
                        <input class="formInput foodDescriptionInput" type="text" name="foodDescription" value="<?= $row['Description'] ?>">
                    </div>

                    <!--display current food picture-->
                    <div class="currentPic">
                        <h4>Current Pic</h4>
                        <?= "<img class='currentPicImage' src='data:image/jpeg;base64,".base64_encode($row['FoodPic'])."' width='100' height ='100'/>"; ?>
                    </div>

                    <!--form field to replace the food picture-->
                    <div class="formField foodPicField">
                        <label class="formLabel foodPicLabel" for="foodPic">Replace Pic</label>
                        <input class="formInput foodPicInput" type="file" name="foodPic">
                    </div>

                    <!--form button to submit the form-->
                    <!--form buttons to submit the form and go back-->
                    <div class="formButtonContainer">
                        <input class="formButton saveChangesButton" type="submit" name="modifyFoodSubmitButton" value="Save Changes">
                        
                    </div>

                    <div class="formBackButton">
                        <a class="formButton goBackButton" href='addFoodPage.php'>Go Back</a>
                    </div>
            </form>

            <div class="foodModifyError">


            <?php
                //display error message if a replacement image was uploaded but is not in jpeg
                if($_SESSION["foodModifyError"] == 'imageTypeError'){
                    echo "<h3 style='color:red'>Only JPEG image is accepted</h3>";
                    $_SESSION["foodModifyError"] = 'null';
                }

                //display success message if the food item was modified successfully
                else if($_SESSION["foodModifyError"] == 'None'){
                    echo "<script>alert('Food modified successfully');</script>";
                    $_SESSION["foodModifyError"] = 'null';
                }
            ?>                 

        </div>



</body>

</html>