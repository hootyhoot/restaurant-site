
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

    $sql = "SELECT Password FROM User WHERE Username = '" . $formUsername . "'";



    /*
    //--just trying to test using prepared statements instead

    $sql = "SELECT Password FROM User WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $formUsername);
    $stmt->execute();
    $stmt->bind_result($password);
    
    while($stmt->fetch()){
        if($password == $formPassword){
            header("Location: homePage.html");
        } else {
            $_SESSION["error"] = "true";
            header("Location: loginPage.php");
        }
    }
    */

    
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row["Password"] == $formPassword){
                header("Location: homePage.html");
            } else {
                $_SESSION['error'] = "true";
                header("Location: loginPage.php");
            }
        }
    } else {
        $_SESSION['error'] = "true";
        header("Location: loginPage.php");
    }
    
    $conn->close();

?>