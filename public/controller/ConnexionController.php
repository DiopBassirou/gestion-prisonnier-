<?php
session_start();

header("Content-Type: application/json");

require_once "../database/Db.php";
$database=new Db();

class ConnexionController{
    public PDO $pdo;
    private $password;
    public $email;
    public function __construct(PDO $pdo,$password,$email) {
        $this->pdo=$pdo;
        $this->password=$password;
        $this->email=$email;
    }
    public function verifyConnexion(){
        if(empty($this->email)|| empty($this->password)){
            echo json_encode(["success"=>false,"message"=>"champs manquant"]);
            exit;
        }

        $mailUser=$this->getByEmail($this->email);

        if($mailUser){
            if($this->verifyPassword($this->password,$mailUser['mot_de_passe'])){
                $this->updateLastLogin($mailUser['id_user']);
                $data=[
                   "success"=> true ,
                   "message"=> "connexion reussie",
                   "nom_utilisateur"=>$mailUser['prenoms']
                ];
                // je garde l'id de mon user et son role dans le serveur
                $_SESSION['id_user'] = $mailUser['id_user'];
                $_SESSION['role'] =$mailUser['role'];
                $_SESSION['id_etablissement'] =$mailUser['id_etablissement'];
              echo  json_encode($data);
              exit;
            }else{
                $data=[
                   "success"=> false ,
                   "message"=> "mot de passe incoret"
                ];
              echo json_encode($data);
              exit;
            }
        }else{
            $data=[
                   "succe"=> false ,
                   "message"=> "email incoret"
                ];
            echo json_encode($data);
            exit;
        }
    }

     public function getByEmail($email) {
        try{
        $sql = "SELECT * FROM utilisateur WHERE email = :email ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        return $user;
        } catch (PDOException $e) {
            return ['status' => false, 'message' => 'Erreur : ' . $e->getMessage()];
        }
    }

    public function verifyPassword($password,$passwordDB) {
        return password_verify($password, $passwordDB);
    }
    
    public function updateLastLogin($id_user) {
        $sql = "UPDATE utilisateur SET derniere_connexion = NOW() WHERE id_user = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([ $id_user]);
    }
    }
if($_SERVER['REQUEST_METHOD']!=="POST"){
   echo json_encode(["error"=>"Methode non autorise"]);
   exit;
}
$data=json_decode(file_get_contents("php://input"),true);
$password=$data["password"];
$email=$data["email"];
$login=new ConnexionController($database->db,$password,$email);
$login->verifyConnexion();
?>

