<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['admin_logged_in']);
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function displayError($message) {
    return '<div class="error">'.$message.'</div>';
}

function displaySuccess($message) {
    return '<div class="success">'.$message.'</div>';
}

function getCategories() {
    global $db;
    $stmt = $db->query("SELECT * FROM categories ORDER BY name");
    return $stmt->fetchAll();
}

function getProductById($id) {
    global $db;
    $stmt = $db->prepare("SELECT p.*, c.name as category_name FROM products p 
                         JOIN categories c ON p.category_id = c.id 
                         WHERE p.id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}
?>