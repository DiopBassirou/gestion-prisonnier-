<?php
session_start();
$idEtablissement=$_SESSION['id_etablissement'];
require_once("../database/Db.php");
$bd=new Db();
$pdo=$bd->db;
      if($_SESSION['role']!=="admin" && $_SESSION['role']!=="ministre" ){
            $stmt=$pdo->prepare(
                  "SELECT h.*,u.nom as nomUser,u.prenoms as prenomUser,u.role as role ,d.prenoms,d.nom FROM historique h
                  JOIN utilisateur u ON h.id_user=u.id_user 
                  JOIN detenu d ON h.num_ecrou=d.num_ecrou
                  WHERE u.id_etablissement = ? ");
            $stmt->execute([$idEtablissement]);
            $data=$stmt->fetchAll();
            if($data){
                  echo json_encode(["success"=>true,"data"=>$data]);
            }else{
                   echo json_encode(["success"=>false,"message"=>"zero pointage pour l'instant"]);
            }
      }else{
            $stmt=$pdo->prepare(
                  "SELECT h.*,u.nom as nomUser,u.prenoms as prenomUser,u.role as role ,d.prenoms,d.nom FROM historique h
                  JOIN utilisateur u ON h.id_user=u.id_user 
                  JOIN detenu d ON h.num_ecrou=d.num_ecrou ");
            $stmt->execute();
            $data=$stmt->fetchAll();
            if($data){
            echo json_encode(["success"=>true,"data"=>$data]);
            }else{
                  echo json_encode(["success"=>false,"message"=>"zero pointage pour l'instant"]);
            }
      }
?>