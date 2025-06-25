<?php
/*Classe pour gérer une Ville */
require_once 'connexion.php';
class Ville{
    private $id;
    private $nom;
    private $province;
    private $date_enre;
    private $str_db;
    function __construct(){
        global $connexion;
            $this->id=0;//Initialise la valeur de l'attribut (id)
            $this->nom="Nouvelle Ville";//Initialise la valeur de l'attribut (nom)
            $this->ville=0;//Initialise la valeur de l'attribut (ville)
            $this->date_enre=date("Y-m-d H:m:i");//Initialise la valeur de l'attribut (date_enre)
            $this->str_db=$connexion;
    }
     public  function show(int $id=0){
            /*Méthode pour récupérer une Ville d'ID passé en paramètre */
            //Initialise automatiquement
            $all=true;
            if($id>0){
                $all=false;
            }
                $query_string="SELECT villes.id, villes.nom AS nom, province AS id_province, provinces.id as id_province,provinces.nom AS nom_province FROM villes INNER JOIN provinces ON villes.province=provinces.id WHERE".  ($all ?' :id ':' villes.id=:id ') ." ORDER BY nom";

                $db_con= $this->str_db;
            $sql= $db_con->prepare($query_string );
            $car=[];

            try {
                $sql->execute([':id'=>$all ? 1: $id]);//Exécute la requête dynamiquement
                while($ville=$sql->fetch(PDO::FETCH_ASSOC)){
                    $ville['id']=(int) $ville['id'];
                    $ville['id_province']=(int) $ville['id_province'];

                    $this->setNom($ville['nom']);//définit le nom de la ville
                    //$this->setProvince($ville['province']);//définit la ville
                    $this->setId($ville['id']);//définit l'ID
                   // $this->setDate($ville['date_enre']);//définit la date
                    $car[]=$ville;
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
    public function getVille(){
        return $this->ville;//Retourne la valeur de l'attribut 'ville'
    }
    public function getDate(){
        return $this->date_enre;//Retourne la valeur de l'attribut 'date_enre'
    }

    /*Méthode pour enregistrer une Ville */
        public function save(string $nom="Nouvelle commune", int $province=0){
            /*Méthode pour enregistrer une voiture*/
            $db_con=$this->str_db;//Récupère la connexion
            $sql=$db_con->prepare("INSERT INTO villes(nom,province) VALUES (:nom, :province)");
            try {
                if($sql->execute([':nom'=>$nom,':province'=>$province])){
                    return ["success"=>true,"message"=> "Ville ajoutée avec succès"];
                }
            } catch (Exception $ex) {
                    return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
        }

    /*Méthode pour modifier les informations d'une Ville */
    public function update(array $fields,int $id){//Méthode pour actualiser les informations d'une commune
            $index =0;
            $response=null;
            $params=[];
            $str="UPDATE villes SET ";
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
                    $response= ["success"=>true,"message"=>"Les informations sur la Ville ont été actualisées avec succès"];
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
                $sql=$db_con->prepare("DELETE FROM villes WHERE id =:id");
            try {
                if($sql->execute([':id'=>$id])){
                    return ["success"=>true,"message"=> "Commune supprimée avec succès"];
                }else{
                    return ["error"=>true,"message"=> "Aune Ville ne correspond à votre demande de suppression"];
                }
            } catch (Exception $ex) {
                return ["success"=>true,"message"=> "Commune supprimée avec succès","info"=>$ex];
            }
        }
    public function setId(int $id){
        $this->id=$id;
    }
    public function setNom(string $nom){
        $this->nom=$nom;
    }
    public function setProvince(int $province){
        $this->ville=$province;
    }
    public function setDate(string $date_enre){
        $this->date_enre=$date_enre;
    }
}
?>