<?php 
session_start();

require_once("../database/Db.php");
$bd=new Db();
$pdo=$bd->db;
if ($_SERVER['REQUEST_METHOD'] !== "POST" ){

    if(isset($_GET['ecrou']) && !empty($_GET['ecrou'])){
        $num=$_GET['ecrou'];
        try{
            $sql="SELECT d.* , e.nom_etablissement as nom_etablissement,i.* , t.* ,l.* FROM detenu d
                JOIN etablissement e ON d.id_etablissement=e.id_etablissement 
                JOIN identite_physique i ON i.num_ecrou=d.num_ecrou 
                JOIN titre_detention t ON d.num_ecrou=t.num_ecrou 
                JOIN detenu_langue dt ON d.num_ecrou=dt.num_ecrou 
                JOIN langue  l ON dt.id_langue=l.id_langue   
                where d.num_ecrou=?";
            $stm=$pdo->prepare($sql);
            $stm->execute([$num]);
            $data=$stm->fetch();
            if( $data){
                echo json_encode(['success'=>true,"data"=> $data]);
                exit;
            }else{
                echo json_encode(['success'=>false,"data"=>"Aucune donnee trouvee"]);   
                exit;     
            }
        }catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }


    if(isset($_GET['sdk']) && !empty($_GET['sdk'])){
        $id_sdk=$_GET['sdk'];
        try{
            $sql = "SELECT num_ecrou FROM empreinte_digitale WHERE id_sdk = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id_sdk]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$result) {
                    echo json_encode( ['status' => false, 'message' => 'Aucune empreinte trouvée.']);
                    exit;
                }

                $num = $result['num_ecrou'];

                $sql="SELECT d.* , e.nom_etablissement as nom_etablissement,i.* , t.* ,l.* FROM detenu d
                    JOIN etablissement e ON d.id_etablissement=e.id_etablissement 
                    JOIN identite_physique i ON i.num_ecrou=d.num_ecrou 
                    JOIN titre_detention t ON d.num_ecrou=t.num_ecrou 
                    JOIN detenu_langue dt ON d.num_ecrou=dt.num_ecrou 
                    JOIN langue  l ON dt.id_langue=l.id_langue   
                    where d.num_ecrou=?";
                $stm=$pdo->prepare($sql);
                $stm->execute([$num]);
                $data=$stm->fetch();
                if( $data){
                    echo json_encode(['success'=>true,"data"=> $data]);
                    exit;
                }else{
                    echo json_encode(['success'=>false,"data"=>"Aucune donnee trouvee"]);   
                    exit;     
                }
        }catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
};


if ($_SERVER['REQUEST_METHOD'] === "POST"){
    header('Content-Type: application/json');
    if(isset($_GET['ajoute_empreinte']) ){
    
        $data=json_decode(file_get_contents("php://input"),true);
        if(isset($data['num_ecrou']) && isset($data['main']) && isset($data['doigt']) && isset($data['id_sdk'])  ){
            if(!empty($data['num_ecrou']) && !empty($data['main']) && !empty($data['doigt']) && !empty($data['id_sdk'])  ){
    
                // if (!$data) { echo json_encode( ['success' => false, 'message' => 'Aucune donnee recue']);exit;}
                $num_ecrou =  $data['num_ecrou'];
                $main =  $data['main'];
                $doigt =  $data['doigt'];
                $id_sdk =  $data['id_sdk'];

                try {
                        $stm=$pdo->prepare("SELECT * FROM detenu WHERE num_ecrou=?");
                        $stm->execute([$num_ecrou]);
                        $num_ecrou_is_exist=$stm->fetch();
                        
                        if(!$num_ecrou_is_exist){
                            echo json_encode(  ['success' => false, 'message' => 'Ce numero d\'ecrou n\'exist pas']);
                            exit;
                        }

                        $stmt=$pdo->prepare("SELECT * FROM empreinte_digitale WHERE num_ecrou=?");
                        $stmt->execute([$num_ecrou]);
                        $num_ecrou_is_existe=$stmt->fetch();
                        if($num_ecrou_is_existe){
                            echo json_encode(  ['success' => false, 'message' => 'Empreite deja enregistre avec ce numero']);
                            exit;
                        }

                        $sql = "INSERT INTO empreinte_digitale (num_ecrou, main, doigt, id_sdk) VALUES (?,?,?,?)";
                        $stmt =  $pdo->prepare($sql);
                        $stmt->execute([ $num_ecrou,  $main, $doigt, $id_sdk]);
                        echo json_encode(  ['success' => true, 'message' => 'Empreinte enregistree avec succes.']);
                        exit;
                    } catch (PDOException $e) {
                        return ['status' => false, 'message' => 'Erreur : ' . $e->getMessage()];
                    }
            }else{
                echo json_encode(["success"=>false,"message"=>"Veuillez donner toutes les données requises (num_ecrou?, main?, doigt?, id_sdk?)"]);   
            }
        }else{
              echo json_encode(["success"=>false,"message"=>"Données manquantes (num_ecrou?, main?, doigt?, id_sdk?)"]);
        }
    }



    if(isset($_GET['pointage'])){
    
        $data=json_decode(file_get_contents("php://input"),true);
        if(isset($data['main']) && isset($data['doigt']) && isset($data['id_sdk'])){
            $id_sdk=$data['id_sdk'];
            $stmt=$pdo->prepare("SELECT * FROM empreinte_digitale WHERE id_sdk=?");
            $stmt->execute([$id_sdk]);
            $result=$stmt->fetch();
            if($result){
                
                if (isset($_SESSION['id_user'])) {
                    $id_user = $_SESSION['id_user'];
                    $num_ecrou=$result['num_ecrou'];
                    $insert=$pdo->prepare("INSERT INTO historique(id_user,num_ecrou,main,doigt)VALUES(?,?,?,?)");
                    $insert->execute([$id_user,$num_ecrou,$data['main'],$data['doigt']]);
                    echo json_encode(["success"=>true,"message"=>"Pointage effectuee"]);
                
                } else {
                    
                    echo json_encode(["success"=>false,"message"=>"personne n'est connectée sur cet appareil"]);
                }
            }else{
                    echo json_encode(["success"=>false,"message"=>"ce detenu n'est pas encors enregistrer dans la base de donnees"]);
            }
        }else{
              echo json_encode(["success"=>false,"message"=>"Données manquantes ( main?, doigt?, id_sdk?)"]);
        }
    }
}
?>

