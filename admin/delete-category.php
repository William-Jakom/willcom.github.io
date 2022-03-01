<?php
//include constant file
include('../config/constants.php');
//echo "delete page"
//check whether the id and image value is set or not

if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    //Get the value and Delete
    //echo "get value and delete";
    $id=$_GET['id'];
    $image_name=$_GET['image_name'];
    //remove the physical image file is available 
    if($image_name !="")
    {
        //image is available so remove it
        $path="../images/category/".$image_name;
        //remove the image
        $remove=unlink($path);

        //if failed to remove image then add an error message and stop the process
        if($remove==false)
        {
            //set the session message
            $_SESSION['remove']="<div class='error'>Failed to remove category image </div>";
            //redirect to manage category page
            header('location'.SITEURL.'admin/manage-category.php');
            //stop the process
            die();
        }
    }
  
    //delete datafrom database
    $sql= "DELETE FROM tbl_category WHERE id=$id";

    //execute the query
    $res =mysqli_query($conn, $sql);

    //chech whether the fata is deleted from database or not
    if($res==true)
    {
      //set success message and redirect
 $_SESSION['delete']="<div class='success'>Category deleted successfully.</div>";
 //redirect to manage category page
 header('location:'.SITEURL.'admin/manage-category.php');     

    }
    else
    {
        //set fai message and redirect
     $_SESSION['delete']="<div class='error'>Failed to delete category.</div>";
    //redirect to manage category page
    header('location:'.SITEURL.'admin/manage-category.php');

    }
      

}
else
{
    //redirect to manage category page
    header('location'.SITEURL.'admin/manage-category.php');
}
?>