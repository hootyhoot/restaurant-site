<?php
session_start();
include "header.php";
include "connection.php";



$CategoryID=$_GET["CategoryID"];
$res=mysqli_query($link,"select * from category where CategoryID=$CategoryID");
while ($row=mysqli_fetch_array($res))
{
    $CategoryName=$row["CategoryName"];

}



?>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Edit Food Category</h1>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form name="form1" action="" method="post">
                        <div class="card-body">

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header"><strong>Edit Current Category</strong></div>
                                    <div class="card-body card-block">
                                        <div class="form-group"><label for="company" class=" form-control-label">Food Category</label><input type="text" name="FoodCategories" placeholder="Add Food Category" class="form-control" value = "<?php echo $CategoryName; ?>"></div>
                                        <div class="form-group">
                                            <br>
                                            <input type="submit" name="submit1" value="Update Category Now" class="btn btn-success">
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </form>
                </div>
            </div>


        </div><!-- .animated -->
    </div><!-- .content -->

    <?php
    if(isset($_POST["submit1"]))
    {
    mysqli_query($link,"update category set CategoryName='$_POST[FoodCategories]' where CategoryID=$CategoryID") or die (mysqli_error($link));

    ?>
        <script type="text/javascript">
            window.location="category.php";
        </script>
        <?php
        }
        ?>



        <?php
        include "footer.php";
        ?>
