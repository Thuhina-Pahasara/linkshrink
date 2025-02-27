<?php
include 'db.php'; // Connect to the database

// Fetch all shortened URLs
$query = "SELECT * FROM urls ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - URL Shortener</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container">
        <h1>Admin Panel - Manage URLs</h1>
        <table>
            <tr>
                <th>Short URL</th>
                <th>Original URL</th>
                <th>Clicks</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><a href="https://yourdomain.com/<?php echo $row['short_code']; ?>" target="_blank"><?php echo $row['short_code']; ?></a></td>
                    <td><?php echo $row['original_url']; ?></td>
                    <td><?php echo $row['clicks']; ?></td>
                    <td>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
