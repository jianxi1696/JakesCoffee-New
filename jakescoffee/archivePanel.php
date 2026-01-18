<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include 'dbLink.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $category = $_GET['category'];
    
    if ($category == 'music') {
        $sql = "UPDATE music SET archived=1 WHERE music_id='$id'";
        $redirect = "cms.php?category=music";
    } else {
        $sql = "UPDATE product SET archived=1 WHERE product_id='$id'";
        $redirect = "cms.php?category=product";
    }
    
    if ($conn->query($sql)) {
        header("Location: $redirect");
        exit;
    } else {
        echo "Error archiving item: " . $conn->error;
    }
} else {
    echo "Error: Missing required parameters (id and category)";
}
?>