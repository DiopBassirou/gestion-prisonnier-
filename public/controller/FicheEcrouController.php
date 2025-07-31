<?php
session_start();
header("Content-Type:application/json");
require '../database/Db.php';
$database=new Db();
    class FicheEcrouController{
        public PDO $pdo;
        public string $num_ecrou;
        public string $nom;
        public string $prenoms;
        public string $surnom;
        public string $sexe;
        public string $date_naissance;
        public string $lieu_naissance;
        public string $fils_de;
        public string $fille_de;
        public string $situation_familiale;
        public int $nb_enfants;
        public string $niveau_instruction;
        public string $situation_militaire;
        public string $profession;
        public string $qualifications;
        public string $domicile;
        public string $nationalite;
        public string $prenom_prevenir;
        public string $nom_prevenir;
        public string $numero_prevenir;
        public string $adresse_prevenir;
        public int $id_etablissement;
        public  $id_langue=[];
       // public int $id_langue;

        public function __construct(PDO $pdo,array $data) {
            $this->pdo=$pdo;
            $this->id_etablissement=$_SESSION['id_etablissement'];
            foreach($data as $key=>$value){
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
        function getAllLangue(){
            $sql="SELECT * FROM langue";
            $stmt=$this->pdo->prepare($sql);
            $stmt->execute();
            $langue=$stmt->fetchAll();
            if( $langue){
                echo json_encode(["success"=>true,"langue"=>$langue]);
            }else{
                echo json_encode(['success'=>false ,"data"=>"aucune donnees trouvees"]);
            }
        }
    /*si le numero d'ecrou generer par js exist dans la base de donne ,
    cette methode genere un numero aleatoir de 8 chiffres puis appelle la methode enregistrer detenu
    sinon elle appelle direct la methode enregitrer detenu 
    */
        function numeroEcrouIsExist() {
            $sql="SELECT * FROM detenu WHERE num_ecrou=?";
            $stm=$this->pdo->prepare($sql);
            $stm->execute(array($this->num_ecrou)); //c'est le numero ecrou generer par js
            $num_ecrou_exist=$stm->fetch();
            while($num_ecrou_exist){
                $num = random_int(0, 99999);
                $this->num_ecrou=(int)('111'.$num);
                $sql="SELECT *FROM detenu WHERE num_ecrou=?";
                $stm=$this->pdo->prepare($sql);
                $stm->execute(array($this->num_ecrou));//c'est le nouveau num ecrou generer par js
                $num_ecrou_exist=$stm->fetch();
            }
    
         $this->enregistrerDetenu();
        }
            
        public function enregistrerDetenu() {
            if(
                empty($this->nom)|| empty($this->prenoms) || empty($this->num_ecrou) || empty($this->sexe)||
                empty($this->situation_familiale) || empty($this->situation_militaire) || empty($this->fils_de) ||
                empty($this->fille_de) || empty($this->profession)  || empty($this->lieu_naissance)|| 
                empty($this->date_naissance) || $this->id_langue=="" || empty($this->niveau_instruction)||empty($this->qualifications)|| 
                empty($this->domicile) || empty($this->nationalite) || empty($this->prenom_prevenir)|| empty($this->id_langue)||
                empty($this->nom_prevenir) || empty($this->numero_prevenir) || empty($this->adresse_prevenir)|| empty($this->id_etablissement)
            ){echo json_encode(["success"=>false,"message"=>"tous les champs sont obligatoir"]); exit;}
            
            try{
            $sql = "INSERT INTO detenu (
                num_ecrou,nom, prenoms, surnom, sexe, date_naissance, lieu_naissance,
                fils_de, fille_de, situation_familiale, nb_enfants,
                niveau_instruction, situation_militaire, profession, qualifications, domicile, nationalite,
                prenom_prevenir, nom_prevenir, numero_prevenir, adresse_prevenir, id_etablissement
                ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? )";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$this->num_ecrou,$this->nom ,$this->prenoms ,$this->surnom ,$this->sexe ,$this->date_naissance ,
                $this->lieu_naissance ,$this->fils_de , $this->fille_de ,$this->situation_familiale ,$this->nb_enfants ,
                $this->niveau_instruction ,$this->situation_militaire ,$this->profession ,$this->qualifications ,
                $this->domicile ,$this->nationalite ,$this->prenom_prevenir ,$this->nom_prevenir ,$this->numero_prevenir
                ,$this->adresse_prevenir ,$this->id_etablissement
                ]);
                
                //on insert les cles etranger dans la table(langueDetenu) entity relation 
                foreach($this->id_langue as $langue){
                $stm=$this->pdo->prepare("INSERT INTO detenu_langue( num_ecrou,id_langue) VALUES (?,?) ");

                    $stm->execute([$this->num_ecrou,$langue]);
                }
                $_SESSION['num_ecrou']=$this->num_ecrou;
                echo json_encode(["success"=>true,"num_ecrou"=>$this->num_ecrou,"message"=>"detenu enregistre","page_suiv"=>"identity_physique"]);
                exit;
            } catch (PDOException $e) {
                echo json_encode( ['status' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
                exit;
            }
        }
    }

    if($_SERVER["REQUEST_METHOD"] ==="GET"){
            $etablissement=new FicheEcrouController($database->db,[]);
            $etablissement->getAllLangue();
    }

    if($_SERVER['REQUEST_METHOD'] ==="POST"){
        $data=json_decode(file_get_contents("php://input"),true);
        $ficheEcrou=new FicheEcrouController($database->db,$data);
        $ficheEcrou->numeroEcrouIsExist();
    }
?>