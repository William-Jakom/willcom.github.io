<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>
        <?php
        //1. get the id of selected id
        $id=$_GET['id'];

        //2. create sql quety to get the details
        $sql="SELECT * FROM tbl_admin1 WHERE id=$id";
        //execute the querry
        $res=mysqli_query($conn, $sql);
        //check whether the query is executed or not
        if($res==true)
        {
            $count = mysqli_num_rows($res);
            //check whether we have admin data or not
            if($count==1)
            {
                //get details
                //echo "admin available";
                $row=mysqli_fetch_assoc($res);

                $full_name=$row['full_name'];
                $username=$row['username'];
            }
            else{
                //redirect to manage admin page 
                header('location:'.SITEURL.'admin/manage-admin.php');
            }

        }


        ?>

        <form action="" method="POST">

        <table>
            <tr>
                <td>Full Name:</td>
                <td>
                    <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                </td>
            </tr>

            <tr>
                <td>Username</td>
                <td>
                    <input type="text" name="username" value="<?php echo $username; ?>">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                </td>
            </tr>

       
        </table>

        </form>
    </div>
</div>

<?php
//check whether the submit button is clicked or not
if(isset($_POST['submit']))
{
    //echo "button clicked";
    //get all value from form to update
     $id=$_POST['id'];
     $full_name=$_POST['full_name'];
     $username=$_POST['username'];

     //create sql query to update admin
     $sql = "UPDATE tbl_admin1 SET
     full_name ='$full_name',
     username = '$username'
     WHERE id='$id'
     ";

     //execite the query
     $res= mysqli_query($conn, $sql);

     //check whether the query is executed successfully or not
     if($res==true)
     {
         //query executed and admin updated 
         $_SESSION['update']= "<div class='success'>Admin Updated successfully. </div>";
         //redurect to manage admin page
         header('location:'.SITEURL.'admin/manage-admin.php');
        
    }
    else
    {
        //fail to update admin
        $_SESSION['update']= "div class='error'>Fail to update Admin. </div>";
        //redurect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
        
    }

}

?>

<?php include('partials/footer.php'); ?>