<?php
header("Content-Type: application/json; charset=UTF-8");

require '../database/Db.php';
    $database = new db();
    $db=$database->db;

$num_ecrou = $_GET['num_ecrou'] ?? null;
$numero = $_GET['numero'] ?? null;

if (!$num_ecrou || !$numero) {
    echo json_encode(["message" => "Paramètres manquants"]);
    exit;
}

try {
    $query = "
        SELECT 
            d.nom, d.prenoms, td.infraction,td.nature,e.nom_etablissement, ip.photo,
            rp.ancienne_date, rp.nouvelle_date, rp.motif_renvoi, rp.date_decision_renvoi,
            (SELECT COUNT(*) FROM renvoi_proces WHERE num_ecrou = :num_ecrou AND numero = :numero) AS nb_renvois
        FROM detenu d
        LEFT JOIN titre_detention td ON d.num_ecrou = td.num_ecrou AND td.numero = :numero
        LEFT JOIN identite_physique ip ON d.num_ecrou = ip.num_ecrou
        LEFT JOIN etablissement e ON d.id_etablissement = e.id_etablissement
        LEFT JOIN renvoi_proces rp ON d.num_ecrou = rp.num_ecrou AND rp.numero = :numero
        WHERE  
              (d.num_ecrou = :num_ecrou AND td.numero = :numero)
        ORDER BY rp.date_decision_renvoi DESC
        LIMIT 1
    ";

    $stmt = $db->prepare($query);
    $stmt->execute(['num_ecrou' => $num_ecrou, 'numero' => $numero]);
    $result = $stmt->fetch();
    if ($result) {
        echo json_encode(["success"=>true,"data"=>$result]);
        exit;
    } else {
        echo json_encode(["success"=>false,"message" => "Aucun renvoi trouvé."]);
        exit;
    }
} catch (Exception $e) {
    echo json_encode(["success"=>false,"message" => "Aucun renvoi trouvé.","error" => $e->getMessage()]);
    exit;
}

?>