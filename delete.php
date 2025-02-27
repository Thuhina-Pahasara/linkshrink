<?php
include 'db.php'; // Connect to the database

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure ID is an integer

    // Delete the URL from the database
    $query = "DELETE FROM urls WHERE id = $id";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('URL deleted successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
