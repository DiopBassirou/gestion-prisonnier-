<?php
header("Content-Type: application/json");

require "../database/Db.php";

class RechercheEmpreinte {
    private PDO $pdo;
    private $main;
    private $doigt;
    private $id_sdk;

    public function __construct(PDO $pdo, $data) {
        $this->pdo = $pdo;
        $this->main = $data['main'] ?? null;
        $this->doigt = $data['doigt'] ?? null;
        $this->id_sdk = $data['id_sdk'] ?? null;
    }

    public function rechercher() {
        if (empty($this->main) || empty($this->doigt) || empty($this->id_sdk)) {
            echo json_encode( ['status' => false, 'message' => 'Tous les champs sont requis.']);
            exit;
        }

        $sql = "SELECT num_ecrou FROM empreinte_digitale WHERE main = ? AND doigt = ? AND id_sdk = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->main,$this->doigt,$this->id_sdk]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            echo json_encode( ['status' => false, 'message' => 'Aucune empreinte trouvée.']);
            exit;
        }

        $num_ecrou = $result['num_ecrou'];

        $sql = "SELECT d.*, i.photo, t.*
                FROM detenu d
                LEFT JOIN identite_physique i ON d.num_ecrou = i.num_ecrou
                LEFT JOIN titre_detention t ON d.num_ecrou = t.num_ecrou
                WHERE d.num_ecrou = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([ $num_ecrou]);
        $detenu = $stmt->fetch();

        if (!$detenu) {
           echo json_encode( ['status' => false, 'message' => 'Données du détenu introuvables.']);
           exit;
        }

        $sql = "SELECT l.langues 
                FROM detenu_langue dl
                JOIN langue l ON dl.id_langue = l.id_langue
                WHERE dl.num_ecrou = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([ $num_ecrou]);
        $langues = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $detenu['langues'] = $langues;

        echo json_encode( ['status' => true, 'data' => $detenu]);
        exit;
    }
}
if ($_SERVER['REQUEST_METHOD'] !== "POST") {

  echo json_encode(['error' => 'Méthode non autorisée']);
  exit;
};
$database = new db();
$data = json_decode(file_get_contents("php://input"), true);
$recherche = new RechercheEmpreinte($database->db, $data);
 $recherche->rechercher();
