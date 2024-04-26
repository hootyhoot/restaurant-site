<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <?php 
        //load up session variables for global use
        session_start();

        //condition check to see if user is properly logged in
        if(!isset($_SESSION["userID"])){
            header("Location: loginPage.php");
        }

        //include the navigation panel
        include "navigationPanel.php";
    ?>

    <!--Page heading-->
    <div class="orderDetailsTitle"><h1>Order Details</h1></div>


    <?php
        //get the order details from previous url
        $orderDate = $_GET["OrderDate"];
        $receipientName = $_GET["DeliveryFirstName"] . " " . $_GET["DeliveryLastName"];
        $paymentID = $_GET["PaymentID"];

        //declaring variables for the database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "restaurantDB";

        //connecting to the sql database
        $conn = new mysqli($servername, $username, $password, $dbname);

        //if connection fails, display error message
        if($conn -> connect_error){
            die("Connection failed: " . $conn -> connect_error);
        }

        //execute sql query statement to fetch the food info for all the food in the selected historical order
        $result = $conn -> query("SELECT Food.FoodName, Food.Price, Food.FoodPic, FoodOrder.Quantity FROM FoodOrder
                                    INNER JOIN Food ON FoodOrder.FoodID = Food.FoodID
                                    WHERE FoodOrder.PaymentID = '" . $paymentID . "'");

        
        //display order date, paymentID and receipient name
        echo "<div class='orderInfo'>";
            echo "<h4 class='orderDate'>Order Date: " . $orderDate . "</h4>";
            echo "<h4 class='paymentId'>Payment ID: " . $paymentID . "</h4>";
            echo "<h4 class='recipientName'>Receipient Name: " . $receipientName . "</h4>";
        echo "</div>";


        $itemCount = 1;
        $grandTotal = 0;

        //display the itemized food order
        echo "<table class='orderDetailsTable'>";
            //table header
            echo "<tr>  <th>Item No.</th>   <th></th>   <th>Food Name</th> <th>Price</th>  <th>Quantity</th>    <th>Sub Total</th>   <th></th>   </tr>";
            
            //loop through all the rows returned by the query
            while($row = $result -> fetch_assoc()){
                //display each food item
                displayRow($itemCount, $grandTotal, $row);
            }

            //display grand total
            echo "<tr> <td style='text-align:right' colspan='5'>Grand Total</td>";
            echo "<td style='text-align:center'>" . number_format($grandTotal,2) . "</td> </tr>";

        echo "</table>";


        //button to go back to Orders Page
        echo "<div class='backButtonContainer'><button onclick='goBack()'>Go Back</button></div>";
        


        //function to display each food order row
        function displayRow(&$itemCount, &$grandTotal, $row){
                    
            echo "<tr class='orderItem'>";
                //display row number
                echo "<td class='itemCount' style='text-align:center'>" . $itemCount . "</td>";
                //display food picture
                echo "<td class='itemImage' style='text-align:center'> <img src='data:image/jpeg;base64,".base64_encode($row['FoodPic'])."' width='100' height ='100'/> </td>";
                //display food name
                echo "<td class='itemName' style='text-align:center'>" . $row["FoodName"] . "</td>";
                //display food price
                echo "<td class='itemPrice' style='text-align:center'>" . number_format($row["Price"],2) . "</td>";
                //display ordered quantity
                echo "<td class='itemQuantity' style='text-align:center'>" . $row["Quantity"] . "</td>";
                //display subtotal of the food item
                echo "<td class='itemSubtotal' style='text-align:center'>" . number_format($row["Price"] * $row["Quantity"],2) . "</td>";
            echo "</tr>";
            
            //cumulative sum into grand total
            $grandTotal += $row["Price"] * $row["Quantity"];
            $itemCount++;

        }

        
        
        //script for button to go back to Orders Page
        echo "<script>
                function goBack() {
                window.history.back();
                }
            </script>";

        //close the connection
        $conn -> close();

    ?>
    


</body>


</html>