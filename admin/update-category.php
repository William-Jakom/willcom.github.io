
<?php include('partials/menu.php');?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update category</h1>
        <br><br>
 <?php
//check whether id is set or not
if(isset($_GET['id']))
{
    //get id and other details
    $id=$_GET['id'];
    //create sql query to get all other details
    $sql = "SELECT * FROM tbl_category WHERE id= $id";

    //execute querry
    $res = mysqli_query($conn, $sql);

    //count the rows to check whether the id is added or not
    $count= mysqli_num_rows($res);
    if($count==1)
    {
        //get all data
        $row =mysqli_fetch_assoc($res);
        $title= $row['title'];
        $current_image=$row['image_name'];
        $featured = $row['featured'];
        $active = $row['active'];
    }
    else
{
    //redirect to manage category with session message
    $_SESSION['no-category-found']= "<div class='error'>Category not found. </div>";
    //redirect to manage category page
     header('location:' .SITEURL.'admin/manage-category.php');
}

}
else
{
 //redirect to manage category page
 header('location:'.SITEURL.'admin/manage-category.php');
}
?>

    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title</td>
                <td>
                    <input type="text"name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Current image:</td>
                <td>
                    <?php
                    if($current_image !="")
                    {
                        //display the image
                        ?>
                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>"width="150px">
                        <?php
            
                    }
                    else
                    {
                        //display message
                        echo "<div class='error'>Image not Added </div>";
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td>New Image:</td>
                <td>
                    <input type="file"name="image" >
                </td>
            </tr>

            <tr>
                <td>Featured:</td>
                <td>
                <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio"name="featured" value="Yes">Yes
                    <input <?php if($featured=="No"){echo "checked";} ?> type="radio"name="featured" value="No">No
                </td>
            </tr>
            
            <tr>
                <td>Active:</td>
                <td>
                    <input  <?php if($active=="Yes"){echo "checked";} ?> type="radio"name="active" value="Yes">Yes
                    <input  <?php if($active=="Yes"){echo "checked";} ?> type="radio"name="active" value="No">No
                </td>
            </tr>

            <tr>
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit"name="submit" value="Update category" class="btn-secondary">              
            </tr>
        </table>
     </form>
     <?php
     if(isset($_POST['submit']))
     {
         //echo "clicked";\
         //get all values from form
         $id=$_POST['id'];
         $title=$_POST['title'];
         $current_image=$_POST['current_image'];
         $featured=$_POST['featured'];
         $active=$_POST['active'];

         //2. updating new image if selected
         //check whether image is selected or not
         if(isset($_FILES['image']['name']))
        {
         //get the image details
         $image_name = $_FILES['image']['name'];

         //check whether the image is available or not
         if($image_name !="")
         {
             //image available
             //upload the new image
             //auto rename image
                        //get extension of the image
                        $ext=end(explode('.',$image_name));

                        //rename image
                        $image_name="food_category_".rand(000,999). '.'.$ext;


                        $source_path=$_FILES['image']['tmp_name'];


                        $destination_path="../images/category/".$image_name;

                        //finally upload the image
                        $upload=move_uploaded_file($source_path, $destination_path);
                        //check whether the image is uploaded or not
                        //and if the image is not uploaded then we will stop the process
                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload']="<div class='error'>Failed to upload the image. </div>";
                            //redirect to manage category page
                            header('location:' .SITEURL.'admin/manage-category.php');
                            die();

                        }
             //remove the current image if available
             if($current_image !="")
             {
                $remove_path="../images/category/".$current_image;
                $remove=unlink($remove_path);
                //check whether the image is removed or not
                //if failed to remove the display message and stop the process
                if($remove==false)
                {
                   //failed to remove the image 
                   $_SESSION['failed-remove']="<div class='error'>Failed to remove current image. </div>";
                   header('location:' .SITEURL.'admin/manage-category.php');
                   die();//stop the process
                }

             }
             
             
         }
         else
         {
             $image_name=$current_image;
         }
        }
        else
        {
            $image_name=$current_image;
        }


         //updating database
        $sql2 = "UPDATE tbl_category SET
        title= '$title',
        image_name='$image_name',
        featured = '$featured',
        active = '$active'
        WHERE id=$id
        ";

         //3. executing query
        $res2 = mysqli_query($conn, $sql2);
         //4. redirect to manage category with message

         //check whether executed or not
         if($res2==true)
         {
             //category updated
        $_SESSION['update']= "<div class='success'>Category updated successfully </div>";
        //redirect to manage category page
        header('location:' .SITEURL.'admin/manage-category.php');
         }
         else
         {
             //failed to update category
             $_SESSION['update']= "<div class='error'>failed to update category. </div>";
                //redirect to manage category page
                header('location:' .SITEURL.'admin/manage-category.php');
         }
     }
     ?>
    </div>
</div>


<?php include('partials/footer.php');?>