<!--this file is to be included in all other pages -->
<!--this is the menu panel (navigation panel) at the top of each page -->
<div id="menu" class="MenuPanel">
    
    <!--Home Page button -->
    <a class="leftAlign" href="homePage.php">Home</a>

    <!--Browse dropdown button -->
    <div class="Dropdown">
        Browse
        <!--Dropdown options (Appetizers, Main Courses, Desserts) from Browse -->
        <div class="MenuDropdownContent">
            <a href="foodCategoryPage.php?chosenCategory=1">Appetizers</a>
            <a href="foodCategoryPage.php?chosenCategory=2">Main Courses</a>
            <a href="foodCategoryPage.php?chosenCategory=3">Desserts</a>
        </div>
    </div>

    <!--Extra buttons to appear if user type is Admin -->
    <?php
        if ($_SESSION["userType"] == "Admin"){
            //Add Food button (for admin to add new food into menu)
            echo "<a class='leftAlign' href='addFoodPage.php'>Add Food</a>";
        }
    ?>
    
    <!--Logout button -->
    <a class="rightAlign" href="logoutCleanup.php">Logout</a>
    <!--Profile button -->
    <a class="rightAlign" href="editProfilePage.php">Profile</a>
    <!--Orders button -->
    <a class="rightAlign" href="orderPage.php">Orders</a>

    <!--Cart button -->
    <a class="rightAlign" href="cartPage.php"><img src="CartIcon3.png" alt="Cart"></a>


</div>

