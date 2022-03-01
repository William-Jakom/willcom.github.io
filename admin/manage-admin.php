<?php include('partials/menu.php');?>
        

            <!---- main content section start-->
            <div class= "main-content">
            <div class="wrapper">
            
            <h1>Manage Admin</h1>
            <br/><br/>
            <?php
            if(isset($_SESSION['add']))
            {
                    echo $_SESSION['add'];//diplaying session message
                    unset($_SESSION['add']); //removing session
            }
                if(isset($_SESSION['delete']))
                {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
                }

                if(isset($_SESSION['update']))
                {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
                }

                if(isset($_SESSION['user-not-found']))
                {
                echo $_SESSION['user-not-found'];
                unset($_SESSION['user-not-found']);
                }
/*
                if(isset($_SESSION['pwd-not-match']))
                {
                echo $_SESSION['pwd-not-match'];
                unset($_SESSION['pwd-not-match']);
                }*/

                if(isset($_SESSION['change-pwd']))
                {
                echo $_SESSION['change-pwd'];
                unset($_SESSION['change-pwd']);
                }
            
            
            ?>
            <br><br><br>


            <!--button to add admin-->
            <a href="add-admin.php" class="btn-primary">Add Admin </a> <br/><br/><br/>       
               <table class="tbl-full">
                   <tr>
                           <th>S.N</th>
                           <th>Full Name</th>
                           <th>Username</th>
                           <th>Actions</th>
                   </tr>
                   <?php
                   //querry to det all admin from database 
                   $sql = "SELECT * FROM tbl_admin1";
                   //execute querry
                   $res = mysqli_query($conn,$sql);

                   //check whether the querry is executed o not
                   if($res==TRUE)
                   {
                           //COUNT  rows to check wether theit ids data at the database
                        $count= mysqli_num_rows($res);//funtion to get all row in database
                        $sn=1;//create variable and assign value
                           //check the num of rows
                           if($count>0)
                           {
                                   //we have data in database
                                   while($rows=mysqli_fetch_assoc($res))
                                   {
                                           //using while loop to get data from database
                                           //and while loop will run as longer we have data in database

                                           //get individual data
                                           $id=$rows['id'];
                                           $full_name=$rows['full_name'];
                                           $username=$rows['username'];

                                           //diplaying values in table
                                           ?>

                  <tr>
                           <td><?php echo $sn++; ?></td>
                           <td><?php echo $full_name; ?></td>
                           <td><?php echo $username; ?></td>
                           <td>
                                   <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change password </a>
                                   <a href="<?php echo SITEURL;?>admin/update_admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin </a>
                                   <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id;  ?>" class="btn-danger">Delete button </a>
                           </td>
                   </tr>

                                           <?php

                                   }
                           }else{
                                   //no data in database
                           }
                   }

                   ?>

                  
           </table>

</div>
        </div>
        <?php include('partials/footer.php');?>