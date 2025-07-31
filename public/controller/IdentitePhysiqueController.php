<?php
session_start();
class IdentitePhysiqueController {
    private PDO $pdo;

    private int $num_ecrou;
    private string $taille;
    private string $corpulence;
    private string $yeux;
    private string $cheveux;
    private string $teint;
    private string $signes_particuliers;
    private string $photo;

    public function __construct(PDO $pdo, array $post, array $files) {
        $this->pdo = $pdo;

        $this->num_ecrou = $_SESSION['num_ecrou'];
        $this->taille = $post['taille'] ?? '';
        $this->corpulence = $post['corpulence'] ?? '';
        $this->yeux = $post['yeux'] ?? '';
        $this->cheveux = $post['cheveux'] ?? '';
        $this->teint = $post['teint'] ?? '';
        $this->signes_particuliers = $post['signes_particuliers'] ?? '';

        // Traitement du fichier
        if (!isset($files['photo']) || $files['photo']['error'] !== 0) {
            throw new Exception("Erreur lors du téléversement de l'image");
        }

        $tmp = $files['photo']['tmp_name'];
        $name = uniqid("photo_") . "." . pathinfo($files['photo']['name'], PATHINFO_EXTENSION);
        $destination = "../image/" . $name;

        if (!move_uploaded_file($tmp, $destination)) {
            throw new Exception("Échec de l'enregistrement du fichier");
        }

        $this->photo = "../image/" . $name; // chemin relatif pour l'affichage
    }

    public function enregistrer() {
        if (
            !$this->num_ecrou || !$this->taille || !$this->corpulence || !$this->yeux ||
            !$this->cheveux || !$this->teint || !$this->signes_particuliers || !$this->photo
        ) {
            throw new Exception("Tous les champs sont requis.");
        }

        $sql = "INSERT INTO identite_physique 
            (num_ecrou, taille, corpulence, yeux, cheveux, teint, signes_particuliers, photo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $this->num_ecrou, $this->taille, $this->corpulence, $this->yeux,
            $this->cheveux, $this->teint, $this->signes_particuliers, $this->photo
        ]);
    }
}

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

require '../database/Db.php';

try {
    $pdo = (new Db())->db;
    $controller = new IdentitePhysiqueController($pdo, $_POST, $_FILES);
    $controller->enregistrer();

    echo json_encode(['success' => true, 'message' => "Identité physique enregistrée avec succès.", "page_suiv" => "empreinte"]);
    exit;
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

?>