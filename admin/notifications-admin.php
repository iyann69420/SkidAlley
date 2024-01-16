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
    .view-order-button {
    background-color: black;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
  }

  .view-order-button:hover {
    background-color: orange;
  }
  .delete-notification-button {
    margin-top: 5px;
    background-color: black;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.delete-notification-button:hover {
    background-color: orange;
    color: white;
}
</style>
<div class="main-content">
    <div class="wrapper">
        <h1>Notifications</h1>
        <br>
        <?php
        

        $notificationSql = "SELECT * FROM admin_notifications ORDER BY timestamp DESC";
        $notificationResult = mysqli_query($conn, $notificationSql);

        if ($notificationResult) {
            if (mysqli_num_rows($notificationResult) > 0) {
                while ($row = mysqli_fetch_assoc($notificationResult)) {
                    $notificationId = $row['id'];
                    $message = $row['order_id'];
                    $reason = $row['reason'];
                    $timestamp = $row['timestamp'];
                    $order_id = $row['order_id'];
                    $isRead = $row['is_read'];
                    $isApproved = $row['is_approved'];

                    $notificationClass = $isRead ? 'notification-item' : 'notification-item unseen';

                    if ($isApproved == 0) {
                        $notificationType = "Cancellation of Order";
                    } elseif ($isApproved == 1) {
                        $notificationType = "Purchase Order";
                    } elseif ($isApproved == 2) {
                        $notificationType = "Order Received";
                    } 
                    elseif ($isApproved == 3) {
                        $notificationType = "Confirming Payment";
                    }
                    elseif ($isApproved == 4) {
                        $notificationType = "Review Pending";
                    }
                    
                    else {
                        continue;
                    }
                    ?>
                    <div class="notifications">
                    <div class="<?php echo $notificationClass; ?>" onclick="showAlertify('<?php echo $message; ?>', '<?php echo $reason; ?>', '<?php echo $timestamp; ?>', '<?php echo $order_id; ?>', '<?php echo $notificationId; ?>', '<?php echo $isApproved; ?>')">
                            <h3><?php echo $notificationType; ?></h3>
                            <?php if ($isApproved == 0) : ?>
                                <p>There is a cancelled order. The reason is: <strong><?php echo $reason; ?></strong></p>
                            <?php elseif ($isApproved == 1) : ?>
                                <p>There is a purchase order.</p>
                            <?php elseif ($isApproved == 2) : ?>
                                <p>Order has been received.</p>
                            <?php elseif ($isApproved == 3) : ?>
                                <p>Confirming payment for order: <strong><?php echo $order_id; ?></strong></p>
                            <?php elseif ($isApproved == 4) : ?>
                                <p>Pending Review: <strong><?php  ?></strong></p>
                            <?php endif; ?>
                            <span class="notification-date"><?php echo $timestamp; ?></span>
                            <button class="delete-notification-button" onclick="deleteNotification(event, '<?php echo $notificationId; ?>')">Delete</button>

                            
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No notifications found.</p>";
            }
        } else {
            echo "Error executing the query: " . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>
</div>

<audio id="notificationSound" src="/SkidAlley/audio/notification.mp3"></audio>

<script>
  function deleteNotification(event, notificationId) {
    // Stop the event propagation to prevent triggering showAlertify
    event.stopPropagation();

    // Make an AJAX call to delete the notification
    $.ajax({
        type: 'POST',
        url: 'delete-notification.php',
        data: {
            notification_id: notificationId
        },
        success: function (response) {
            console.log('Notification deleted');
            
            // Refresh the page after successful deletion
            location.reload();
        },
        error: function (error) {
            console.error('Error deleting notification', error);
        }
    });
}


function showAlertify(message, reason, timestamp, order_id, notification_id, isApproved) {
    var notificationType = isApproved == 0 ? 'Cancellation of Order' : 'Purchase Order';

    // Play the notification sound in the background with muted audio
    var notificationSound = new Audio('/SkidAlley/audio/notification.mp3'); // Replace with the correct path to your notification sound
    notificationSound.muted = true;
    notificationSound.play();

    // Change the tab name
    document.title = 'New Notification - ' + notificationType;

    alertify.alert(
    notificationType,
    getMessageText(isApproved, reason) +
        '<br><br>' +
        timestamp +
        '<br><br><button class="view-order-button" onclick="redirectToOrder(' +
        order_id +
        ')">View Order</button>',
    function () {
        // This function is called after the user clicks the "OK" button in the alertify dialog
        markNotificationAsRead(notification_id);

        // Reset the tab name to the default value
        document.title = 'Admin Notification';

        // Reload the page to reflect the updated "is_read" status
        window.location.reload();
    }
);
}


  function getMessageText(isApproved, reason) {
    if (isApproved == 0) {
      return 'There is a cancelled order. The reason is: <strong>' + reason + '</strong>';
    } else if (isApproved == 1) {
      return 'There is a purchase order.';
    } else if (isApproved == 2){
      return 'Order has been recieve.';
    } 
    else if (isApproved == 3){
      return 'Confirming Payment';
      
    } 
    else if (isApproved == 4){
      return 'There is a Review';
      
    } 
    else {
      return ''; // Handle other cases if needed
    }
  }

  function redirectToOrder(orderId) {
    window.location.href = `update-orders.php?id=${orderId}`;
  }

  function markNotificationAsRead(notificationId) {
    // Make an AJAX call to mark the notification as read
    $.ajax({
      type: 'POST',
      url: 'mark_notification_as_read.php',
      data: {
        notification_id: notificationId
      },
      success: function (response) {
        console.log('Notification marked as read');
      },
      error: function (error) {
        console.error('Error marking notification as read', error);
      }
    });
  }
  
  function playNotificationSound() {
    // Create an audio element
    var audio = new Audio('/SkidAlley/audio/notification.mp3');

    // Play the notification sound
    audio.play();
}
</script>

<?php include('partials/footer.php'); ?>