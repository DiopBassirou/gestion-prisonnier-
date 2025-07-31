<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if(!isLoggedIn()) {
    redirect(SITE_URL.'/user/login.php');
}

// Récupérer les infos du client
$stmt = $db->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$customer = $stmt->fetch();

// Mettre à jour les infos si formulaire soumis
$errors = [];
$success = false;

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_info'])) {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    
    // Validation
    if(empty($firstName)) $errors[] = 'Le prénom est requis';
    if(empty($lastName)) $errors[] = 'Le nom est requis';
    
    if(empty($errors)) {
        $stmt = $db->prepare("UPDATE customers SET first_name = ?, last_name = ?, address = ?, phone = ? WHERE id = ?");
        $stmt->execute([$firstName, $lastName, $address, $phone, $_SESSION['user_id']]);
        $success = true;
        
        // Mettre à jour la session
        $_SESSION['user_name'] = $firstName.' '.$lastName;
    }
}

// Changer le mot de passe
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Vérifier le mot de passe actuel
    $stmt = $db->prepare("SELECT password FROM customers WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    if(!password_verify($currentPassword, $user['password'])) {
        $errors[] = 'Mot de passe actuel incorrect';
    } elseif(strlen($newPassword) < 6) {
        $errors[] = 'Le nouveau mot de passe doit avoir au moins 6 caractères';
    } elseif($newPassword !== $confirmPassword) {
        $errors[] = 'Les nouveaux mots de passe ne correspondent pas';
    } else {
        // Mettre à jour le mot de passe
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE customers SET password = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $_SESSION['user_id']]);
        $success = true;
    }
}

$pageTitle = "Mon compte";
require_once '../includes/header.php';
?>

<div class="account-section">
    <div class="account-sidebar">
        <div class="user-info">
            <div class="avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <h3><?= htmlspecialchars($customer['first_name'].' '.$customer['last_name']) ?></h3>
            <p><?= htmlspecialchars($customer['email']) ?></p>
        </div>
        
        <ul class="account-menu">
            <li class="active"><a href="<?= SITE_URL ?>/user/account.php">Mes informations</a></li>
            <li><a href="<?= SITE_URL ?>/user/orders.php">Mes commandes</a></li>
        </ul>
    </div>
    
    <div class="account-content">
        <h2>Mes informations</h2>
        
        <?php if($success): ?>
            <div class="success">
                <p>Informations mises à jour avec succès!</p>
            </div>
        <?php endif; ?>
        
        <?php if(!empty($errors)): ?>
            <div class="errors">
                <?php foreach($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" class="account-form">
            <input type="hidden" name="update_info" value="1">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">Prénom</label>
                    <input type="text" name="first_name" id="first_name" 
                           value="<?= htmlspecialchars($customer['first_name']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="last_name">Nom</label>
                    <input type="text" name="last_name" id="last_name" 
                           value="<?= htmlspecialchars($customer['last_name']) ?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" value="<?= htmlspecialchars($customer['email']) ?>" readonly>
                <small>Pour changer votre email, veuillez contacter le support.</small>
            </div>
            
            <div class="form-group">
                <label for="address">Adresse</label>
                <textarea name="address" id="address"><?= htmlspecialchars($customer['address'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="phone">Téléphone</label>
                <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($customer['phone'] ?? '') ?>">
            </div>
            
            <button type="submit" class="btn">Mettre à jour</button>
        </form>
        
        <h3>Changer le mot de passe</h3>
        <form method="post" class="account-form">
            <input type="hidden" name="change_password" value="1">
            
            <div class="form-group">
                <label for="current_password">Mot de passe actuel</label>
                <input type="password" name="current_password" id="current_password" required>
            </div>
            
            <div class="form-group">
                <label for="new_password">Nouveau mot de passe</label>
                <input type="password" name="new_password" id="new_password" required minlength="6">
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                <input type="password" name="confirm_password" id="confirm_password" required minlength="6">
            </div>
            
            <button type="submit" class="btn">Changer le mot de passe</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>