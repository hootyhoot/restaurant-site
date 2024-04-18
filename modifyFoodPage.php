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

            echo "modify food " . $_GET["FoodID"]
        ?>

        <div>
            
            <form name = "modifyFoodForm" action="modifyFoodFunction.php" method="post" enctype="multipart/form-data">
            
                    <div class="foodFormField">
                        <label class="formLabel" for="foodName">Food Name</label>
                        <input class="formInput" type="text" id="foodName" name="foodName" placeholder="Enter name of food"> 
                    </div>


                    <div class="foodFormField">
                        <label class="formLabel" for="foodCategory">Food Category</label>
                        <select class="formInput" name="foodCategory">
                            <option value="1">Appetizers</option>
                            <option value="2">Main Courses</option>
                            <option value="3">Desserts</option>
                        </select>
                    </div>
                    

                    <div class="foodFormField">
                        <label class="formLabel" for="foodPrice">Price</label>
                        <input class="formInput" type="number" step="0.01" name="foodPrice" placeholder="Enter selling price">
                    </div>


                    <div class="foodFormField">
                        <label class="formLabel" for="foodAvailability">Availability</label>
                        <select class="formInput" name="foodAvailability">
                            <option value="Available">Available</option>
                            <option value="Not Available">Unavailable</option>
                        </select>
                    </div>


                    <div class="foodFormField">
                        <label class="formLabel" for="foodDescription">Description</label>
                        <input class="formInput" type="text" name="foodDescription" placeholder="Enter description of food">
                    </div>


                    <div class="foodFormField">
                        <label class="formLabel" for="foodPic">Add Pic</label>
                        <input class="formInput" type="file" name="foodPic">
                    </div>

                    <div class="foodFormButton">
                        <input class="formButton" type="submit" name="addFoodSubmitButton" value="Add Now">
                    </div>
            </form>

            <?php
                if($_SESSION["foodUploadError"] == 'imageTypeError'){
                    echo "<h3 style='color:red'>Only JPEG image is accepted</h3>";
                    $_SESSION["foodUploadError"] = 'null';
                }

                else if($_SESSION["foodUploadError"] == 'None'){
                    echo "<h3 style='color:green'>Food added successfully</h3>";
                    $_SESSION["foodUploadError"] = 'null';
                }
            ?>                           

        </div>



</body>

</html>