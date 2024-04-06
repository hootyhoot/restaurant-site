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
    ?>

    <?php
        echo "<h1>Specific page for " . $_GET["foodID"] . "</h1>";
    ?>

</body>


</html>