<?php include('partials-front/menu.php'); ?>

<br><br><br><br><br><br><br><br>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/alertify.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/themes/default.min.css" />

<script src="https://cdn.jsdelivr.net/npm/alertifyjs/build/alertify.min.js"></script>
<style>
    .ajs-button.ajs-ok {
        background-color: black !important;
        color: white !important;
    }

    .ajs-button.ajs-ok:hover {
        background-color: orange !important;
        color: black !important;
    }
    .ajs-button.ajs-ok, .ajs-button.ajs-cancel {
        background-color: black !important;
        color: white !important;
    }

    .ajs-button.ajs-ok:hover, .ajs-button.ajs-cancel:hover {
        background-color: orange !important;
        color: black !important;
    }
    .view-orders-button {
    padding: 10px 20px;
    background-color: black;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: color 0.3s;
}

.view-orders-button:hover {
    color: orange;
}

.notification:hover {
        background-color: #f9f9f9;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
       
    }

    .delete-button {
        background: none;
        border: none;
    }

    .delete-button:hover {
        color: darkred;
        transform: scale(1.1); /* Optional: to provide a slight scale effect on hover */
    }
    
</style>
<body>
    <header>
        <h1>Notification </h1>
    </header>
    
    <main>
        <div class="notification-container">
            <?php
            // Assuming you have already established a database connection
            // Perform a SELECT query to fetch notifications
            $notificationSql = "SELECT * FROM notifications WHERE user_id = $userId ORDER BY timestamp DESC";
            $notificationResult = mysqli_query($conn, $notificationSql);

            if (mysqli_num_rows($notificationResult) > 0) {
                // Loop through the notifications and display them
                while ($row = mysqli_fetch_assoc($notificationResult)) {
                    $notificationId = $row['notification_id'];
                    $message = $row['message'];
                    $timestamp = $row['timestamp'];
                    $notificationType = $row['notification_type'];

                    ?>
                    <div class='notification' onclick="showNotification('<?php echo $message ?>', '<?php echo $notificationType ?>', <?php echo $notificationId ?>)">
                        <p><?php echo $message?></p>
                        <p><small>Sent at: <?php echo $timestamp?></small></p>
                        <form method="post" action="<?php echo SITEURL; ?>delete-notification.php">
                            <input type="hidden" name="notification_id" value="<?php echo $notificationId; ?>">
                            <button type="submit" class="delete-button" style="background: none; border: none;" onclick="deleteNotification(event)">
                                <i class="fa fa-trash" style="color: red;"></i>
                            </button>
                        </form>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No notifications found.</p>";
            }
            ?>
        </div>
    </main>
    <script>
        function deleteNotification(event) {
                event.stopPropagation();
                var notificationId = event.target.closest('form').querySelector('input[name="notification_id"]').value;
                
                // Send an AJAX request to delete the notification
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '<?php echo SITEURL; ?>delete-notification.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.send('notification_id=' + notificationId);

                xhr.onload = function () {
                    if (xhr.status == 200) {
                        // If the deletion is successful, you can remove the notification element from the DOM
                        event.target.closest('.notification').remove();
                    } else {
                        console.error(xhr.responseText);
                    }
                };
            }

           function showNotification(message, type, notificationId) {
            alertify.confirm('Notification Details', 
        '<div style="font-weight: bold; font-size: 16px; margin-bottom: 10px;">' + type + '</div>' +
        '<div style="margin-bottom: 10px;">Message: ' + message + '</div>' +
        '<div><button onclick="redirectToOrders()" class="view-orders-button">View Orders</button></div>', 
        function(){
            // Update the is_read field in the database
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update-notification.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('notification_id=' + notificationId);

            xhr.onload = function () {
                if (xhr.status == 200) {
                    // You can add additional logic here if needed
                } else {
                    console.error(xhr.responseText);
                }
            };
        }, 
        function() {
            // Cancel button callback
        })
        .set('labels', {ok:'Mark as Read', cancel:'Cancel'})
        .set('defaultFocus', 'cancel');
        }


            function redirectToOrders() {
                // Redirect to orderstatus.php
                window.location.href = 'orderstatus.php'; // Change this URL according to your project structure
            }

            function deleteNotification(event) {
                event.stopPropagation();
                var notificationId = event.target.closest('form').querySelector('input[name="notification_id"]').value;
                
                // Send an AJAX request to delete the notification
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '<?php echo SITEURL; ?>delete-notification.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.send('notification_id=' + notificationId);

                xhr.onload = function () {
                    if (xhr.status == 200) {
                        // If the deletion is successful, you can remove the notification element from the DOM
                        event.target.closest('.notification').remove();
                    } else {
                        console.error(xhr.responseText);
                    }
                };
            }
    </script>


</body>
</html>

<?php include('partials-front/footer.php'); ?>
