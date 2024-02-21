<?php
// Establish database connection
include "../db.php";

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare INSERT query
$sql = "INSERT INTO products (name, description, price, category_id, created) 
        VALUES ('Product Name', 'Product Description', 10.99, 1, NOW())";

// Execute query
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
