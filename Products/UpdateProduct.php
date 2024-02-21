<?php
// Establish database connection
include "../db.php";

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare UPDATE query
$sql = "UPDATE products SET name = 'New Product Name', description = 'New Product Description' WHERE id = 1";

// Execute query
if (mysqli_query($conn, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
