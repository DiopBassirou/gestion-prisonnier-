<?php
header('Content-Type: application/json');
require '../database/Db.php';

    $database = new db();
    $pdo=$database->db;
        
    if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['num_ecrou']) && !empty($_GET['num_ecrou']) ) {
        $num_ecrou = (int) $_GET['num_ecrou'];

        $sql = "SELECT * FROM titre_detention WHERE num_ecrou = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$num_ecrou]);
        $existingTitre = $stmt->fetchAll();
        if ($existingTitre) {
            echo json_encode(["success"=>true,'data' => $existingTitre]);
            exit;   
        }else {
            echo json_encode(["success"=>false,'message' => 'Aucun titre de detention trouvé pour ce numéro d\'écrou.']);
            exit;
        }
    }


    if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['numero']) && !empty($_GET['numero']) ) {
        $numero = $_GET['numero'];

        $sql = "SELECT * FROM titre_detention WHERE numero = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$numero]);
        $existingTitre = $stmt->fetch();
        if ($existingTitre) {
            echo json_encode(["success"=>true,'data' => $existingTitre]);
            exit;   
        }else {
            echo json_encode(["success"=>false,'message' => 'Aucun titre de detention trouvé pour ce numéro']);
            exit;
        }
    }
?>   