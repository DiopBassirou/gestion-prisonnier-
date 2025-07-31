<?php
require_once("../database/Db.php");

header("Content-Type: application/json");

$bd = new Db();
$pdo = $bd->db;

$data = json_decode(file_get_contents("php://input"), true);

$num_ecrou = trim($data["num_ecrou"] ?? '');
$numero = trim($data["numero"] ?? '');
$nouvelle_date = trim($data["nouvelle_date"] ?? '');
$date_decision_renvoi = trim($data["date_decision_renvoi"] ?? '');
$motif_renvoi = trim($data["motif_renvoi"] ?? '');

if (empty($num_ecrou) || empty($numero) || empty($nouvelle_date) || empty($date_decision_renvoi)) {
    echo json_encode(["success"=>false,"message" => "Champs obligatoires manquants."]);
    exit;
}

// Vérifier que le titre existe
$check = $pdo->prepare("SELECT * FROM titre_detention WHERE numero = :numero AND num_ecrou = :num_ecrou");
$check->execute(["numero" => $numero, "num_ecrou" => $num_ecrou]);

if (!$check->fetch()) {
    echo json_encode(["success"=>false,"message" => "Le numéro ou le numéro d'écrou n'existe pas dans titre_detention."]);
    exit;
}

// Récupérer la dernière nouvelle_date si existante
try {
    
    $stmt = $pdo->prepare("SELECT nouvelle_date FROM renvoi_proces WHERE num_ecrou = :num_ecrou AND numero = :numero ORDER BY id_renvoi DESC LIMIT 1");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt->execute(["num_ecrou" => $num_ecrou, "numero" => $numero]);

    $lastRenvoi = $stmt->fetch();
    $ancienne_date = $lastRenvoi ? $lastRenvoi["nouvelle_date"] : null;

    $insert = $pdo->prepare("INSERT INTO renvoi_proces (num_ecrou, numero, ancienne_date, nouvelle_date, motif_renvoi, date_decision_renvoi) 
    VALUES (:num_ecrou, :numero, :ancienne_date, :nouvelle_date, :motif_renvoi, :date_decision_renvoi)");

    $success = $insert->execute([
        "num_ecrou" => $num_ecrou,
        "numero" => $numero,
        "ancienne_date" => $ancienne_date,
        "nouvelle_date" => $nouvelle_date,
        "motif_renvoi" => $motif_renvoi,
        "date_decision_renvoi" => $date_decision_renvoi
    ]);

    if ($success) {
        echo json_encode(["success"=>true, "message" => "Renvoi enregistré avec succès.","page_suiv"=>"suivi_des_detention"]);
        exit;
    } else {
        echo json_encode(["success"=>false,"message" => "Erreur lors de l'insertion."]);
        exit;
    }

} catch (PDOException $e) {
    echo json_encode(["success"=>false,"message" => "Erreur de base de données: " ,"erreur"=> $e->getMessage()]);
    exit;
}