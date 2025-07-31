<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Rediriger si le panier est vide
if(empty($_SESSION['cart'])) {
    redirect(SITE_URL.'/cart.php');
}

// Rediriger les non-connectés vers la page de connexion
if(!isLoggedIn()) {
    $_SESSION['redirect_to'] = SITE_URL.'/checkout.php';
    redirect(SITE_URL.'/user/login.php');
}

$errors = [];
$success = false;

// Récupérer les infos du client
$stmt = $db->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$customer = $stmt->fetch();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $payment_method = $_POST['payment_method'];
    
    // Validation
    if(empty($address)) $errors[] = 'L\'adresse est requise';
    if(empty($phone)) $errors[] = 'Le numéro de téléphone est requis';
    if(!in_array($payment_method, ['cash', 'credit_card', 'mobile_money'])) {
        $errors[] = 'Méthode de paiement invalide';
    }
    
    if(empty($errors)) {
        // Calculer le total
        $total = 0;
        foreach($_SESSION['cart'] as $product_id => $quantity) {
            $product = getProductById($product_id);
            if($product) {
                $total += $product['price'] * $quantity;
            }
        }
        
        // Créer la commande
        $db->beginTransaction();
        try {
            // Insérer la commande
            $stmt = $db->prepare("INSERT INTO orders (customer_id, total, payment_method) VALUES (?, ?, ?)");
            $stmt->execute([$customer['id'], $total, $payment_method]);
            $order_id = $db->lastInsertId();
            
            // Insérer les articles de la commande
            foreach($_SESSION['cart'] as $product_id => $quantity) {
                $product = getProductById($product_id);
                if($product) {
                    $stmt = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$order_id, $product_id, $quantity, $product['price']]);
                    
                    // Mettre à jour le stock
                    $stmt = $db->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                    $stmt->execute([$quantity, $product_id]);
                }
            }
            
            $db->commit();
            
            // Vider le panier et afficher confirmation
            unset($_SESSION['cart']);
            $success = true;
            
        } catch(Exception $e) {
            $db->rollBack();
            $errors[] = 'Une erreur est survenue lors de la commande: '.$e->getMessage();
        }
    }
}

$pageTitle = "Passer la commande";
require_once 'includes/header.php';
?>

<section class="checkout-section">
    <?php if($success): ?>
        <div class="order-success">
            <h2>Commande passée avec succès!</h2>
            <p>Merci pour votre achat. Votre commande a été enregistrée sous le numéro #<?= $order_id ?>.</p>
            <p>Nous vous contacterons bientôt pour confirmer la livraison.</p>
            <a href="<?= SITE_URL ?>/user/orders.php" class="btn">Voir mes commandes</a>
            <a href="<?= SITE_URL ?>/products/" class="btn btn-light">Continuer mes achats</a>
        </div>
    <?php else: ?>
        <div class="checkout-steps">
            <div class="step active">1. Livraison</div>
            <div class="step">2. Paiement</div>
            <div class="step">3. Confirmation</div>
        </div>
        
        <?php if(!empty($errors)): ?>
            <div class="errors">
                <?php foreach($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" class="checkout-form">
            <div class="form-section">
                <h3>Informations de livraison</h3>
                
                <div class="form-group">
                    <label for="fullname">Nom complet</label>
                    <input type="text" id="fullname" value="<?= htmlspecialchars($customer['first_name'].' '.$customer['last_name']) ?>" readonly>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="<?= htmlspecialchars($customer['email']) ?>" readonly>
                </div>
                
                <div class="form-group">
                    <label for="address">Adresse de livraison*</label>
                    <textarea name="address" id="address" required><?= htmlspecialchars($customer['address'] ?? '') ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="phone">Téléphone*</label>
                    <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($customer['phone'] ?? '') ?>" required>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Méthode de paiement</h3>
                
                <div class="payment-methods">
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="cash" checked>
                        <div class="payment-content">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Paiement à la livraison</span>
                        </div>
                    </label>
                    
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="credit_card">
                        <div class="payment-content">
                            <i class="fas fa-credit-card"></i>
                            <span>Carte de crédit</span>
                        </div>
                    </label>
                    
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="mobile_money">
                        <div class="payment-content">
                            <i class="fas fa-mobile-alt"></i>
                            <span>Mobile Money</span>
                        </div>
                    </label>
                </div>
            </div>
            
            <div class="order-summary">
                <h3>Récapitulatif de la commande</h3>
                <table>
                    <?php
                    $total = 0;
                    foreach($_SESSION['cart'] as $product_id => $quantity):
                        $product = getProductById($product_id);
                        if($product):
                            $subtotal = $product['price'] * $quantity;
                            $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= $product['name'] ?> x <?= $quantity ?></td>
                        <td><?= number_format($subtotal, 0, ',', ' ') ?> <?= CURRENCY ?></td>
                    </tr>
                    <?php endif; endforeach; ?>
                    <tr class="total">
                        <td>Total</td>
                        <td><?= number_format($total, 0, ',', ' ') ?> <?= CURRENCY ?></td>
                    </tr>
                </table>
            </div>
            
            <button type="submit" class="btn btn-primary">Confirmer la commande</button>
        </form>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>