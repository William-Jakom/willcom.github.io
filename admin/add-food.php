<?php include('partials/menu.php');?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

    <br><br>
    <?php
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset ($_SESSION['upload']);
        }
    ?>
    <form action=""method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" placeholder="title of the food">
                </td>
            </tr>

            <tr>
                <td>Description:</td>
                <td>
                   <textarea name="description"  cols="30" rows="5" placeholder="description of the food"></textarea>
                </td>
            </tr>

            <tr>
                <td>Price:</td>
                <td>
                    <input type="number" name="price" >
                </td>
            </tr>

            <tr>
                <td>Select Image:</td>
                <td>
                    <input type="file" name="image" >
                </td>
            </tr>

            <tr>
                <td>Category:</td>
                <td>
                    <select name="category">
                        <?php
                        //create php code to  display categories from database
                        //1. create sql to get all active categories from database
                            $sql="SELECT * FROM tbl_category WHERE active='Yes'";

                            $res = mysqli_query($conn, $sql);

                            //count Rows to check whether we have categories or not
                            $count = mysqli_num_rows($res);

                            //if count is greater than zero then we have categoriess
                            if($count>0)
                            {
                                //we have the category
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    //get the details from categories
                                    $id=$row['id'];
                                    $title=$row['title'];
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //we do not have category
                                ?>
                                <option value="1">No category Found</option>
                                <?php
                            }


                        //2. display on dropdown
                        ?>
                        <option value="1">Food</option>
                        <option value="2">Snacks</option>
                        
                    </select>
                </td>
            </tr>

            <tr>
                <td>Featured:</td>
                <td>
                    <input type="radio" name="featured" value="Yes">Yes
                    <input type="radio" name="featured" value="No">No
                </td>
            </tr>  
            
            <tr>
                <td>Active:</td>
                <td>
                    <input type="radio" name="active" value="Yes">Yes
                    <input type="radio" name="active" value="No">No
                </td>
            </tr> 
            
            <tr>
                <td colspan="7">
                    <input type="submit"name="submit" value="Add Food" class="btn-secondary">
                </td>
            </tr>
            

        </table>
    </form>
    <?php
    //check whether the button is clicked or bot
    if(isset($_POST['submit']))
    {
        //add food in database

        //1. get data from form
        $title=$_POST['title'];
        $description=$_POST['description'];
        $price=$_POST['price'];
        $category=$_POST['category'];

        //check whether radio button for featured and active are checked or not
        if(isset($_POST['featured']))
        {
            $featured=$_POST['featured'];
        }
        else
        {
            $featured = "No";//setting the default value
        }

        if(isset($_POST['active']))
        {
            $active= $_POST['active'];
        }
        else
        {
            $active="No";//setting the default value
        }
        //2. upload image if selected
        //check whether the select image is clicked or not and upload image only if image is selected
        if(isset($_FILES['image']['name']))
        {
            //get the details of the selected image
            $image_name = $_FILES['image']['name'];

            //check whether the image is selected or not and upload image only if selected
            if($image_name!="")
            {
                //image selected
                //rename the image
                //get the extension of selected image
                $ext=end(explode('.', $image_name));
                //create new name for the image
                $image_name="Food-Name".rand(0000,9999).".".$ext; //new image name may be "food-name.jpg"
                //upload the image

                //get the src path and destination path

                //source path is current location of the image
                $src=$_FILES['image']['tmp_name'];

                //destination path for the image to be uploaded
                $dst= "../images/food/".$image_name;

                //finally upload food image
                $upload=move_uploaded_file($src,$dst);

                //check whether images uploaded or not
                if($upload==false)
                {
                    //failed to upload image
                    //redirect to add food page with error message
                    $_SESSION['upload']="<div class= 'error'>Failed to upload image. </div>";
                    header('location:'.SITEURL.'admin/add-food.php');
                    //stop the process
                }
            }
            
        }
        else
        {
            $_image_name=""; //setting the defalt value as blank
        }

        //3. insert into database
        //create sql query to save data in database
        //numerical are not closed in quotes
        $sql2= "INSERT INTO tbl_food SET
        title='$title',
        description= '$description',
        price = $price,
        image_name= '$image_name',
        category_id = $category,
        featured='$featured',
        active= '$active'
        ";

        //execute the query\
        $res2 = mysqli_query($conn, $sql2);
        //check whether data is inserted or not
        //4. redirect with message to manage food page
        if($res2==true)
        {
            //data inserted successfully
        $_SESSION['upload']="<div class= 'success'>Food Added successfully. </div>";
        header('location:'.SITEURL.'admin/add-food.php'); 
        }
        else
        {
            //failed to insert data
        $_SESSION['upload']="<div class= 'error'>Failed to add food. </div>";
        header('location:'.SITEURL.'admin/add-food.php'); 
        }

        

    }
    
    ?>
    </div>
</div>

<?php include('partials/footer.php');?>