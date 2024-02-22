<?php
include "../db.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo $_SERVER['REQUEST_METHOD'] ;
// Check if request method is DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Retrieve data from the request body (assuming it's JSON)
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if product ID is provided in the request data
    if (isset($data['id'])) {
        // Sanitize the input to prevent SQL injection
        $productId = mysqli_real_escape_string($conn, $data['id']);

        // Prepare DELETE query
        $sql = "DELETE FROM products WHERE id = $productId";

        // Execute query
        if (mysqli_query($conn, $sql)) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        echo "Product ID not provided";
    }
} else {
    echo "Invalid request method";
}

// Close connection
mysqli_close($conn);
?>
