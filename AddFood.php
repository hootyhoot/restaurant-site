<?php
// Report all PHP errors
error_reporting(E_ALL);

// Display errors in the browser
ini_set('display_errors', 1);

session_start();
//include "header.php";
include "connection.php";
// rest of your code

$CategoryID = isset($_GET["CategoryID"]) ? $_GET["CategoryID"] : '';
$Food_category ='';
if ($CategoryID != '') {
    $res = mysqli_query($link,"select * from category where CategoryID=$CategoryID");

    while ($row = mysqli_fetch_array($res))
    {
    $Food_category = $row["CategoryName"];
    }
}
?>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Add Food into <?php echo "<font color ='red'>" .$Food_category. "</font>"; ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="col-lg-6">
                            <form name = "form1" action="" method="post" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header"><strong>Add New Food (Text-Based)</strong></div>
                                <div class="card-body card-block">
                                    <div class="form-group"><label for="company" class=" form-control-label">Food Name</label><input type="text" name="food" placeholder="Add Food" class="form-control"> </div>
                                    <div class="form-group">
                                    <label for="company" class=" form-control-label">Price</label>
                                    <input type="number" step="0.01" name="price" placeholder="price" class="form-control">
                                </div>
                                    <label for="company" class=" form-control-label">Availability</label>
                                    <select name="availability" class="form-control">
                                        <option value="1">Available</option>
                                        <option value="0">Unavailable</option>
                                    </select>
                                    <div class="form-group"><label for="company" class=" form-control-label">Description</label><input type="text" name="description" placeholder="Add Option 3" class="form-control"> </div>
                                    <div class="form-group">
                                    <label for="company" class=" form-control-label">Add Pic</label>
                                    <input type="file" name="pic" class="form-control" style="padding-bottom:43px">
                                </div>
                                <div class="form-group">
                                    <br>
                                    <input type="submit" name="submit1" value="Add Now" class="btn btn-success">
                                </div>
                            </form>
                                    






                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <table class="table table-bordered">
                            <tr>
                                <th>FoodID</th>
                                <th>FoodName</th>
                                <th>Price</th>
                                <th>Availability</th>
                                <th>FoodPic</th>
                                <th>Description</th>
                                <th>CategoryID</th>
                                <th>Modify</th>
                                <th>Delete</th>

                            </tr>


                        <?php

                $res = mysqli_query($link, "SELECT Food.*, Category.CategoryName FROM Food INNER JOIN Category ON Food.CategoryID = Category.CategoryID ORDER BY Food.CategoryID ASC");
                while ($row=mysqli_fetch_array($res))
                {
                    echo"<tr>";
                    echo"<td>"; echo $row["FoodID"]; echo"</td>";
                    echo"<td>"; echo $row["FoodName"]; echo"</td>";
                    echo"<td>"; echo $row["Price"]; echo"</td>";
                    echo "<td>"; echo $row["Availability"] == 1 ? "Yes" : "No"; echo "</td>";

                    echo"<td>";
                    if(strpos($row["FoodPic"],'option_images/')!==false)
                    {
                        ?>
                        <img src="<?php echo $row["FoodPic"];?>" height="70" width ="70">
                        <?php
                    }
                    else
                    {
                        echo "<img src='".$row["FoodPic"]."' width='100' height='100'>";
                    }
                    echo"</td>";
                    echo"<td style='font-size: 12px;'>"; echo $row["Description"]; echo"</td>";
                    echo "<td>"; echo $row["CategoryName"]; echo "</td>";

                    echo "<td>";
                    ?>
                    <a href="EditFood.php?FoodID=<?php echo $row["FoodID"]; ?>">Edit</a>
                    <?php
                    echo "</td>";
                    echo "<td>";
                    ?>
                    <a href="DeleteFood.php?FoodID=<?php echo $row["FoodID"]; ?>">Delete</a>
                    <?php
                    echo "</tr>";

                }

                                        ?>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
</div><!-- .animated -->
</div><!-- .content -->

<?php
if(isset($_POST["submit1"]))
{
$loop=0;
    $count=0;
    $res=mysqli_query($link,"select * from Food where CategoryID ='$Food_category' order by FoodID asc") or die (mysqli_error($link));

    $count=mysqli_num_rows($res);


    $fileName = $_FILES['pic']['name'];
    $targetDir = "image/";
    $targetFilePath = $targetDir . $fileName;


    $price = $_POST['price'];

if (!is_numeric($price)) {
    die("Invalid price value.");
}
$price = round($price,2);


if(move_uploaded_file($_FILES['pic']['tmp_name'], $targetFilePath)) {
    mysqli_query($link,"insert into Food values (NULL,'$_POST[food]','$price','$_POST[availability]','$targetFilePath','$_POST[description]','$CategoryID')") or die (mysqli_error($link));
} else {
    echo "There was an error uploading the file.";
}

    if($count==0)
    {

    }
    else
    {
        while($row=mysqli_fetch_array($res))
        {
            $loop = $loop+1;
            mysqli_query($link,"update Food where FoodID = $row[FoodID]");
        }
    }



//$loop=$loop+1;
//mysqli_query($link,"insert into Food values (NULL,'$_POST[food]','$_POST[price]','$_POST[availability]','$_FILES[pic]','$_POST[description]','$Food_category')") or die (mysqli_error($link));
?>

<script type="text/javascript">
    alert("Food has been added successfully");
    window.location.href="AddFood.php?CategoryID=<?php echo $CategoryID; ?>";
</script>
<?php
}
?>

