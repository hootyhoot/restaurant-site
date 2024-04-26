<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body style="background-color: black;">

    <!--load up session variables to be used globally-->
    <?php session_start(); ?>
    
    <!--division for the login's header & login form-->
    <div class="logReg">
        
        <!--header for the login form-->
        <h2>USER LOGIN</h2>
        
    
        <!--division for the login form-->
        <div class="logRegForm">

            <!--creating the form for the login-->
            <form action="loginVerify.php" method="post">
                
                <!--division for the username field-->
                <div class="formField">
                    <label class="formLabel" for="username">Username</label>
                    <input class="formInput" type="text" id="username" name="username">
                </div>
                
                <!--division for the password field-->
                <div class="formField">
                    <label class="formLabel" for="password">Password</label>
                    <input class="formInput" type="password" id="password" name="password">
                </div>

                <!--submit button for the login form, form inputs will be sent to loginVerify.php for validation-->
                <input class="formButton" type="submit" value="Login">
                
                <!--button that will link to the registration page-->
                <a class="registerButton" href="registerPage.php">Register</a>
            </form>
            
            <!--display error message if login is invalid-->
            <?php
                if($_SESSION["loginError"] == "true"){
                    echo "<h3 style=\"color:red\">Invalid Username or Password</h3>";
                    $_SESSION["loginError"] = "false";
                }
            ?>

        </div>

    </div>
    
</body>
</html>