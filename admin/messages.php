<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Messages</h1>

        <br />

        <br /><br /><br />

        <a href="add-message.php" class="btn-primary">Add Message</a>
        <br /><br /><br />

        <table class="tbl-full">
            <tr>
                <th>#</th>
                <th>Sender</th>
                <th>Recipient</th>
                <th>Message Text</th>
                <th>Timestamp</th>
                <th>Action</th>
            </tr>

            <tr>
                <td>1</td>
                <td>Skid Alley</td>
                <td>User2324</td>
                <td>Hello World!</td>
                <td>2023-08-24 10:00:00</td>
                <td>
                    <a href="<?php echo SITEURL; ?>admin/update-message.php?id=<?php echo $id; ?>" class='btn-secondary'>Update Message</a>
                    <a href="<?php echo SITEURL; ?>admin/delete-message.php?id=<?php echo $id; ?>" class="btn-third">Delete Message</a>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php include('partials/footer.php') ?>
