<?php
/*Classe pour gérer une commune */
require_once 'connexion.php';
class Commune{
    private $id;
    private $nom;
    private $ville;
    private $date_enre;
    private $str_db;
    function __construct(){
        global $connexion;
            $this->id=0;//Initialise la valeur de l'attribut (id)
            $this->nom="Commune inconnue";//Initialise la valeur de l'attribut (nom)
            $this->ville=0;//Initialise la valeur de l'attribut (ville)
            $this->date_enre=date("Y-m-d H:m:i");//Initialise la valeur de l'attribut (date_enre)
            $this->str_db=$connexion;
    }
     public  function show(int $id=0){
            /*Méthode pour récupérer une commune d'ID passé en paramètre */
          //  $this->init();//Initialise automatiquement
            $all=true;
            $db_con= $this->str_db;
            if($id>0){
                $all=false;
            }
            $query_string="SELECT communes.id, communes.nom, communes.date_enre, communes.ville, villes.nom AS ville_nom FROM communes INNER JOIN villes ON communes.ville=villes.id WHERE ".($all ? ":id" :" communes.id=:id ")." ORDER BY nom";
            $sql= $db_con->prepare($query_string);
            $car=[];
           // return [$sql];

            try {
                $sql->execute([':id'=>$all ? 1: $id]);//Exécute la requête dynamiquement
                while($commune=$sql->fetch(PDO::FETCH_ASSOC)){
                    $commune['id']=(int) $commune['id'];
                    $commune['ville']=(int) $commune['ville'];

                    $this->setNom($commune['nom']);//définit le nom de la ville
                    $this->setVille($commune['ville']);//définit la ville
                    $this->setId($commune['id']);//définit l'ID
                    $this->setDate($commune['date_enre']);//définit la date
                    $car[]=$commune;
                }
            } catch (Exception $ex) { 
                return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
            return $car;
        }

        /*Méthode pour enregistrer une commune */
        public function save(string $nom="Nouvelle commune", int $ville=0){
            /*Méthode pour enregistrer une voiture*/
            $db_con=$this->str_db;//Récupère la connexion
            $sql=$db_con->prepare("INSERT INTO communes(nom,ville) VALUES (:nom, :ville)");
            try {
                if($sql->execute([':nom'=>$nom,':ville'=>$ville])){
                    return ["success"=>true,"message"=> "Commune ajoutée avec succès"];
                }
            } catch (Exception $ex) {
                    return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
        }
    
    /*Méthode pour modifier les informations d'une commune */
    public function update(array $fields,int $id){//Méthode pour actualiser les informations d'une commune
            $index =0;
            $response=null;
            $str="UPDATE communes SET "; 
            $params=[];
            
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
                    $response= ["success"=>true,"message"=>"Les informations sur la Commune ont été actualisées avec succès"];
                }
            }catch(Exception $ex){
               $response= ["error"=>$ex];
            }
            return $response;
        }
    /*Les communtateurs des données  */
        public function delete(int $id=0){
            /*Méthode pour supprimer une Commune*/
                $db_con=$this->str_db;//Récupère la connexion
                $sql=$db_con->prepare("DELETE FROM communes WHERE id =:id");
            try {
                if($sql->execute([':id'=>$id])){
                    return ["success"=>true,"message"=> "Commune supprimée avec succès"];
                }else{
                    return ["error"=>true,"message"=> "Aune Commune ne correspond à votre demande de suppression"];
                }
            } catch (Exception $ex) {
                return ["success"=>true,"message"=> "Commune supprimée avec succès","info"=>$ex];
            }
        }






    public function getId(){
        return $this->id;//Retourne la valeur de l'attribut 'id'
    }

    public function getNom(){
        return $this->nom;//Retourne la valeur de l'attribut 'nom'
    }
    public function getVille(){
        return $this->ville;//Retourne la valeur de l'attribut 'ville'
    }
    public function getDate(){
        return $this->date_enre;//Retourne la valeur de l'attribut 'date_enre'
    }



    public function setId(int $id){
        $this->id=$id;
    }
    public function setNom(string $nom){
        $this->nom=$nom;
    }
    public function setVille(int $ville){
        $this->ville=$ville;
    }
    public function setDate(string $date_enre){
        $this->date_enre=$date_enre;
    }

}
?>