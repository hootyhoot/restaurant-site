<?php
session_start();
include "header.php";
include "connection.php";


?>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Add Category</h1>
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
                                <div class="card-header"><strong>Create Category</strong><small> (Food Ordering System)</small></div>
                                <div class="card-body card-block">
                                    <div class="form-group"><label for="company" class=" form-control-label">Food Category</label><input type="text" name="FoodCategories" placeholder="Add Food Category" class="form-control"></div>
                                    <div class="form-group">
                                        <input type="submit" name="submit1" value="Add Category" class="btn btn-success">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title">Food Categories</strong>
                                </div>

                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Category ID</th>
                                            <th scope="col">Food Category Name</th>
                                            <th scope="col">Modify</th>
                                            <th scope="col">Delete</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $count=0;
                                            $res=mysqli_query($link,"select * from category");
                                            while ($row=mysqli_fetch_array($res))
                                                {
                                                    $count=$count+1;
                                                        ?>
                                                    <tr>
                                                        <th scope="row"><?php echo $count;?></th>
                                                        <td><?php echo $row["CategoryID"];?></td>
                                                        <td><?php echo $row["CategoryName"];?></td>
                                                        <td><a href="ModifyCategory.php?CategoryID=<?php echo $row["CategoryID"]?>">Modify</a></td>
                                                        <td><a href="DeleteCategory.php?CategoryID=<?php echo $row["CategoryID"]?>">Delete</a></td>
                                                    </tr>
                                                        <?php
                                                }
                                        ?>





                                        </tbody>
                                    </table>
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
        mysqli_query($link,"insert into category values(NULL, '$_POST[FoodCategories]')") or die (mysqli_error($link));

        ?>
        <script type="text/javascript">
            alert("Food category was added successfully");
            window.location.href=window.location.href;
        </script>
<?php
    }
    ?>



<?php
include "footer.php";
?>
