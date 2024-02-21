<?php
include "../db.php";
// Establish database connection


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if product ID is provided in the request
if (isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $productId = mysqli_real_escape_string($conn, $_GET['id']);

    // Prepare SELECT query
    $sql = "SELECT * FROM products WHERE id = $productId";

    // Execute query
    $result = mysqli_query($conn, $sql);

    // Check if there is exactly one row returned
    if (mysqli_num_rows($result) == 1) {
        // Fetch the product details
        $product = mysqli_fetch_assoc($result);

        // Return product details as JSON response
        header('Content-Type: application/json');
        echo json_encode($product);
    } else {
        // Product not found, return 404 response
        http_response_code(404);
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    // Product ID not provided, return 400 response
    http_response_code(400);
    echo json_encode(['error' => 'Product ID is required']);
}

// Close connection
mysqli_close($conn);
?>
