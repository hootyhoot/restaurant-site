<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="registerpage">

    <!--load up session variables to be used globally-->
    <?php session_start(); ?>

    <!--division for the register's header & register form-->
    <div class="logReg">

        <!--header for the register form-->
    <h2 class="registrationHeader">REGISTRATION</h2>

        <!--division for the register form-->
        <div class="logRegForm">

            <!--creating the form for the registration-->
            <form action="registerVerify.php" method ="post">

                <!--division for the first name field-->
                <div class="formField">
                    <label class="formLabel" for="firstnName">First Name</label>
                    <input class="formInput" type="text" id="firstName" name="firstName" required>
                </div>

                <!--division for the last name field-->
                <div class="formField">
                    <label class="formLabel" for="lastName">Last Name</label>
                    <input class="formInput" type="text" id="lastName" name="lastName" required>
                </div>

                <!--division for the email field-->
                <div class="formField">
                    <label class="formLabel" for="email">Email</label>
                    <input class="formInput" type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required placeholder="google@gmail.com">
                </div>

                <!--division for the username field-->
                <div class="formField">
                    <label class="formLabel" for="username">Username</label>
                    <input class="formInput" type="text" id="name" name="username" required>
                </div>

                <!--division for the password field-->
                <div class="formField">
                    <label class="formLabel" for="password">Password</label>
                    <input class="formInput" type="password" id="password" name="password" required minlength="8" placeholder="minimum 8 character">
                </div>

                <!--division for the confirm password field-->
                <div class="formField">
                    <label class="formLabel" for="confirmPass">Confirm Password</label>
                    <input class="formInput" type="password" id="confirmPass" name="confirmPassword" required minlength="8" placeholder="minimum 8 character">
                </div>

                <!--division for the contact number field-->
                <div class="formField">
                    <label class="formLabel" for="contactNum">Contact Number</label>
                    <input class="formInput" type="tel" id="contactNum" name="contactNum" minlength="10" maxlength="10" pattern="[0-9]{10}" title="0121112222" placeholder="without '-'" required>
                </div>

                <!--division for the news and promotion field-->
                <div class="formField newsAndPromotionsField">
                    <input type="checkbox" id="newsAndPromotions">
                    <label for="newsAndPromotions">I want the latest news and promotions!</label>
                </div>

                <!--division for the terms and conditions field-->

                    <div class="formField termsAndConditionsField">
                        <input type="checkbox" id="termsAndConditions" required>
                        <label for="termsAndConditions">I accept terms and conditions</label>
                    </div>

                

                <!--submit button for the registration form-, form inputs will be sent to registerVerify.php for validation-->
                <input class="formButton" type="submit" value="Register Now">

                <!--button that will link back to the login page-->
                <a class="registerButton" href="loginPage.php">Back to Login</a>


            </form>

            <!--if registration is invalid, display error message depending on cause of registration error-->
            <!--will also display success message if registration is successful-->
            <!--error messages are set in registerVerify.php-->
            <?php
                //if username already exists, display error message
                if($_SESSION["registerError"] == "Username already exists"){
                    echo "<h3 style=\"color:red\">Username already exists</h3>";
                    $_SESSION["registerError"] = "Nil";
                }
                //if passwords do not match, display error message
                else if($_SESSION["registerError"] == "Passwords do not match"){
                    echo "<h3 style=\"color:red\">Passwords do not match</h3>";
                    $_SESSION["registerError"] = "Nil";
                }
                //if contact number format is invalid, display error message
                else if($_SESSION["registerError"] == "Invalid Contact Number"){
                    echo "<h3 style=\"color:red\">Invalid Contact Number Format</h3>";
                    echo "<h3 style=\"color:red\">Contact Number should be numeric and without '-'</h3>";
                    $_SESSION["registerError"] = "Nil";
                }
                //if any fields are empty, display error message
                else if($_SESSION["registerError"] == "Empty fields"){
                    echo "<h3 style=\"color:red\">Please fill in all fields</h3>";
                    $_SESSION["registerError"] = "Nil";
                }
                //if registration is successful, display success message
                else if($_SESSION["registerError"] == "None"){
                    echo "<h3 style=\"color:green\">Registration Successful</h3>";
                    $_SESSION["registerError"] = "Nil";
                }

                
            ?>

        </div>

    </div>
    
    
    
</body>
</html>