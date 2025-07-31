<?php
require_once '../includes/config.php';
require_once '../includes/admin-auth.php';

$pageTitle = "Tableau de bord";
require_once 'includes/admin-header.php';
?>

<div class="admin-dashboard">
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-value"><?= number_format(getTotalSales()) ?> <?= CURRENCY ?></div>
            <div class="stat-label">Chiffre d'affaires</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-value"><?= number_format(getOrderCount()) ?></div>
            <div class="stat-label">Commandes</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-value"><?= number_format(getProductCount()) ?></div>
            <div class="stat-label">Produits</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-value"><?= number_format(getCustomerCount()) ?></div>
            <div class="stat-label">Clients</div>
        </div>
    </div>
    
    <div class="recent-orders">
        <h2>Commandes récentes</h2>
        <table>
            <thead>
                <tr>
                    <th>N° Commande</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $orders = getRecentOrders();
                foreach($orders as $order):
                ?>
                <tr>
                    <td>#<?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                    <td><?= number_format($order['total'], 0, ',', ' ') ?> <?= CURRENCY ?></td>
                    <td>
                        <span class="status-badge <?= $order['status'] ?>">
                            <?= getStatusLabel($order['status']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="orders/view.php?id=<?= $order['id'] ?>" class="btn btn-small">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/admin-footer.php'; ?>