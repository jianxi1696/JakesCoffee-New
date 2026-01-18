<?php
include 'dbLink.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Jake's Coffee Shop</title>
    <link rel="stylesheet" href="table.css" />
    <script src="script.js" defer></script>
</head>
<body>
    <div class="box-container">
        <div id="header">
            <h1>Jake's Cofee Shop</h1>
            <div class="hamburger" id="hamburger-menu">☰</div>

        </div>
        <div id="container">
            <div id="nav">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="music.php">Music</a></li>
                    <li><a href="#">Jobs</a></li>
                </ul>
            </div>

            <div id="main-content">
                <div class="music-wrapper">
                    <table id="music-table">
                        <thead>
                            <tr>
                                <th>Music Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql = "SELECT * FROM music WHERE archived=0 ORDER BY music_id";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $name = htmlspecialchars($row['music_title']);
                                    echo "<tr>";
                                    echo "<td><strong>{$name}</strong></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No music found.</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="footer">
            <p>Copyright &copy; 2025 Jake's Coffee Shop<br>
            <a href="#">jake@jcoffee.com</a>
            </p>
        </div>
    </div>
</body>
</html>
