<?php
include 'database.php';

$id = $_GET['id'];
$success = null;
$listing = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("UPDATE listing SET title = ?, description = ?, price = ?, location = ? WHERE id = ?");
    $stmt->bind_param("ssdsi", $title, $description, $price, $location, $id);
    $success = $stmt->execute();

    $stmt->close();
}

$stmt = $conn->prepare("SELECT * FROM listing WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$listing = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Listing</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="d-flex align-items-center mt-5 mb-3">
            <a href="index.php" class="btn btn-secondary mr-3">Back to Listings</a>
            <h1 class="mb-0">Edit Listing</h1>
        </div>

        <?php if (!is_null($success)) {
            if ($success) { ?>
                <div class="alert alert-success" role="alert">
                    Listing updated successfully.
                </div>
            <?php } else { ?>
                <div class="alert alert-danger" role="alert">
                    Error updating listing.
                </div>
            <?php }
        } ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($listing['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($listing['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($listing['price']); ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($listing['location']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Listing</button>
        </form>
    </div>
</body>
</html>
