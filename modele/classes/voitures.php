<?php
    require_once 'connexion.php';//Charge le fichier de connexion à la base des donées
    class Voiture{
        private int $id ;
        private int $capacite ;
        private string $marque ;
        private string $image ;
        private string $date_taxi ;
        private $str_db;//Stockera les informations sur l'objet PDO de connexion à la base des données
        
        public function __construct(){
            global $connexion;//Expose la valeur de $connexion dans la méthode
            $this->str_db = $connexion;//initialise la valeur de ($id)
            $this->id = 0;//initialise la valeur de ($id)
            $this->capacite = 8;//initialise la valeur de ($capacite)
            $this->marque = "HYUNDAI";//initialise la valeur de ($marque)
            $this->image = "hyundai.jpg";//initialise la valeur de ($image)
        }
        public function show(int $id=0,bool $all=true){
            /*Méthode pour récupérer une voiture d'ID passé en paramètre */

            if($id>0){
                $all=false;
            }
            $db_con= $this->str_db;
            $sql= $db_con->prepare($all ? "SELECT * FROM voitures WHERE :id" : "SELECT * FROM voitures WHERE id=:id" );
            $car=[];

            try {
                $sql->execute([':id'=>$all ? 1: $id]);//Exécute la requête dynamiquement
                while($voiture=$sql->fetch(PDO::FETCH_ASSOC)){
                    $voiture['id']=(int) $voiture['id'];
                    $voiture['dispo']=$voiture['dispo']=="1" ? true:false;
                    $voiture['capacite']=(int) $voiture['capacite'];
                    $car[]=$voiture;
                }
            } catch (Exception $ex) { 
                return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }

            return $car;
        }
        public function update(array $fields,int $id,$datas=[]){//Méthode pour actualiser les informations d'une voiture
            global $connexion;
            $index =0;
            $response=null;
            $params=[];
            $str="UPDATE voitures SET ";
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
            $req= $connexion ->prepare($str);
            try{
                if($req->execute($params)){
                    $response= ["success"=>true,"message"=>"Les informations sur la voiture ont été actualisées avec succès"];
             }
            }catch(Exception $ex){
               $response= ["error"=>$ex];
            }
            return $response;
        }
        public  function getId(){
            return $this->id;
        }
        public  function getCapacite(){
            return $this->capacite;
        }
        public  function getMarque(){
            return $this->marque;
        }
        public  function getImage(){
            return $this->image;
        }
        public  function getDate(){
            return $this->date_taxi;
        }


        public  function setCapacite($capacite){//Méthode pour la valeur de ($capacite) pour la classe
            $this->capacite=$capacite;//Définit la valeur de l'attribut($capacite)
        }
        public  function setMarque($marque){//Méthode pour la valeur de ($marque) pour la classe
            $this->marque=$marque;//Définit la valeur de l'attribut($marque)
        }
        public  function setImage($image){//Méthode pour la valeur de ($image) pour la classe
            $this->image=$image;//Définit la valeur de l'attribut($image)
        } 

        public function saveImage(string $old_image,array $photo): string{ //Méthode pour enregistrer l'image d'une voiture
            $name=$old_image;//nom de l'image par défaut sera celui existant
            if(isset($photo['photo']) && count($photo['photo'])){ //Change le nom du fichier si un fichier est passé
                $extension=explode("/",$photo['photo']['type']['file'])[1];//extension du fichier récu
                $temp_folder=$photo['photo']['tmp_name']['file'];//Chemin temporaire du fichier récu
                $path= dirname(dirname((__DIR__)))."/src/cars/";//Dossier dans lequel sera enregistré l'image
                $name= "car_".date('YmdHmiuv').'.'.($extension);//génère un nom pour l'image
                $destination=$path.$name;//unit les chaînes pour faire un nom de destination

                if(move_uploaded_file($temp_folder,$destination)){//Permet de tranférer le fichier dans le répertoire de destination
                    if(file_exists($path.$old_image) && unlink($path.$old_image) && (strtolower($old_image)!="image.png")){//vérifie si le fichier existe dans le répertoire
                        //$destination="Envoyé avec succès. Suppression faite aussi";
                    }
                }
            }
            return $name;//retourne le nom du fichier qui sera enregistré
        }
        public function save($capacite=18, $marque="Bus HYUNDAI", $image="hyundai.jpg"){
            /*Méthode pour enregistrer une voiture*/
            $db_con=$this->str_db;//Récupère la connexion
            $sql=$db_con->prepare("INSERT INTO voitures(capacite, marque, image) VALUES (:capacite, :marque, :image)");
    
            try {
                if($sql->execute([':capacite'=>$capacite,':marque'=>$marque,':image'=>$image])){
                    return ["success"=>true,"message"=> "Véhicule ajouté avec succès"];
                };
            } catch (Exception $ex) {
                return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
        }
 
        public function delete(int $id=0){
            /*Méthode pour supprimer une voiture*/
                $db_con=$this->str_db;//Récupère la connexion
                $sql=$db_con->prepare("DELETE FROM voitures WHERE id =:id");
            try {
                if($sql->execute([':id'=>$id])){ 
                    return ["success"=>true,"message"=> "Véhicule supprimé avec succès"];
                }else{
                    return ["error"=>true,"message"=> "Aucun Véhicule ne correspond à votre demande de suppression"];
                }
            } catch (Exception $ex) {
                return ["success"=>true,"message"=> "Véhicule supprimé avec succès","info"=>$ex];
            }
        }

    }
?>