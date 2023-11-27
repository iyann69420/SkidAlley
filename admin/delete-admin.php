<?php 
 
   include('../config/constants.php');

  //get id of admin to be deleted
  $id = $_GET['id'];

  //create sql query to delete admin 
  $sql = "DELETE FROM admin WHERE id=$id";
   
  //execute query
  $res = mysqli_query($conn, $sql); 

  //check whether the query is executed sucessfully or not
  if($res==true)
  {
    //echo "Admin Deleted";
    $_SESSION['delete'] = "<div class = 'success'>Admin Deleted Sucessfully </div>";
    
    header('location:'.SITEURL.'admin/admin.php');
  }
  else
  {
    //echo "Failed to Delete ";

    $_SESSION['delete'] = "<div class = 'error'>Failed to Delete Admin </div> ";
    
    header('location:'.SITEURL.'admin/admin.php');
  }

  //



?>