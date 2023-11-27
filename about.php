<?php include('partials-front/menu.php'); ?>

<html>
<br><br><br><br><br><br><br><br>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<?php
            $sql = "SELECT * FROM content_management_aboutus";
            $res = mysqli_query($conn, $sql);

            if ($res == TRUE) {
                $count = mysqli_num_rows($res);

                $sn = 1;

                if ($count > 0) {
                    while ($rows = mysqli_fetch_assoc($res)) {
                        $id = $rows['id'];
                        $aboutus = $rows['aboutus'];
                        $font = $rows['font'];
                        $textsize = $rows['text_size'];

                        

                        ?>

                        <body style="text-align: center"; >   

                        <div class="about-page">
                            <h1>ABOUT US</h1>
                            <td>
                                <span class="aboutus-description" style="font-family: <?php echo $font; ?>; font-size: <?php echo $textsize; ?>px;"><?php echo $aboutus; ?></span>
                            </td>
                            <br>
                            <a class="icon-link" href="https://www.facebook.com/skidalley" target="_blank">
                                <i class="fab fa-facebook-square fa-2x"></i> <!-- Font Awesome Facebook Icon -->
                            </a>
                            
                            <!-- Location Icon Link -->
                            <a class="icon-link" href="https://goo.gl/maps/FistR2mVw7F8FMxu9" target="_blank">
                                <i class="fas fa-map-marker-alt fa-2x"></i> <!-- Font Awesome Location Icon -->
                        </div>


                        </body>

                        <?php
                    }
                } else {
                    // Display a message when there are no customers
                    echo "<td colspan='5'><div class='error'>No About Us Inputted.</div></td>";
                }
            }
            ?>


</html>
 <script>
    document.getElementById('font-select').addEventListener('change', function() {
    const selectedFont = this.value;
    document.getElementById('font-preview').style.fontFamily = selectedFont;
    document.getElementById('aboutus-content').style.fontFamily = selectedFont; // Apply selected font to the content
});
 </script>

 
<?php include('partials-front/footer.php'); ?>