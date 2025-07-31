<?php require_once 'includes/config.php'; ?>
<?php require_once 'includes/header.php'; ?>

<div class="hero-section">
    <h1>Bienvenue chez ThiouneBoutique</h1>
    <p>Découvrez nos produits authentiques</p>
    <a href="products/" class="btn">Voir nos produits</a>
</div>

<section class="featured-products">
    <h2>Produits Phares</h2>
    <div class="products-grid">
        <?php
        $stmt = $db->query("SELECT * FROM products WHERE featured = 1 AND stock > 0 LIMIT 4");
        while ($product = $stmt->fetch()):
        ?>
        <div class="product-card">
            <img src="<?= SITE_URL ?>/assets/images/products/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
            <h3><?= $product['name'] ?></h3>
            <span class="price"><?= number_format($product['price'], 0, ',', ' ') ?> <?= CURRENCY ?></span>
            <a href="product.php?id=<?= $product['id'] ?>" class="btn">Voir détails</a>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>