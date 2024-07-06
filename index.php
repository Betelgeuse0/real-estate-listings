<?php
include 'database.php';

$entry_deleted = null;
if (isset($_GET['delete'])) {
    $entry_deleted = $_GET['delete'] == 1;
}

$result = $conn->query("SELECT * FROM listing ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Listings</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container">
        <?php if ($entry_deleted): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Deleted listing successfully
            </div>
        <?php endif ?>

        <h1 class="mt-5">Real Estate Listings</h1>
        <a href="add_listing.php" class="btn btn-primary mb-3">Add New Listing</a>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Picture</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Date Listed</th>
                    <th>Edit / Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <img src="<?php echo htmlspecialchars($row['picture']); ?>" alt="Listing Picture" style="max-width: 100px;">
                    </td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($row['created_at']))); ?></td>
                    <td>
                        <a href="edit_listing.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="delete_listing.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this listing?');">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
