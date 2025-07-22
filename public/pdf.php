<?php
require('fpdf/fpdf.php');
error_reporting(E_ALL & ~E_WARNING);
ini_set("display_errors", 0);



session_start();

   $pdf = new FPDF();

   $pdf->AddPage();
   

   $pdf->SetXY(25,20);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(65,60,"",1);
   
   $pdf->SetXY(90,20);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(65,60,"",1);

   $pdf->SetXY(155,20);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(30,60,"",1);
   //je commence les ligne de la premier case 
   $pdf->SetXY(25,20);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(130,12,"",1);
   $pdf->SetXY(26,22);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Taille :"));
   $pdf->SetXY(36,22);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",'taille'));

   $pdf->SetXY(94,22);
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
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Corpulence :"));
   $pdf->SetXY(36,34);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",'corpulence'));

   $pdf->SetXY(25,44);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(65,12,"",1);
   $pdf->SetXY(26,46);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Yeux :"));
   $pdf->SetXY(36,46);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'yeux'));

   $pdf->SetXY(25,56);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(65,12,"",1);
   $pdf->SetXY(26,58);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Cheveux :"));
   $pdf->SetXY(36,58);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",'cheveux'));

   $pdf->SetXY(25,68);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(65,12,"",1);
   $pdf->SetXY(26,70);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Teint :"));
   $pdf->SetXY(36,70);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'teint'));

   $pdf->SetXY(25,80);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(160,12,"",1);
   $pdf->SetXY(26,82);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Signe particuliers aparents :"));
   $pdf->SetXY(56,82);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  'signes_particuliers'));

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
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Nature:"));
   $pdf->SetXY(36,109);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'nature'));

   $pdf->SetXY(26,126);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Numero:"));
   $pdf->SetXY(36,126);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT", 'numero'));

   $pdf->SetXY(100,126);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Date:"));
   $pdf->SetXY(110,126);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",'date_entree'));

   $pdf->SetXY(25,132);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(160,12,"",1);
   $pdf->SetXY(26,134);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Origine:"));
   $pdf->SetXY(36,134);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",'origine'));

   $pdf->SetXY(25,144);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(160,12,"",1);
   $pdf->SetXY(26,146);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Infraction :"));
   $pdf->SetXY(36,146);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",'infraction'));

   $pdf->SetXY(25,156);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(100,12,"",1);
   $pdf->SetXY(26,158);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Date de condamnation :"));
   $pdf->SetXY(36,158);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",'date_condamnation'));

   $pdf->SetXY(125,156);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(60,12,"",1);
   $pdf->SetXY(130,158);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Jiriduction :"));
   $pdf->SetXY(130,158);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",'jiriduction'));

   $pdf->SetXY(25,168);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(32,22,"",1);
   $pdf->SetXY(28,174);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Pouce Droit"));

   $pdf->SetXY(57,168);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(32,22,"",1);
   $pdf->SetXY(60,174);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Index Droit"));

   $pdf->SetXY(89,168);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(32,22,"",1);
   $pdf->SetXY(92,174);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Medius Droit"));

   $pdf->SetXY(121,168);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(32,22,"",1);
   $pdf->SetXY(123,174);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Annulaire Droit"));

   $pdf->SetXY(153,168);
   $pdf->setFont('Arial','B',12);
   $pdf->Cell(32,22,"",1);
   $pdf->SetXY(154,174);
   $pdf->setFont('Arial','',12);
   $pdf->Write(5,iconv("UTF-8", "ISO-8859-1//TRANSLIT",  "Auriculaire Droit"));


   $pdf->Output();
?>