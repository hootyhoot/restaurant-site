
<?php

    //load up session variables to be used globally
    session_start();

    //declaring variables for the database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "restaurantDB";

    //connecting to the sql database
    $conn = new mysqli($servername, $username, $password, $dbname);

    //if connection fails, display error message
    if ($conn -> connect_error){
        die("Connection failed: ". $conn->connect_error);
    }

    //declaring variables that stores the form inputs from the login page
    $formUsername = $_POST["username"];
    $formPassword = $_POST["password"];

    //sql query statement to fetch all relevent user information that matches with the username input by user
    $sql = "SELECT UserID, Password, UserType FROM User WHERE Username = '" . $formUsername . "'";


    //execute query statement
    $result = $conn->query($sql);

    //if rows are returned, check all the rows to see if any of the password matches with the password input by user
    //query should only return one row, since username is unique
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            //if password matches, store the user id and user type in session variables and redirect to home page
            if($row["Password"] == $formPassword){
                $_SESSION["userID"] = $row["UserID"];
                $_SESSION["userType"] = $row["UserType"];
                header("Location: homePage.php");
            } 
            //if password does not match, set the 'loginError' session variable and redirect to login page
            else {
                $_SESSION["loginError"] = "true";
                header("Location: loginPage.php");
            }
        }
    }
    //if no rows are returned, set the 'loginError' session variable and redirect to login page
    else {
        $_SESSION["loginError"] = "true";
        header("Location: loginPage.php");
    }
    
    //close the connection
    $conn->close();

?>