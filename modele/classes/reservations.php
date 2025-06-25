<?php
/*Classe pour gérer une Reservation */
require_once 'connexion.php';
class Reservation{
    private $id;
    private $utilisateur;
    private $taxi;
    private $ville;
    private $service;
    private $etat;
    private $adresse;
    private $date_valide;

    private $str_db;
    function __construct(){
        global $connexion;

        $this->id=0;//Initialise la valeur de l'attribut (id)
        $this->utilisateur=0;//Initialise la valeur de l'attribut (utilisateur)
        $this->taxi=0;//Initialise la valeur de l'attribut (taxi)
        $this->ville=0;//Initialise la valeur de l'attribut (ville)
        $this->service=0;//Initialise la valeur de l'attribut (service)
        $this->etat=0;//Initialise la valeur de l'attribut (etat)
        $this->adresse="Kinshasa, R. D. Congo, commune de Gombe, ISIPA-SHAUMBA";//Initialise la valeur de l'attribut (adresse)
        $this->date_valide=date("Y-m-d H:m:i");//Initialise la valeur de l'attribut (date_valide)

        $this->str_db=$connexion;
    }

    /*Méthode pour retourner la valeur de l'attribut (id) */
    public function getId()    {
        return $this->id;//récupère la valeur de l'attribut (id)
    }
    /*Méthode pour retourner la valeur de l'attribut (utilisateur) */
    public function getUser(){
        return $this->utilisateur;//récupère la valeur de l'attribut (utilisateur)
    }
    /*Méthode pour retourner la valeur de l'attribut (taxi) */
    public function getVaxi(){
        return $this->taxi;//récupère la valeur de l'attribut (taxi)
    }
    /*Méthode pour retourner la valeur de l'attribut (ville) */
    public function getVille(){
        return $this->ville;//récupère la valeur de l'attribut (ville)
    }
    /*Méthode pour retourner la valeur de l'attribut (service) */
    public function getService(){
        return $this->service;//récupère la valeur de l'attribut (service)
    }
    /*Méthode pour retourner la valeur de l'attribut (etat) */
    public function getEtat(){
        return $this->etat;//récupère la valeur de l'attribut (etat)
    }
    /*Méthode pour retourner la valeur de l'attribut (adresse) */
    public function getAdresse(){
        return $this->adresse;//récupère la valeur de l'attribut (adresse)
    }
    /*Méthode pour retourner la valeur de l'attribut (date_valide) */
    public function getDate(){
        return $this->date_valide;//récupère la valeur de l'attribut (date_valide)
    }



    /*Méthode pour modifier la valeur de l'attribut (id) */
    public function setId(int $id=0)    {
        $this->id=$id;//Chcange la valeur de l'attribut (id)
    }
    /*Méthode pour modifier la valeur de l'attribut (utilisateur) */
    public function setUser(int $utilisateur=0){
        $this->utilisateur=$utilisateur;//Chcange la valeur de l'attribut (utilisateur)
    }
    /*Méthode pour modifier la valeur de l'attribut (taxi) */
    public function setVaxi(int $taxi=0){
        $this->taxi=$taxi;//Chcange la valeur de l'attribut (taxi)
    }
    /*Méthode pour modifier la valeur de l'attribut (ville) */
    public function setVille(int $ville=0){
        $this->ville=$ville;//Chcange la valeur de l'attribut (ville)
    }
    /*Méthode pour modifier la valeur de l'attribut (service) */
    public function setService(int $service=0){
        $this->service=$service;//Chcange la valeur de l'attribut (service)
    }
    /*Méthode pour modifier la valeur de l'attribut (etat) */
    public function setEtat(int $etat=0){
        $this->etat=$etat;//Chcange la valeur de l'attribut (etat)
    }
    /*Méthode pour modifier la valeur de l'attribut (adresse) */
    public function setAdresse(string $adresse="Kinshasa, Gombe, ISIPA/SHAUMBA, n°451-Bil"){
        $this->adresse=$adresse;//Chcange la valeur de l'attribut (adresse)
    }
    /*Méthode pour modifier la valeur de l'attribut (date_valide) */
    public function setDate(string $date_valide=""){
        $this->date_valide=$date_valide;//Chcange la valeur de l'attribut (date_valide)
    }


