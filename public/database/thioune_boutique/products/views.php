<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if(!isset($_GET['id'])) {
    redirect('./products/');
}

$product = getProductById($_GET['id']);
if(!$product) {
    redirect('./products/');
}

$pageTitle = $product['name'];
require_once '../includes/header.php';
?>

<section class="product-detail">
    <div class="product-images">
        <img src="../assets/images/products/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
    </div>
    
    <div class="product-info">
        <h1><?= $product['name'] ?></h1>
        <span class="category"><?= $product['category_name'] ?></span>
        <span class="price"><?= number_format($product['price'], 0, ',', ' ') ?> <?= CURRENCY ?></span>
        
        <div class="stock-status">
            <?php if($product['stock'] > 0): ?>
                <span class="in-stock">En stock (<?= $product['stock'] ?> disponibles)</span>
            <?php else: ?>
                <span class="out-of-stock">Rupture de stock</span>
            <?php endif; ?>
        </div>
        
        <div class="product-description">
            <h3>Description</h3>
            <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        </div>
        
        <?php if($product['stock'] > 0): ?>
        <form method="post" action="../cart.php?action=add" class="add-to-cart">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <div class="quantity">
                <label for="quantity">Quantité:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $product['stock'] ?>">
            </div>
            <button type="submit" class="btn">Ajouter au panier</button>
        </form>
        <?php endif; ?>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>