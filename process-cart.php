<?php
include('./config/constants.php');

if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn']) {
    if (isset($_POST['add_to_cart'])) {
        $client_id = $_SESSION['client_id']; // Get the client ID from the session
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $selected_color = $_POST['selected_color'];
        $selected_size = $_POST['selected_size'];

        // Check if the product is in stock
        $stock_query = "SELECT sl.quantity
        FROM stock_list sl
        INNER JOIN product_colors_sizes pcs ON sl.product_colors_sizes_id = pcs.id
        WHERE sl.product_id = '$product_id'
        AND pcs.color = '$selected_color'
        AND pcs.size = '$selected_size'";


        $stock_result = mysqli_query($conn, $stock_query);

        if (!$stock_result) {
            die("Query failed: " . mysqli_error($conn)); // Print MySQL error message
        }

        if (mysqli_num_rows($stock_result) > 0) {
            $stock_row = mysqli_fetch_assoc($stock_result);
            $stock_quantity = $stock_row['quantity'];

            // Check if the requested quantity exceeds the available stock
            if ($quantity <= $stock_quantity) {
                // Product is in stock, proceed to add it to the cart
                $check_existing_query = "SELECT * FROM cart_list WHERE client_id = '$client_id' AND product_id = '$product_id' AND color = '$selected_color' AND size = '$selected_size'";
                $existing_result = mysqli_query($conn, $check_existing_query);

                if (!$existing_result) {
                    die("Query failed: " . mysqli_error($conn)); // Print MySQL error message
                }

                if (mysqli_num_rows($existing_result) > 0) {
                    // If the product already exists, update the quantity
                    $update_query = "UPDATE cart_list 
                    SET quantity = quantity + $quantity 
                    WHERE client_id = '$client_id' 
                    AND product_id = '$product_id' 
                    AND color = '$selected_color' 
                    AND size = '$selected_size'";
                    $result = mysqli_query($conn, $update_query);
                } else {
                    // If the product does not exist, insert it into the cart
                    $insert_query = "INSERT INTO cart_list (client_id, product_id, color, size, quantity) 
                    VALUES ('$client_id', '$product_id', '$selected_color', '$selected_size', '$quantity')";
                    $result = mysqli_query($conn, $insert_query);
                }

                if ($result) {
                    $_SESSION['add'] = "<div class='success'>Product added to cart successfully.</div>";
                } else {
                    $_SESSION['add'] = "<div class='error'>Failed to add product to cart.</div>";
                }

                header("Location: cart.php");
                exit(); // Redirect to the cart page
            } else {
                // Quantity exceeds available stock, show an error message
                $_SESSION['add'] = "<div class='error'>Quantity exceeds available stock.</div>";
                header("Location: product-details.php?id=$product_id"); // Redirect back to the product details page
                exit();
            }
        } else {
            // Product is not in stock, show an error message
            $_SESSION['add'] = "<div class='error'>Product is not in stock for the selected color and size.</div>";
            header("Location: product-details.php?id=$product_id"); // Redirect back to the product details page
            exit();
        }
    }
} else {
    if (isset($_POST['add_to_cart'])) {
        header("Location: cart.php");
        exit();
    }
}
?>
