<?php

//Fichier pour Stocker les méthode de suppression des ressources.

    /*Suppression d'une communes par ID */
    $router->addRoute('POST', "/api/communes/delete/{id}", function($id) use($response) {
        $model = new Commune();//Crée une instance pour la commune

        $data= $model->delete((int) $id);
        $response['key']= "suppression_de_commune";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    

    /*Suppression d'une province par ID */
    $router->addRoute('POST', "/api/provinces/delete/{id}", function($id) use($response) {
        $model = new Province();//Crée une instance pour la province

        $data= $model->delete((int) $id);
        $response['key']= "suppression_de_province";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    
 
    /*Suppression d'une reservation par ID */
    $router->addRoute('POST', "/api/reservations/delete/{id}", function($id) use($response) {
        $model = new Reservation();//Crée une instance pour la province

        $data= $model->delete((int) $id);
        $response['key']= "suppression_de_reservation";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });


    /*Suppression d'un Service par ID */
    $router->addRoute('POST', "/api/services/delete/{id}", function($id) use($response) {
        $model = new Service();//Crée une instance pour le Service

        $data= $model->delete((int) $id);
        $response['key']= "suppression_de_service";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
         echo json_encode($response);
        exit;
    });

    /*Suppression d'un Tarif par ID */
    $router->addRoute('POST', "/api/tarifs/delete/{id}", function($id) use($response) {
        $model = new Tarif();//Crée une instance pour le Tarif
 
        $data= $model->delete((int) $id);
        $response['key']= "suppression_de_tarif";//
         
        if(isset($data["success"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
         echo json_encode($response);
        exit;
    });

    /*Suppression d'un Compte par ID */
    $router->addRoute('POST', "/api/comptes/delete/{id}", function($id) use($response) {
        /*echo "delete user here from api ${id}";
        //echo json_encode($_POST);
        
        exit ;*/
        $model = new Utilisateur();//Crée une instance pour le Tarif
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


    /*Suppression d'un Ville par ID */
    $router->addRoute('POST', "/api/villes/delete/{id}", function($id) use($response) {
        $model = new Ville();//Crée une instance pour le Ville
        $data= $model->delete((int) $id);
        $response['key']= "suppression_de_ville";//
         
        if(isset($data["success"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });

    /*Suppression d'un Ville par ID */
    $router->addRoute('POST', "/api/voitures/delete/{id}", function($id) use($response) {
        $model = new Voiture();//Crée une instance pour le Voiture
 
        $data= $model->delete((int) $id);
        $response['key']= "suppression_de_voiture";//
         
        if(isset($data["success"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });

?>