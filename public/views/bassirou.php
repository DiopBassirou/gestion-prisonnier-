<?php 
require_once("../database/Db.php");
require('../fpdf/fpdf.php');
$bd=new Db();
$pdo=$bd->db;
   if(isset($_GET['ecrou'])){
    try{
        $num=$_GET['ecrou'];
        $sql="SELECT d.* , e.nom_etablissement as nom_etablissement,i.* , t.* , GROUP_CONCAT(l.langues SEPARATOR ', ') AS langues FROM detenu d
              JOIN etablissement e ON d.id_etablissement=e.id_etablissement 
              JOIN identite_physique i ON i.num_ecrou=d.num_ecrou 
              JOIN titre_detention t ON d.num_ecrou=t.num_ecrou 
              JOIN detenu_langue dt ON d.num_ecrou=dt.num_ecrou 
              JOIN langue  l ON dt.id_langue=l.id_langue   
              where d.num_ecrou=?";
        $stm=$pdo->prepare($sql);
        $stm->execute([$num]);
        $data=$stm->fetch();
        if(!$data){
            $sql="SELECT d.* , e.nom_etablissement as nom_etablissement,i.* /*, t.**/ , GROUP_CONCAT(l.langues SEPARATOR ', ') AS langues FROM detenu d
              JOIN etablissement e ON d.id_etablissement=e.id_etablissement 
              JOIN identite_physique i ON i.num_ecrou=d.num_ecrou 
            --   JOIN titre_detention t ON d.num_ecrou=t.num_ecrou 
              JOIN detenu_langue dt ON d.num_ecrou=dt.num_ecrou 
              JOIN langue  l ON dt.id_langue=l.id_langue   
              where d.num_ecrou=?";
        $stm=$pdo->prepare($sql);
        $stm->execute([$num]);
        $data=$stm->fetch();
        }
        //var_dump($data);
    }catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }


