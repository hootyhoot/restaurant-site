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


    <div><h1>Profile</h1></div>

    <form action="updateProfileFunction.php" method ="post">

        <div class="formField">
            <label class="formLabel" for="firstnName">First Name</label>
            <input class="formInput" type="text" id="firstName" name="firstName" value="<?php echo $row['FirstName']?>">
        </div>

        <div class="formField">
            <label class="formLabel" for="lastName">Last Name</label>
            <input class="formInput" type="text" id="lastName" name="lastName" value="<?php echo $row['LastName']?>">
        </div>

        <div class="formField">
            <label class="formLabel" for="email">Email</label>
            <input class="formInput" type="email" id="email" name="email" value="<?php echo $row['Email'] ?>">
        </div>

        <div class="formField">
            <label class="formLabel" for="username">Username</label>
            <input class="formInput" type="text" id="name" name="username" value="<?php echo $row['Username']?>" disabled>
        </div>

        <div class="formField">
            <label class="formLabel" for="password">Password</label>
            <input class="formInput" type="password" id="password" name="password" value="<?php echo $row['Password']?>">
        </div>

        <div class="formField">
            <label class="formLabel" for="contactNum">Contact Number</label>
            <input class="formInput" type="tel" id="contactNum" name="contactNum" minlength="10" maxlength="11" placeholder="without '-'" value="<?php echo $row['ContactNo']?>">
        </div>

        <input class="formButton" type="submit" value="Save Changes">
        

    </form>
        

    <?php

        if($_SESSION["updateProfileError"] == "None"){
            echo "<h3 style='color:green'>Profile updated successfully</h3>";
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