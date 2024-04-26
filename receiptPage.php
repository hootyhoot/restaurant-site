<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<style>
        body {
            text-align: center;
        }
        img {
            width: 200px;
            height: 200px;
        }
    </style>

<body>
    
    <?php 
        session_start(); 
        include "navigationPanel.php";
    ?>

    <h1>Order received!</h1>
    <img src="icons/delivery-bike.png" alt="Image of delivery bike">


</body>


</html>