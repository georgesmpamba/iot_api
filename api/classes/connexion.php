<?php
//fichier de connexion à la base des données
      try {
         $connexion=new PDO("mysql:host=localhost:3306;dbname=iot_inc", "root", "");
        } catch (Exception $th) {
            echo json_encode(["datas"=>["errorAPI"=>"L'accès aux informations est impossible","error"=>$th,"info"=>[$this->user_name,$this->password,$this->db_name,$this->host]]]);
            exit;
        }
?>