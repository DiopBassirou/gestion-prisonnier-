<?php
session_start();
require '../database/Db.php';
$database=new Db();
$pdo=$database->db;
if(isset($_GET['ecrou'])){
    try{
        $num=$_GET['ecrou'];
        $sql="SELECT d.* , e.nom_etablissement as nom_etablissement,i.photo as photo ,t.*  FROM detenu d
              JOIN etablissement e ON d.id_etablissement=e.id_etablissement
              JOIN identite_physique i ON i.num_ecrou=d.num_ecrou
              JOIN titre_detention t ON t.num_ecrou=d.num_ecrou
              where d.num_ecrou=?
          ";
        $stm=$pdo->prepare($sql);
        $stm->execute([$num]);
        $data=$stm->fetch();
        echo json_encode(['success'=>true,"data"=>$data]);
    }catch (PDOException $e) {
        echo json_encode( ['status' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
        exit;
    }
}else{
        try{
            if($_SESSION['role']!=="admin" && $_SESSION['role']!=="ministre" ){
                $idEtablissement=$_SESSION['id_etablissement'];
                $sql="SELECT d.* , e.nom_etablissement as nom_etablissement FROM detenu d 
                    JOIN etablissement e ON d.id_etablissement=e.id_etablissement 
                    JOIN titre_detention t ON t.num_ecrou=d.num_ecrou
                    JOIN identite_physique i ON i.num_ecrou=d.num_ecrou
                    WHERE d.id_etablissement=?";
                $stm=$pdo->prepare($sql);
                $stm->execute([$idEtablissement]);
                $data=$stm->fetchAll();
                echo json_encode(['success'=>true,"data"=>$data]);
                exit;
            }else{
                $sql="SELECT d.* , e.nom_etablissement as nom_etablissement FROM detenu d 
                  JOIN etablissement e ON d.id_etablissement=e.id_etablissement 
                  JOIN titre_detention t ON t.num_ecrou=d.num_ecrou
                  JOIN identite_physique i ON i.num_ecrou=d.num_ecrou";
                $stm=$pdo->prepare($sql);
                $stm->execute();
                $data=$stm->fetchAll();
                echo json_encode(['success'=>true,"data"=>$data]);
                exit;
            }
        }catch (PDOException $e) {
            echo json_encode( ['status' => false, 'message' => '' ]);
            exit;
        }
    } 
?>