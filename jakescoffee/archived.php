<?php
session_start();


if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include 'dbLink.php';

$current_category = isset($_GET['category']) ? $_GET['category'] : 'product';

if ($current_category == 'product') {
    $sql = "SELECT * FROM product WHERE archived=1 ORDER BY product_id";
} elseif ($current_category == 'music') {
    $sql = "SELECT * FROM music WHERE archived=1 ORDER BY music_id";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jake's Coffee Shop - Archived Items</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div id="bigBox">
    <header>
        <h1>Content Management System</h1>
        <p>Archives</p>
    </header>

    <button class="menu-toggle" onclick="toggleMenu()">☰ Menu</button>

    <div class="content-area">
        
        <nav class="left-column" id="sideMenu">
            <div class="section-title">MANAGE</div>
            <a href="cms.php?category=product" class="<?= $current_category == 'product' ? 'active' : '' ?>">Products</a>
            <a href="cms.php?category=music" class="<?= $current_category == 'music' ? 'active' : '' ?>">Music Playlist</a>
            
            <div class="section-title">ACTIONS</div>
            <a href="addPanel.php?category=<?= $current_category ?>">Add New Record</a>
            <a href="archived.php?category=<?= $current_category ?>" class="active">View Archived Records</a>
            
            <div class="section-title">SITE</div>
            <a href="index.html" target="_blank">View Website</a>
            <a href="logout.php">Logout</a>
        </nav>

        <main class="right-column">
            
            <div class="admin-header">
                <h2>Archived <?= $current_category == 'product' ? 'Products' : 'Songs' ?></h2>
                <a href="cms.php?category=<?= $current_category ?>" class="btn">← Back to Active Items</a>
            </div>

            <div class="alert">
                <strong>Note:</strong> Restoring an item will make it active again.
            </div>

            <?php if ($result->num_rows == 0): ?>
                <div style="text-align: center; padding: 40px; background: white; border-radius: 8px;">
                    <p style="font-size: 1.2em; color: #888;">No archived items found.</p>
                </div>
            <?php else: ?>

            <?php if ($current_category == 'product'): ?>
             
                 <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Image File Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    while($row = $result->fetch_assoc()): 
                    ?>
                        <tr>
                            <td><?= $row['product_id'] ?></td>
                            <td><?= $row['product_name'] ?></td>
                            <td><?= $row['product_price'] ?></td>
                            <td><?= $row['image_file_name'] ?></td>
                            <td>
                                <div class="action-links">
                                    <a href="restorePanel.php?id=<?= $row['product_id'] ?>&category=product" onclick="return confirm('Restore this item to active?')" style="color: #009900ff;">↩ Restore</a>
    
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                

            <?php elseif ($current_category == 'music'): ?>
                
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Music Title</th>
                            <th>File Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['music_id'] ?></td>
                            <td><?= $row['music_title'] ?></td>
                            <td><?= $row['music_file_name'] ?></td>
                            <td>
                                <div class="action-links">
                                    <a href="restorePanel.php?id=<?= $row['music_id'] ?>&category=music" onclick="return confirm('Restore this song to active?')" style="color: #009900ff;">↩ Restore</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php endif; ?>

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