<?php
class Db{
    // private  string $host='localhost';
    // private string $user ="root";
    // private string $dbname="prison";
    // private string $password="";
    private string $host = 'mysql-prison.alwaysdata.net';
    private string $user = 'prison'; 
    private string $dbname = 'prison_database'; 
    private string $password = 'gestion1234';
    public PDO $db;

    public function __construct() {
        $this->getConnexion();
    }

    public  function getConnexion (): PDO{
        try{
            $this->db=new PDO("mysql:host={$this->host};dbname={$this->dbname}",$this->user,$this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        }catch(Exception $e){
            //echo ("l'erreur:" + $e->getMessage());
        }
        return $this->db;

    }
}
?>