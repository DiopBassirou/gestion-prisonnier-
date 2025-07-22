<?php
header('Content-Type: application/json');
require '../database/Db.php';

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
   
    public function __construct(PDO $pdo, array $data) {
        $this->pdo = $pdo;

        $this->num_ecrou = (int) ($data['num_ecrou'] ?? 0);
        $this->taille =$data['taille'] ?? '';
        $this->corpulence =$data['corpulence'] ?? '';
        $this->yeux =$data['yeux'] ?? '';
        $this->cheveux =$data['cheveux'] ?? '';
        $this->teint =$data['teint'] ?? '';
        $this->signes_particuliers =$data['signes_particuliers'] ?? '';
        $this->photo =$data['photo'] ?? '';
    }

    public function enregistrerIdentitePhysique() {
        if (
            empty($this->num_ecrou) || empty($this->taille) ||empty($this->corpulence) ||empty($this->yeux) ||
            empty($this->cheveux) || empty($this->teint) || empty($this->signes_particuliers) || empty($this->photo)

        ) {echo json_encode(["success"=>false,"message" => "Champ manquand"]); exit; }

        $sql = "INSERT INTO identite_physique 
                (num_ecrou, taille, corpulence, yeux, cheveux, teint, signes_particuliers, photo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([ 
            $this->num_ecrou,$this->taille,$this->corpulence,$this->yeux,
            $this->cheveux,$this->teint,$this->signes_particuliers,$this->photo
        ]);
        echo json_encode(["success"=>true,"message" => "Identité physique enregistrée avec succès.","page_suiv"=>"empreinte"]);
        exit;
    }
}
if ($_SERVER['REQUEST_METHOD'] !== "POST") {

  echo json_encode(['success'=>false,'message' => 'Méthode non autorisée']);
  exit;
};
$data = json_decode(file_get_contents("php://input"), true);
$database = new db();
$identite = new IdentitePhysiqueController($database->db, $data);
$identite->enregistrerIdentitePhysique();


