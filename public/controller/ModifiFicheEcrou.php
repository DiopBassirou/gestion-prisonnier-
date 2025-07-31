<?php
session_start();
    require_once("../database/Db.php");
    $db = new Db();
    $pdo=$db->db;
    if($_GET['ecrou'] && $_GET['page']== "modifiFiche_ecrou") {
        $ecrou= $_GET['ecrou'];
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        try {
            $query = "SELECT d.*, GROUP_CONCAT(l.langues SEPARATOR ',') as langue FROM detenu d 
            JOIN detenu_langue dl ON d.num_ecrou = dl.num_ecrou
            JOIN langue l ON dl.id_langue = l.id_langue
             WHERE d.num_ecrou = :ecrou";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['ecrou' => $ecrou]);
            $detenu = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $sql="SELECT * FROM etablissement";
            $stmtt=$pdo->prepare($sql);
            $stmtt->execute();
            $etablissement=$stmtt->fetchAll();
            if ($etablissement) {
                $detenu['etablissement'] = $etablissement;
            } else {
                $detenu['etablissement'] = [];
            }

            if (!$detenu) {
                echo json_encode(['status' => false, 'message' => 'Aucun détenu trouvé avec ce numéro d\'écrou.']);
                exit;
            }
            echo json_encode(['status' => true, 'data' => $detenu]);
        } catch (Exception $e) {
            echo "Erreur: " . $e->getMessage();
            exit;
        }
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prenom_prevenir = $_POST['prenom_prevenir'];
            $nom_prevenir = $_POST['nom_prevenir'];
            $numero_prevenir = $_POST['numero_prevenir'];
            $adresse_prevenir = $_POST['adresse_prevenir'];
            $niveau_instruction = $_POST['niveau_instruction'];
            $fils_de = $_POST['fils_de'] ?? '';
            $sexe = $_POST['sexe'] ?? '';
            $date_naissance = $_POST['date_naissance'] ?? '';
            $lieu_naissance = $_POST['lieu_naissance'] ?? '';
            $prenoms = $_POST['prenoms'] ?? '';
            $surnom = $_POST['surnom'] ?? '';   
            $situation_familiale = $_POST['situation_familiale'] ?? '';
            $nb_enfants = $_POST['nb_enfants'] ?? 0;
            $fille_de = $_POST['fille_de'] ?? '';
            $nom = $_POST['nom'] ?? '';
            $profession = $_POST['profession'] ?? '';
            $qualification = $_POST['qualifications'] ?? '';
            $domicile = $_POST['domicile'] ?? '';
            $nationalite = $_POST['nationalite'] ?? '';
             $id_etablissement = $_SESSION['id_etablissement'];
            $date_entree = $_POST['date_entree'] ?? '';
            $langue= $_POST['langue'] ?? [];


            try {
                $query = "UPDATE detenu SET 
                    prenom_prevenir = :prenom_prevenir,
                    nom_prevenir = :nom_prevenir,
                    numero_prevenir = :numero_prevenir,
                    adresse_prevenir = :adresse_prevenir,
                    niveau_instruction = :niveau_instruction,
                    fils_de = :fils_de,
                    sexe = :sexe,
                    date_naissance = :date_naissance,
                    lieu_naissance = :lieu_naissance,
                    prenoms = :prenoms,
                    surnom = :surnom,
                    situation_familiale = :situation_familiale,
                    nb_enfants = :nb_enfants,
                    fille_de = :fille_de,
                    nom = :nom,
                    profession = :profession,
                    qualifications = :qualification,
                    domicile = :domicile,
                    nationalite = :nationalite,
                    id_etablissement = :id_etablissement,
                    date_entree = :date_entree
                WHERE num_ecrou = :ecrou";
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                    'prenom_prevenir' => $prenom_prevenir,
                    'nom_prevenir' => $nom_prevenir,
                    'numero_prevenir' => $numero_prevenir,
                    'adresse_prevenir' => $adresse_prevenir,
                    'niveau_instruction' => $niveau_instruction,
                    'fils_de' => $fils_de,
                    'sexe' => $sexe,
                    'date_naissance' => $date_naissance,
                    'lieu_naissance' => $lieu_naissance,
                    'prenoms' => $prenoms,
                    'surnom' => $surnom,
                    'situation_familiale' => $situation_familiale,
                    'nb_enfants' => $nb_enfants,
                    'fille_de' => $fille_de,
                    'nom' => $nom,
                    'profession' => $profession,
                    'qualification' => $qualification,
                    'domicile' => $domicile,
                    'nationalite' => $nationalite,
                    'id_etablissement' => $id_etablissement,
                    'date_entree' => $date_entree,
                    'ecrou' => $ecrou
                ]);
                foreach($langue as $languee){
                    $select = "SELECT id_langue FROM langue WHERE langues = :langue";
                    $stmt = $pdo->prepare($select); 
                    $stmt->execute(['langue' => $languee]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($result && isset($result['id_langue'])) {
                    $id_langue = $result['id_langue'];
                    $query = "INSERT INTO detenu_langue (num_ecrou, id_langue) VALUES (:ecrou, :id_langue)
                              ON DUPLICATE KEY UPDATE id_langue = :id_langue";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute(['ecrou' => $ecrou, 'id_langue' => $id_langue]);
                }
                }
                echo json_encode(['status' => true, 'message' => 'Données mises à jour avec succès.', 'page_suiv' => 'modifIdentityPysique']);
            } catch (Exception $e) {
                echo json_encode(['status' => false, 'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()]);
            }
        }
    }

?>