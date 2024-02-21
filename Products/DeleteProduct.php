<?php
include "../db.php";

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare DELETE query
$sql = "DELETE FROM products WHERE id = 1";

// Execute query
if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
