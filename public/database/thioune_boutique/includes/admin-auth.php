<?php
require_once '../includes/config.php';

// Vérification de connexion ET du statut admin
if(!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

// Nouveau : Vérification du statut admin
$stmt = $db->prepare("SELECT is_admin FROM customers WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if(!$user || !$user['is_admin']) {
    header("Location: ../index.php");
    exit();
}



if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Fonctions pour l'admin
function getTotalSales() {
    global $db;
    $stmt = $db->query("SELECT SUM(total) as total FROM orders");
    $result = $stmt->fetch();
    return $result['total'] ?? 0;
}

function getOrderCount() {
    global $db;
    $stmt = $db->query("SELECT COUNT(id) as count FROM orders");
    $result = $stmt->fetch();
    return $result['count'] ?? 0;
}

function getProductCount() {
    global $db;
    $stmt = $db->query("SELECT COUNT(id) as count FROM products");
    $result = $stmt->fetch();
    return $result['count'] ?? 0;
}

function getCustomerCount() {
    global $db;
    $stmt = $db->query("SELECT COUNT(id) as count FROM customers");
    $result = $stmt->fetch();
    return $result['count'] ?? 0;
}

function getRecentOrders($limit = 5) {
    global $db;
    $stmt = $db->query("SELECT o.*, CONCAT(c.first_name, ' ', c.last_name) as customer_name 
                       FROM orders o
                       JOIN customers c ON o.customer_id = c.id
                       ORDER BY o.created_at DESC
                       LIMIT $limit");
    return $stmt->fetchAll();
}

function getStatusLabel($status) {
    $labels = [
        'pending' => 'En attente',
        'processing' => 'En traitement',
        'shipped' => 'Expédiée',
        'delivered' => 'Livrée'
    ];
    return $labels[$status] ?? $status;
}
?>