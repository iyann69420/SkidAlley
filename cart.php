<?php
include('partials-front/menu.php');

if (!isset($_SESSION['userLoggedIn'])) {
    header("Location: login.php");
    exit();
}
?>
<br><br><br>
<body style="text-align: center"; >

<?php
if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn']) {
    
    $client_id = $_SESSION['client_id'];
    $totalPrice = 0;
   

    ?>
    <div class="cart-container">
    <br><br><br><br>
    <h1>Shopping Cart</h1>
    <br><br><br>

    <table class="add-to-cart">
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Name</th>
            <th>Unit Price</th>
            <th>Color</th>
            <th>Size</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>

        <?php
        $sql = "SELECT c.id AS cart_id, c.product_id, c.quantity, c.color, c.size, p.name, p.price, p.image_path, d.discount_percentage
        FROM cart_list c
        INNER JOIN product_list p ON c.product_id = p.id
        LEFT JOIN discounts d ON c.product_id = d.product_id AND NOW() BETWEEN d.start_time AND d.end_time

        WHERE c.client_id = $client_id";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        $sn = 1;

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $cart_id = $row['cart_id'];
                $product_id = $row['product_id'];
                $product_name = $row['name'];
                $product_price = $row['price'];
                $product_quantity = $row['quantity'];
                $product_total = $product_price * $product_quantity;
                $product_image = $row['image_path'];

                // Check if there is enough stock for the product
                $color = $row['color'];
                $size = $row['size'];
                $stock_query = "SELECT sl.quantity
                FROM stock_list sl
                INNER JOIN product_colors_sizes pcs ON sl.product_colors_sizes_id = pcs.id
                WHERE sl.product_id = $product_id AND pcs.color = '$color' AND pcs.size = '$size'";
                $stock_result = mysqli_query($conn, $stock_query);
                $stock_row = mysqli_fetch_assoc($stock_result);
                $available_stock = $stock_row['quantity'];

                $discount_percentage = $row['discount_percentage'];

                // Apply discount based on fetched discount percentage
               $discounted_price = $product_price - ($product_price * ($discount_percentage / 100));
                $product_total = $discounted_price * $product_quantity; // Updated calculation with discount
                $product_price = $discounted_price;

                

                // Add data-available-stock attribute to plus and minus buttons
                ?>
                <tr>
                    <td><?php echo $sn++; ?></td>
                    <td>
                        <?php
                        if ($product_image == "") {
                            echo "<div class='error'>Image not Added.</div>";
                        } else {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/bike/<?php echo $product_image; ?>"
                                 width="100px">
                            <?php
                        }
                        ?>
                    </td>

                    <td><?php echo $product_name; ?></td>
                    <td>PHP<?php echo number_format($product_price); ?></td>

                    <td><?php echo $row['color']; ?></td>
                    <td><?php echo $row['size']; ?></td>

                    <td>
                        <div class="quantity-control">
                            <?php
                            if ($product_quantity > $available_stock) {
                                // Not enough stock message
                                echo "<div class='error'>Not enough stock available for $product_name. Available stock: $available_stock</div>";
                            } else {
                                ?>
                                <button class="minus-btn" data-cart-id="<?php echo $cart_id; ?>">-</button>
                                <input type="number" class="quantity" value="<?php echo $product_quantity; ?>"
                                       data-product-id="<?php echo $product_id; ?>"
                                       data-product-price="<?php echo $product_price; ?>"
                                       data-available-stock="<?php echo $available_stock; ?>">
                                <button class="plus-btn" data-cart-id="<?php echo $cart_id; ?>">+</button>
                                <?php
                            }
                            ?>
                        </div>
                    </td>

                    <td class="product-total">₱<?php echo $product_total; ?></td>
                    <td>
                        <a class="delete-btn" data-cart-id="<?php echo $cart_id; ?>" href="<?php echo SITEURL; ?>delete-cart.php?id=<?php echo $cart_id; ?>">Delete</a>
                        </td>
                </tr>
                <?php
                $totalPrice += $product_total; // Add product total to the total price
            }
        } else {
            echo "<tr> <td colspan='9' class='error' style='font-size: 32px; color: red;'> No cart added. </td> </tr>";


        }
        ?>
        <tr>
            <td colspan="7" style="text-align: right">Total Price:</td>
            <td class="total-price">₱<?php echo number_format($totalPrice); ?></td>
            <td></td>
        </tr>
    </table>
    
    <br><br><br>
    <a class="checkout-button" href="<?php echo SITEURL; ?>checkout.php?client_id=<?php echo $client_id; ?>&cart_id=<?php echo $cart_id; ?>">Checkout</a>


        

    </div>


    <br>

    <?php
}
?>

