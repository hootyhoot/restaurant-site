<?php
session_start();
include "header.php";
include "connection.php";


?>
<div class="breadcrumbs">
    <div class="col-sm-15">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Select Food Categories for Add / Edit Food</h1>
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

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">CategoryID</th>
                                <th scope="col">Category Name</th> 
                                <th scope="col">Select</th>
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
                                    <td><?php echo $row["CategoryName"];?></td>
                                    <td><?php echo $row["CategoryID"];?></td>
                                    <td><a href="AddFood.php?CategoryID=<?php echo $row["CategoryID"]?>">Select</a></td>
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


    </div>
</div><!-- .animated -->
</div><!-- .content -->

<?php
include "footer.php";
?>

