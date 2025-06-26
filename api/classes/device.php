<?php
/*Classe pour gérer un équipement */
require_once 'connexion.php';
class Device{
        private $id;
        private $modele;
        private $mac;
        private $proprio;
        private $date_enre;

    private $str_db;//chaîne de connexion à la base des données
    function __construct(){
        global $connexion;

            $this->modele="ESP32000";
            $this->mac="00:00:00:00:00:00:00:00";
            $this->proprio="";
            $this->date_enre=date("Y-m-d H:m:i");//Initialise la valeur de l'attribut (date_enre)
            $this->str_db=$connexion;
    }
     public  function show(int $id=0){
            /*Méthode pour récupérer un équipement d'ID passé en paramètre */
          //  $this->init();//Initialise automatiquement
            $all=true;
            $db_con= $this->str_db;
            if($id>0){
                $all=false;
            }
            $query_string="SELECT * FROM devices WHERE ".($all ? ":id" :" id_dev=:id ")." ORDER BY modele ASC";
            $sql= $db_con->prepare($query_string);
            $devices=[];

            try {
                $sql->execute([':id'=>$all ? 1: $id]);//Exécute la requête dynamiquement
                while($device=$sql->fetch(PDO::FETCH_ASSOC)){
                    $device['id_dev']=(int) $device['id_dev'];
                    $device['proprio_dev']=(int) $device['proprio_dev'];

                    $devices[]=$device;
                }
            } catch (Exception $ex) { 
                return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
            return $devices;
        }

        /*Méthode pour enregistrer un équipement */
        public function save(string $modele="", int $proprio=0){
            /*Méthode pour enregistrer une voiture*/
            $db_con=$this->str_db;//Récupère la connexion
            $sql=$db_con->prepare("INSERT INTO devices(modele_dev,proprio_dev) VALUES (:nom, :proprio)");
            try {
                if($sql->execute([':nom'=>$modele,':proprio'=>$proprio])){
                    return ["success"=>true,"message"=> "Equipement ajouté avec succès"];
                }
            } catch (Exception $ex) {
                    return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
        }
    
    /*Méthode pour modifier les informations d'un équipement */
    public function update(array $fields,int $id){//Méthode pour actualiser les informations d'un équipement
            $index =0;
            $response=null;
            $str="UPDATE devices SET "; 
            $params=[];
            
            foreach ($fields as $key => $value) {
                $params[$index]=$value ;    
                if($index<(count($fields)-1)){
                    $str=$str.' '.$key."=?".", "; 
                }  else{
                    $str=$str.''.$key."=? WHERE id_dev=".$id; 
                }
                $index++;//incrémente  l'index
            }
            if(count($params)<1){//Bloque l'exécution s'il n'y a pas de paramètre à modifier
                return ["error"=>"Aucune modification ne sera faite"];
            }
            $req= $this->str_db ->prepare($str);
            try{
                if($req->execute($params)){
                    $response= ["success"=>true,"message"=>"Les informations sur l'équipement ont été actualisés avec succès"];
                }
            }catch(Exception $ex){
               $response= ["error"=>$ex];
            }
            return $response;
        }
    /*Les communtateurs des donnés  */
        public function delete(int $id=0){
            /*Méthode pour supprimer un équipement*/
                $db_con=$this->str_db;//Récupère la connexion
                $sql=$db_con->prepare("DELETE FROM devices WHERE id_dev =:id");
            try {
                if($sql->execute([':id'=>$id])){
                    return ["success"=>true,"message"=> "Equipement supprimé avec succès"];
                }else{
                    return ["error"=>true,"message"=> "Aun équipement ne correspond à votre demande de suppression"];
                }
            } catch (Exception $ex) {
                return ["success"=>true,"message"=> "Equipement supprimé avec succès","info"=>$ex];
            }
        }

}
?>