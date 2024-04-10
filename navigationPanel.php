<div id="menu" class="MenuPanel">
    <a class="leftAlign" href="homePage.php">Home</a>

    <div class="Dropdown">
        Browse
        <div class="MenuDropdownContent">
            <a href="foodCategoryPage.php?chosenCategory=1">Appetizers</a>
            <a href="foodCategoryPage.php?chosenCategory=2">Main Courses</a>
            <a href="foodCategoryPage.php?chosenCategory=3">Desserts</a>
        </div>
    </div>

    <?php
        if ($_SESSION["userType"] == "Admin"){
            echo "<a class=\"leftAlign\" href=\"addFoodPage.php\">Add Food</a>";
        }
    ?>
    
    <a class="rightAlign" href="logoutCleanup.php">Logout</a>
    <a class="rightAlign" href="editProfilePage.php">Profile</a>
    <a class="rightAlign" href="cartPage.php">Cart</a>

</div>

