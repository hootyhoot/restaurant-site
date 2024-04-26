<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>




    <?php
        //load up session variables to be used globally
        session_start();

        //condition check to see if user is properly logged in
        if(!isset($_SESSION["userID"])){
            header("Location: loginPage.php");
        }

        //include the navigation panel
        include "navigationPanel.php";
        //#DFD6D4
    ?>

    <!--Display page heading for the cart page-->
<div class="cartTitle"><h1>Cart</h1></div>


    <?php
        //declaring variables for the database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "restaurantDB";

        //connecting to the sql database
        $conn = new mysqli($servername, $username, $password, $dbname);

        //if connection fails, display error message
        if($conn -> connect_error){
            die("Connection failed: " . $conn -> connect_error);
        }

        //execute sql query statement to fetch the logged in user's cart items
        $result = $conn -> query("SELECT FoodID, Quantity FROM Cart WHERE UserID = '" . $_SESSION["userID"]. "'");

        //if query returns rows, display the cart items in a table
        if($result -> num_rows > 0){
            //declare counter variables
            $itemCount = 1;
            $grandTotal = 0;

            //start of table to display cart items
            echo "<table class='cartTable'>";
                //table header
                echo "<tr>  <th>Item No.</th>   <th></th>   <th>Food Name</th> <th>Price</th>  <th>Quantity</th>    <th>Sub Total</th>   <th></th>   </tr>";
                
                //loop through all the rows returned by the query
                while($row = $result -> fetch_assoc()){
                    //execute sql query statement to fetch the food item details based on the FoodID
                    $foodResult = $conn -> query("SELECT FoodName, Price, FoodPic FROM Food WHERE FoodID = '" . $row["FoodID"] . "'");
                    $foodRow = $foodResult -> fetch_assoc();
                    
                    //display the food item details in a table row
                    echo "<tr class='cartItem'>";
                    echo "<td class='itemNumber' style='text-align:center'>" . $itemCount . "</td>";
                        //display the picture of the food item
                    echo "<td class='itemImage'> <img src='data:image/jpeg;base64,".base64_encode($foodRow['FoodPic'])."' width='100' height ='100'/> </td>";
                        //display the food name, price, quantity, sub total and remove button
                    echo "<td class='itemName' style='text-align:center'>" . $foodRow["FoodName"] . "</td>";
                    echo "<td class='itemPrice' style='text-align:right'>" . number_format($foodRow["Price"],2) . "</td>";
                    echo "<td class='itemQuantity' style='text-align:center'><input type='number' id='" . $row["FoodID"] . "' name='quantity' value='" . $row['Quantity'] . "' min='1'>" . "</td>";
                    echo "<td class='itemSubtotal' style='text-align:right'>" . number_format($foodRow["Price"] * $row["Quantity"],2) . "</td>";
                    
                    echo "<td class='itemRemove'> <a href='deleteFromCartFunction.php?FoodID=" . $row["FoodID"] . "'><img src='icons/bin.png' alt='Remove'></a> </td>";
                    
                echo "</tr>";
                    
                    $grandTotal += $foodRow["Price"] * $row["Quantity"];
                    $itemCount++;
                
                }

                //display the grand total of the cart items
                echo "<tr></tr>";
                echo "<tr> <td style='text-align:right' colspan='5'>Grand Total</td>";
                echo "<td style='text-align:right'>" . number_format($grandTotal,2) . "</td> </tr>";

            echo "</table>";

            //display a button to proceed to checkout
            echo "<a class='checkoutButton' href='checkoutPage.php'>Checkout</a>";
        }
        //if cart is empty, display a message to inform user
        else{
            echo "<div class = 'empty-cart-message'><p>Your cart is empty</p></div>";
        }

        //close the connection
        $conn -> close();
    ?>
    
    
    <script>
        //script to add event listener to the quantity input field

        //initialize variable to store all the 'quantity' input fields
        var quantityFields = document.getElementsByName("quantity");
        
        //loop through all the 'quantity' input fields and add event listener to each of them
        for(var i = 0; i < quantityFields.length; i++){
            //listen for the 'change' event
            //and redirect to updateCartFunction.php with the FoodID and updated Quantity of the triggered input field
            quantityFields[i].addEventListener("change", function(){
                window.location.href = "updateCartFunction.php?FoodID=" + this.id + "&Quantity=" + this.value;
            });
        }
    </script>


</body>
</html>