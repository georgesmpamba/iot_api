<?php
//fichier de connexion à la base des données
      try {
         $connexion=new PDO("mysql:host=sql311.infinityfree.com:3306;dbname=if0_38958398_taxi_wewatoo", "if0_38958398", "Taxi2025RDC");
        } catch (Exception $th) {
            echo json_encode(["datas"=>["errorAPI"=>"L'accès aux informations est impossible","error"=>"Une erreur interne est survenue","info"=>[]]]);
            exit;
        }

?>