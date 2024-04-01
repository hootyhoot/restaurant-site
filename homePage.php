<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    ####
    <?php session_start(); ?>

    <div id="menu" class="MenuPanel">
        <a class="leftAlign" href="homePage.html">Home</a>

        <div class="Dropdown">
            Browse
            <div class="MenuDropdownContent">
                <a href="#">Appetizers</a>
                <a href="#">Main Courses</a>
                <a href="insert link">Desserts</a>
            </div>
        </div>

        <?php
            if ($_SESSION["userType"] == "Admin"){
                echo "<a class=\"leftAlign\" href=\"addFoodPage.php\">Add Food</a>";
            }
        
        ?>
        
        <a class="rightAlign" href="logoutCleanup.php">Logout</a>
        <a class="rightAlign" href="editProfilePage.php">Profile</a>
        <a class="rightAlign" href="#">Cart</a>

    </div>
    

    <div class="mainImageContainer">
            <img src="homePage.jpg" alt="Home Page Food">
            <h1>Welcome to our restaurant!</h1>
    </div>
    
    
  

</body>
</html>