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

        $this->num_ecrou = (int) ($data['num_ecrou'] );
        $this->nature =$data['nature'] ?? '';
        $this->numero =$data['numero'] ?? '';
        $this->date_titre = $data['date_titre'] ?? '';
        $this->origine =$data['origine'] ?? '';
        $this->infraction =$data['infraction'] ?? '';
        $this->date_condamnation ='';
        $this->juridiction ='';
        $this->duree_peine ='';
        $this->date_liberation ='';
    }

    

    public function enregistrer() {
        if (empty($this->nature)|| empty($this->num_ecrou) || empty($this->numero)||empty($this->date_titre)|| empty($this->origine) || empty($this->infraction )) 
        {
            echo json_encode(["success"=>false,"message" => "champ manquand"]);
            exit;
        }
        // Vérifier si le numéro d'écrou existe
        $sql = "SELECT * FROM detenu WHERE  num_ecrou = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->num_ecrou]);
        $existingNumEcrou = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$existingNumEcrou) {
            //si le numéro d'écrou n'existe pas on lui fait savoir
            echo json_encode(["success"=>false,"message" => "Ce titre de détention n'existe pas pour ce numéro d'écrou. Veuillez vérifier les informations saisies"]);
            exit;   
        }

        $sql = "SELECT * FROM titre_detention WHERE  numero = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([ $this->numero]);
        $existingTitre = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($existingTitre) {
            //si un titre existe on fait rien on lui fait savoir que que ce numero existe déjà
            echo json_encode(["success"=>false,"message" => "Ce titre de détention existe déjà avec ce numero Veuillez vérifier les informations saisies"]);
            exit;   
        }
            // INSERT si aucun titre de détention trouvé
            $sql = "INSERT INTO titre_detention (
                num_ecrou, nature, numero, date_titre, origine, infraction,
                date_condamnation, juridiction, duree_peine, date_liberation
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $this->num_ecrou,
                $this->nature,
                $this->numero,
                $this->date_titre,
                $this->origine,
                $this->infraction,
                $this->date_condamnation,
                $this->juridiction,
                $this->duree_peine,
                $this->date_liberation
            ]);
            echo json_encode(["success"=>true,"message" => "Titre de détention enregistré avec succès.","page_suiv"=>"titreDetProvisoir"]);
            exit; 
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $input = json_decode(file_get_contents("php://input"), true);
    $database = new db();
    $titre = new TitreDetentionController($database->db, $input);
    $titre->enregistrer();
}