<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if(isLoggedIn()) {
    redirect(SITE_URL);
}

$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Validation
    if(empty($email) || empty($password)) {
        $errors[] = 'Email et mot de passe requis';
    } else {
        // Vérification des identifiants
        $stmt = $db->prepare("SELECT * FROM customers WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if($user && password_verify($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['first_name'].' '.$user['last_name'];
            
            redirect(SITE_URL);
        } else {
            $errors[] = 'Identifiants incorrects';
        }
    }
}

$pageTitle = "Connexion";
require_once '../includes/header.php';
?>

<div class="auth-container">
    <h1>Connexion</h1>
    
    <?php if(!empty($errors)): ?>
        <div class="errors">
            <?php foreach($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
        </div>
        
        <button type="submit" class="btn">Se connecter</button>
    </form>
    
    <p>Pas encore de compte? <a href="register.php">Inscrivez-vous</a></p>
</div>

<?php require_once '../includes/footer.php'; ?>