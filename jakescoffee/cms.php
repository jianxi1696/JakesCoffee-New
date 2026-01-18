<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include 'dbLink.php';


$current_category = isset($_GET['category']) ? $_GET['category'] : 'product';


if ($current_category == 'product') {
    $sql = "SELECT * FROM product WHERE archived=0 ORDER BY product_id";
} elseif ($current_category == 'music') {
    $sql = "SELECT * FROM music WHERE archived=0 ORDER BY music_id";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jake's Coffee Shop - Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div id="bigBox">
    <header>
        <h1>Content Management System</h1>
        <p><?php echo $current_category == 'product' ? 'Products' : 'Music Playlist Management'; ?></p>
    </header>

    <button class="menu-toggle" onclick="toggleMenu()">☰ Menu</button>

    <div class="content-area">
        <nav class="left-column" id="sideMenu">
            <div class="section-title">MANAGE</div>
            <a href="cms.php?category=product" class="<?= $current_category == 'product' ? 'active' : '' ?>">Products</a>
            <a href="cms.php?category=music" class="<?= $current_category == 'music' ? 'active' : '' ?>">Music Playlist</a>
            
            <div class="section-title">ACTIONS</div>
            <a href="addPanel.php?category=<?= $current_category ?>">Add New Record</a>
            <a href="archived.php?category=<?= $current_category ?>">View Archived Records</a>
            
            <div class="section-title">SITE</div>
            <a href="index.html">View Website</a>
            <a href="logout.php">Logout</a>
        </nav>

        <main class="right-column">
            
            <div class="admin-header">
                <h2><?= $current_category == 'product' ? 'Products' : 'Music Playlist Management' ?></h2>
                <a href="addPanel.php?category=<?= $current_category ?>" class="btn btn-success">+ Add New Item</a>
            </div>

            <?php if ($current_category == 'product'): ?>
                <table id="productTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image File Name</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['product_id'] ?></td>
                            <td><?= $row['product_name'] ?></td>
                            <td><?= $row['product_price'] ?></td>
                            <td><?= $row['image_file_name'] ?></td>
                            <td>
                                <div class="action-links">
                                    <a href="edit_menu.php?id=<?= $row['product_id'] ?>">🛠️ Edit Record</a>
                                    <a href="archivePanel.php?id=<?= $row['product_id'] ?>&category=product" onclick="return confirm('Archive this item?')" style="color: #c94545;"> Archive Record</a>
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
                            <th>Song Title</th>
                            <th>Music File Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    while($row = $result->fetch_assoc()): 
                    ?>
                        <tr>
                            <td><?= $row['music_id'] ?></td>
                            <td><?= $row['music_title'] ?></td>
                            <td><?= $row['music_file_name'] ?></td>
                            <td>
                                <div class="action-links">
                                    <a href="edit_music.php?id=<?= $row['music_id'] ?>"> Edit</a>
                                    <a href="archivePanel.php?id=<?= $row['music_id'] ?>&category=music" onclick="return confirm('Archive this song?')" style="color: #c94545;"> Archive</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        </main>

    </div>

    <footer>
        <p>Copyright © 2011 Jake's Coffee House - Admin Panel</p>
        <a href="mailto:jake@jcoffee.com">jake@jcoffee.com</a>
    </footer>
</div>

<script>

function filterTable(category) {
    const rows = document.querySelectorAll('#productTable tbody tr');
    const buttons = document.querySelectorAll('.category-filters button');
    
    
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    
    rows.forEach(row => {
        if (category === 'all') {
            row.style.display = '';
        } else {
            row.style.display = row.dataset.category === category ? '' : 'none';
        }
    });
}


function toggleMenu() {
    const menu = document.getElementById('sideMenu');
    menu.classList.toggle('active');
}
</script>

</body>
</html>