<?php
    
    //load up session variables to be used globally
    session_start();

    //if payment method is Credit Card, validate the form inputs
    if($_SESSION["checkoutFormDetails"]["paymentMethod"] == "CreditCard"){
        //declaring variables for the form inputs from paymentPage.php
        $cardholderName = $_POST["cardholderName"];
        $cardNumber = $_POST["cardNumber"];
        $expiryMonth = $_POST["expiryMonth"];
        $expiryYear = $_POST["expiryYear"];
        $cvc = $_POST["cvc"];
        $currentMonth = date("m");
        $currentYear = date("y");

        $_SESSION["paymentDetailsError"] = "None";

        //if any fields are empty, set paymentDetailsError and redirect to paymentPage.php
        if($_SESSION["paymentDetailsError"] == "None" && ($cardholderName == "" || $cardNumber == "" || $expiryMonth == "" || $expiryYear == "" || $cvc == "")){
            $_SESSION["paymentDetailsError"] = "Empty Fields";
            header("Location: paymentPage.php");
        }
        //if card details (number, expiry & cvc) are not numeric, set paymentDetailsError and redirect to paymentPage.php
        else if($_SESSION["paymentDetailsError"] == "None" && (!is_numeric($cardNumber) || !is_numeric($expiryMonth) || !is_numeric($expiryYear) || !is_numeric($cvc))){
            $_SESSION["paymentDetailsError"] = "Invalid Input";
            header("Location: paymentPage.php");
        }
        //if expiry date is invalid, set paymentDetailsError and redirect to paymentPage.php
        else if($_SESSION["paymentDetailsError"] == "None" && (($expiryYear < $currentYear || $expiryYear > ($currentYear+5)) || ($expiryMonth < 1 || $expiryMonth > 12) || ($expiryYear == 24 && $expiryMonth < $currentMonth) )){
            $_SESSION["paymentDetailsError"] = "Invalid Expiry Date";
            header("Location: paymentPage.php");
        }
        //if validation passed, add to food order database and redirect to receiptPage.php
        else if($_SESSION["paymentDetailsError"] == "None"){
            addToFoodOrder("Credit Card");
            header("Location: receiptPage.php");
        }
    }

    //else just add to food order database and redirect to receiptPage.php
    else{
        addToFoodOrder("Touch N Go");
        header("Location: receiptPage.php");
    }
    



    //function to add the confirmed and paid food order to the database
    function addToFoodOrder($paymentType){
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

        //get the current date and time
        $orderDate = date("Y-m-d H:i:s");

        //execute sql query statement to insert the payment details data into the Payment table
        $conn -> query("INSERT INTO Payment (PaymentType, Amount, PaymentDate) 
                            VALUES ('" . $paymentType
                            . "', '" . $_SESSION["cartGrandTotal"] . "', '" . $orderDate . "')");        
        //get the paymentID of the inserted payment details
        $paymentID = $conn -> insert_id;

        //execute sql query statement to insert the delivery details data into the DeliveryDetails table
        $conn -> query("INSERT INTO DeliveryDetails (FirstName, LastName, ContactNo, Address)
                            VALUES ('" . $_SESSION["checkoutFormDetails"]["checkoutFirstName"] 
                            . "', '" . $_SESSION["checkoutFormDetails"]["checkoutLastName"] 
                            . "', '" . $_SESSION["checkoutFormDetails"]["checkoutContactNo"] 
                            . "', '" . $_SESSION["checkoutFormDetails"]["checkoutAddress"] . "')");
        //get the deliveryID of the inserted delivery details
        $deliveryID = $conn -> insert_id;

        //execute sql query statement to select all the food items in the cart of the current user
        $result = $conn -> query("SELECT FoodID, Quantity FROM Cart WHERE UserID = '" . $_SESSION["userID"] . "'");

        //for each food item returned by the query from Cart table, insert the row into FoodOrder table
        //along with the paymentID and deliveryID
        while($row = $result -> fetch_assoc()){
            $conn -> query("INSERT INTO FoodOrder (UserID, FoodID, Quantity, PaymentID, DeliveryID) 
                                VALUES ('" . $_SESSION["userID"] . "', '" . $row["FoodID"] 
                                . "', '" . $row["Quantity"] . "', '" . $paymentID . "', '" . $deliveryID . "')");
        }

        //execute sql query statement to delete all the food items in the cart of the current user
        $conn -> query("DELETE FROM Cart WHERE UserID = '" . $_SESSION["userID"] . "'");

        //close the database connection
        $conn -> close();

    }

?>