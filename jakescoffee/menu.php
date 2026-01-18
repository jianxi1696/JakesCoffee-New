<?php
include 'dbLink.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jake's Coffee Shop</title>
    <link rel="stylesheet" href="table.css">
    <script src="script.js" defer></script>
</head>
<body>

<div class="box-container">

    <div id="header">
        <h1>Jake's Coffee Shop</h1>
        <div class="hamburger" id="hamburger-menu">☰</div>
    </div>

    <div id="container">

        <div id="nav">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="menu.php" class="active">Menu</a></li>
                <li><a href="music.php">Music</a></li>
                <li><a href="#">Jobs</a></li>
            </ul>
        </div>

        <div id="main-content">
            <div class="products-wrapper">

                <table id="products-table">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                    $sql = "SELECT product_name, product_price, image_file_name
                            FROM product
                            WHERE archived = 0
                            ORDER BY product_name ASC";

                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $imgFile = trim($row['image_file_name']); // IMPORTANT FIX
                            $name  = htmlspecialchars($row['product_name']);
                            $price = number_format((float)$row['product_price'], 2);

                            echo "<tr>";
                            echo "<td>
                                    <img src='/coffeeshop/images/{$imgFile}'
                                         alt='{$name}'
                                         style='width:100px;height:100px;object-fit:cover;'>
                                  </td>";
                            echo "<td>{$name}</td>";
                            echo "<td>₱ {$price}</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No products found.</td></tr>";
                    }
                    ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>

    <div id="footer">
        <p>
            Copyright &copy; 2025 Jake's Coffee Shop<br>
            <a href="mailto:jake@jcoffee.com">jake@jcoffee.com</a>
        </p>
    </div>

</div>

</body>
</html>
