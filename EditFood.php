//NEED TO EDIT A LOT OF THINGS.

<?php

// Report all PHP errors
error_reporting(E_ALL);

// Display errors in the browser
ini_set('display_errors', 1);
ob_start();
session_start();

//include "header.php";
include "connection.php";



$FoodID=$_GET["FoodID"];

$FoodName="";
$Price="";
$Availability="";
$FoodPic="";
$Description="";

$res=mysqli_query($link,"select * from Food where FoodID=$FoodID");
while ($row=mysqli_fetch_array($res))
{
    $FoodName = $row["FoodName"];
    $Price = $row["Price"];
    $Availability = $row["Availability"];
    $FoodPic = $row["FoodPic"];
    $Description = $row["Description"];
}

?>


<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Edit Food</h1>
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

                        <div class="col-lg-12">
                            <form name = "form1" action="" method="post" enctype="multipart/form-data">
                                <div class="card">
                                    <div class="card-header"><strong>Update Food (Text-Based)</strong></div>
                                    < <div class="card-body card-block">
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
                            </form>
                        </div>

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

    if(isset($_POST["submit1"])) {
        $fileName = $_FILES['pic']['name'];
        $targetDir = "image/";
        $targetFilePath = $targetDir . $fileName;
    
        if(move_uploaded_file($_FILES['pic']['tmp_name'], $targetFilePath)) {
            mysqli_query($link,"UPDATE Food SET FoodName = '$_POST[food]', Price ='$_POST[price]', Availability = '$_POST[availability]', FoodPic ='$targetFilePath', Description = '$_POST[description]' WHERE FoodID=$FoodID");
        } else {
            echo "There was an error uploading the file.";
        }
    }
    
   // mysqli_query($link,"UPDATE Food SET FoodName = '$_POST[food]', Price ='$_POST[price]', Availability = '$_POST[availability]', FoodPic ='$_FILES[pic]', Description = '$_POST[description]' WHERE FoodID=$FoodID");
    //$res=mysqli_query($link,"
    //SELECT category.CategoryID from Food
    //inner join category on Food.CategoryID = category.CategoryName
    //WHERE Food.FoodID = $FoodID");
    //$data=mysqli_fetch_array($res);
   // header("location: add_edit_questions.php?examID=$data[examID]");
    ?>

<script type="text/javascript">
    alert("Food has been added successfully");
    window.location.href="AddFood.php?CategoryID=<?php echo $row["CategoryID"]?>";
</script>

<?php

}

?>


