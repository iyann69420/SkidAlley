<?php include('partials-front/menu.php'); ?>

<br><br><br><br><br><br><br><br>

<?php 
if (!isset($_SESSION['userLoggedIn'])) {
    header("Location: login.php");
    exit();
}
?>

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
.notification.unread {
    border-left: 5px solid #ff9800; /* Choose the color you want for unread notifications */
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
                $isRead = $row['is_read'];

                // Add a CSS class based on whether the notification has been read or not
                $notificationClass = $isRead ? 'read' : 'unread';

                ?>
                <div class='notification <?php echo $notificationClass; ?>' onclick="showNotification('<?php echo $message ?>', '<?php echo $notificationType ?>', <?php echo $notificationId ?>)">
                    <p><?php echo $message ?></p>
                    <p><small>Sent at: <?php echo $timestamp ?></small></p>
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
     function showNotification(message, type, notificationId) {
        // Send an AJAX request to update the is_read field in the database
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update-notification.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('notification_id=' + notificationId);

        xhr.onload = function () {
            if (xhr.status == 200) {
                // After updating the is_read field, show the notification details
                alertify.confirm('Notification Details',
                    '<div style="font-weight: bold; font-size: 16px; margin-bottom: 10px;">' + type + '</div>' +
                    '<div style="margin-bottom: 10px;">Message: ' + message + '</div>' +
                    '<div><button onclick="redirectToOrders()" class="view-orders-button">View Orders</button></div>',
                    function () {
                        // This is the callback function when the "Mark as Read" button is clicked
                    },
                    function () {
                        // Callback function when the Cancel button is clicked
                        location.reload(); // Reload the page after the Alertify dialog is closed
                    })
                    .set('labels', { ok: 'Mark as Read', cancel: 'Cancel' })
                    .set('defaultFocus', 'cancel');
            } else {
                console.error(xhr.responseText);
            }
        };
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
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include('partials-front/footer.php'); ?>