error_reporting(E_ALL & ~E_WARNING);
ini_set("display_errors", 0);


   $pdf = new FPDF();
   // $pdf->AliasNbPages();

   $pdf->AddPage();
   $pdf->SetXY(25,10);
   $pdf->setFont('Arial','B',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "FICHE ECROU "));

   $pdf->SetXY(25,20);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(75,20,"",1);
   $pdf->SetXY(37,22);
   $pdf->setFont('Arial','BU',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Etablissement : "));
   $pdf->SetXY(26,28);
   $pdf->setFont('Arial','',12);
   $pdf->MultiCell(75,6,iconv("UTF-8", "ISO-8859-1//TRANSLIT", $data['nom_etablissement']));
   
   $pdf->SetXY(100,20);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(75,20,"",1);
   $pdf->SetXY(105,22);
   $pdf->setFont('Arial','B',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "N ECROU   ". $data['num_ecrou']));

   $pdf->SetXY(100,30);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(75,10,"",1);
   $pdf->SetXY(101,32);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Date&Heure :  ".date("m-d-y")."  "."a ".  date("G")."H :".date("i")." mn"));

   $pdf->SetXY(25,40);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(150,10,"",1);
   $pdf->SetXY(26,42);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Nom : ".$data['nom']));

   $pdf->SetXY(25,50);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(150,10,"",1);
   $pdf->SetXY(26,52);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Prenom : ". $data['prenoms']));

   $pdf->SetXY(25,60);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(150,10,"",1);
   $pdf->SetXY(26,62);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Surnom : ".$data['surnom']));

   $pdf->SetXY(86,62);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "SEXE :  ".$data['sexe']));

   $pdf->SetXY(25,70);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(150,10,"",1);
   $pdf->SetXY(26,72);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Date et Lieu de Naissance : ".$data['date_naissance']."  a    ".$data['lieu_naissance']));

   // $pdf->SetXY(25,70);
   // $pdf->setFont('Arial','B',12);
   // $pdf->Cell(150,10,"",1);

   $pdf->SetXY(25,80);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(150,10,"",1);
   $pdf->SetXY(26,82);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Fils/Fille de : ".$data['fils_de']."  et de  ". $data['fille_de']));

   $pdf->SetXY(25,90);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(150,10,"",1);
   $pdf->SetXY(26,92);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Langue Parlees : ".$data['langues']));

   $pdf->SetXY(25,100);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(150,10,"",1);
   $pdf->SetXY(26,102);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Nationalite : ". $data['nationalite']));

   $pdf->SetXY(25,110);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(150,10,"",1);
   $pdf->SetXY(26,112);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Situation Familiale : ".$data['situation_familiale']));

   $pdf->SetXY(90,112);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Nombre d'enfants : ".$data['nb_enfants']));

   $pdf->SetXY(25,120);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(150,10,"",1);
   $pdf->SetXY(26,122);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Niveau Instruction : ".$data['niveau_instruction']));

   $pdf->SetXY(25,130);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(150,10,"",1);
   $pdf->SetXY(26,132);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Situation Militaire : ". $data['situation_militaire']));

   $pdf->SetXY(25,140);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(150,10,"",1);
   $pdf->SetXY(26,142);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Profession ou Activite Exercee : ".$data['profession']));

   $pdf->SetXY(25,150);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(150,10,"",1);
   $pdf->SetXY(26,152);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Autres qualification profossionnelles : "."Neant"));

    $pdf->SetXY(25,160);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(150,10,"",1);
   $pdf->SetXY(26,162);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Domicile : ".$data['domicile']));

   $pdf->SetXY(25,170);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(150,20,"",1);
   $pdf->SetXY(26,172);
   $pdf->setFont('Arial','',12);
   $pdf->MultiCell(150,6,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Personne a prevenir: ".$data['prenom_prevenir']." ".$data['nom_prevenir']." TEL: ".$data['numero_prevenir']." Adresse: ". $data['adresse_prevenir']));
   
  //  $pdf->SetXY(25,180);
  //  $pdf->setFont('Arial','B',12);
  //  $pdf->Cell(150,10,"",1);
  //  $pdf->SetXY(26,182);
  //  $pdf->setFont('Arial','',12);
  //  $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Nom :"));

   $pdf->SetXY(25,190);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(30,30,"",1);
   $pdf->SetXY(55,190);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(30,30,"",1);

   $pdf->SetXY(85,190);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(30,30,"",1);

   $pdf->SetXY(115,190);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(30,30,"",1);

   $pdf->SetXY(145,190);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(30,30,"",1);


   //l'autre pdf

      $pdf->AddPage();
   

   $pdf->SetXY(90,20);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(50,60,"",1);

   $pdf->SetXY(140,20);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(45,60,"",1);
   var_dump($data['photo']);
if(!empty($data['photo'])){
   $pdf->Image($data['photo'],140.5,25,44,48);
}
   //je commence les lignes de la premier case 
   $pdf->SetXY(25,20);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(115,12,"",1);
   $pdf->SetXY(26,22); 
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Taille : ". $data['taille']));
   
   $pdf->SetXY(91,22);
   $pdf->setFont('Arial','B',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "PROPOSE AU GREFFE"));

   $pdf->SetXY(100,32);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Prenom&nom"));

   $pdf->SetXY(100,62);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Date&Signature"));

  // $pdf->SetXY(166,52);
   //$pdf->setFont('Arial','',12);
   //$pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Photo"));

   //pour la case taill:

   $pdf->SetXY(25,32);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(65,12,"",1);
   $pdf->SetXY(26,34);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Corpulence : ".$data['corpulence']));

   $pdf->SetXY(25,44);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(65,12,"",1);
   $pdf->SetXY(26,46);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Yeux : ".$data['yeux']));

   $pdf->SetXY(25,56);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(65,12,"",1);
   $pdf->SetXY(26,58);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Cheveux : ".$data['cheveux']));
   
   $pdf->SetXY(25,68);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(65,12,"",1);
   $pdf->SetXY(26,70);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Teint : ".$data['teint']));

   $pdf->SetXY(25,80);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(160,12,"",1);
   $pdf->SetXY(26,82);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Signe particuliers aparents : ".$data['signes_particuliers']));

   $pdf->SetXY(25,92);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(160,16,"",1);
   $pdf->SetXY(86,98);
   $pdf->setFont('Arial','B',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "TITRE DE DETENTION"));

   $pdf->SetXY(25,108);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(160,24,"",1);
   $pdf->SetXY(26,109);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Nature: ".$data['nature']));
   
   $pdf->SetXY(26,126);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Numero: ".$data['numero']));

   $pdf->SetXY(100,126);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Date: ".$data['date_entree']));

   $pdf->SetXY(25,132);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(160,12,"",1);
   $pdf->SetXY(26,134);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Origine: ".$data['origine']));
   
   $pdf->SetXY(25,144);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(160,32,"",1);
//    $pdf->SetXY(26,146);
//    $pdf->setFont('Arial','',12);
//    $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Infraction : "));
   $pdf->SetXY(26,146);
   $pdf->setFont('Arial','',12);
  // $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", $data['infraction']));
   $pdf->MultiCell(160,6,iconv("UTF-8", "ISO-8859-1//TRANSLIT","Infraction : ". $data['infraction']));

   $pdf->SetXY(25,176);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(90,10,"",1);
   $pdf->SetXY(26,178);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Date de condamnation : ".$data['date_condamnation']));

   $pdf->SetXY(115,176);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(70,10,"",1);
   $pdf->SetXY(116,178);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Juriduction : ".$data['juridiction']));

   $pdf->SetXY(25,186);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(90,12,"",1);
   $pdf->SetXY(26,188);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Duree de la peine : ".$data['duree_peine']));

   $pdf->SetXY(115,186);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(70,12,"",1);
   $pdf->SetXY(116,188);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Date de liberation : ".$data['date_liberation']));
   

   $pdf->SetXY(25,198);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(32,22,"",1);
   $pdf->SetXY(28,202);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Pouce Droit"));

   $pdf->SetXY(57,198);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(32,22,"",1);
   $pdf->SetXY(60,202);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Index Droit"));

   $pdf->SetXY(89,198);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(32,22,"",1);
   $pdf->SetXY(92,202);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Medius Droit"));

   $pdf->SetXY(121,198);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(32,22,"",1);
   $pdf->SetXY(123,202);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Annulaire Droit"));

   $pdf->SetXY(153,198);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(32,22,"",1);
   $pdf->SetXY(154,202);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Auriculaire Droit"));



    $pdf->Output();
}
?>
