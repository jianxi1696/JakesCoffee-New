<?php
include 'dbLink.php';

$id = $_GET['id'];

$sql = "SELECT * FROM product WHERE product_id = $id";
$result = $conn->query($sql);
$item = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $file_name = $_POST['image_file_name'];
    
    $update_sql = "UPDATE product SET 
                   product_name='$name',  
                   product_price='$product_price',
                   image_file_name='$file_name' 
                   WHERE product_id=$id";
    
    if ($conn->query($update_sql)) {
        header("Location: cms.php?category=product&success=1");
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
    <title>Edit Menu Item - Jake's Coffee Shop</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Edit Menu Item</h1>
    </header>

    <div class="form-container">
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <label for="product_name">Item Name:</label>
                <input type="text" name="product_name" id="product_name" value="<?= htmlspecialchars($item['product_name']) ?>" required>       
            </div>

            <div class="form-group">
                <label for="product_price">Item Price:</label>
                <input type="text" name="product_price" id="product_price" value="<?= htmlspecialchars($item['product_price']) ?>" required>    
            </div>
            
            <div class="form-group">
                <label for="image_file_name">Image File Name:</label>
                <input type="text" name="image_file_name" id="image_file_name" value="<?= htmlspecialchars($item['image_file_name']) ?>" required> 
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="cms.php?category=product" style="text-align: center; text-decoration: none; line-height: 1.5;">Cancel</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>