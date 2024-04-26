<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

  <style>
    .noOrders {
        text-align: center;
    }
  </style>

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
                die("Connection failed: " . $conn -> connect_error);
            }

            $result = $conn -> query("SELECT DeliveryDetails.FirstName, DeliveryDetails.LastName, DeliveryDetails.ContactNo, 
                                        DeliveryDetails.Address, Payment.PaymentID, Payment.PaymentType, Payment.Amount, 
                                        Payment.PaymentDate FROM FoodOrder 
                                        INNER JOIN DeliveryDetails ON FoodOrder.DeliveryID = DeliveryDetails.DeliveryID 
                                        INNER JOIN Payment ON FoodOrder.PaymentID = Payment.PaymentID 
                                        WHERE FoodOrder.UserID = '" . $_SESSION["userID"] . "'
                                        ORDER BY Payment.PaymentID");
        
        ?>

        <div class="orderTitle"><h1>Orders</h1></div>

        
        <?php
            if($result -> num_rows > 0){
                $row = $result -> fetch_assoc();
                $paymentID = $row["PaymentID"];
                $orderCount = 1;
                $orderDate = $row["PaymentDate"];
                $orderDate = date("Y-m-d");

                echo "<table class='orderTable'>";

                echo "<tr class='tableHeader'> <th>No.</th> <th>Order Date</th> <th>Delivery Details</th> <th>Payment Details</th> </tr>";

                displayrow($orderCount, $orderDate, $row);
                $orderCount++;

                while($row = $result -> fetch_assoc()){
                        if($paymentID != $row["PaymentID"]){
                            
                            $paymentID = $row["PaymentID"];
                            $orderDate = $row["PaymentDate"];
                            $orderDate = date("Y-m-d");
                            
                            displayRow($orderCount, $orderDate, $row);

                            $orderCount++;
                        }
                    }
                    

                echo "</table>";


            }
            else{
                echo "<div class='noOrders'><h2>You have not made any orders.</h2></div>";
            }


            $conn -> close();




            function displayRow($orderCount, $orderDate, $row){
                echo "<div class='orderRow'>";

                        echo "<tr class='orderDetails' onClick='location.href=\"orderDetailsPage.php?PaymentID=" . $row["PaymentID"] . 
                                "&OrderDate=" . $orderDate . "&DeliveryFirstName=" . $row["FirstName"] .
                                "&DeliveryLastName=" . $row["LastName"] .   "\"'>";


                            echo "<td class='orderCount' style='text-align:center'>" . $orderCount . "</td>";
                            echo "<td class='orderDate' style='text-align:center'>" . $orderDate . "</td>";
                            
                            echo "<td class='deliveryDetails'>";
                                
                                echo "<table class='deliveryTable'>";

                                    echo "<tr>";
                                        echo "<td style='text-align:left'>Deliver To: " . $row["FirstName"] . " " . $row["LastName"] . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                        echo "<td style='text-align:left'>Contact No: " . $row["ContactNo"] . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                        echo "<td style='text-align:left'>Address: " . $row["Address"] . "</td>";
                                    echo "</tr>";

                                echo "</table>";

                            echo "</td>";
                                

                            echo "<td class='paymentDetails'>";

                            echo "<table class='paymentTable'>";

                                    echo "<tr>";
                                        echo "<td style='text-align:left'>Payment ID: " . $row["PaymentID"] . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                        echo "<td style='text-align:left'>Amount: RM" . number_format($row["Amount"],2) . " (" . $row["PaymentType"] . ")</td>";
                                    echo "</tr>";

                                echo "</table>";

                            echo "</td>";

                        echo "</tr>";

                    
                echo "</div>";

            }
        ?>


        

</body>

</html>