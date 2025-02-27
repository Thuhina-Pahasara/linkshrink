<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Update visit count (Already implemented)
$conn->query("UPDATE site_stats SET total_visits = total_visits + 1");

// Fetch total users
$user_query = "SELECT COUNT(*) as total_visits FROM site_stats"; 
$user_result = $conn->query($user_query);
$total_visits = ($user_result->num_rows > 0) ? $user_result->fetch_assoc()['total_visits'] : 0;

// Fetch total shorten button clicks (count of shortened URLs)
$shorten_query = "SELECT COUNT(*) as total_shortens FROM urls"; 
$shorten_result = $conn->query($shorten_query);
$total_shortens = ($shorten_result->num_rows > 0) ? $shorten_result->fetch_assoc()['total_shortens'] : 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="gothan.css">
</head>
<body>
<div class="container">
    <h1>URL Shortener</h1>

    <!-- Display Total Users and Shortens with New Styles -->
<!-- Page Visit Stats at Bottom Left -->
<div class="page-stats">
    <p>👀 Page Visits: <strong><?php echo $total_visits; ?></strong></p>
    <p>🔗 URLs Shortened: <strong><?php echo $total_shortens; ?></strong></p>
</div>


    <form action="shorten.php" method="POST">
        <input type="text" name="url" placeholder="Enter your URL" required>
        <button type="submit">Shorten</button>
    </form>
</div>

        <?php
        if (isset($_GET['short'])) {
            $short_code = $_GET['short'];
            $shortened_url = "https://yourdomain.com/" . htmlspecialchars($short_code);

            $query = "SELECT clicks FROM urls WHERE short_code = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $short_code);
            $stmt->execute();
            $result = $stmt->get_result();

            $clicks = 0;
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $clicks = $row['clicks'];
            }

            echo "<div class='shortened-url'>
                    <p>Your Shortened URL: <a href='$shortened_url' target='_blank'>$shortened_url</a></p>
                    <p>Clicks: <strong>$clicks</strong></p>
                  </div>";
        }
        ?>
    </div>
</body>
</html>
