<?php include('../config/constants.php');?>
<html>
    <head>
    <title>login Food order system</title>
    <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <div class="login">
            <h1 class="text-center">login</h1>
            <br><br>

            <?php
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset ($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset ($_SESSION['no-login-message']);
            }


            ?>
            <br><br>

            <!--login form start here  -->
            <form action="" method="POST" class="text-center">
                Username <br>
                <input type="text"name="username" placeholder="Enter user name"><br><br>
                Password <br>
                <input type="password"name="password" placeholder="Enter password"><br><br>

                <input type="submit"name="submit" value="login" class="btn-primary"><br><br>
            </form>
              <!--login form end here  -->

            <p class="text-center">created by <a href="www.facebook.com">william jakom </a></p>
        </div>
    </body>
</html>
<?php  
//check whether submit button is clicled or not
if(isset($_POST['submit']))
{
    //process login
    //1. get data from login form
    //$username=$_POST['username'];
    // $password=md5($_POST['password']);
     $username=mysqli_real_escape_string($conn, $_POST['username']);
    
     $raw_password=md5($_POST['password']);
     $password=mysqli_real_escape_string($conn, $raw_password);

     //2. sql tro check whether the username and password exist
     $sql="SELECT * FROM tbl_admin1 WHERE username ='$username' AND password='$password'";

     //3. execute the query
     $res=mysqli_query($conn, $sql);
    //4. count row to check whether user exist or not
    $count=mysqli_num_rows($res);
    if($count==1)
    {
        //user available and login successfully
        $_SESSION['login']="<div class='success'>Login successfully. </div>";
        $_SESSION['user']=  $username ;//check whether user is login or not and lof out will unset   
        //redirect to home page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //user not available and login fail
        $_SESSION['login']="<div class='error text-center'>Username or password did not match. </div>";

        //redirect to home page
        header('location:'.SITEURL.'admin/login.php');
    }
}

?>