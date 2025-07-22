<?php

header('Content-Type: application/json');

//require __DIR__.".";
require "../database/Db.php";
$database=new db();
class InscriptionController {
    private $pdo;

    public $id_user;
    public $email;
    public $mot_de_passe; 
    public $nom;
    public $id_etablissement;
    public $prenoms;
    public $role;
    public $actif;
    public $date_creation;
    public $derniere_connexion;

    public function __construct(PDO $pdo,$data) {
        $this->pdo = $pdo;
        $this->email=$data['email']??"";
        $this->nom=$data['nom']??"";
        $this->prenoms=$data['prenom']??"";
        $this->role=$data['role'] ?? "agent";           
        $this->id_etablissement=$data['id_etablissement'] ??"agent";
        $this->mot_de_passe=$data['password']??"";

    }

    public function createUser() {
        if( empty($this->mot_de_passe)|| empty($this->nom)|| empty($this->prenoms)|| empty($this->email)){
            echo json_encode(['error' => 'Champs manquants']);
            exit;   
        };

        try{
            if(!$this->getByEmail($this->email)){    
            $hash = password_hash($this->mot_de_passe, PASSWORD_BCRYPT);
            $sql = "INSERT INTO utilisateur ( email, mot_de_passe, nom, prenoms, role,id_etablissement) VALUES (?,?,?,?,?,?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array($this->email,$hash,$this->nom,$this->prenoms, $this->role,$this->id_etablissement));
            $this->id_user=$this->pdo->lastInsertId();
            
            echo json_encode(['success' => true,"page_suiv"=>"historique", 'message' => 'Utilisateur créé avec succès']);
            }else{
                echo json_encode(['error' => "ce mail exist deja"]);
            }
        } catch (PDOException $e) {
            return ['status' => false, 'message' => 'Erreur : ' . $e->getMessage()];
        }
    }

   
    public function getByEmail($email) {
        try{
        $sql = "SELECT * FROM utilisateur WHERE email = :email ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        return $user;
        } catch (PDOException $e) {
            return ['status' => false, 'message' => 'Erreur : ' . $e->getMessage()];
        }
    }

    function getAllEtablissement(){
            $sql="SELECT * FROM etablissement";
            $stmt=$this->pdo->prepare($sql);
            $stmt->execute();
            $etablissement=$stmt->fetchAll();

            if($etablissement ){
                echo json_encode(["success"=>true,"etablissement"=>$etablissement]);
            }else{
                echo json_encode(['success'=>false ,"data"=>"aucune donnees trouvees"]);
            }
        }

}

if($_SERVER["REQUEST_METHOD"] ==="GET"){
        $etablissement=new InscriptionController($database->db,[]);
        $etablissement->getAllEtablissement();
}

//var_dump($_SERVER['REQUEST_METHOD']);
//json_encode(["verification"=>$_SERVER['REQUEST_METHOD']]);
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $data = json_decode(file_get_contents('php://input'), true);
    $use=new InscriptionController($database->db,$data);
    $use->createUser();
};


?>