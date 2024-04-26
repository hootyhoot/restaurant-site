<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<style>
    .center-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: calc(100vh - 60px); /* Adjust based on the height of your navigation panel */
        margin: -40px 0 0 0; /* Add negative top margin */
        text-align: center;
    }
    img {
        width: 200px;
        height: 200px;
    }
    h1 {
        font-size: 3em; /* Adjust to make the text larger */
        margin-bottom: 20px; /* Adjust to position the text higher */
    }
</style>

<body>
    
    <?php 
        session_start(); 
        include "navigationPanel.php";
    ?>

    <div class="center-content">
        <h1>Order received!</h1>
        <img src="icons/delivery-bike.png" alt="Image of delivery bike">
        <h3>You can also check your order history in the Orders page</h3>
    </div>

</body>

</html>