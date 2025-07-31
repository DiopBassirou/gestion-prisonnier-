<?php
header('Content-Type: application/json');
require '../database/Db.php';


class CondamnationController {
    private PDO $pdo;

    private int $num_ecrou;
    private string $nature;
    private string $numero;
    private string $date_titre;
    private string $origine;
    private string $infraction;
    private string $date_condamnation;
    private string $juridiction;
    private string $duree_peine;
    private string $date_liberation;

    public function __construct(PDO $pdo, array $data) {
        $this->pdo = $pdo;

        $this->num_ecrou = (int) ($data['num_ecrou'] ?? 0);
        $this->nature =$data['nature'] ?? '';
        $this->numero =$data['numero'] ?? '';
        $this->date_titre = $data['date_titre'] ?? '';
        $this->origine =$data['origine'] ?? '';
        $this->infraction =$data['infraction'] ?? '';
        $this->date_condamnation = $data['date_condamnation'] ?? '';
        $this->juridiction =$data['juridiction'] ?? '';
        $this->duree_peine =$data['duree_peine'] ?? '';
        $this->date_liberation = $data['date_liberation'] ?? '';
    }

    public function getTitreDetentionByNumEcrou(int $num_ecrou,$numero) {
        if( empty($num_ecrou) || empty($numero)) {
            echo json_encode(["success" => false, "message" => "Numéro d'écrou ou numer du detention manquant"]);
            exit;
        }
        $sql = "SELECT * FROM titre_detention WHERE num_ecrou = ? AND numero=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$num_ecrou,$numero]);
        $titreDetention= $stmt->fetch();
        if ($titreDetention) {
            echo json_encode(["success" => true, "data" => $titreDetention]);
            exit;
        } else {
            echo json_encode(["success" => false, "message" => "Titre de détention non trouvé pour ce numéro d'écrou."]);
            exit;
        }
    }

    public function updateTitreDetention() {
        if (
             empty($this->nature)|| empty($this->num_ecrou) || empty($this->numero)||empty($this->date_titre) || empty($this->origine) ||
            empty($this->infraction )||empty($this->date_condamnation) ||empty($this->juridiction) ||empty($this->duree_peine) ||empty($this->date_liberation) 
        ) {
            echo json_encode(["success"=>false,"message" => "champ manquand"]);
            exit;
        }
            // On met a jour le titre de detention apres condamnation
            $sql = "UPDATE titre_detention SET
                nature = ?, date_titre = ?, origine = ?, infraction = ?,
                date_condamnation = ?, juridiction = ?, duree_peine = ?, date_liberation = ?
                WHERE num_ecrou = ? AND numero = ?";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $this->nature,
                $this->date_titre,
                $this->origine,
                $this->infraction,
                $this->date_condamnation,
                $this->juridiction,
                $this->duree_peine,
                $this->date_liberation,
                $this->num_ecrou,
                $this->numero
            ]);
         echo json_encode(["success"=>true,"message" => "Titre de détention enregistré avec succès.","page_suiv"=>"condamnation"]);
         exit;
    }
}

if( $_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['num_ecrou']) && isset($_GET['numero'])) {
    $num_ecrou = (int) $_GET['num_ecrou'];
    $numero = $_GET['numero'];
    $database = new db();
    $titre = new CondamnationController($database->db, []);
    $titre->getTitreDetentionByNumEcrou($num_ecrou,$numero);       
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

$input = json_decode(file_get_contents("php://input"), true);
$database = new db();
$titre = new CondamnationController($database->db, $input);
$titre->updateTitreDetention();
}