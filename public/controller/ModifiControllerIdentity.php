<?php
session_start();
    require_once("../database/Db.php");
    $db = new Db();
    $pdo=$db->db;
    if($_GET['ecrou'] && $_GET['page']== "modifIdentityPysique") {
        $ecrou= $_GET['ecrou'];
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        try {
            $query="SELECT *FROM identite_physique WHERE num_ecrou = :ecrou";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['ecrou' => $ecrou]);
            $identity = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$identity) {
                echo json_encode(['status' => false, 'message' => 'Aucune identité physique trouvée pour ce numéro d\'écrou.']);
                exit;
            }
            echo json_encode(['status' => true, 'data' => $identity]);
        } catch (Exception $e) {
            echo "Erreur: " . $e->getMessage();
            exit;
        }
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $taille = $_POST['taille'] ?? '';
            $corpulence = $_POST['corpulence'] ?? '';
            $yeux = $_POST['yeux'] ?? '';
            $cheveux = $_POST['cheveux'] ?? '';
            $teint = $_POST['teint'] ?? '';
            $signes_particuliers = $_POST['signes_particuliers'] ?? '';
            $photo = $_FILES['photo']['name'] ?? '';

            if ($photo) {
                $target_dir = "../image/";
                $target_file = $target_dir . basename($_FILES["photo"]["name"]);
                move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
            }

            try {
                $query="UPDATE identite_physique SET taille=:taille, corpulence=:corpulence, yeux=:yeux, cheveux=:cheveux, teint=:teint, signes_particuliers=:signes_particuliers, photo=:photo WHERE num_ecrou = :ecrou";
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                    'taille' => $taille,
                    'corpulence' => $corpulence,
                    'yeux' => $yeux,
                    'cheveux' => $cheveux,
                    'teint' => $teint,
                    'signes_particuliers' => $signes_particuliers,
                    'photo' => "../image/".$photo,
                    'ecrou' => $ecrou
                ]);
                echo json_encode(['status' => true, 'message' => 'Identité physique mise à jour avec succès.', 'page_suiv' => 'modifiFiche_ecrou']);
            } catch (Exception $e) {
                echo json_encode(['status' => false, 'message' => 'Erreur lors de la mise à jour de l\'identité physique: ' . $e->getMessage()]);
            }
        }

    }
?>