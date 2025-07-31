<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Actions sur le panier
if(isset($_GET['action'])) {
    switch($_GET['action']) {
        case 'add':
            if(isset($_POST['product_id'], $_POST['quantity'])) {
                $product_id = (int)$_POST['product_id'];
                $quantity = (int)$_POST['quantity'];
                
                // Vérifier que le produit existe et est en stock
                $product = getProductById($product_id);
                if($product && $quantity > 0 && $quantity <= $product['stock']) {
                    if(isset($_SESSION['cart'][$product_id])) {
                        $_SESSION['cart'][$product_id] += $quantity;
                    } else {
                        $_SESSION['cart'][$product_id] = $quantity;
                    }
                    
                    $_SESSION['message'] = 'Produit ajouté au panier';
                }
            }
            redirect(SITE_URL.'/cart.php');
            break;
            
        case 'update':
            if(isset($_POST['quantities'])) {
                foreach($_POST['quantities'] as $product_id => $quantity) {
                    $product_id = (int)$product_id;
                    $quantity = (int)$quantity;
                    
                    $product = getProductById($product_id);
                    if($product && $quantity >= 0) {
                        if($quantity == 0) {
                            unset($_SESSION['cart'][$product_id]);
                        } else {
                            $_SESSION['cart'][$product_id] = $quantity;
                        }
                    }
                }
                $_SESSION['message'] = 'Panier mis à jour';
            }
            redirect(SITE_URL.'/cart.php');
            break;
            
        case 'remove':
            if(isset($_GET['id'])) {
                $product_id = (int)$_GET['id'];
                if(isset($_SESSION['cart'][$product_id])) {
                    unset($_SESSION['cart'][$product_id]);
                    $_SESSION['message'] = 'Produit retiré du panier';
                }
            }
            redirect(SITE_URL.'/cart.php');
            break;
            
        case 'clear':
            unset($_SESSION['cart']);
            $_SESSION['message'] = 'Panier vidé';
            redirect(SITE_URL.'/cart.php');
            break;
    }
}

$pageTitle = "Votre panier";
require_once 'includes/header.php';

// Afficher les messages
if(isset($_SESSION['message'])) {
    echo '<div class="message">'.$_SESSION['message'].'</div>';
    unset($_SESSION['message']);
}
?>

<section class="cart-section">
    <?php if(empty($_SESSION['cart'])): ?>
        <div class="empty-cart">
            <h2>Votre panier est vide</h2>
            <p>Découvrez nos produits et faites vos achats!</p>
            <a href="../products/" class="btn">Voir les produits</a>
        </div>
    <?php else: ?>
        <form method="post" action="?action=update">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach($_SESSION['cart'] as $product_id => $quantity):
                        $product = getProductById($product_id);
                        if($product):
                            $subtotal = $product['price'] * $quantity;
                            $total += $subtotal;
                    ?>
                    <tr>
                        <td>
                            <div class="product-info">
                                <img src="<?= SITE_URL ?>/assets/images/products/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                                <div>
                                    <h3><?= $product['name'] ?></h3>
                                    <span class="category"><?= $product['category_name'] ?></span>
                                </div>
                            </div>
                        </td>
                        <td><?= number_format($product['price'], 0, ',', ' ') ?> <?= CURRENCY ?></td>
                        <td>
                            <input type="number" name="quantities[<?= $product_id ?>]" 
                                   value="<?= $quantity ?>" min="1" max="<?= $product['stock'] ?>">
                        </td>
                        <td><?= number_format($subtotal, 0, ',', ' ') ?> <?= CURRENCY ?></td>
                        <td>
                            <a href="?action=remove&id=<?= $product_id ?>" class="remove-item">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endif; endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">Total</td>
                        <td colspan="2"><?= number_format($total, 0, ',', ' ') ?> <?= CURRENCY ?></td>
                    </tr>
                </tfoot>
            </table>
            
            <div class="cart-actions">
                <button type="submit" class="btn">Mettre à jour le panier</button>
                <a href="?action=clear" class="btn btn-light">Vider le panier</a>
                <a href="checkout.php" class="btn btn-primary">Passer la commande</a>
            </div>
        </form>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>