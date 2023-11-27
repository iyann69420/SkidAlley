<?php include('partials/menu.php'); ?>
 
<div class="main-content">
    <div class ="wrapper">
        <h1>Add Message</h1>

        <br><br>

    
        <br><br>

        <form action="" method="POST">

           <table class="tbl-30">
           <tr>
                <td>Message</td>
                <td>
                    <textarea name="message" id="" cols="30" rows="5" placeholder="Message"></textarea>
                </td>
            </tr>
           
            <tr>
                <td>Timestamp:</td>
                <td>
                    <?php $currentTimestamp = date('Y-m-d H:i:s'); ?>
                    <input type="hidden" name="timestamp" value="<?php echo $currentTimestamp; ?>">
                    <?php echo $currentTimestamp; ?>
                </td>
            </tr>
            
            <tr>
    <td>Recipient:</td>
    <td>
        <select name="recipient">
        <option value="all">ALL</option>
            <?php
            // Assuming you have a database connection established
            $query = "SELECT * FROM client_list WHERE status = 1";
            $res = mysqli_query($conn, $query);

            $count = mysqli_num_rows($res);
            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $client = $row['username'];
                    echo '<option value="' . $id . '">' . $client . '</option>';
                }
            } else {
                echo '<option value="0">No Client Found</option>';
            }
            ?>
        </select>
    </td>
</tr>










            <tr>
                <td coolspan="2">
                    <input type="submit" name="submit" value="Add Message" class="btn-secondary">
                </td>
            </tr>

           </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $notificationMessage = $_POST['notification_message'];
            $timestamp = date('Y-m-d H:i:s'); // Current timestamp
        
            $query = "INSERT INTO notifications (user_id, message, notification_type, timestamp, status, is_read, promo_id) 
                      VALUES (:user_id, :message, :notification_type, :timestamp, :status, :is_read, :promo_id)";
        
            // You'll need to bind actual values for these placeholders
            $params = [
                'user_id' => 1,  // Change this to the actual user's ID
                'message' => $notificationMessage,
                'notification_type' => 'some_type', // Change this as needed
                'timestamp' => $timestamp,
                'status' => 'active', // Change this as needed
                'is_read' => 0, // Assuming the notification is unread initially
                'promo_id' => null // Change this if needed
            ];
        
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
        
            // Notify user (you'll need to implement this part)
            // You can use email, push notifications, etc.
        }
        
        ?>
        
    </div>
</div>


<?php include('partials/footer.php'); ?>