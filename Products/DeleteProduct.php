<?php
include "../db.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if product ID is provided in the request
if (isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $productId = mysqli_real_escape_string($conn, $_GET['id']);
}
// Prepare DELETE query
$sql = "DELETE FROM products WHERE id = $productId";

// Execute query
if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
