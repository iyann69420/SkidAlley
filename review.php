<?php
// Function to validate and sanitize input
function validateInput($data) {
    return htmlspecialchars(trim($data));
}

include('partials-front/menu.php');

if (!isset($_SESSION['userLoggedIn'])) {
    header("Location: login.php");
    exit();
}
$userId = $_SESSION['client_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Review</title>
    <!-- Include your CSS styles or link to an external stylesheet here -->
    <style>
  
        .review-container {
            margin-top: 30px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 700px; /* Adjust the width as needed */
            max-width: 100%; /* Ensures the container doesn't exceed the width of its parent */
            margin-left: auto; /* Centers the container horizontally */
            margin-right: auto;
            
      
        }
        .review-container h1, .input-review-container h1 {
            text-align: center; /* Center the text horizontally */
            margin-top: 20px; /* Add some top margin for spacing */
            font-size: 39px;
            
        }
        .product-container{

            width: 500px;
        }
        .input-review-container{

            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 1000px; /* Adjust the width as needed */
            max-width: 100%; /* Ensures the container doesn't exceed the width of its parent */
            margin-left: auto; /* Centers the container horizontally */
            margin-right: auto;
        }
        
        textarea[name="review"] {
        width: 100%;
        height: 100px;
        padding: 10px;
        margin-top: 10px;
        box-sizing: border-box;
        resize: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        line-height: 1.5;
    }

        textarea[name="review"]:focus {
            border-color: #007BFF; /* Highlight border color on focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add a subtle box shadow on focus */
        }
       

        label {
            margin-top: 10px;
        }

        input[type="file"] {
            margin-top: 5px;
        }

        .stars {
            display: flex;
            margin-top: 10px;
        }

        .star {
            cursor: pointer;
            font-size: 24px;
            margin: 0 5px;
        }

        .star:hover,
        .selected {
            color: gold;
        }

        textarea {
            margin-top: 10px;
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        input[type="submit"] {
    display: block; /* Make the submit button a block-level element */
    margin: 15px auto 0; /* Center the button horizontally using margin */
    padding: 10px;
    font-size: 14px;
    background-color: black;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 200px; /* Set the desired width */
}
        input[type="submit"]:hover {
            background-color: orange;
        }

        .uploaded-image {
            margin-top: 15px;
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<?php
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = validateInput($_GET['order_id']);
    $query = "SELECT op.*, ol.ref_code, ol.total_amount, ol.delivery_address, ol.payment_method, ol.status
                  FROM order_products op
                  JOIN order_list ol ON op.order_id = ol.id
                  WHERE op.order_id = '$order_id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        // Initialize an array to store product details
        $products = array();

        // Fetch the data
        while ($row = mysqli_fetch_assoc($result)) {
            // Access the data using $row['column_name']
            $productId = $row['product_id'];
            $quantity = $row['quantity'];
            $color = $row['color'];
            $pricePerUnit = $row['price_per_unit'];

            // Fetch additional details from the product_list table
            $productQuery = "SELECT name, image_path FROM product_list WHERE id = '$productId'";
            $productResult = mysqli_query($conn, $productQuery);
            $productData = mysqli_fetch_assoc($productResult);

            // Store the product details in the array
            $products[] = array(
                'name' => $productData['name'],
                'image_path' => $productData['image_path'],
                'quantity' => $quantity,
                'color' => $color,
                'pricePerUnit' => $pricePerUnit
            );

            // Free the product result set
            mysqli_free_result($productResult);
        }

        // Display the container outside the loop
        ?>
    
        <div class="review-container">
        <h1>Product</h1>
            <?php
            // Loop through the stored product details and display them
            $count = 0; // Initialize a counter

            foreach ($products as $product) {
                // Start a new row container after every three products
                if ($count % 100 == 0 && $count > 0) {
                    echo '</div><div class="review-container">';
                   
                }
                ?>
                <div class="product-container">
                    <h1></h1>
                    <img id='product-image'
                         src='http://localhost/SkidAlley/images/bike/<?php echo $product['image_path']; ?>'
                         alt='<?php echo $product['name']; ?>'
                         style='width: 200px'>
                         <div class="product-info">
                        <p>Product Name: <?php echo $product['name']; ?></p>
                        <p>Quantity: <?php echo $product['quantity']; ?></p>
                        <p>Color: <?php echo $product['color']; ?></p>
                        <p>Price per Unit: ₱<?php echo number_format($product['pricePerUnit']); ?></p>
                        <!-- Add more details as needed -->
                    </div>
                </div>
                <?php
                $count++; // Increment the counter
            }
            ?>
        </div>
        <?php

        // Free result set
        mysqli_free_result($result);
    } else {
        // Handle query error
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "<p>Invalid order ID.</p>";
}

// Close the connection
mysqli_close($conn);
?>
<br>
<div class="input-review-container">
<h1>Rate Product</h1>
<br>

    <form action="process-review.php" method="post" enctype="multipart/form-data">
        <!-- Hidden input field to pass order_id to the processing script -->
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">

        <!-- Image Upload -->
        <label for="image">Upload Image:</label>
        <input type="file" name="image" accept="image/*" >
        <br>
        <img id="image-preview" alt="Image Preview" style="width: 200px; display: none;">
        <br>
        <!-- Star Rating -->
        <label for="stars">Star Rating:</label>
        <div class="stars">
            <?php
            // Generate 5 stars
            for ($i = 1; $i <= 5; $i++) {
                echo "<span class='star'>&#9733;</span>";
            }
            ?>
        </div>
        <input type="hidden" name="stars" id="stars" value="0" required>
        <br>

        <!-- Review Text -->
        <label for="review">Your Review:</label>
        <textarea name="review" rows="4" required></textarea>
        <br>

       

        <!-- Submit Button -->
        <input type="submit" value="Submit Review">
       
    </form>
</div>
<?php
// Check if the form is submitted and an image is uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    // Handle the uploaded image
    $uploadedImage = $_FILES['image'];
    $uploadPath = '../images/reviews/'; // Specify your upload directory
    $ext = pathinfo($uploadedImage['name'], PATHINFO_EXTENSION);
    $image_name = "Review-" . rand(0000, 9999) . "." . $ext;
    $dst = $uploadPath . $image_name;

    // Move the uploaded file to the upload directory
    $uploadSuccess = move_uploaded_file($uploadedImage['tmp_name'], $dst);

    
    if ($uploadSuccess) {
        echo "<img class='uploaded-image' src='{$uploadPath}{$image_name}' alt='Uploaded Image'>";
    } else {
        echo "<p>Failed to upload the image.</p>";
    }
}
?>

</body>
</html>

<?php include('partials-front/footer.php'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/default.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Handle star rating
        const stars = document.querySelectorAll(".star");

        stars.forEach((star, index) => {
            star.addEventListener("mouseover", function () {
                const selectedStars = index + 1;

                // Highlight selected stars
                stars.forEach((s, i) => {
                    s.classList.toggle("selected", i < selectedStars);
                });
            });

            // Reset stars on mouseout
            star.addEventListener("mouseout", function () {
                const selectedStars = parseInt(document.querySelector("#stars").value, 10);

                // Highlight selected stars
                stars.forEach((s, i) => {
                    s.classList.toggle("selected", i < selectedStars);
                });
            });

            // Click event
            star.addEventListener("click", function () {
                const selectedStars = index + 1;
                document.querySelector("#stars").value = selectedStars;
            });
        });
        const imageInput = document.querySelector('input[name="image"]');
    const imagePreview = document.getElementById('image-preview');

    imageInput.addEventListener('change', function () {
        const file = imageInput.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        } else {
            // Reset preview if no file selected
            imagePreview.src = '';
            imagePreview.style.display = 'none';
        }
    });


        // Handle form submission via AJAX
        const form = document.querySelector("form");

        form.addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(form);

            // Perform AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "process-review.php", true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Success
                    alertify.success(xhr.responseText);

                    // Check if the response contains "Review submitted successfully"
                    if (xhr.responseText.includes("Review submitted successfully")) {
                        // Redirect to orderstatus.php
                        <?php $_SESSION['reviewSubmitted'] = true; ?>
                        window.location.href = "orderstatus.php";
                    }
                } else {
                    // Error
                    alertify.error(xhr.responseText);
                }
            };

            xhr.onerror = function () {
                alertify.error("An error occurred during the AJAX request.");
            };

            xhr.send(formData);
        });
    });
</script>
