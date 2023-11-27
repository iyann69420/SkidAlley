<?php
 include('../config/constants.php');

 $id = $_GET['id'];

 //create sql query to delete admin 
 $sql = "DELETE FROM content_management_aboutus WHERE id=$id";
  
 //execute query
 $res = mysqli_query($conn, $sql); 

 //check whether the query is executed sucessfully or not
 if($res==true)
 {
   //echo "Admin Deleted";
   $_SESSION['delete'] = "<div class = 'success'> Deleted Sucessfully </div>";
   
   header('location:'.SITEURL.'admin/aboutus.php');
 }
 else
 {
   //echo "Failed to Delete ";

   $_SESSION['delete'] = "<div class = 'error'>Failed to Delete  </div> ";
   
   header('location:'.SITEURL.'admin/about.php');
 }


?>