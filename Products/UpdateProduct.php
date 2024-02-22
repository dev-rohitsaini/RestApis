<?php
// Establish database connection
include "../db.php";

// Check if request method is PUT
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
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
    $id = $data['id'] ?? '';
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

    // Prepare UPDATE query with placeholders
    $sql = "UPDATE products 
            SET name = ?, description = ?, price = ?, category_id = ?
            WHERE id = ?";

    // If ID is not provided or does not exist, create a new record
    if (empty($id) || !is_numeric($id) || $id <= 0 || !recordExists($conn, $id)) {
        $sql = "INSERT INTO products (name, description, price, category_id, created) 
                VALUES (?, ?, ?, ?, NOW())";
    }

    // Prepare statement
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        die("Error: " . mysqli_error($conn));
    }

    // Bind parameters
    if (empty($id) || !is_numeric($id) || $id <= 0 || !recordExists($conn, $id)) {
        mysqli_stmt_bind_param($stmt, "ssdi", $name, $description, $price, $category_id);
    } else {
        mysqli_stmt_bind_param($stmt, "ssdii", $name, $description, $price, $category_id, $id);
    }

    // Execute statement
    if (mysqli_stmt_execute($stmt)) {
        if (empty($id) || !is_numeric($id) || $id <= 0 || !recordExists($conn, $id)) {
            echo "New record created successfully";
        } else {
            echo "Record updated successfully";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}

// Function to check if a record with the given ID exists
function recordExists($conn, $id) {
    $sql = "SELECT id FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $count = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
    return $count > 0;
}
?>
