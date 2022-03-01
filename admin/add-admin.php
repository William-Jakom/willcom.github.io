<?php include('partials/menu.php');?>
<div class="class-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>

        <?php
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];//diplaying session message
            unset ($_SESSION['add']);//removing sessioon message
        }

        ?>
        
        <form action="" method="post">

        <table class="tbl-30">
            <tr>
                <td>Full Name</td>
                <td><input type="text" name="full_name" placeholder="enter your name"></td>
            </tr>

            <tr>
                <td>Username
                    <td>
                        <input type="text" name="username" placeholder="your user name">
                    </td>
                </td>
            </tr>

            <tr>
                <td>Password
                    <td>
                        <input type="password" name="password" placeholder="your password">
                    </td>
                </td>
            </tr>

            <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add admin" class="btn-secondary">
                    </td>
            
            </tr>

        </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
//process the value in forms and save them in database
//check whether submit button is clicked

if(isset($_POST['submit']))
{
    //1. get data from form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    //2. sql querry to savew data into database
    $sql = "INSERT INTO tbl_admin1 SET
    full_name='$full_name',
    username='$username',
    password='$password'
    ";  

    //3. execute querry and save data in database
    
    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    //4. check whwther the querry is executed/ data is inserted
    if($res==TRUE)
    {
        //echo "data is inserted ";

        //creating session variable to diplay message 
        $_SESSION['add']="<div class='success'>admin added successfully</div>";
        //redirecting page to admin
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //creating session variable to diplay message 
        $_SESSION['add']="Failed to add Admin";
        //redirecting page to admin
        header("location:".SITEURL.'admin/add-category.php');
        
    }
}
?>