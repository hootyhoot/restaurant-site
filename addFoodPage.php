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
        ?>



        <!-----------Header Title for the Page---------------------->
        <div class="addFoodPageHeader">
            
            <h1>Add Food</h1>

        </div>





        <div class="addFoodFormContainer">
            
            <form name = "addFoodForm" action="addFoodFunction.php" method="post" enctype="multipart/form-data">
            
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





        <div class="currentFoodRecords">
               

                <table class="foodRecordTable">
                    
                    <div class="tableHeader">
                        <tr>
                            <th>FoodID</th>
                            <th>FoodName</th>
                            <th>Price</th>
                            <th>Availability</th>
                            <th>FoodPic</th>
                            <th>Description</th>
                            <th>CategoryID</th>
                            <th>Delete</th>

                        </tr>
                    </div>

                    <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "restaurantDB";
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        if($conn -> connect_error){
                            echo"failed";
                            die("Connection failed: ". $conn->connect_error);
                        }
                        
                        if($result = $conn->query("SELECT Food.*, Category.CategoryName FROM Food INNER JOIN Category ON Food.CategoryID = Category.CategoryID ORDER BY Food.CategoryID ASC")){                      

                            while ($row = $result ->fetch_row()){

                                echo"<tr>";
                                echo"<td>"; echo $row[0]; echo"</td>";
                                echo"<td>"; echo $row[1]; echo"</td>";
                                echo"<td>"; echo $row[2]; echo"</td>";
                                echo "<td>"; echo $row[3]; echo "</td>";
                                
                                echo"<div class='foodImage'>";
                                    echo"<td>"; echo "<img src='data:image/jpeg;base64,".base64_encode($row[4])."' width='100' height ='100'/>"; echo"</td>";
                                echo"</div>";

                                echo"<td style='font-size: 12px;'>"; echo $row[5]; echo"</td>";
                                echo "<td>"; echo $row[6]; echo "</td>";

                                echo "<td>"; echo "<a href='deleteFoodFunction.php?FoodID=".$row[0]; echo "'>Delete</a>"; echo "</td>";

                                echo "</tr>";

                            }
                        }
                        $conn -> close();
                    ?>

                </table>
                            
        </div>



</body>


</html>