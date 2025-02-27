<?php
include 'db.php'; // Connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $original_url = trim($_POST['url']);

    // Check if URL is valid
    if (!filter_var($original_url, FILTER_VALIDATE_URL)) {
        die("<div class='error-message'>❌ Invalid URL format!</div>");
    }

    // Check for honeypot field (Bot Protection)
    if (!empty($_POST['honeypot'])) {
        die("<div class='error-message'>⚠️ Bot detected!</div>");
    }

    // Generate a shorter short code (4 random characters)
    do {
        $short_code = substr(md5(uniqid(rand(), true)), 0, 4);
        $check_query = "SELECT * FROM urls WHERE short_code = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("s", $short_code);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0); // Regenerate if the short code exists

    // Insert into database using prepared statements
    $insert_query = "INSERT INTO urls (short_code, original_url, clicks) VALUES (?, ?, 0)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ss", $short_code, $original_url);

    if ($stmt->execute()) {
        $shortened_url = "lk/$short_code"; // Change this to match your domain
        $conn->query("UPDATE site_stats SET shorten_clicks = shorten_clicks + 1");

        echo "<div class='container'>
                <div class='success-message'>
                <h2  style='color: cyan;'>🎉 Link Shortened Successfully!</h2>
                <div class='link-box'>
                    <input type='text' id='short-url' value='$shortened_url' readonly>
                    <button onclick='copyToClipboard()' class='copy-btn'>Copy</button>
                </div>
              </div>";
    } else {
        echo "<div class='error-message'>❌ Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="shorten.css">
    <script>
    function copyToClipboard() {
        var copyText = document.getElementById("short-url");
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");
        alert("Copied: " + copyText.value);
    }
    </script>
</head>
<body>

</body>
</html>
