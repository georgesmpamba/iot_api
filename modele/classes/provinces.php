<?php
/*Classe pour gérer une Province */
require_once 'connexion.php';
class Province{
    private $id;
    private $nom; 
    private $date_enre;
    private $str_db;
    function __construct(){
        global $connexion;
            $this->id=0;//Initialise la valeur de l'attribut (id)
            $this->nom="Province Auto-Générée";//Initialise la valeur de l'attribut (nom)
             $this->date_enre=date("Y-m-d H:m:i");//Initialise la valeur de l'attribut (date_enre)
            $this->str_db=$connexion;
    }
     public  function show(int $id=0,bool $all=true){
            /*Méthode pour récupérer une  Province d'ID passé en paramètre */
          //Initialise automatiquement
          if($id>0){
            $all=false;
          }
            $db_con= $this->str_db;
            $sql= $db_con->prepare($all ?"SELECT * FROM provinces WHERE :id ORDER BY nom ASC":"SELECT * FROM provinces WHERE id=:id ORDER BY nom ASC" );
            $car=[];

            try {
                $sql->execute([':id'=>$all ? 1: $id]);//Exécute la requête dynamiquement
                while($province=$sql->fetch(PDO::FETCH_ASSOC)){
                    $province['id']=(int) $province['id'];//Convertit en Entier 
                    
                    $this->setNom($province['nom']);//définit le nom de la Province
                    $this->setId($province['id']);//définit l'ID
                    $this->setDate($province['date_enre']);//définit la date
                    $car[]=$province;
                }
            } catch (Exception $ex) { 
                return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
            return $car;
        }
    public function getNom(){
        return $this->nom;//Retourne la valeur de l'attribut 'nom'
    } 
    public function getDate(){
        return $this->date_enre;//Retourne la valeur de l'attribut 'date_enre'
    }
    /*Méthode pour enregistrer une  Province */
        public function save(string $nom="Auto-générée Province"){
            /*Méthode pour enregistrer une voiture*/
            $db_con=$this->str_db;//Récupère la connexion
            $sql=$db_con->prepare("INSERT INTO provinces(nom) VALUES (:nom)");
            try {
                if($sql->execute([':nom'=>$nom])){
                    return ["success"=>true,"message"=> "Province ajoutée avec succès"];
                }
            } catch (Exception $ex) {
                    return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
        }
    /*Méthode pour modifier les informations d'une  Province */
    public function update(array $fields,int $id){//Méthode pour actualiser les informations d'une province
            $index =0;
            $response=null;
            $params=[];
            $str="UPDATE provinces SET ";
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
                    $response= ["success"=>true,"message"=>"Les informations sur la  Province ont été actualisées avec succès"];
             }
            }catch(Exception $ex){
               $response= ["error"=>$ex];
            }
            return $response;
        }
    /*Les communtateurs des données  */
        public function delete(int $id=0){
            /*Méthode pour supprimer une province*/
                $db_con=$this->str_db;//Récupère la connexion
                $sql=$db_con->prepare("DELETE FROM provinces WHERE id =:id");
            try {
                if($sql->execute([':id'=>$id])){
                    return ["success"=>true,"message"=> "Province supprimée avec succès"];
                }else{
                    return ["error"=>true,"message"=> "Aune  Province ne correspond à votre demande de suppression"];
                }
            } catch (Exception $ex) {
                return ["success"=>true,"message"=> "Province supprimée avec succès","info"=>$ex];
            }
        }
    public function setId(int $id){
        $this->id=$id;
    }
    public function setNom(string $nom){
        $this->nom=$nom;
    } 
    public function setDate(string $date_enre){
        $this->date_enre=$date_enre;
    }
}
?>