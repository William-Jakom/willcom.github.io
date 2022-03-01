<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change password</h1>
        <br><br>

        <?php
        if(isset($_GET['id']))
        {
            $id=$_GET['id'];
        }
        ?>


        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Old password</td>
                    <td>
                        <input type="password"name="current_password" placeholder="current password">
                    </td>
                </tr>

                <tr>
                    <td>New password</td>
                    <td>
                        <input type="password"name="new_password" placeholder="new password">
                    </td>
                </tr>

                <tr>
                    <td>confirm password</td>
                    <td>
                        <input type="password"name="confirm_password" placeholder="confirm password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value = "change password" class="btn-secondary">

                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php
    //check whether the submit button in clicked or not
    if(isset($_POST['submit']))
    {
        //echo "clicked";
        //1. get data from form
        $id=$_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password=md5($_POST['new_password']);
        $confirm_password=md5($_POST['confirm_password']);

        //2. check whether the user with current id and current password exist
        $sql = "SELECT * FROM  tbl_admin1 WHERE id=$id AND password='$current_password'";
        //3. check whether new and current password match
        $res=mysqli_query($conn, $sql);

        if($res==true)
        {
            //check whether data is available
            $count=mysqli_num_rows($res);

            if($count==1)
            {
                //user exist and pasword can be changed
                //echo "User found";
                //check whether the new password and confirm password  match
                if($new_password==$confirm_password)
                {
                    //update password
                    //echo "password match";
                    $sql2="UPDATE tbl_admin1 SET
                    password='$new_password'
                    WHERE id=$id
                    ";
                    //execute the query
                    $res2=mysqli_query($conn, $sql2);
                    //check whether query is executed or not
                    if($res2==true)
                    {
                        //display success message
                        //redirect to manage admin page 
                    $_SESSION['change-pwd']="<div class='success'>password changed successfully  </div>";
                    //redirect the user 
                    header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        //Display error message
                        //redirect to manage admin page 
                    $_SESSION['pwd-not-match']="<div class='error'>Fail to change password   </div>";
                    //redirect the user to home page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                    }


                }
                else
                {
                    //redirect to manage admin page 
                    $_SESSION['pwd-not-match']="<div class='error'>password did not match  </div>";
                //redirect the user 
                header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                $_SESSION['user-not-found']="<div class='error'>User not found  </div>";
                //redirect the user 
                header('location:'.SITEURL.'admin/manage-admin.php');

            }
        }

        //4. change password if all above is true
    }

?>

<?php include('partials/footer.php'); ?>