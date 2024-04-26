<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body style ="background-color:#D4D4D4  ;">

    <?php 
        session_start();

        //condition check to see if user is properly logged in
        if(!isset($_SESSION["userID"])){
            header("Location: loginPage.php");
        }

        include "navigationPanel.php";
    ?>

    <div class="orderDetailsTitle"><h1>Order Details</h1></div>


    <?php
        $orderDate = $_GET["OrderDate"];
        $receipientName = $_GET["DeliveryFirstName"] . " " . $_GET["DeliveryLastName"];
        $paymentID = $_GET["PaymentID"];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "restaurantDB";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if($conn -> connect_error){
            die("Connection failed: " . $conn -> connect_error);
        }

        $result = $conn -> query("SELECT Food.FoodName, Food.Price, Food.FoodPic, FoodOrder.Quantity FROM FoodOrder
                                    INNER JOIN Food ON FoodOrder.FoodID = Food.FoodID
                                    WHERE FoodOrder.PaymentID = '" . $paymentID . "'");

        

        echo "<div class='orderInfo'>";
            echo "<h4 class='orderDate'>Order Date: " . $orderDate . "</h4>";
            echo "<h4 class='paymentId'>Payment ID: " . $paymentID . "</h4>";
            echo "<h4 class='recipientName'>Receipient Name: " . $receipientName . "</h4>";
        echo "</div>";


        $itemCount = 1;
        $grandTotal = 0;

        echo "<table class='orderDetailsTable'>";
            //table header
            echo "<tr>  <th>Item No.</th>   <th></th>   <th>Food Name</th> <th>Price</th>  <th>Quantity</th>    <th>Sub Total</th>   <th></th>   </tr>";
            
            while($row = $result -> fetch_assoc()){
                displayRow($itemCount, $grandTotal, $row);
            }

            echo "<tr></tr>";
            echo "<tr> <td style='text-align:right' colspan='5'>Grand Total</td>";
            echo "<td style='text-align:right'>" . number_format($grandTotal,2) . "</td> </tr>";

        echo "</table>";



        function displayRow(&$itemCount, &$grandTotal, $row){
                    
            echo "<tr class='orderItem'>";
            echo "<td class='itemCount' style='text-align:center'>" . $itemCount . "</td>";
            echo "<td class='itemImage'> <img src='data:image/jpeg;base64,".base64_encode($row['FoodPic'])."' width='100' height ='100'/> </td>";
            echo "<td class='itemName' style='text-align:center'>" . $row["FoodName"] . "</td>";
            echo "<td class='itemPrice' style='text-align:right'>" . number_format($row["Price"],2) . "</td>";
            echo "<td class='itemQuantity' style='text-align:center'>" . $row["Quantity"] . "</td>";
            echo "<td class='itemSubtotal' style='text-align:right'>" . number_format($row["Price"] * $row["Quantity"],2) . "</td>";
        echo "</tr>";
                    
                    $grandTotal += $row["Price"] * $row["Quantity"];
                    $itemCount++;

        }

        
        echo "<div class='backButtonContainer'><button onclick='goBack()'>Go Back</button></div>";
        

        echo "<script>
        function goBack() {
        window.history.back();
        }
        </script>";

        $conn -> close();

    ?>
    


</body>


</html>