<?php include('../config/constants.php');?>
<?php

//check whether value is passed in url
if(isset($_GET['id']) && isset($_GET['image_name']))
{
    //process to delete
    //echo "process to delete"
    //1. get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //2. remove the image if available
    //check whether the image is avaible or not and delete only if it is avaailable
    if($image_name!= "")
    {
        //if has image and need to remove the folder
        //het the image path
        $path = "../images/food/".$image_name;
        //remone image file from the folder
        $remove = unlink($path);
        //check whether the image is removed or not
        if($remove==false)
        {
            //failed to remove the image
            $_SESSION['upload']="<div class='error'>Failed to remove the image. </div>";
            header('location:'.SITEURL.'admin/manage-food.php');
            //stop the process of removing food
            die();

        }
    }

    //3. delete food from database
    $sql = "DELETE FROM tbl_food WHERE id = $id";
    //execute the query
    $res = mysqli_query($conn, $sql);

    //check whether the query is executed or not and set the seddion message
    
    //4. redirect to manage food seddion
    if($res==true)
    {
        //food deleted
        $_SESSION['delete']="<div class='success'> Food deleted successfully. </div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else
    {
        //failed to delete food with session message
        $_SESSION['delete']="<div class='error'>Failed to delete food. </div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }


}
else
{
    //redirect o manage food page
    $_SESSION['anauthorize']="<div class='error'>unauthorized access. </div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}
?>