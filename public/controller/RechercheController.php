<?php
header("Content-Type: application/json");
require_once "../database/Db.php";

class RechercheController {
    private PDO $pdo;
    private array $criteres;

    public function __construct(PDO $pdo, array $criteres) {
        $this->pdo = $pdo;
        $this->criteres = $criteres;
    }
    public function rechercher() {
        $sql = "SELECT d.*, e.nom_etablissement/*,t.infraction,t.date_liberation */
                FROM detenu d
                JOIN etablissement e ON d.id_etablissement = e.id_etablissement ";
                // JOIN titre_detention t ON d.num_ecrou=t.num_ecrou";
        
        $conditions = [];
        $params = [];

        foreach ($this->criteres as $key => $value) {
            if ($value === '') continue;

            switch ($key) {
                case 'nom':
                case 'num_ecrou':
                case 'prenoms':
                case 'profession':
                case 'niveau_instruction':
                case 'situation_familiale':
                    $conditions[] = "d.$key LIKE ?";
                    $params[] = "%$value%";
                    break;

                case 'nationalite':
                    $conditions[] = "d.nationalite = ?";
                    $params[] = $value;
                    break;

                case 'num_ecrou':
                    $conditions[] = "d.num_ecrou = ?";
                    $params[] = $value;
                    break;

                case 'sexe':
                    $conditions[] = "d.sexe = ?";
                    $params[] = $value;
                    break;

                case 'age_min':
                    $conditions[] = "TIMESTAMPDIFF(YEAR, d.date_naissance, CURDATE()) >= ?";
                    $params[] = $value;
                    break;

                case 'age_max':
                    $conditions[] = "TIMESTAMPDIFF(YEAR, d.date_naissance, CURDATE()) <= ?";
                    $params[] = $value;
                    break;

                case 'date_entree_min':
                    $conditions[] = "DATE(d.date_entree) >= ?";
                    $params[] = $value;
                    break;
                    
                case 'date_entree_max':
                    $conditions[] = "DATE(d.date_entree) <= ?";
                    $params[] = $value;
                    break;

                case 'date_sortie':
                    $conditions[] = "d.num_ecrou IN (
                        SELECT num_ecrou FROM titre_detention WHERE date_liberation = ?
                    )";
                    $params[] = $value;
                    break;

                default:
                //$params[]="";
                    break;
            }
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!$resultats){echo json_encode([ "success" => false,"MESSAGE"=>"okkkkkk"]) ; exit;}

        echo json_encode([
            "success" => true,
            "data" => $resultats
        ]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $db = new Db();
   
    $controller = new RechercheController($db->db, $data);
    $controller->rechercher();
}
