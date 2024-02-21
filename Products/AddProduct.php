<?php
// Establish database connection
include "../db.php";
// Sample JSON data received from the frontend

// Parse JSON data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate JSON data
if ($data === null) {
    // JSON data is invalid, return an error response
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON data']);
    exit;
}

// Extract data from JSON
$name = $data['name'] ?? '';
$description = $data['description'] ?? '';
$price = $data['price'] ?? '';
$category_id = $data['category_id'] ?? '';

// Validate extracted data (add more validation as needed)
if (empty($name) || empty($price) || empty($category_id)) {
    // Required fields are missing, return an error response
    http_response_code(400);
    echo json_encode(['error' => 'Name, price, and category ID are required']);
    exit;
}

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare INSERT query with placeholders
$sql = "INSERT INTO products (name, description, price, category_id, created) 
        VALUES (?, ?, ?, ?, NOW())";

// Prepare statement
$stmt = mysqli_prepare($conn, $sql);
if ($stmt === false) {
    die("Error: " . mysqli_error($conn));
}

// Bind parameters
mysqli_stmt_bind_param($stmt, "ssdi", $name, $description, $price, $category_id);

// Execute statement
if (mysqli_stmt_execute($stmt)) {
    echo "New record created successfully";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
