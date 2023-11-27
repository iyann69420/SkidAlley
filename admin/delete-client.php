<?php 
 
   include('../config/constants.php');

  //get id of admin to be deleted
  $id = $_GET['id'];

  //create sql query to delete admin 
  $sql = "DELETE FROM client_list WHERE id=$id";
   
  //execute query
  $res = mysqli_query($conn, $sql); 

  //check whether the query is executed sucessfully or not
  if($res==true)
  {
    //echo "Admin Deleted";
    $_SESSION['delete'] = "<div class = 'success'>Client Deleted Sucessfully </div>";
    
    header('location:'.SITEURL.'admin/clients.php');
  }
  else
  {
    //echo "Failed to Delete ";

    $_SESSION['delete'] = "<div class = 'error'>Failed to Delete Client </div> ";
    
    header('location:'.SITEURL.'admin/clients.php');
  }

  //



?>