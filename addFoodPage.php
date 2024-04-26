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
            //include the navigation panel
            include "navigationPanel.php";
        ?>



        <!-----------Header Title for the Page---------------------->
        <div class="addFoodPageHeader">
            
            <h1>Add Food</h1>

        </div>




        <!-----------Form to add new food into menu---------------------->
        <div class="addFoodFormContainer">
            
            <form name = "addFoodForm" action="addFoodFunction.php" method="post" enctype="multipart/form-data">
            
                    <!--label and input field for food name-->
                    <div class="foodFormField">
                        <label class="formLabel" for="foodName">Food Name</label>
                        <input class="formInput" type="text" id="foodName" name="foodName" placeholder="Enter name of food"> 
                    </div>

                    
                    <!--label and input field for food category-->
                    <div class="foodFormField">
                        <label class="formLabel" for="foodCategory">Food Category</label>
                        <select class="formInput" name="foodCategory">
                            <option value="1">Appetizers</option>
                            <option value="2">Main Courses</option>
                            <option value="3">Desserts</option>
                        </select>
                    </div>
                    

                    <!--label and input field for food price-->
                    <div class="foodFormField">
                        <label class="formLabel" for="foodPrice">Price</label>
                        <input class="formInput" type="number" step="0.01" min='0.01' name="foodPrice" placeholder="Enter selling price">
                    </div>


                    <!--label and input field for food availability-->
                    <div class="foodFormField">
                        <label class="formLabel" for="foodAvailability">Availability</label>
                        <select class="formInput" name="foodAvailability">
                            <option value="Available">Available</option>
                            <option value="Not Available">Unavailable</option>
                        </select>
                    </div>


                    <!--label and input field for food description-->
                    <div class="foodFormField">
                        <label class="formLabel" for="foodDescription">Description</label>
                        <input class="formInput" type="text" name="foodDescription" placeholder="Enter description of food">
                    </div>


                    <!--label and file upload field for food picture-->
                    <div class="foodFormField">
                        <label class="formLabel" for="foodPic">Add Pic</label>
                        <input class="formInput" type="file" name="foodPic">
                    </div>


                    <!--submit button to add food into the menu-->
                    <div class="foodFormButton">
                        <input class="formButton" type="submit" name="addFoodSubmitButton" value="Add Now">
                    </div>
            </form>

        
            <?php
                //display error message if food is not added successfully due to incorrect image type
                if($_SESSION["foodUploadError"] == 'imageTypeError'){
                    echo "<h3 style='color:red'>Only JPEG image is accepted</h3>";
                    $_SESSION["foodUploadError"] = 'null';
                }

                //display message if food is successfully added
                else if($_SESSION["foodUploadError"] == 'None'){
                    echo "<h3 style='color:green'>Food added successfully</h3>";
                    $_SESSION["foodUploadError"] = 'null';
                }
            ?>                           

        </div>





        <!-----------Table to display all the current food records---------------------->
        <div class="currentFoodRecords">
               
                <h1>Current Food Records</h1>
                
                <!--start table to display all the food records-->
                <table class="foodRecordTable">
                    
                    <div class="tableHeader">
                        <!--table headers-->
                        <tr>
                            <th class='foodRecordHeader'>FoodID</th>
                            <th class='foodRecordHeader'>Food Name</th>
                            <th class='foodRecordHeader'>Price</th>
                            <th class='foodRecordHeader'>Availability</th>
                            <th class='foodRecordHeader'>Food Picture</th>
                            <th class='foodRecordHeader'>Description</th>
                            <th class='foodRecordHeader'>Category Name</th>
                            <th></th>
                        </tr>
                    </div>

                    <?php
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
                        
                        //execute sql query statement to fetch all food records that match the selected food category
                        //enter block if query returns rows
                        if($result = $conn->query("SELECT Food.*, Category.CategoryName FROM Food 
                                        INNER JOIN Category ON Food.CategoryID = Category.CategoryID ORDER BY Food.CategoryID ASC")){                      

                            //loop through all the rows returned by the query
                            while ($row = $result ->fetch_row()){
                                //make subclass name for this one.
                                //echo the table row and display the food records
                                echo"<tr>";
                                echo"<td class='foodRecordCell'>"; echo $row[0]; echo"</td>";
                                echo"<td class='foodRecordCell'>"; echo $row[1]; echo"</td>";
                                echo"<td class='foodRecordCell'>"; echo $row[2]; echo"</td>";
                                echo "<td class='foodRecordCell'>"; echo $row[3]; echo "</td>";
                                
                                echo"<div class='foodImage'>";
                                    echo"<td class='foodRecordCell'>"; echo "<img src='data:image/jpeg;base64,".base64_encode($row[4])."' width='100' height ='100'/>"; echo"</td>";
                                echo"</div>";

                                echo"<td class='foodRecordCell' style='font-size: 12px;'>"; echo $row[5]; echo"</td>";
                                echo "<td class='foodRecordCell'>"; echo $row[7]; echo "</td>";

                                    
                                    //display a button that will link to the modifyFoodPage.php with the food id of the selected food
                                    echo "<td>"; echo "<a class='modifyButton' href='modifyFoodPage.php?FoodID=".$row[0]; echo "'>Modify</a>"; echo "</td>";

                                echo "</tr>";

                            }
                        }

                        //close the connection
                        $conn -> close();
                    ?>

                </table>
                            
        </div>



</body>


</html>