</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/default.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>


<script>
    
$(document).ready(function () {
    $('.plus-btn').click(function () {
        var cartId = $(this).data('cart-id');
        var quantityInput = $(this).siblings('.quantity');
        var currentQuantity = parseInt(quantityInput.val());
        var availableStock = parseInt(quantityInput.data('available-stock'));

        if (currentQuantity < availableStock) {
            quantityInput.val(currentQuantity + 1);
            updateTotal(quantityInput);
            updateQuantity(cartId, currentQuantity + 1); // Send an AJAX request to update the quantity
        } else {
            // Display an alert using AlertifyJS
            alertify.error("Not enough stock available.");

            setTimeout(function() {
            alertify.dismissAll();
            }, 8000);
          
        }

        
        
    });
    $('.quantity').each(function () {
        updateTotal(this);
    })

    $('.delete-btn').click(function (e) {
        e.preventDefault(); // Prevent the default link behavior

        var cartId = $(this).data('cart-id');

        alertify.confirm("Delete Cart","Are you sure you want to delete this item from the cart?",
            function () {
                $.ajax({
                    type: "GET",
                    url: "delete-cart.php",
                    data: {
                        id: cartId
                    },
                    success: function (response) {
                        // Parse the JSON response
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            // Remove the row from the table
                            $('tr[data-cart-id="' + cartId + '"]').remove();
                            // Update the grand total
                            updateGrandTotal();
                            // Store the success message in local storage
                            localStorage.setItem('deleteMessage', 'Item deleted successfully');
                            location.reload(); // Reload the page after successful deletion
                        } else {
                            alertify.error('Failed to delete item');
                        }
                    },
                    error: function () {
                        alertify.error('An error occurred');
                    }
                });
            },
            function () {
                alertify.error('Delete canceled');
            });
    });

    $('.minus-btn').click(function () {
        var cartId = $(this).data('cart-id');
        var quantityInput = $(this).siblings('.quantity');
        var currentQuantity = parseInt(quantityInput.val());
        if (currentQuantity > 1) {
            quantityInput.val(currentQuantity - 1);
            updateTotal(quantityInput);
            updateQuantity(cartId, currentQuantity - 1); // Send an AJAX request to update the quantity
        }
    });

    $('.quantity').on('input', function () {
        updateTotal(this);
        updateQuantity($(this).siblings('.plus-btn').data('cart-id'), $(this).val()); 
    });
    function updateTotal(input) {
    var quantity = parseInt($(input).val());
    var unitPrice = parseFloat($(input).data('product-price'));
    var totalCell = $(input).closest('tr').find('.product-total');
    var newTotal = unitPrice * quantity;

    if (!isNaN(newTotal)) {
        // Format the newTotal to include commas for thousands and display currency symbol
        var formattedTotal = newTotal.toLocaleString('en-PH', {
            style: 'currency',
            currency: 'PHP'
        });

        totalCell.text(formattedTotal);
        updateGrandTotal();
    }
}

function updateGrandTotal() {
    var grandTotal = 0;
    $('.product-total').each(function () {
        var productTotal = parseFloat($(this).text().replace(/[^\d.-]/g, ''));
        if (!isNaN(productTotal)) {
            grandTotal += productTotal;
        }
    });

    // Format the grandTotal to include commas for thousands and display currency symbol
    var formattedGrandTotal = grandTotal.toLocaleString('en-PH', {
        style: 'currency',
        currency: 'PHP'
    });

    $('.total-price').text(formattedGrandTotal);
}

    // Initial update of grand total
    updateGrandTotal();

    function updateQuantity(cartId, newQuantity) {
        $.ajax({
            type: "POST",
            url: "update-cart-quantity.php",
            data: {
                cartId: cartId,
                newQuantity: newQuantity
            },
            success: function (response) {
                if (response.success) {
                    // Quantity updated successfully
                    // You can update the displayed total and grand total here if needed
                } else {
                    console.error(response.message);
                }
            },
            error: function () {
                console.error("AJAX request failed");
            }
        });
    }
});

var deleteMessage = localStorage.getItem('deleteMessage');
    if (deleteMessage) {
        alertify.success(deleteMessage);
        // Clear the stored message after displaying it
        localStorage.removeItem('deleteMessage');
    }


</script>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include('partials-front/footer.php'); ?>
