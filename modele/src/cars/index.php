<?php
       header('Access-Control-Allow-Origin: *');//Permet aux serveurs de se connecter sans erreur d'en-tête CORS  
    header('Access-Control-Allow-Credentials: *');//Permet aux serveurs de se connecter sans erreur d'en-tête CORS  
    header('Access-Control-Allow-Methods: GET,POST,DELETE,PATCH');//Permet aux serveurs de se connecter sans erreur d'en-tête CORS  
    header('Access-Control-Allow-Headers:Content-Type,Authorization,X-Requested-With');//Permet aux serveurs de se connecter sans erreur d'en-tête CORS  
 
    echo json_encode($_POST);
    exit;

?>