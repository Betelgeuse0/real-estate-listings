<?php
include 'database.php';

$success = NULL;
$error = NULL;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $picture = "";

    // Handle file upload
    if (isset($_FILES["picture"]) and $_FILES["picture"]["error"] == UPLOAD_ERR_OK) {
        $upload_dir = "uploads/";
        $picture = basename($_FILES["picture"]["name"]);
        $target_file = $upload_dir . $picture;
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            $picture = $target_file;
        } else {
            $success = false;
        }
    }

    $stmt = $conn->prepare("INSERT INTO listing (title, description, price, location, picture) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $title, $description, $price, $location, $picture);

    $success = $stmt->execute();
    $error = $stmt->error;

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Listing</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <?php 
        if (!is_null($success)) {
            if ($success) { ?>
                <div class="alert alert-success mt-3" role="alert">
                    Added listing successfully
                </div>
            <?php } else { ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php "Error: " . $error ?>
                </div>
            <?php }
        }
        ?>
        
        <div class="d-flex align-items-center mt-5 mb-3">
            <a href="index.php" class="btn btn-secondary mr-3" style="font-size: 150%"><b><</b></a>
            <h1 class="mb-0">Add New Listing</h1>
        </div>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>
            <div class="form-group">
                <label for="picture">Picture</label>
                <input type="file" accept="image/*,.pdf" class="form-control-file" id="picture" name="picture">
            </div>
            <button type="submit" class="btn btn-primary">Add Listing</button>
        </form>
    </div>
</body>
</html>