     public  function show(int $id=0,bool $all=true){
            /*Méthode pour récupérer une  reservation d'ID passé en paramètre */
          if($id>0){
            $all=false;
          }
            $db_con= $this->str_db;
            $query_string="
                SELECT 
		                reservations.id             AS id_reservation,
		                reservations.date_enre      AS date_reservation,
		                reservations.date_valide    AS date_valide,
		                reservations.etat           AS etat,
		                reservations.adresse        AS localisation,
		                JSON_OBJECT('id_car',voitures.id,'modele_car',voitures.marque,'capacite_car',capacite,'image_car',image,'date_car',date_taxi) AS voiture,
                        JSON_OBJECT('id_user',utilisateurs.id,'nom',utilisateurs.nom,'postnom',utilisateurs.post_nom,'prenom',utilisateurs.prenom,'sexe',utilisateurs.sexe,'num_tel',utilisateurs.num_tel,'adresse',utilisateurs.adresse,'date_enre',utilisateurs.date_enre) AS compte,
		                JSON_OBJECT('id_ville',villes.id,'nom_ville',villes.nom,'date_ville',villes.date_enre) AS destination,
		                JSON_OBJECT('id_service',services.id,'nom_service',services.nom_service,'temps_service',services.duree,'date_service',services.date_service,'prix', montant,'en',devise) as service
                FROM reservations 

                INNER JOIN utilisateurs ON  reservations.utilisateur = utilisateurs.id
                INNER JOIN voitures 	ON	reservations.taxi 		 = voitures.id
                INNER JOIN villes 		ON  reservations.ville		 = villes.id
                INNER JOIN services 	ON	reservations.service	 = services.id
                INNER JOIN tarifs    	ON	reservations.service              = tarifs.service
                WHERE ".($all ? " :id ":" utilisateur = :id");

            $query_param= $all ? 1: $id;//Génère le paramètre pour la requête

            $sql= $db_con->prepare($query_string);
            $car=[];
            try {
                $sql->execute([':id'=>$query_param]);//Exécute la requête dynamiquement

                while($service=$sql->fetch(PDO::FETCH_ASSOC)){

                        $service['id_reservation']  =(int) $service['id_reservation'];//Convertit en Entier 
                        $service['destination']     = json_decode($service['destination']);//Convertit les informations de $service['destination'] en JSON valide
                        $service['service']         = json_decode($service['service']);//Convertit les informations de $service['service'] en JSON valide
                        $service['voiture']         = json_decode($service['voiture']);//Convertit les informations de $service['voiture'] en JSON valide
                        $service['compte']          = json_decode($service['compte']);//Convertit les informations de $service['compte'] en JSON valide

                    $car[]=$service;
                }
            } catch (Exception $ex) { 
                return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
            return $car;
        }
     
    /*Méthode pour enregistrer une  reservation */
        public function save(int $utilisateur=0,int $taxi=0,int $ville=0,int $service=0, string $adresse="Kinshasa, Gombe, ISIPA/SHAUMBA, n°451-Bil",string $date_valide=""){
            /*Méthode pour enregistrer une reservation*/

            $db_con=$this->str_db;//Récupère la connexion
            $sql=$db_con->prepare("INSERT INTO reservations(utilisateur,taxi,ville,service,adresse,date_valide) VALUES (:utilisateur,:taxi,:ville,:service,:adresse,:date_valide)");

            $this->setUser($utilisateur);
            $this->setVaxi($taxi);
            $this->setVille($ville);
            $this->setService($service);
            $this->setAdresse($adresse==""? $this->getAdresse():$adresse);
            $this->setDate($date_valide==""? $this->getDate():$date_valide);

            $params=  [
                ':utilisateur'=>    $this->getUser(),
                ':taxi'=>           $this->getVaxi(),
                ':ville'=>          $this->getVille(),
                ':service'=>        $this->getService(),
                ':adresse'=>        $this->getAdresse(),
                ':date_valide'=>    $this->getDate()
            ];//Les paramètres à exécuter dans la requête

            try {
                if($sql->execute($params)){
                    return ["success"=>true,"message"=> "Reservation faite avec succès"];
                }
            } catch (Exception $ex) {
                    return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
        }
    /*Méthode pour modifier les informations d'une  reservation */
    public function update(array $fields,int $id){//Méthode pour actualiser les informations d'une reservation
            $index =0;
            $response=null;
            $params=[];
            $str="UPDATE reservations SET ";
            foreach ($fields as $key => $value) {
                $params[$index]=$value ;    
                if($index<(count($fields)-1)){
                    $str=$str.' '.$key."=?".", "; 
                } else{
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
                    $response= ["success"=>true,"message"=>"Les informations sur la  reservation ont été actualisées avec succès"];
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
                $sql=$db_con->prepare("DELETE FROM reservations WHERE id =:id");
            try {
                if($sql->execute([':id'=>$id])){
                    return ["success"=>true,"message"=> "Reservation supprimée avec succès"];
                }else{
                    return ["error"=>true,"message"=> "Aucune Reservation ne correspond à votre demande de suppression"];
                }
            } catch (Exception $ex) {
                return ["success"=>true,"message"=> "Reservation supprimée avec succès","info"=>$ex];
            }
        }
}
?>