<?php include('partials-front/menu.php'); ?>

<html>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
 <style>
        /* General styling for the contact page */
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .contact-page {
            padding: 20px;
            background-color: #f8f8f8;
        }

        h1 {
            color: #333;
        }

        .contactus-description {
            font-family: <?php echo $font; ?>;
            font-size: <?php echo $textsize; ?>px;
            color: #555;
        }

        /* Styling for the map container */
        .mapcontainer {
            margin-top: 20px;
            position: relative;
        }

        /* Adjust the size of the Facebook Page plugin */
        .fb-page {
            width: 300px; /* Set your desired width */
            height: 400px; /* Set your desired height */
            margin-bottom: 20px;
        }

        /* Style for the Leaflet Map container */
        #map {
            width: 100%;
            height: 600px; /* Set your desired height */
        }
    </style>
<?php
$sql = "SELECT * FROM content_management_contactus";
$res = mysqli_query($conn, $sql);

if ($res == TRUE) {
    $count = mysqli_num_rows($res);

    if ($count > 0) {
        while ($rows = mysqli_fetch_assoc($res)) {
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
                <br>

               <div class="mapcontainer">
                <br><br>

               <h2>Facebook Page</h2>
               <br>
                <div class="fb-page" data-href="https://www.facebook.com/skidalley" data-tabs="timeline" data-width="300" data-height="400" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" style="width: 300px; height: 400px;">
                    <blockquote cite="https://www.facebook.com/skidalley" class="fb-xfbml-parse-ignore">
                        <a href="https://www.facebook.com/skidalley">Ski Valley</a>
                    </blockquote>
                </div>
                <br><br><br><br><br>
                <h2>Our Location</h2>
                <br>
                <!-- Leaflet Map with Corrected Marker -->
                <div id="map"></div>
                <script>
                    var map = L.map('map').setView([14.312775357608217, 120.96450306328985], 16); // Corrected coordinates

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    var marker = L.marker([14.312775357608217, 120.96450306328985]).addTo(map); // Corrected coordinates
                    marker.bindPopup("<b>Skid Alley Bike Shop</b>").openPopup();
                </script>
                  </div>

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

<!-- Add an anchor with id "facebook-page" to scroll to -->
<a id="facebook-page"></a>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v13.0&appId=YOUR_APP_ID&autoLogAppEvents=1" nonce="YOUR_NONCE"></script>
</html>
<?php include('partials-front/footer.php'); ?>
