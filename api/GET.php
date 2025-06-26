<?php

    $router->addRoute('GET', "/api", function() use($response){
        //racine de l'API
        echo json_encode($response);
        exit;
    });

    /*Chargement des données */    
    $router->addRoute('GET', "/api/datas", function() use($response) {
        $model = new Data();//Crée une instance pour la donnée
        $data= $model->show();
        $response['key']= "liste_des_donnees";
        $response['datas']['content']= $data;
        $response['success']['message']= count($data)>0  ? "Les données sont chargées avec succès":"Pas donnée disponible";//charge les données
     
        echo json_encode($response);
        exit;
    });
    
    /*Chargement d'une donnée par ID */
    $router->addRoute('GET', "/api/datas/{id}", function($id) use($response) {
        $model = new Data();//Crée une instance pour la donnée
        $id=(int) $id;
        $data=$model->show($id);

        $response['key']= "lire_une_donnee_par_id";//charge les données
        $response['datas']['content']= $data;//charge la donnée
        $response['success']['message']= count($data)>0  ? "La donnée est chargée avec succès":"Pas donnée disponible";//charge les données
        echo json_encode($response);
        exit;
    });

    /*Chargement des USERS */    
    $router->addRoute('GET', "/api/users", function() use($response) {
        $model = new User();//Crée une instance pour User
        $data= $model->show();
        $response['key']= "liste_des_utilisateurs";
        $response['datas']['content']= $data;
        $response['success']['message']= count($data)>0  ? "Les utilisateurs sont chargés avec succès":"Pas de compte disponible";//charge les données
     
        echo json_encode($response);
        exit;
    });
    
    /*Chargement d'un compte Utilisateur par ID */
    $router->addRoute('GET', "/api/users/{id}", function($id) use($response) {
        $model = new User();//Crée une instance pour User
        $id=(int) $id;
        $data=$model->show($id);

        $response['key']= "lire_un_utilisateur_par_id";//charge les données
        $response['datas']['content']= $data;//charge le user
        $response['success']['message']= count($data)>0  ? "Le compte a été chargé avec succès":"Pas compte disponible";//charge les données
        echo json_encode($response);
        exit;
    });

 ?>