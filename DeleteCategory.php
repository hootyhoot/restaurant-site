<?php
session_start();
include "connection.php";


$CategoryID=$_GET["CategoryID"];
mysqli_query($link,"delete from category where CategoryID=$CategoryID");
?>

<script type="text/javascript">
    window.location="category.php";
</script>
