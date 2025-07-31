<?php
header("Content-Type: application/json; charset=UTF-8");
require '../database/Db.php';

$database = new db();
$db = $database->db;

$num_ecrou = $_GET['num_ecrou'] ?? null;
$numero = $_GET['numero'] ?? null;

if (!$num_ecrou || !$numero) {
    echo json_encode(["success" => false, "message" => "Paramètres manquants"]);
    exit;
}

try {
    $query = "
        SELECT 
            ancienne_date, nouvelle_date, motif_renvoi, date_decision_renvoi
        FROM renvoi_proces
        WHERE num_ecrou = :num_ecrou AND numero = :numero
        ORDER BY date_decision_renvoi DESC
    ";
    $stmt = $db->prepare($query);
    $stmt->execute(['num_ecrou' => $num_ecrou, 'numero' => $numero]);
    $renvois = $stmt->fetchAll();

    echo json_encode(["success" => true, "data" => $renvois]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Erreur serveur", "error" => $e->getMessage()]);
}
?>