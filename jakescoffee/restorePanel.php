<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include 'dbLink.php';

if (isset($_GET['id']) && isset($_GET['category'])) {
    $id = $_GET['id'];
    $category = $_GET['category'];
    
    // Determine which table to update based on category
    if ($category == 'music') {
        $sql = "UPDATE music SET archived=0 WHERE music_id='$id'";
        $redirect = "archived.php?category=music";
    } else {
        $sql = "UPDATE product SET archived=0 WHERE product_id='$id'";
        $redirect = "archived.php?category=product";
    }
    
    if ($conn->query($sql)) {
        header("Location: $redirect");
        exit;
    } else {
        echo "Error restoring item: " . $conn->error;
    }
} else {
    echo "Error: Missing required parameters (id and category)";
}
?>