<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style= "background-color :#EDE2E0   ;" >




    <?php 
        session_start();
        include "navigationPanel.php";
        //#DFD6D4
    ?>

<div class="cartTitle"><h1>Cart</h1></div>

    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "restaurantDB";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if($conn -> connect_error){
            die("Connection failed: " . $conn -> connect_error);
        }

        $result = $conn -> query("SELECT FoodID, Quantity FROM Cart WHERE UserID = '" . $_SESSION["userID"]. "'");

        if($result -> num_rows > 0){
            $itemCount = 1;
            $grandTotal = 0;

            echo "<table class='cartTable'>";
                //table header
                echo "<tr>  <th>Item No.</th>   <th></th>   <th>Food Name</th> <th>Price</th>  <th>Quantity</th>    <th>Sub Total</th>   <th></th>   </tr>";
                
                while($row = $result -> fetch_assoc()){
                    $foodResult = $conn -> query("SELECT FoodName, Price, FoodPic FROM Food WHERE FoodID = '" . $row["FoodID"] . "'");
                    $foodRow = $foodResult -> fetch_assoc();
                    
                    echo "<tr class='cartItem'>";
                    echo "<td class='itemNumber' style='text-align:center'>" . $itemCount . "</td>";
                    echo "<td class='itemImage'> <img src='data:image/jpeg;base64,".base64_encode($foodRow['FoodPic'])."' width='100' height ='100'/> </td>";
                    echo "<td class='itemName' style='text-align:center'>" . $foodRow["FoodName"] . "</td>";
                    echo "<td class='itemPrice' style='text-align:right'>" . number_format($foodRow["Price"],2) . "</td>";
                    echo "<td class='itemQuantity' style='text-align:center'><input type='number' id='" . $row["FoodID"] . "' name='quantity' value='" . $row['Quantity'] . "' min='1'>" . "</td>";
                    echo "<td class='itemSubtotal' style='text-align:right'>" . number_format($foodRow["Price"] * $row["Quantity"],2) . "</td>";
                    
                    echo "<td class='itemRemove'> <a href='deleteFromCartFunction.php?FoodID=" . $row["FoodID"] . "'><img src='bin.png' alt='Remove'></a> </td>";
                    
                echo "</tr>";
                    
                    $grandTotal += $foodRow["Price"] * $row["Quantity"];
                    $itemCount++;
                
                }

                echo "<tr></tr>";
                echo "<tr> <td style='text-align:right' colspan='5'>Grand Total</td>";
                echo "<td style='text-align:right'>" . number_format($grandTotal,2) . "</td> </tr>";

            echo "</table>";

            echo "<a class='checkoutButton' href='checkoutPage.php'>Checkout</a>";
        }
        else{
            echo "<div class = 'empty-cart-message'><p>Your cart is empty</p></div>";
        }

        $conn -> close();
    ?>
    
    
    <script>
        var quantityFields = document.getElementsByName("quantity");
        
        for(var i = 0; i < quantityFields.length; i++){
            quantityFields[i].addEventListener("change", function(){
                window.location.href = "updateCartFunction.php?FoodID=" + this.id + "&Quantity=" + this.value;
            });
        }
    </script>


</body>
</html>