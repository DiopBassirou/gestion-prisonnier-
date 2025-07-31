<?php 
require_once '../includes/config.php';
require_once '../includes/functions.php';

$errors = [];
$success = false;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation des données
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Validation
    if(empty($firstName)) $errors[] = 'Le prénom est requis';
    if(empty($lastName)) $errors[] = 'Le nom est requis';
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email invalide';
    if(strlen($password) < 6) $errors[] = 'Le mot de passe doit avoir au moins 6 caractères';
    if($password !== $confirmPassword) $errors[] = 'Les mots de passe ne correspondent pas';
    
    // Vérification email unique
    $stmt = $db->prepare("SELECT id FROM customers WHERE email = ?");
    $stmt->execute([$email]);
    if($stmt->fetch()) $errors[] = 'Cet email est déjà utilisé';
    
    if(empty($errors)) {
        // Création du compte
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO customers (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$firstName, $lastName, $email, $hashedPassword]);
        
        $success = true;
    }
}

$pageTitle = "Inscription";
require_once '../includes/header.php';
?>

<div class="auth-container">
    <h1>Créer un compte</h1>
    
    <?php if(!empty($errors)): ?>
        <div class="errors">
            <?php foreach($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <?php if($success): ?>
        <div class="success">
            <p>Compte créé avec succès! <a href="login.php">Connectez-vous</a></p>
        </div>
    <?php else: ?>
        <form method="post">
            <div class="form-group">
                <label for="first_name">Prénom</label>
                <input type="text" name="first_name" id="first_name" required>
            </div>
            
            <div class="form-group">
                <label for="last_name">Nom</label>
                <input type="text" name="last_name" id="last_name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe (6 caractères minimum)</label>
                <input type="password" name="password" id="password" required minlength="6">
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" name="confirm_password" id="confirm_password" required minlength="6">
            </div>
            
            <button type="submit" class="btn">S'inscrire</button>
        </form>
        
        <p>Déjà un compte? <a href="login.php">Connectez-vous</a></p>
    <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>