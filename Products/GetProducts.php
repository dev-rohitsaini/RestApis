<?php
include "../db.php";


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare SELECT query
$sql = "SELECT * FROM products";

// Execute query
$result = mysqli_query($conn, $sql);

// Check if there are rows returned
if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "ID: " . $row["id"] . " - Name: " . $row["name"] . " - Description: " . $row["description"] . "<br>";
    }
} else {
    echo "0 results";
}

// Close connection
mysqli_close($conn);
?>
