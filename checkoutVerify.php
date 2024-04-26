<!--to check if previous form has invalid input-->
<?php

    //defining constants for form fields from checkoutPage.php
    define("FIRST_NAME_FIELD","checkoutFirstName");
    define("LAST_NAME_FIELD","checkoutLastName");
    define("CONTACT_NUMBER_FIELD","checkoutContactNo");
    define("ADDRESS_FIELD","checkoutAddress");
    define("PAYMENT_METHOD_FIELD","paymentMethod");

    //load up session variables to be used globally
    session_start();
    $_SESSION["checkoutDetailsError"] = "None";

    //declaring variables for the form inputs from checkoutPage.php
    $formFirstName = $_POST[FIRST_NAME_FIELD];
    $formLastName = $_POST[LAST_NAME_FIELD];
    $formContactNo = $_POST[CONTACT_NUMBER_FIELD];
    $formAddress = $_POST[ADDRESS_FIELD];
    $formPaymentMethod = $_POST[PAYMENT_METHOD_FIELD];

    //if any fields are empty, set checkoutDetailsError and redirect to checkoutPage.php
    if($_SESSION["checkoutDetailsError"] == "None" && ($formFirstName == "" || $formLastName == "" || $formContactNo == "" || $formAddress == "")){
        $_SESSION["checkoutDetailsError"] = "Empty Fields";
        header("Location: checkoutPage.php");
    }
    //if contact number is not numeric or contains '-', set checkoutDetailsError and redirect to checkoutPage.php
    else if($_SESSION["checkoutDetailsError"] == "None" && (!is_numeric($formContactNo) || str_contains($formContactNo, '-')) ){
        $_SESSION["checkoutDetailsError"] = "Invalid Contact Number";
        header("Location: checkoutPage.php");
    }
    //if validation passed, store form details in session and redirect to paymentPage.php
    else{
        
        $_SESSION["checkoutFormDetails"] = $_POST;
        header("Location: paymentPage.php");
    }

?>
