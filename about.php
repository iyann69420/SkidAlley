<?php include('partials-front/menu.php'); ?>

<html>

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