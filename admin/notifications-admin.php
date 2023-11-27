<?php include('partials/menu.php'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/alertify.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/themes/default.min.css" />

<script src="https://cdn.jsdelivr.net/npm/alertifyjs/build/alertify.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style>
.main-content {
  width: 80%;
  margin: 0 auto;
  padding: 20px;
  
}

.wrapper {
  padding: 20px;
}

.notifications {
  list-style: none;
  padding: 0;
}

.notification-item {
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 5px;
  padding: 20px;
  margin-bottom: 20px;
}
.notification-item.unseen {
        border: 1px solid red; 
}


.notification-item h3 {
  margin: 0 0 10px;
  font-size: 22px;
  color: #333;
}

.notification-item p {
  margin: 0 0 10px;
  color: #666;
  font-size: 16px;
}

.notification-date {
  display: block;
  color: #999;
  font-size: 14px;
}
</style>
<div class="main-content">
    <div class="wrapper">
        <h1>Notifications</h1>
        <br>
        <?php
            // Assuming you have already established the database connection elsewhere
            $notificationSql = "SELECT * FROM admin_notifications ORDER BY timestamp DESC";
            $notificationResult = mysqli_query($conn, $notificationSql);

            if (mysqli_num_rows($notificationResult) > 0) {
                // Loop through the notifications and display them
                while ($row = mysqli_fetch_assoc($notificationResult)) {
                    $notificationId = $row['id'];
                    $message = $row['order_id'];
                    $reason = $row['reason'];
                    $timestamp = $row['timestamp'];
                    $order_id = $row['order_id'];
                    $isRead = $row['is_read']; 

                    $notificationClass = $isRead ? 'notification-item' : 'notification-item unseen';
        ?>

          <div class="notifications">
                <div class="<?php echo $notificationClass; ?>" onclick="showAlertify('<?php echo $message; ?>', '<?php echo $reason; ?>', '<?php echo $timestamp; ?>', '<?php echo $order_id; ?>', '<?php echo $notificationId; ?>')">
                    <h3>Cancellation of Order</h3>
                    <p>There is a cancelled order. The reason is: <strong><?php echo $reason; ?></strong></p>
                    <span class="notification-date"><?php echo $timestamp; ?></span>
                </div>
            </div>

        <?php
            }
        } else {
            echo "<p>No notifications found.</p>";
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<script>
   function showAlertify(message, reason, timestamp, order_id, notification_id) {
        alertify.alert('Cancellation of Order', 'There is a cancelled order. The reason is: ' + reason + '<br><br>' + timestamp + '<br><br><button onclick="redirectToOrder(' + order_id + ')">View Order</button>', function () {
            markNotificationAsRead(notification_id);
        });
    }

    function redirectToOrder(orderId) {
        window.location.href = `update-orders.php?id=${orderId}`;
    }

    function markNotificationAsRead(notificationId) {
        // Make an AJAX call to mark the notification as read
        $.ajax({
            type: 'POST',
            url: 'mark_notification_as_read.php',
            data: { notification_id: notificationId },
            success: function (response) {
                console.log('Notification marked as read');
            },
            error: function (error) {
                console.error('Error marking notification as read', error);
            }
        });
    }
</script>