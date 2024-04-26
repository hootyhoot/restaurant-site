<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style='background-color: #e5e9ec;'>

    <?php
        session_start();

        //condition check to see if user is properly logged in
        if(!isset($_SESSION["userID"])){
            header("Location: loginPage.php");
        }

        include "navigationPanel.php";
        $paymentType = $_SESSION["checkoutFormDetails"]["paymentMethod"];

        if($paymentType == "CreditCard"){
            echo "<h1 class='paymentTitle'>Pay by Credit Card</h1>";
            include "creditCardPaymentForm.php";

            if($_SESSION["paymentDetailsError"] == "Empty Fields"){
                echo "<h3 class='paymentError'>Please fill in all fields</h3>";
                $_SESSION["paymentDetailsError"] = "nil";
            }
            else if($_SESSION["paymentDetailsError"] == "Invalid Input"){
                echo "<h3 class='paymentError'>Please ensure card details are correct (16 digits card number)</h3>";
                $_SESSION["paymentDetailsError"] = "nil";
            }
            else if($_SESSION["paymentDetailsError"] == "Invalid Expiry Date"){
                echo "<h3 class='paymentError'>Please ensure card is not expired</h3>";
                $_SESSION["paymentDetailsError"] = "nil";
            }
        }
        else if($paymentType == "TouchNGo"){
            
            
            
            echo "<h1 class='paymentTitle'>Pay by <img src='icons/TngIcon.svg' alt='Touch n Go Icon' class='paymentIcon'></h1>";
            


            echo "<img class='paymentImage' src='icons/Tngpayment.jpeg' width='250' height='250'>";
            echo "<a class='paymentNextLink' href='paymentVerify.php'>Next</a>";
        }
    ?>


</body>

</html>