<?php
header("Content-Type: application/json");
require "../database/Db.php";

class Empreinte {
    private PDO $pdo;
    private $num_ecrou;
    private $main;
    private $doigt;
    private $id_sdk;

    public function __construct(PDO $pdo, $data) {
        $this->pdo = $pdo;

        $this->num_ecrou = $data['num_ecrou'] ?? null;
        $this->main = $data['main'] ?? null;
        $this->doigt = $data['doigt'] ?? null;
        $this->id_sdk = $data['id_sdk'] ?? null;
    }

    public function enregistrer() {
        if (empty($this->num_ecrou) ||empty($this->main) || empty($this->doigt) || empty($this->id_sdk))
         {
            echo json_encode( ['success' => false, 'message' => 'Tous les champs sont obligatoires.']);
            exit;
        }

        try {
            $sql = "INSERT INTO empreinte_digitale (num_ecrou, main, doigt, id_sdk) VALUES (?,?,?,?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$this->num_ecrou, $this->main,$this->doigt,$this->id_sdk]);

            echo json_encode(  ['success' => true, 'message' => 'Empreinte enregistrée avec succès.',"page_suiv"=>"form_fiche_ecrou"]);
            exit;
        } catch (PDOException $e) {
            return ['status' => false, 'message' => 'Erreur : ' . $e->getMessage()];
        }
    }
}

$database = new db();
$data = json_decode(file_get_contents("php://input"), true);
$empreinte = new Empreinte($database->db, $data);
$empreinte->enregistrer();
