<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include 'dbLink.php';

$category = isset($_GET['category']) ? $_GET['category'] : 'product';

if (isset($_POST['save'])) {
    if ($category == 'product') {
        $name = $_POST['product_name'];
        $price = $_POST['product_price'];
        $image = $_POST['image_file_name'];
        $sql = "INSERT INTO product (product_name, product_price, image_file_name, archived)
                VALUES ('$name', '$price', '$image', 0)";
    } elseif ($category == 'music') {
        $music_title = $_POST['music_title'];
        $music_file_name = $_POST['music_file_name'];
        $sql = "INSERT INTO music (music_title, music_file_name, archived)
                VALUES ('$music_title', '$music_file_name', 0)";
    }

    if ($conn->query($sql)) {
        header("Location: cms.php?category=$category");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jake's Coffee Shop - Add New Item</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div id="bigBox">
    <header>
        <h1>Content Management System</h1>
        <p>Add Record</p>
    </header>

    <button class="menu-toggle" onclick="toggleMenu()">☰ Menu</button>

    <div class="content-area">
        <?php $current_category = $category; ?>
        <nav class="left-column" id="sideMenu">
            <div class="section-title">MANAGE</div>
            <a href="cms.php?category=product" class="<?= $current_category == 'product' ? 'active' : '' ?>">Products</a>
            <a href="cms.php?category=music" class="<?= $current_category == 'music' ? 'active' : '' ?>">Music Playlist</a>
            
            <div class="section-title">ACTIONS</div>
            <a href="addPanel.php?category=<?= $current_category ?>" class="active">Add New Record</a>
            <a href="archived.php?category=<?= $current_category ?>">View Archived Records</a>
            
            <div class="section-title">SITE</div>
            <a href="index.html" target="_blank">View Website</a>
            <a href="logout.php">Logout</a>
        </nav>

        <main class="right-column">
            
            <div class="form-header">
                <h2><?= $category == 'product' ? 'Add New Menu Item' : 'Add New Song' ?></h2>
                <a href="cms.php?category=<?= $category ?>" style="color: #4a2c2a; text-decoration: none;">← Back to List</a>
            </div>

            <div class="form-container">
                <form method="POST">
                    
                    <?php if ($category == 'product'): ?>

                        <div class="form-group">
                            <label for="product_name">Product Name *</label>
                            <input type="text" name="product_name" id="product_name" placeholder="e.g., Caramel Latte" required>    
                        </div>

                        <div class="form-group">
                            <label for="product_price">Product Price</label>
                            <input type="text" name="product_price" id="product_price" placeholder="e.g., 150.00" required> 
                        </div>

                        <div class="form-group">
                            <label for="image_file_name">Image File Name *</label>
                            <input type="text" name="image_file_name" id="image_file_name" placeholder="e.g., caramel_latte.jpg" required>
                            <small>Ensure the image is uploaded to the 'images' folder.</small>
                        </div>

                    <?php elseif ($category == 'music'): ?>
                        <div class="form-group">
                            <label for="music_title">Music Title *</label>
                            <input type="text" name="music_title" id="music_title" placeholder="e.g., Smooth Jazz Vibes" required>
                        </div>
                        <div class="form-group">
                            <label for="music_file_name">Music File Name *</label>
                            <input type="text" name="music_file_name" id="music_file_name" placeholder="e.g., smooth_jazz_vibes.mp3" required>
                            <small>Ensure the music file is uploaded to the 'music' folder.</small>
                        </div>

                    <?php endif; ?>

                    <div class="form-actions">
                        <button type="submit" name="save" class="btn btn-success"> Save Item</button>
                        <a href="cms.php?category=<?= $category ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>

        </main>

    </div>

    <footer>
        <p>Copyright © 2011 Jake's Coffee House - Admin Panel</p>
        <a href="mailto:jake@jcoffee.com">jake@jcoffee.com</a>
    </footer>
</div>

<script>
function toggleMenu() {
    const menu = document.getElementById('sideMenu');
    menu.classList.toggle('active');
}
</script>

</body>
</html>