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

    <div class="checkoutContainer">
            
        <div class="checkoutTitle"><h1>Shipping Details</h1></div>
        
        <form class="checkoutForm" name="checkoutForm" action="checkoutVerify.php" method="post">
        
            <div class="formField checkoutFirstNameField">
                <label class="formLabel checkoutFirstNameLabel" for="checkoutFirstName">First Name</label>
                <input class="formInput checkoutFirstNameInput" type="text" id="checkoutFirstName" name="checkoutFirstName"> 
            </div>

            <div class="formField checkoutLastNameField">
                <label class="formLabel checkoutLastNameLabel" for="checkoutLastName">Last Name</label>
                <input class="formInput checkoutLastNameInput" type="text" id="checkoutLastName" name="checkoutLastName"> 
            </div>

            <div class="formField checkoutContactNoField">
                <label class="formLabel checkoutContactNoLabel" for="checkoutContactNo">Contact Number</label>
                <input class="formInput checkoutContactNoInput" type="tel" id="checkoutContactNo" name="checkoutContactNo" minlength="10" maxlength="10" pattern="[0-9]{10}" title="0121112222" placeholder="without '-'">
            </div>

            <div class="formField checkoutAddressField">
                <label class="formLabel checkoutAddressLabel" for="checkoutAddress">Address</label>
                <input class="formInput checkoutAddressInput" type="text" id="checkoutAddress" name="checkoutAddress"> 
            </div>

            <div class="orderSummaryTitle"><h1>Order Summary</h1></div>


            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "restaurantDB";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if($conn -> connect_error){
                    die("Connection failed: " . $conn -> connect_error);
                }

                $result = $conn -> query("SELECT Food.FoodName, Food.Price, Cart.Quantity FROM Cart INNER JOIN Food ON Cart.FoodID = Food.FoodID WHERE Cart.UserID = '" . $_SESSION["userID"] . "'");

                $itemCount = 1;
                $grandTotal = 0;
                
                
                echo "<div class='orderSummaryContainer'>";
                
                    echo "<table class='orderSummaryTable'>";
                        echo "<tr> <th class='tableHeader'>Item No.</th> <th class='tableHeader'>Food Name</th> <th class='tableHeader'>Quantity</th> <th class='tableHeader'>Sub Total</th> </tr>";
                
                        while($row = $result -> fetch_assoc()){
                            echo "<tr class='tableRow'>";
                                echo "<td class='tableData centerText'>" . $itemCount . "</td>";
                                echo "<td class='tableData centerText'>" . $row["FoodName"] . "</td>";
                                echo "<td class='tableData centerText'>" . $row["Quantity"] . "</td>";
                                echo "<td class='tableData rightText'>" . number_format($row["Price"] * $row["Quantity"],2) . "</td>";
                            echo "</tr>";
                
                            $grandTotal += $row["Price"] * $row["Quantity"];
                            $itemCount++;
                        }
                
                        echo "<tr class='tableRow'></tr>";
                        echo "<tr class='tableRow'> <td class='tableData rightText' colspan='3'>Grand Total</td>";
                        echo "<td class='tableData rightText'>" . number_format($grandTotal,2) . "</td> </tr>";
                
                    echo "</table>";
                
                echo "</div>";
                
                
                $_SESSION["cartGrandTotal"] = $grandTotal;
                $conn -> close();
            ?>


<div class="paymentMethodContainer">
                <div class="paymentMethodTitle"><h1>Payment Method</h1></div>

                <label class="paymentMethodLabel" for="paymentMethod"></label>
                <input class="paymentMethodInput" type="radio" id="paymentMethod" name="paymentMethod" value="CreditCard" checked>
                <img src="creditcardicon.png" alt="Credit Card Icon" class="paymentMethodIcon"> Credit Card
                <input class="paymentMethodInput" type="radio" id="paymentMethod" name="paymentMethod" value="TouchNGo">
                <img src="Tngicon.svg" alt="Touch 'n Go Icon" class="paymentMethodIcon"> Touch 'n Go
            </div>
                
            <div class="checkoutSubmitButtonContainer">
                <input type="submit" name="checkoutSubmitButton" value="Place Order">
            </div>

        </form>
        
        <?php

            if($_SESSION["checkoutDetailsError"] == "Empty Fields"){
                echo "<h3 class='checkoutError'>Please fill in all fields</h3>";
                $_SESSION["checkoutDetailsError"] = "null";
            }
            else if($_SESSION["checkoutDetailsError"] == "Invalid Contact Number"){
                echo "<h3 class='checkoutError'>Invalid Contact Number</h3>";
                $_SESSION["checkoutDetailsError"] = "null";
            }

        ?>

    </div>






    

</body>

</html>