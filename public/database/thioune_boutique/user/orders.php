<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if(!isLoggedIn()) {
    redirect(SITE_URL.'/user/login.php');
}

// Récupérer les commandes du client
$stmt = $db->prepare("SELECT o.*, 
                     COUNT(oi.id) as items_count, 
                     SUM(oi.quantity) as total_quantity 
                     FROM orders o
                     JOIN order_items oi ON o.id = oi.order_id
                     WHERE o.customer_id = ?
                     GROUP BY o.id
                     ORDER BY o.created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll();

$pageTitle = "Mes commandes";
require_once '../includes/header.php';
?>

<div class="account-section">
    <div class="account-sidebar">
        <div class="user-info">
            <div class="avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <h3><?= htmlspecialchars($_SESSION['user_name']) ?></h3>
            <p><?= htmlspecialchars($_SESSION['user_email']) ?></p>
        </div>
        
        <ul class="account-menu">
            <li><a href="<?= SITE_URL ?>/user/account.php">Mes informations</a></li>
            <li class="active"><a href="<?= SITE_URL ?>/user/orders.php">Mes commandes</a></li>
        </ul>
    </div>
    
    <div class="account-content">
        <h2>Mes commandes</h2>
        
        <?php if(empty($orders)): ?>
            <div class="empty-orders">
                <p>Vous n'avez pas encore passé de commande.</p>
                <a href="<?= SITE_URL ?>/products/" class="btn">Découvrir nos produits</a>
            </div>
        <?php else: ?>
            <div class="orders-list">
                <?php foreach($orders as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-info">
                                <span class="order-number">Commande #<?= $order['id'] ?></span>
                                <span class="order-date"><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></span>
                            </div>
                            <div class="order-status <?= $order['status'] ?>">
                                <?php 
                                $statusLabels = [
                                    'pending' => 'En attente',
                                    'processing' => 'En traitement',
                                    'shipped' => 'Expédiée',
                                    'delivered' => 'Livrée'
                                ];
                                echo $statusLabels[$order['status']] ?? $order['status']; 
                                ?>
                            </div>
                        </div>
                        
                        <div class="order-details">
                            <div class="order-items-count">
                                <i class="fas fa-box-open"></i>
                                <?= $order['items_count'] ?> article(s) - <?= $order['total_quantity'] ?> pièce(s)
                            </div>
                            <div class="order-total">
                                Total: <?= number_format($order['total'], 0, ',', ' ') ?> <?= CURRENCY ?>
                            </div>
                            <a href="<?= SITE_URL ?>/user/order.php?id=<?= $order['id'] ?>" class="btn btn-small">
                                Voir détails
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>