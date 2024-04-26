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
            //load up session variables to be used globally
            session_start();

            //condition check to see if user is properly logged in
            if(!isset($_SESSION["userID"])){
                header("Location: loginPage.php");
            }

            //include the navigation panel
            include "navigationPanel.php";

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

            //execute sql query statement to fetch the logged in user's historical order details
            $result = $conn -> query("SELECT DeliveryDetails.FirstName, DeliveryDetails.LastName, DeliveryDetails.ContactNo, 
                                        DeliveryDetails.Address, Payment.PaymentID, Payment.PaymentType, Payment.Amount, 
                                        Payment.PaymentDate FROM FoodOrder 
                                        INNER JOIN DeliveryDetails ON FoodOrder.DeliveryID = DeliveryDetails.DeliveryID 
                                        INNER JOIN Payment ON FoodOrder.PaymentID = Payment.PaymentID 
                                        WHERE FoodOrder.UserID = '" . $_SESSION["userID"] . "'
                                        ORDER BY Payment.PaymentID");
        
        ?>

        <!--Page heading-->
        <div class="orderTitle"><h1>Orders</h1></div>

        
        <?php
            //if query returns rows, display all orders
            if($result -> num_rows > 0){
                //fetch the first row of the query result
                $row = $result -> fetch_assoc();
                $paymentID = $row["PaymentID"];
                $orderCount = 1;
                $orderDate = $row["PaymentDate"];
                $orderDate = date("Y-m-d");

                //start of table to display all orders
                echo "<table class='orderTable'>";

                //table header
                echo "<tr class='tableHeader'> <th>No.</th> <th>Order Date</th> <th>Delivery Details</th> <th>Payment Details</th> </tr>";

                //display the first row of the query result
                displayrow($orderCount, $orderDate, $row);
                //increment counter
                $orderCount++;
                
                //loop through the rest of the rows
                while($row = $result -> fetch_assoc()){
                    //if the paymentID is different from the previous row, it means its a different order group
                    //display it
                    if($paymentID != $row["PaymentID"]){
                            //set the new paymentID and date
                            $paymentID = $row["PaymentID"];
                            $orderDate = $row["PaymentDate"];
                            $orderDate = date("Y-m-d");
                            
                            //display the row
                            displayRow($orderCount, $orderDate, $row);

                            //increment counter
                            $orderCount++;
                        }
                    }
                    

                echo "</table>";


            }
            //if query returns no rows, display message to inform user
            else{
                echo "<div class='noOrders'><h2>You have not made any orders.</h2></div>";
            }

            //close the database connection
            $conn -> close();





            //function to display each row of the order table
            function displayRow($orderCount, $orderDate, $row){
                echo "<div class='orderRow'>";

                        //start row, set the onclick event to redirect to orderDetailsPage.php
                        //which will display the itemized order details
                        echo "<tr class='orderDetails' onClick='location.href=\"orderDetailsPage.php?PaymentID=" . $row["PaymentID"] . 
                                "&OrderDate=" . $orderDate . "&DeliveryFirstName=" . $row["FirstName"] .
                                "&DeliveryLastName=" . $row["LastName"] .   "\"'>";

                            //display row number
                            echo "<td class='orderCount' style='text-align:center'>" . $orderCount . "</td>";
                            //display order date
                            echo "<td class='orderDate' style='text-align:center'>" . $orderDate . "</td>";
                            
                            //display name, contact number and address of the delivery in one column
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
                                
                            
                            //display payment ID and total amount in one column
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