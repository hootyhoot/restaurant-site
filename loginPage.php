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
        
        <h2>USER LOGIN</h2>
        
    

        <div class="loginForm">

            <form action="loginVerify.php" method="post">
                
                <div class="formField">
                    <label class="formLabel" for="username">Username</label>
                    <input class="formInput" type="text" id="username" name="username">
                </div>
                
                <div class="formField">
                    <label class="formLabel" for="password">Password</label>
                    <input class="formInput" type="password" id="password" name="password">
                </div>

                <input class="formButton" type="submit" value="Login">
                
                <a class="registerButton" href="registerPage.html">Register</a>
            </form>
            
            <?php
                if($_SESSION["error"] == "true"){
                    echo "<h3 style=\"color:red\">Invalid Username or Password</h3>";
                    session_destroy();
                }
            ?>

        </div>

    </div>
    
</body>
</html>