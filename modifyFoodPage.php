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

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "restaurantDB";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if($conn -> connect_error){
                echo"failed";
                die("Connection failed: ". $conn->connect_error);
            }

            $result = $conn -> query("SELECT * FROM Food WHERE FoodID = " . $_GET["FoodID"]);
            $row = $result -> fetch_assoc();

            $catResult = $conn -> query("SELECT * FROM Category");

            echo "Modify Food: " . $row["FoodName"];
        ?>

        <div>
            
            <form name = "modifyFoodForm" action="modifyFoodFunction.php" method="post" enctype="multipart/form-data">

                    <div>
                        <input type="hidden" id="foodID" name="foodID" value="<?= $row['FoodID']?>">
                    </div>

                    <div class="foodFormField">
                        <label class="formLabel" for="foodName">Food Name</label>
                        <input class="formInput" type="text" id="foodName" name="foodName" value="<?= $row['FoodName']?>"> 
                    </div>


                    <div class="foodFormField">
                        <label class="formLabel" for="foodCategory">Food Category</label>
                        <select class="formInput" name="foodCategory">
                            <?php
                                while($catRow = $catResult -> fetch_assoc()){
                                    if($catRow["CategoryID"] == $row["CategoryID"]){
                                        echo "<option value='" . $catRow["CategoryID"] . "' selected>" . $catRow["CategoryName"] . "</option>";
                                    }
                                    else{
                                        echo "<option value='" . $catRow["CategoryID"] . "'>" . $catRow["CategoryName"] . "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    

                    <div class="foodFormField">
                        <label class="formLabel" for="foodPrice">Price</label>
                        <input class="formInput" type="number" step="0.01" name="foodPrice" value="<?= $row['Price'] ?>">
                    </div>


                    <div class="foodFormField">
                        <label class="formLabel" for="foodAvailability">Availability</label>
                        <select class="formInput" name="foodAvailability">
                            <?php
                                if($row['Availability'] == 'Available'){
                                    echo "<option value='Available' selected>Available</option>";
                                    echo "<option value='Not Available'>Unavailable</option>";
                                }
                                else{
                                    echo "<option value='Available'>Available</option>";
                                    echo "<option value='Not Available' selected>Unavailable</option>";
                                }
                            ?>
                        </select>
                    </div>


                    <div class="foodFormField">
                        <label class="formLabel" for="foodDescription">Description</label>
                        <input class="formInput" type="text" name="foodDescription" value="<?= $row['Description'] ?>">
                    </div>
                    
                    <div>
                        <h4>Current Pic</h4>
                        <?= "<img src='data:image/jpeg;base64,".base64_encode($row['FoodPic'])."' width='100' height ='100'/>"; ?>
                    </div>

                    <div class="foodFormField">
                        <label class="formLabel" for="foodPic">Replace Pic</label>
                        <input class="formInput" type="file" name="foodPic">
                    </div>

                    <div class="foodFormButton">
                        <input class="formButton" type="submit" name="modifyFoodSubmitButton" value="Save Changes">
                    </div>
            </form>

            <?php
                if($_SESSION["foodModifyError"] == 'imageTypeError'){
                    echo "<h3 style='color:red'>Only JPEG image is accepted</h3>";
                    $_SESSION["foodModifyError"] = 'null';
                }

                else if($_SESSION["foodModifyError"] == 'None'){
                    echo "<h3 style='color:green'>Food modified successfully</h3>";
                    $_SESSION["foodModifyError"] = 'null';
                }
            ?>                           

        </div>



</body>

</html>