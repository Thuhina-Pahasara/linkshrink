<?php
include 'db.php'; // Connect to the database

if (isset($_GET['code'])) {
    $short_code = $_GET['code'];

    // Check if the short code exists in the database
    $query = "SELECT original_url, clicks FROM urls WHERE short_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $short_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $original_url = $row['original_url'];
        $clicks = $row['clicks'] + 1;

        // Update click count
        $update_query = "UPDATE urls SET clicks = ? WHERE short_code = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("is", $clicks, $short_code);
        $stmt->execute();

        // Redirect to the original URL
        header("Location: $original_url");
        exit();
    } else {
        echo "Invalid Short URL!";
    }
} else {
    echo "No Short URL Provided!";
}
?>
