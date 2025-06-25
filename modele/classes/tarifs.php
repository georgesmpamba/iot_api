<?php
/*Classe pour gérer une sorte */
require_once 'connexion.php';
class Tarif{
    private $str_db;

    private $id_tar;
    private $montant;
    private $devise;
    private $service;
    private $date_tarif;



    function __construct(){
        global $connexion;
            $this->id=0;//Initialise la valeur de l'attribut (id)
            $this->nom="Service Auto-Généré";//Initialise la valeur de l'attribut (nom)
            $this->sorte="";//Initialise la valeur de l'attribut (nom)
            $this->date_tarif=date("Y-m-d H:m:i");//Initialise la valeur de l'attribut (date_service)
            $this->str_db=$connexion;
    }
     public  function show(int $id=0,bool $all=true){
            /*Méthode pour récupérer une  Tarif d'ID passé en paramètre */
          if($id>0){
            $all=false;
          }

            $db_con= $this->str_db;
            $sql= $db_con->prepare($all ?"SELECT * FROM tarifs INNER JOIN services ON tarifs.service=services.id  WHERE :id ORDER BY nom_service ASC":"SELECT * FROM tarifs INNER JOIN services ON tarifs.service=services.id WHERE id_tar=:id ORDER BY nom_service ASC" );
            $car=[];
            try {
                $sql->execute([':id'=>$all ? 1: $id]);//Exécute la requête dynamiquement
                while($service=$sql->fetch(PDO::FETCH_ASSOC)){
                    $service['id']=(int) $service['id'];//Convertit en Entier 
                    $service['id_tar']=(int) $service['id_tar'];//Convertit en Entier 
                    $service['montant']=(int) $service['montant'];//Convertit en Entier 
                    $service['service']=(int) $service['service'];//Convertit en Entier 
                    $service['duree']=(int) $service['duree'];//Convertit en Entier 
                    $car[]=$service;
                }
            } catch (Exception $ex) { 
                return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
            return $car;
        }
    public function getId(){
        return $this->id;//Retourne la valeur de l'attribut 'id'
    }
    public function getNom(){
        return $this->nom;//Retourne la valeur de l'attribut 'nom'
    } 
    public function getDate(){
        return $this->date_service;//Retourne la valeur de l'attribut 'date_service'
    }
    /*Méthode pour enregistrer un  service */
        public function save(int $montant=1500,string $devise="FC",int $service=0){
            /*Méthode pour enregistrer un service*/
 
            $db_con=$this->str_db;//Récupère la connexion

            $sql=$db_con->prepare("INSERT INTO tarifs(montant,devise,service) VALUES (:montant,:devise,:service)");
            try {
                if($sql->execute([':montant'=>$montant,':devise'=>$devise,':service'=>$service])){
                    return ["success"=>true,"message"=> "Tarif ajouté avec succès"];
                }
            } catch (Exception $ex) {
                    return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
        }
    /*Méthode pour modifier les informations d'une  service */
    public function update(array $fields,int $id){//Méthode pour actualiser les informations d'une service
            $index =0;
            $response=null;
            $params=[];
            $str="UPDATE tarifs SET ";
            foreach ($fields as $key => $value) {
                $params[$index]=$value ;    
                if($index<(count($fields)-1)){
                    $str=$str.' '.$key."=?".", "; 
                }  else{
                    $str=$str.''.$key."=? WHERE id_tar=".$id; 
                }
                $index++;//incrémente  l'index
            }
            if(count($params)<1){//Bloque l'exécution s'il n'y a pas de paramètre à modifier
                return ["error"=>"Aucune modification ne sera faite"];
            }
            $req= $this->str_db ->prepare($str);
            try{
                if($req->execute($params)){
                   return  $response= ["success"=>true,"message"=>"Les informations sur la tarif ont été actualisées avec succès"];
             }
            }catch(Exception $ex){
                    return  $response= ["error"=>$ex];
            }
            return $response;
        }
    /*Les communtateurs des données  */
        public function delete(int $id=0){
            /*Méthode pour supprimer une service*/
                $db_con=$this->str_db;//Récupère la connexion
                $sql=$db_con->prepare("DELETE FROM tarifs WHERE id_tar =:id");
            try {
                if($sql->execute([':id'=>$id])){
                    return ["success"=>true,"message"=> "Tarif supprimé avec succès"];
                }else{
                    return ["error"=>true,"message"=> "Aucun Tarif ne correspond à votre demande de suppression"];
                }
            } catch (Exception $ex) {
                return ["success"=>true,"message"=> "Tarif supprimé avec succès","info"=>$ex];
            }
        }
    public function setId(int $id){
        $this->id=$id;
    }
    public function setNom(string $nom){
        $this->nom=$nom;
    }
    public function setSorte(int $sorte){
        $this->sorte=$sorte;
    }
    public function setDate(string $date_service){
        $this->date_service=$date_service;
    }
}
?>