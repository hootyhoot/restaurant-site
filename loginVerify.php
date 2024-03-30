
<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "restaurantDB";


    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn -> connect_error){
        die("Connection failed: ". $conn->connect_error);
    }

    $formUsername = $_POST["username"];
    $formPassword = $_POST["password"];

    $sql = "SELECT Password, UserType FROM User WHERE Username = '" . $formUsername . "'";


    
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row["Password"] == $formPassword){
                $_SESSION["userType"] = $row["UserType"];
                header("Location: homePage.php");
            } else {
                $_SESSION["loginError"] = "true";
                header("Location: loginPage.php");
            }
        }
    } else {
        $_SESSION["loginError"] = "true";
        header("Location: loginPage.php");
    }
    
    $conn->close();

?>