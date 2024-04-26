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
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "restaurantDB";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if($conn -> connect_error){
            die("Connection failed: " . $conn -> connect_error);
        }

        $result = $conn -> query("SELECT Username, Password, FirstName, LastName, Email, ContactNo FROM User WHERE UserID = '" . $_SESSION["userID"] . "'");
        
        $row = $result -> fetch_assoc();
    ?>


    <div class="profileTitle"><h1>Profile</h1></div>

    <form class="profileForm" action="updateProfileFunction.php" method ="post">

        <div class="formField firstNameField">
            <label class="formLabel firstNameLabel" for="firstName">First Name</label>
            <input class="formInput firstNameInput" type="text" id="firstName" name="firstName" value="<?php echo $row['FirstName']?>">
        </div>

        <div class="formField lastNameField">
            <label class="formLabel lastNameLabel" for="lastName">Last Name</label>
            <input class="formInput lastNameInput" type="text" id="lastName" name="lastName" value="<?php echo $row['LastName']?>">
        </div>

        <div class="formField emailField">
            <label class="formLabel emailLabel" for="email">Email</label>
            <input class="formInput emailInput" type="email" id="email" name="email" value="<?php echo $row['Email'] ?>">
        </div>

        <div class="formField usernameField">
            <label class="formLabel usernameLabel" for="username">Username</label>
            <input class="formInput usernameInput" type="text" id="username" name="username" value="<?php echo $row['Username']?>" disabled>
        </div>

        <div class="formField passwordField">
            <label class="formLabel passwordLabel" for="password">Password</label>
            <input class="formInput passwordInput" type="password" id="password" name="password" value="<?php echo $row['Password']?>">
        </div>

        <div class="formField contactNumField">
            <label class="formLabel contactNumLabel" for="contactNum">Contact Number</label>
            <input class="formInput contactNumInput" type="tel" id="contactNum" name="contactNum" minlength="10" maxlength="11" placeholder="without '-'" value="<?php echo $row['ContactNo']?>">
        </div>

        <input class="formButton saveChangesButton" type="submit" value="Save Changes">
        


    </form>
        

    <?php

        if($_SESSION["updateProfileError"] == "None"){
            echo "<script>alert('Profile updated successfully');</script>";
            $_SESSION["updateProfileError"] = "null";
        }

        else if($_SESSION["updateProfileError"] == "Invalid Contact Number"){
            echo "<h3 style='color:red'>Invalid Contact Number</h3>";
            $_SESSION["updateProfileError"] = "null";
        }

        else if($_SESSION["updateProfileError"] == "Empty fields"){
            echo "<h3 style='color:red'>Please do not leave any fields empty</h3>";
            $_SESSION["updateProfileError"] = "null";
        }

        $conn -> close();
    ?>

</body>
</html>