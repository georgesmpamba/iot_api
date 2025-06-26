<?php
/*Classe pour gérer les données des équipements */
require_once 'connexion.php';
class Data{
        private $id;
        private $dev;
        private $content;

    private $str_db;//chaîne de connexion à la base des données
    function __construct(){
            global $connexion;
            $this->dev=0;
            $this->content=["hum"=>50, "mac"=>"00:00:00:00:00:00:00:00","temp"=>25];
            
            $this->date_enre=date("Y-m-d H:m:i");//Initialise la valeur de l'attribut (date_enre)
            $this->str_db=$connexion;
    }
     public  function show(int $id=0){
            /*Méthode pour récupérer un équipement d'ID passé en paramètre */
            $all=true;//Spécifie s'il faut lire toutes les données ou pas
            $db_con= $this->str_db;
            if($id>0){
                $all=false;
            }
            $query_string="SELECT * FROM datas WHERE ".($all ? ":id" :" id_dat=:id ")." ORDER BY modele ASC";
            $sql= $db_con->prepare($query_string);
            $datas=[];

            try {
                $sql->execute([':id'=>$all ? 1: $id]);//Exécute la requête dynamiquement
                while($device=$sql->fetch(PDO::FETCH_ASSOC)){
                    $device['id_dat']=(int) $device['id_dat'];//Convertit en Integer les données de "id_dat"
                    $device['dev_dat']=(int) $device['dev_dat'];//Convertit en Integer les données de "dev_dat"
                    $device['content_dat']=json_decode ($device['content_dat']);//Décode les données de l'équipement

                    $datas[]=$device;
                }
            } catch (Exception $ex) { 
                return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
            return $datas;
        }

        /*Méthode pour enregistrer un équipement */
        public function save(string $device=0, int $content=["hum"=>50, "mac"=>"00:00:00:00:00:00:00:00","temp"=>25]){
            /*Méthode pour enregistrer une voiture*/
            $db_con=$this->str_db;//Récupère la connexion
            $sql=$db_con->prepare("INSERT INTO datas(dev_dat,content_dat) VALUES (:device, :content)");
            try {
                if($sql->execute([':device'=>$device,':content'=>json_encode($content)])){
                    return ["success"=>true,"message"=> "Les données ont été ajoutées avec succès"];
                }
            } catch (Exception $ex) {
                    return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
        }
    /*Méthode pour modifier les informations d'un équipement */
    public function update(array $fields,int $id){//Méthode pour actualiser les informations d'un équipement
         /*Les données ne doivent pas être modifiées, donc l'usage de cette méthode doit être justifié*/
            $index =0;
            $response=null;
            $str="UPDATE datas SET "; 
            $params=[];
            
            foreach ($fields as $key => $value) {
                $params[$index]=$value ;    
                if($index<(count($fields)-1)){
                    $str=$str.' '.$key."=?".", "; 
                }  else{
                    $str=$str.''.$key."=? WHERE id_dat=".$id; 
                }
                $index++;//incrémente  l'index
            }
            if(count($params)<1){//Bloque l'exécution s'il n'y a pas de paramètre à modifier
                return ["error"=>"Aucune modification ne sera faite"];
            }
            $req= $this->str_db ->prepare($str);
            try{
                if($req->execute($params)){
                    $response= ["success"=>true,"message"=>"Les informations sur les données de l'équipement ont été actualisées avec succès"];
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
                $sql=$db_con->prepare("DELETE FROM datas WHERE id_dat =:id");
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