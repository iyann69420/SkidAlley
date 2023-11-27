<?php
 include('../config/constants.php');

 $id = $_GET['id'];

 //create sql query to delete admin 
 $sql = "DELETE FROM brand_list WHERE id=$id";
  
 //execute query
 $res = mysqli_query($conn, $sql); 

 //check whether the query is executed sucessfully or not
 if($res==true)
 {
   //echo "Admin Deleted";
   $_SESSION['delete'] = "<div class = 'success'>Brand Deleted Sucessfully </div>";
   
   header('location:'.SITEURL.'admin/brands.php');
 }
 else
 {
   //echo "Failed to Delete ";

   $_SESSION['delete'] = "<div class = 'error'>Failed to Delete Brands </div> ";
   
   header('location:'.SITEURL.'admin/brands.php');
 }


?>