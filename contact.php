<?php include('partials-front/menu.php'); ?>

<html>
<br><br><br><br><br><br><br><br>


<?php
            $sql = "SELECT * FROM content_management_contactus";
            $res = mysqli_query($conn, $sql);

            if ($res == TRUE) {
                $count = mysqli_num_rows($res);

                $sn = 1;

                if ($count > 0) {
                    while ($rows = mysqli_fetch_assoc($res)) {
                        $id = $rows['id'];
                        $aboutus = $rows['contactus'];
                        $font = $rows['font'];
                        $textsize = $rows['text_size'];
                       

                        

                        ?>
                        <body style="text-align: center"; >   

                            <div class="contact-page">
                                <h1>CONTACT US</h1>
                                <td>
                                 <span class="contactus-description" style="font-family: <?php echo $font; ?>; font-size: <?php echo $textsize; ?>px;"><?php echo $aboutus; ?></span>
                                </td>

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
<?php include('partials-front/footer.php'); ?>