<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

$category_id = $_GET['category_id'] ?? null;
$search = $_GET['search'] ?? null;

$pageTitle = "Nos produits";
require_once '../includes/header.php';
?>

<section class="products-section">
    <div class="filters">
        <form method="get" class="search-form">
            <input type="text" name="search" placeholder="Rechercher..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
        
        <div class="categories">
            <h3>Catégories</h3>
            <ul>
                <li><a href="?">Tous les produits</a></li>
                <?php foreach(getCategories() as $category): ?>
                    <li>
                        <a href="?category_id=<?= $category['id'] ?>" <?= $category_id == $category['id'] ? 'class="active"' : '' ?>>
                            <?= $category['name'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <div class="products-list">
        <?php
        $sql = "SELECT p.*, c.name as category_name FROM products p 
               JOIN categories c ON p.category_id = c.id 
               WHERE p.stock > 0";
        
        $params = [];
        
        if($category_id) {
            $sql .= " AND p.category_id = ?";
            $params[] = $category_id;
        }
        
        if($search) {
            $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $searchTerm = "%$search%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " ORDER BY p.created_at DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll();
        
        if(empty($products)) {
            echo '<p class="no-results">Aucun produit trouvé.</p>';
        } else {
            echo '<div class="products-grid">';
            foreach($products as $product) {
                echo '<div class="product-card">';
                echo '<img src="'.SITE_URL.'/assets/images/products/'.$product['image'].'" alt="'.$product['name'].'">';
                echo '<div class="product-info">';
                echo '<h3>'.$product['name'].'</h3>';
                echo '<span class="category">'.$product['category_name'].'</span>';
                echo '<span class="price">'.number_format($product['price'], 0, ',', ' ').' '.CURRENCY.'</span>';
                echo '<a href="view.php?id='.$product['id'].'" class="btn">Voir détails</a>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>