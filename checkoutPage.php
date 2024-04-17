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

    

    <div>
        
        <div><h1>Shipping Details</h1></div>

        <form name="checkoutForm" action="checkoutVerify.php" method="post">


            <!---------- To input shipping details -------------------->
            <div>
                <label class="formLabel" for="checkoutFirstName">First Name</label>
                <input class="formInput" type="text" id="checkoutFirstName" name="checkoutFirstName"> 
            </div>

            <div>
                <label class="formLabel" for="checkoutLastName">Last Name</label>
                <input class="formInput" type="text" id="checkoutLastName" name="checkoutLastName"> 
            </div>

            <div>
                <label class="formLabel" for="checkoutContactNo">Contact Number</label>
                <input class="formInput" type="tel" id="checkoutContactNo" name="checkoutContactNo" minlength="10" maxlength="10" pattern="[0-9]{10}" title="0121112222" placeholder="without '-'">
            </div>

            <div>
                <label class="formLabel" for="checkoutAddress">Address</label>
                <input class="formInput" type="text" id="checkoutAddress" name="checkoutAddress"> 
            </div>


            <!-- To display Order Summary and Choose Payment Option -->
            <div><h1>Order Summary</h1></div>
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
                
                echo "<div>";

                    echo "<table>";
                        echo "<tr> <th>Item No.</th> <th>Food Name</th> <th>Quantity</th> <th>Sub Total</th> </tr>";

                        while($row = $result -> fetch_assoc()){
                            echo "<tr>";
                                echo "<td style='text-align:center'>" . $itemCount . "</td>";
                                echo "<td style='text-align:center'>" . $row["FoodName"] . "</td>";
                                echo "<td style='text-align:center'>" . $row["Quantity"] . "</td>";
                                echo "<td style='text-align:right'>" . number_format($row["Price"] * $row["Quantity"],2) . "</td>";
                            echo "</tr>";

                            $grandTotal += $row["Price"] * $row["Quantity"];
                            $itemCount++;
                        }

                        echo "<tr></tr>";
                        echo "<tr> <td style='text-align:right' colspan='3'>Grand Total</td>";
                        echo "<td style='text-align:right'>" . number_format($grandTotal,2) . "</td> </tr>";

                    echo "</table>";

                echo "</div>";
                
                $_SESSION["cartGrandTotal"] = $grandTotal;
                $conn -> close();
            ?>


            <div>
                <div><h1>Payment Method</h1></div>

                <label class="" for="paymentMethod"></label>
                <input class="" type="radio" id="paymentMethod" name="paymentMethod" value="CreditCard" checked> Credit Card
                <input class="" type="radio" id="paymentMethod" name="paymentMethod" value="TouchNGo"> TouchNGo
            </div>
            
            <div>
                <input type="submit" name="checkoutSubmitButton" value="Place Order">
            </div>

        </form>
        
        <?php

            if($_SESSION["checkoutDetailsError"] == "Empty Fields"){
                echo "<h3 style='color:red'>Please fill in all fields</h3>";
                $_SESSION["checkoutDetailsError"] = "null";
            }
            else if($_SESSION["checkoutDetailsError"] == "Invalid Contact Number"){
                echo "<h3 style='color:red'>Invalid Contact Number</h3>";
                $_SESSION["checkoutDetailsError"] = "null";
            }

        ?>

    </div>






    

</body>

</html>