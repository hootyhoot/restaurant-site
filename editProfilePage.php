<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <?php 
        //load up session variables for global use
        session_start();

        //condition check to see if user is properly logged in
        if(!isset($_SESSION["userID"])){
            header("Location: loginPage.php");
        }

        //include the navigation panel
        include "navigationPanel.php";
    ?>

    <?php
        //declaring variables for the database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "restaurantDB";

        //connecting to the sql database
        $conn = new mysqli($servername, $username, $password, $dbname);

        //if connection fails, display error message
        if($conn -> connect_error){
            die("Connection failed: " . $conn -> connect_error);
        }

        //execute sql query statement to fetch the user's profile details
        $result = $conn -> query("SELECT Username, Password, FirstName, LastName, Email, ContactNo FROM User WHERE UserID = '" . $_SESSION["userID"] . "'");
        
        //fetch the result of the query
        $row = $result -> fetch_assoc();
    ?>


    <div class="profileTitle"><h1>Profile</h1></div>
    
    <!--form to display and edit the user's profile details-->
    <form class="profileForm" action="updateProfileFunction.php" method ="post">

        <!--input field for first name-->
        <div class="formField firstNameField">
            <label class="formLabel firstNameLabel" for="firstName">First Name</label>
            <input class="formInput firstNameInput" type="text" id="firstName" name="firstName" value="<?php echo $row['FirstName']?>">
        </div>

        <!--input field for last name-->
        <div class="formField lastNameField">
            <label class="formLabel lastNameLabel" for="lastName">Last Name</label>
            <input class="formInput lastNameInput" type="text" id="lastName" name="lastName" value="<?php echo $row['LastName']?>">
        </div>

        <!--input field for email-->
        <div class="formField emailField">
            <label class="formLabel emailLabel" for="email">Email</label>
            <input class="formInput emailInput" type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<?php echo $row['Email'] ?>">
        </div>

        <!--input field for username-->
        <div class="formField usernameField">
            <label class="formLabel usernameLabel" for="username">Username</label>
            <input class="formInput usernameInput" type="text" id="username" name="username" value="<?php echo $row['Username']?>" disabled>
        </div>

        <!--input field for password-->
        <div class="formField passwordField">
            <label class="formLabel passwordLabel" for="password">Password</label>
            <input class="formInput passwordInput" type="password" id="password" name="password" value="<?php echo $row['Password']?>">
        </div>

        <!--input field for contact number-->
        <div class="formField contactNumField">
            <label class="formLabel contactNumLabel" for="contactNum">Contact Number</label>
            <input class="formInput contactNumInput" type="tel" id="contactNum" name="contactNum" minlength="10" maxlength="11" placeholder="without '-'" value="<?php echo $row['ContactNo']?>">
        </div>

        <!--button to save changes-->
        <input class="formButton saveChangesButton" type="submit" value="Save Changes">
        


    </form>
        

    <?php

        //display message if update was successful
        if($_SESSION["updateProfileError"] == "None"){
            echo "<script>alert('Profile updated successfully');</script>";
            $_SESSION["updateProfileError"] = "null";
        }

        //display error message if the contact number format is invalid
        else if($_SESSION["updateProfileError"] == "Invalid Contact Number"){
            echo "<h3 style='color:red'>Invalid Contact Number</h3>";
            $_SESSION["updateProfileError"] = "null";
        }

        //display error message if any fields are left empty
        else if($_SESSION["updateProfileError"] == "Empty fields"){
            echo "<h3 style='color:red'>Please do not leave any fields empty</h3>";
            $_SESSION["updateProfileError"] = "null";
        }

        //close the connection
        $conn -> close();
    ?>

</body>
</html>