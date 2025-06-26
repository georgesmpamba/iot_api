<?php

//Fichier pour Stocker les méthode de suppression des ressources.

    /*Suppression d'une équipement par ID */
    $router->addRoute('POST', "/api/devices/delete/{id}", function($id) use($response) {
        $model = new Device();//Crée une instance pour l'équipement

        $data= $model->delete((int) $id);
        $response['key']= "suppression_de_equipement";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    

    /*Suppression d'une Donnée de l'équipement par ID */
    $router->addRoute('POST', "/api/datas/delete/{id}", function($id) use($response) {
        $model = new Data();//Crée une instance pour la Data

        $data= $model->delete((int) $id);
        $response['key']= "suppression_de_donnee";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    
 
    /*Suppression d'un Compte par ID */
    $router->addRoute('POST', "/api/users/delete/{id}", function($id) use($response) {
        
        $model = new User();//Crée une instance pour le User
        $data= $model->delete((int) $id);
        $response['key']= "suppression_de_compte";//
         
        if(isset($data["success"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
?>