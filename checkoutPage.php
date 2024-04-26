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

        //condition check to see if user is properly logged in
        if(!isset($_SESSION["userID"])){
            header("Location: loginPage.php");
        }

        //include the navigation panel
        include "navigationPanel.php";
    ?>

    
    <div class="checkoutContainer">
        
        <!--section for customer to input delivery details-->
        <div class="checkoutTitle"><h1>Shipping Details</h1></div>
        
        <!--form for checkout-->
        <form class="checkoutForm" name="checkoutForm" action="checkoutVerify.php" method="post">
        
            <!--input field for delivery First Name-->
            <div class="formField checkoutFirstNameField">
                <label class="formLabel checkoutFirstNameLabel" for="checkoutFirstName">First Name</label>
                <input class="formInput checkoutFirstNameInput" type="text" id="checkoutFirstName" name="checkoutFirstName"> 
            </div>

            <!--input field for delivery Last Name-->
            <div class="formField checkoutLastNameField">
                <label class="formLabel checkoutLastNameLabel" for="checkoutLastName">Last Name</label>
                <input class="formInput checkoutLastNameInput" type="text" id="checkoutLastName" name="checkoutLastName"> 
            </div>

            <!--input field for delivery Contact Number-->
            <div class="formField checkoutContactNoField">
                <label class="formLabel checkoutContactNoLabel" for="checkoutContactNo">Contact Number</label>
                <input class="formInput checkoutContactNoInput" type="tel" id="checkoutContactNo" name="checkoutContactNo" minlength="10" maxlength="10" pattern="[0-9]{10}" title="0121112222" placeholder="without '-'">
            </div>

            <!--input field for delivery Address-->
            <div class="formField checkoutAddressField">
                <label class="formLabel checkoutAddressLabel" for="checkoutAddress">Address</label>
                <input class="formInput checkoutAddressInput" type="text" id="checkoutAddress" name="checkoutAddress"> 
            </div>


            <!--section for order summary-->
            <div class="orderSummaryTitle"><h1>Order Summary</h1></div>


            <?php
                //declaring variables for the database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "restaurantDB";

                //connecting to database
                $conn = new mysqli($servername, $username, $password, $dbname);

                //if connection failed, display error message
                if($conn -> connect_error){
                    die("Connection failed: " . $conn -> connect_error);
                }

                //execute sql query to retrieve the food name, price and quantity for each item in the cart table of the logged in user
                $result = $conn -> query("SELECT Food.FoodName, Food.Price, Cart.Quantity FROM Cart INNER JOIN Food ON Cart.FoodID = Food.FoodID WHERE Cart.UserID = '" . $_SESSION["userID"] . "'");

                //initializing counter variables
                $itemCount = 1;
                $grandTotal = 0;
                
                
                //display the order summary table
                echo "<div class='orderSummaryContainer'>";
                
                    //start the table
                    echo "<table class='orderSummaryTable'>";
                        //table header
                        echo "<tr> <th class='tableHeader'>Item No.</th> <th class='tableHeader'>Food Name</th> <th class='tableHeader'>Quantity</th> <th class='tableHeader'>Sub Total</th> </tr>";
                
                        //loop through all the returned rows
                        while($row = $result -> fetch_assoc()){
                            //start a new row
                            echo "<tr class='tableRow'>";
                                //display item number
                                echo "<td class='tableData centerText'>" . $itemCount . "</td>";
                                //display food name
                                echo "<td class='tableData centerText'>" . $row["FoodName"] . "</td>";
                                //display quantity
                                echo "<td class='tableData centerText'>" . $row["Quantity"] . "</td>";
                                //display sub total
                                echo "<td class='tableData rightText'>" . number_format($row["Price"] * $row["Quantity"],2) . "</td>";
                            echo "</tr>";
                            
                            //cumulative sum into grand total
                            $grandTotal += $row["Price"] * $row["Quantity"];
                            //increment item count
                            $itemCount++;
                        }
                
                        echo "<tr class='tableRow'></tr>";
                        //display grand total
                        echo "<tr class='tableRow'> <td class='tableData rightText' colspan='3'>Grand Total</td>";
                        echo "<td class='tableData rightText'>" . number_format($grandTotal,2) . "</td> </tr>";
                
                    echo "</table>";
                
                echo "</div>";
                
                //store the grand total into a session variable (used in paymentVerify.php)
                $_SESSION["cartGrandTotal"] = $grandTotal;
                //close the connection
                $conn -> close();
            ?>
    

            <div class="paymentMethodContainer">
                <!--section for payment method selection-->
                <div class="paymentMethodTitle"><h1>Payment Method</h1></div>
                    
                    <!--field for user to select payment option-->
                    <label class="paymentMethodLabel" for="paymentMethod"></label>
                    <input class="paymentMethodInput" type="radio" id="paymentMethod" name="paymentMethod" value="CreditCard" checked>
                    <img src="icons/creditcardicon.png" alt="Credit Card Icon" class="paymentMethodIcon"> Credit Card
                    <input class="paymentMethodInput" type="radio" id="paymentMethod" name="paymentMethod" value="TouchNGo">
                    <img src="icons/Tngicon.svg" alt="Touch 'n Go Icon" class="paymentMethodIcon"> Touch 'n Go
                </div>
                
                <!--submit button for checkout form-->
                <div class="checkoutSubmitButtonContainer">
                    <input type="submit" name="checkoutSubmitButton" value="Place Order">
                </div>
            </div>

        </form>
        

        <?php
            //display error message if there is any empty fields
            if($_SESSION["checkoutDetailsError"] == "Empty Fields"){
                echo "<h3 class='checkoutError'>Please fill in all fields</h3>";
                $_SESSION["checkoutDetailsError"] = "null";
            }
            //display error message if contact number is invalid
            else if($_SESSION["checkoutDetailsError"] == "Invalid Contact Number"){
                echo "<h3 class='checkoutError'>Invalid Contact Number</h3>";
                $_SESSION["checkoutDetailsError"] = "null";
            }

        ?>

    </div>



</body>

</html>