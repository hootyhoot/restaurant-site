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

        <div>
            
            <!--form to modify the food item details-->
            <!--form will be populated with existing data of the selected food item upon loading the page-->
            <form name = "modifyFoodForm" action="modifyFoodFunction.php" method="post" enctype="multipart/form-data">

                    <!--hidden input field to store the FoodID of the selected food item-->
                    <!--to be passed to next page for validation-->
                    <div>
                        <input type="hidden" id="foodID" name="foodID" value="<?= $row['FoodID']?>">
                    </div>

                    <!--form field for food name-->
                    <div class="foodFormField">
                        <label class="formLabel" for="foodName">Food Name</label>
                        <input class="formInput" type="text" id="foodName" name="foodName" value="<?= $row['FoodName']?>"> 
                    </div>

                    <!--form field for food category-->
                    <div class="foodFormField">
                        <label class="formLabel" for="foodCategory">Food Category</label>
                        <select class="formInput" name="foodCategory">
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
                    <div class="foodFormField">
                        <label class="formLabel" for="foodPrice">Price</label>
                        <input class="formInput" type="number" step="0.01" name="foodPrice" value="<?= $row['Price'] ?>">
                    </div>

                    <!--form field for food availability-->
                    <div class="foodFormField">
                        <label class="formLabel" for="foodAvailability">Availability</label>
                        <select class="formInput" name="foodAvailability">
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
                    <div class="foodFormField">
                        <label class="formLabel" for="foodDescription">Description</label>
                        <input class="formInput" type="text" name="foodDescription" value="<?= $row['Description'] ?>">
                    </div>
                    
                    <!--display current food picture-->
                    <div>
                        <h4>Current Pic</h4>
                        <?= "<img src='data:image/jpeg;base64,".base64_encode($row['FoodPic'])."' width='100' height ='100'/>"; ?>
                    </div>

                    <!--form field to replace the food picture-->
                    <div class="foodFormField">
                        <label class="formLabel" for="foodPic">Replace Pic</label>
                        <input class="formInput" type="file" name="foodPic">
                    </div>

                    <!--form button to submit the form-->
                    <div class="foodFormButton">
                        <input class="formButton" type="submit" name="modifyFoodSubmitButton" value="Save Changes">
                    </div>
            </form>


            <?php
                //display error message if a replacement image was uploaded but is not in jpeg
                if($_SESSION["foodModifyError"] == 'imageTypeError'){
                    echo "<h3 style='color:red'>Only JPEG image is accepted</h3>";
                    $_SESSION["foodModifyError"] = 'null';
                }

                //display success message if the food item was modified successfully
                else if($_SESSION["foodModifyError"] == 'None'){
                    echo "<h3 style='color:green'>Food modified successfully</h3>";
                    $_SESSION["foodModifyError"] = 'null';
                }
            ?>                           

        </div>



</body>

</html>