<?php
/*Classe pour gérer une sorte */
require_once 'connexion.php';
class Service{
    private $id;
    private $nom; 
    private $sorte; 
    private $date_service;
    private $str_db;
    function __construct(){
        global $connexion;
            $this->id=0;//Initialise la valeur de l'attribut (id)
            $this->nom="Service Auto-Généré";//Initialise la valeur de l'attribut (nom)
            $this->sorte="";//Initialise la valeur de l'attribut (nom)
            $this->date_service=date("Y-m-d H:m:i");//Initialise la valeur de l'attribut (date_service)
            $this->str_db=$connexion;
    }
     public  function show(int $id=0,bool $all=true){
            /*Méthode pour récupérer une  service d'ID passé en paramètre */
          if($id>0){
            $all=false;
          }
            $db_con= $this->str_db;
            $query_string="SELECT services.id as id,id_tar, nom_service as nom, duree, sorte,date_service,montant,devise FROM services LEFT JOIN tarifs ON services.id=tarifs.service  WHERE ". ($all? " services.id>= :id ":" services.id=:id ") ." ORDER BY nom_service ASC";
            $sql= $db_con->prepare($query_string );
            $car=[];
            try {
                $x=0;
                $sql->execute([':id'=>$all ? 1: $id]);//Exécute la requête dynamiquement

                while($service=$sql->fetch(PDO::FETCH_ASSOC)){
                    $service['id']=(int) $service['id'];//Convertit en Entier 
                    $service['id_tar']=(int) $service['id_tar'];//Convertit en Entier 
                    $service['duree']=(int) $service['duree'];//Convertit en Entier 
                    $service['nom']=$service['nom']==NULL ? "Service généré":$service['nom'];
                    $this->setNom($service['nom']);//définit le nom de la sorte
                    $this->setId($service['id']);//définit l'ID
                    $this->setDate($service['date_service']);//définit la date
                    $car[]=$service;
                    /*
                    echo var_dump($car).
                    "<br/><br/>";
                    */
                    /*
                    if(isset($car[$x]) && $car[$x]['id']!=((int) $service['id'])){
                        $car[]=$service;
                   }
                    $x++;
                    */
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
        public function save(string $nom_service="Auto-générée service",$duree=4,string $sorte='Sorte Automatique'){
            /*Méthode pour enregistrer un service*/
            $db_con=$this->str_db;//Récupère la connexion

            $sql=$db_con->prepare("INSERT INTO services(nom_service,duree,sorte) VALUES (:nom_service,:duree,:sorte)");
            try {
                if($sql->execute([':nom_service'=>$nom_service,':duree'=>$duree,':sorte'=>$sorte])){
                    return ["success"=>true,"message"=> "Service ajouté avec succès"];
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
            $str="UPDATE services SET ";
            foreach ($fields as $key => $value) {
                $params[$index]=$value ;    
                if($index<(count($fields)-1)){
                    $str=$str.' '.$key."=?".", "; 
                }  else{
                    $str=$str.''.$key."=? WHERE id=".$id; 
                }
                $index++;//incrémente  l'index
            }
            if(count($params)<1){//Bloque l'exécution s'il n'y a pas de paramètre à modifier
                return ["error"=>"Aucune modification ne sera faite"];
            }
            $req= $this->str_db ->prepare($str);
            try{
                if($req->execute($params)){
                    $response= ["success"=>true,"message"=>"Les informations sur le Service ont été actualisées avec succès"];
             }
            }catch(Exception $ex){
               $response= ["error"=>$ex];
            }
            return $response;
        }
    /*Les communtateurs des données  */
        public function delete(int $id=0){
            /*Méthode pour supprimer une service*/
                $db_con=$this->str_db;//Récupère la connexion
                $sql=$db_con->prepare("DELETE FROM services WHERE id =:id");
            try {
                if($sql->execute([':id'=>$id])){
                    return ["success"=>true,"message"=> "Service supprimé avec succès"];
                }else{
                    return ["error"=>true,"message"=> "Aucun Service ne correspond à votre demande de suppression"];
                }
            } catch (Exception $ex) {
                return ["success"=>true,"message"=> "Service supprimé avec succès","info"=>$ex];
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