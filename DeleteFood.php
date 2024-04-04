<?php

// Report all PHP errors
error_reporting(E_ALL);

// Display errors in the browser
ini_set('display_errors', 1);

session_start();

include "connection.php";
?>
<?php

$FoodID=$_GET["FoodID"];

$res=mysqli_query($link,"
    select category.CategoryID from Food
    inner join category on Food.CategoryID = category.CategoryName
    where Food.FoodID=$FoodID");

$data=mysqli_fetch_array($res);

mysqli_query($link,"delete from Food where FoodID=$FoodID");

header("location: AddFood.php?FoodID=$data[FoodID]");


?>
