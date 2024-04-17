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
        $paymentType = $_SESSION["checkoutFormDetails"]["paymentMethod"];

        if($paymentType == "CreditCard"){
            echo "<h1>Pay by Credit Card</h1>";
            include "creditCardPaymentForm.php";

            if($_SESSION["paymentDetailsError"] == "Empty Fields"){
                echo "<h3 style='color:red' >Please fill in all fields</h3>";
                $_SESSION["paymentDetailsError"] = "nil";
            }
            else if($_SESSION["paymentDetailsError"] == "Invalid Input"){
                echo "<h3 style='color:red'>Please ensure card details are correct (16 digits card number)</h3>";
                $_SESSION["paymentDetailsError"] = "nil";
            }
            else if($_SESSION["paymentDetailsError"] == "Invalid Expiry Date"){
                echo "<h3 style='color:red'>Please ensure card is not expired</h3>";
                $_SESSION["paymentDetailsError"] = "nil";
            }
        }
        else if($paymentType == "TouchNGo"){
            echo "<h1>Pay by Touch 'n Go</h1>";
            echo "<img src='default images/TNG.jpg' width='250' height='250'>";
            echo "<a href='paymentVerify.php'>Next</a>";
        }
    ?>


</body>

</html>