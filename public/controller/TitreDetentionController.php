<?php
header('Content-Type: application/json');
require '../database/Db.php';


class TitreDetentionController {
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

    public function enregistrer() {
        if (
             empty($this->nature)|| empty($this->num_ecrou) || empty($this->numero)||empty($this->date_titre) || empty($this->origine) ||
            empty($this->infraction )||empty($this->date_condamnation) ||empty($this->juridiction) ||empty($this->duree_peine) ||empty($this->date_liberation) 
        ) {
            echo json_encode(["success"=>false,"message" => "champ manquand"]);
            exit;
        }

        $sql = "INSERT INTO titre_detention (num_ecrou, nature, numero, date_titre, origine, infraction, date_condamnation, juridiction, duree_peine, date_liberation)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            $this->num_ecrou,$this->nature,$this->numero,$this->date_titre,$this->origine,$this->infraction,
             $this->date_condamnation, $this->juridiction,$this->duree_peine,$this->date_liberation
        ]);
         echo json_encode(["success"=>true,"message" => "Titre de détention enregistré avec succès.","page_suiv"=>"titre_detention"]);
         exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] !== "POST") {

  echo json_encode(['error' => 'Méthode non autorisée']);
  exit;
};


$input = json_decode(file_get_contents("php://input"), true);
$database = new db();
$titre = new TitreDetentionController($database->db, $input);
$titre->enregistrer();
