<?php
include 'dbLink.php';

$id = $_GET['id'];


$sql = "SELECT * FROM music WHERE music_id = $id";
$result = $conn->query($sql);
$item = $result->fetch_assoc();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $filename = $_POST['file_name'];
    $update_sql = "UPDATE music SET music_title='$title', music_file_name='$filename' WHERE music_id=$id";
    
    if ($conn->query($update_sql)) {
        header("Location: cms.php?category=music&success=1");
        exit();
    } else {
        $error = "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Music - Jake's Coffee Shop</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Edit Music Track</h1>
    </header>

    <div class="form-container">
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="title">Song Title:</label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($item['music_title']) ?>" required>        
            </div>
            
            <div class="form-group">
                <label for="file_name">Music File Name:</label>
                <input type="text" name="file_name" id="file_name" value="<?= htmlspecialchars($item['music_file_name']) ?>" required>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="cms.php?category=music" class="btn btn-secondary" style="text-align: center; text-decoration: none; line-height: 1.5;">Cancel</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>