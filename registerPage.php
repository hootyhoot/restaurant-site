<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="background-color: black;">

    <?php session_start(); ?>

    <div class="Login">

        <h2>REGISTRATION</h2>


        <div class="loginForm">

            <form action="registerVerify.php" method ="post">

                <div class="formField">
                    <label class="formLabel" for="firstnName">First Name</label>
                    <input class="formInput" type="text" id="firstName" name="firstName">
                </div>

                <div class="formField">
                    <label class="formLabel" for="lastName">Last Name</label>
                    <input class="formInput" type="text" id="lastName" name="lastName">
                </div>

                <div class="formField">
                    <label class="formLabel" for="email">Email</label>
                    <input class="formInput" type="email" id="email" name="email">
                </div>

                <div class="formField">
                    <label class="formLabel" for="username">Username</label>
                    <input class="formInput" type="text" id="name" name="username">
                </div>

                <div class="formField">
                    <label class="formLabel" for="password">Password</label>
                    <input class="formInput" type="password" id="password" name="password">
                </div>

                <div class="formField">
                    <label class="formLabel" for="confirmPass">Confirm Password</label>
                    <input class="formInput" type="password" id="confirmPass" name="confirmPassword">
                </div>

                <div class="formField">
                    <label class="formLabel" for="contactNum">Contact Number</label>
                    <input class="formInput" type="tel" id="contactNum" name="contactNum" minlength="10" maxlength="10" pattern="[0-9]{10}" title="0121112222" placeholder="without '-'">
                </div>

                <input class="formButton" type="submit" value="Register Now">

                <a class="registerButton" href="loginPage.php">Back to Login</a>


            </form>

            <?php
                if($_SESSION["registerError"] == "Username already exists"){
                    echo "<h3 style=\"color:red\">Username already exists</h3>";
                    $_SESSION["registerError"] = "Nil";
                }
                else if($_SESSION["registerError"] == "Passwords do not match"){
                    echo "<h3 style=\"color:red\">Passwords do not match</h3>";
                    $_SESSION["registerError"] = "Nil";
                }
                else if($_SESSION["registerError"] == "Invalid Contact Number"){
                    echo "<h3 style=\"color:red\">Invalid Contact Number Format</h3>";
                    echo "<h3 style=\"color:red\">Contact Number should be numeric and without '-'</h3>";
                    $_SESSION["registerError"] = "Nil";
                }
                else if($_SESSION["registerError"] == "Empty fields"){
                    echo "<h3 style=\"color:red\">Please fill in all fields</h3>";
                    $_SESSION["registerError"] = "Nil";
                }
                else if($_SESSION["registerError"] == "None"){
                    echo "<h3 style=\"color:green\">Registration Successful</h3>";
                    $_SESSION["registerError"] = "Nil";
                }

                
            ?>

        </div>

    </div>
    
    
    
</body>
</html>