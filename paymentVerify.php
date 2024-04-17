<?php
    
    session_start();

    
    if($_SESSION["checkoutFormDetails"]["paymentMethod"] == "CreditCard"){
        $cardholderName = $_POST["cardholderName"];
        $cardNumber = $_POST["cardNumber"];
        $expiryMonth = $_POST["expiryMonth"];
        $expiryYear = $_POST["expiryYear"];
        $cvc = $_POST["cvc"];

        $_SESSION["paymentDetailsError"] = "None";

        if($_SESSION["paymentDetailsError"] == "None" && ($cardholderName == "" || $cardNumber == "" || $expiryMonth == "" || $expiryYear == "" || $cvc == "")){
            $_SESSION["paymentDetailsError"] = "Empty Fields";
            header("Location: paymentPage.php");
        }
        else if($_SESSION["paymentDetailsError"] == "None" && (!is_numeric($cardNumber) || !is_numeric($expiryMonth) || !is_numeric($expiryYear) || !is_numeric($cvc))){
            $_SESSION["paymentDetailsError"] = "Invalid Input";
            header("Location: paymentPage.php");
        }
        else if($_SESSION["paymentDetailsError"] == "None" && ($expiryYear < 24 || ($expiryMonth < 1 || $expiryMonth > 12))){
            $_SESSION["paymentDetailsError"] = "Invalid Expiry Date";
            header("Location: paymentPage.php");
        }
        else{
            addToFoodOrder("Credit Card");
            header("Location: receiptPage.php");
        }
    }
    else{
        addToFoodOrder("Touch N Go");
        header("Location: receiptPage.php");
    }
    

    function addToFoodOrder($paymentType){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "restaurantDB";
        

        $conn = new mysqli($servername, $username, $password, $dbname);

        if($conn -> connect_error){
            die("Connection failed: " . $conn -> connect_error);
        }

        $orderDate = date("Y-m-d H:i:s");

        $conn -> query("INSERT INTO Payment (PaymentType, Amount, PaymentDate) 
                            VALUES ('" . $paymentType
                            . "', '" . $_SESSION["cartGrandTotal"] . "', '" . $orderDate . "')");        
        $paymentID = $conn -> insert_id;


        $conn -> query("INSERT INTO DeliveryDetails (FirstName, LastName, ContactNo, Address)
                            VALUES ('" . $_SESSION["checkoutFormDetails"]["checkoutFirstName"] 
                            . "', '" . $_SESSION["checkoutFormDetails"]["checkoutLastName"] 
                            . "', '" . $_SESSION["checkoutFormDetails"]["checkoutContactNo"] 
                            . "', '" . $_SESSION["checkoutFormDetails"]["checkoutAddress"] . "')");
        $deliveryID = $conn -> insert_id;


        $result = $conn -> query("SELECT FoodID, Quantity FROM Cart WHERE UserID = '" . $_SESSION["userID"] . "'");

        while($row = $result -> fetch_assoc()){
            $conn -> query("INSERT INTO FoodOrder (UserID, FoodID, Quantity, PaymentID, DeliveryID) 
                                VALUES ('" . $_SESSION["userID"] . "', '" . $row["FoodID"] 
                                . "', '" . $row["Quantity"] . "', '" . $paymentID . "', '" . $deliveryID . "')");
        }

        $conn -> query("DELETE FROM Cart WHERE UserID = '" . $_SESSION["userID"] . "'");

    }

?>