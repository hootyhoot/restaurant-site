<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style='background-color: #e5e9ec;'>

    <?php
        //load up session variables to be used globally
        session_start();

        //condition check to see if user is properly logged in
        if(!isset($_SESSION["userID"])){
            header("Location: loginPage.php");
        }

        //include the navigation panel
        include "navigationPanel.php";
        //load the payment type selected by user from session variable
        $paymentType = $_SESSION["checkoutFormDetails"]["paymentMethod"];

        //display the credit card payment page if user selected credit card payment
        if($paymentType == "CreditCard"){
            //display title for the credit card payment page
            echo "<h1 class='paymentTitle'>Pay by Credit Card</h1>";
            //include the credit card payment form
            include "creditCardPaymentForm.php";

            //display error message if there is any empty fields in the payment form
            if($_SESSION["paymentDetailsError"] == "Empty Fields"){
                echo "<h3 class='paymentError'>Please fill in all fields</h3>";
                $_SESSION["paymentDetailsError"] = "nil";
            }
            //display error message if the card number is invalid (less than 16 numbers)
            else if($_SESSION["paymentDetailsError"] == "Invalid Input"){
                echo "<h3 class='paymentError'>Please ensure card details are correct (16 digits card number)</h3>";
                $_SESSION["paymentDetailsError"] = "nil";
            }
            //display error message if the expiry date is invalid (earlier than 2023)
            else if($_SESSION["paymentDetailsError"] == "Invalid Expiry Date"){
                echo "<h3 class='paymentError'>Please ensure card is not expired</h3>";
                $_SESSION["paymentDetailsError"] = "nil";
            }
        }



        //display the Touch n Go payment page if user selected Touch n Go payment
        else if($paymentType == "TouchNGo"){
            //display title for the Touch n Go payment page
            echo "<h1 class='paymentTitle'>Pay by <img src='icons/TngIcon.svg' alt='Touch n Go Icon' class='paymentIcon'></h1>";
            //display the Touch n Go payment image
            echo "<img class='paymentImage' src='icons/Tngpayment.jpeg' width='250' height='250'>";
            //button for user to proceed to the next page after payment
            echo "<a class='paymentNextLink' href='paymentVerify.php'>Next</a>";
        }

    ?>


</body>

</html>