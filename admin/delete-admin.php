<?php
//inlude contant.php file
include('../config/constants.php');
//1. get id od admin to be delete
 $id=$_GET['id'];

//2. create sql to delete admin
$sql= "DELETE FROM tbl_admin1 WHERE id=$id";
//execute querry
$res =mysqli_query($conn, $sql);
//check whether the querry is executed or not
if($res==true)
{
    //querry executed susscefully
    //echo "admin deleted";
    //create session varible to diplay message
    $_SESSION['delete']="<div class='success'>Admin Deleted successfully </div>";
    //redirect to manage Admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else
{
//failed to delete admin
$_SESSION['delete']="<div class='error'>Failed to delete Admin. Try again later.</div>";

    header('location:'.SITEURL.'admin/manage-admin.php');
}
//3. redirect to manage admin page with message

?>