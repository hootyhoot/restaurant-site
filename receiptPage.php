<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<style>
        body {
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .receiptContainer {
            text-align: center;
        }
</style>

<body>
    
    
    <?php 
    
        session_start(); 

        //condition check to see if user is properly logged in
        if(!isset($_SESSION["userID"])){
            header("Location: loginPage.php");
        }

        include "navigationPanel.php";

        // Assuming the purchase details are stored in the session
        $totalAmount = $_SESSION['cartGrandTotal'];
        $paymentMethod = $_SESSION['checkoutFormDetails']['paymentMethod'];
        $lastName = $_SESSION['checkoutFormDetails']['checkoutLastName'];
        $contactNo = $_SESSION['checkoutFormDetails']['checkoutContactNo'];
        $address = $_SESSION['checkoutFormDetails']['checkoutAddress'];
    ?>

<div class="receiptContainer">
    <h1 class="receiptTitle">Receipt</h1>

    <div class="section">
        <h2 class="sectionTitle">Customer Details:</h2>
        <p class="detail">Last Name: <?php echo $lastName; ?></p>
        <p class="detail">Contact Number: <?php echo $contactNo; ?></p>
        <p class="detail">Address: <?php echo $address; ?></p>
    </div>

    <div class="section">
        <h2 class="sectionTitle">Total Amount:</h2>
        <p class="detail">RM<?php echo $totalAmount; ?></p>
    </div>

    <div class="section">
        <h2 class="sectionTitle">Payment Method:</h2>
        <p class="detail"><?php echo $paymentMethod; ?></p>
    </div>

    <h2 class="thankYouMessage">Thank you for your purchase!</h2>

    <button onclick="location.href='homePage.php';" class="btn btn-primary" id="continue-btn">Continue</button>

    <button onclick="window.print();" class="btn btn-primary" id="print">Print</button>
</div>
</body>

</html>