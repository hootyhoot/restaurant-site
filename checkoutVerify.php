<!--to check if previous form has invalid input-->
<?php
    define("FIRST_NAME_FIELD","checkoutFirstName");
    define("LAST_NAME_FIELD","checkoutLastName");
    define("CONTACT_NUMBER_FIELD","checkoutContactNo");
    define("ADDRESS_FIELD","checkoutAddress");
    define("PAYMENT_METHOD_FIELD","paymentMethod");

    session_start();
    $_SESSION["checkoutDetailsError"] = "None";

    $formFirstName = $_POST[FIRST_NAME_FIELD];
    $formLastName = $_POST[LAST_NAME_FIELD];
    $formContactNo = $_POST[CONTACT_NUMBER_FIELD];
    $formAddress = $_POST[ADDRESS_FIELD];
    $formPaymentMethod = $_POST[PAYMENT_METHOD_FIELD];


    if($_SESSION["checkoutDetailsError"] == "None" && ($formFirstName == "" || $formLastName == "" || $formContactNo == "" || $formAddress == "")){
        $_SESSION["checkoutDetailsError"] = "Empty Fields";
        header("Location: checkoutPage.php");
    }
    else if($_SESSION["checkoutDetailsError"] == "None" && (!is_numeric($formContactNo) || str_contains($formContactNo, '-')) ){
        $_SESSION["checkoutDetailsError"] = "Invalid Contact Number";
        header("Location: checkoutPage.php");
    }
    else{
        
        $_SESSION["checkoutFormDetails"] = $_POST;
        header("Location: paymentPage.php");
    }

?>
