<?php

    $router->addRoute('GET', "/api", function() use($response){
        echo json_encode($response);
        exit;
    });
    $router->addRoute('GET', "/api/src/cars/{id}", function($id) use($response){
        echo json_encode(["car_id"=>$id]);
        exit;
    });

    /*Chargement des communes */
    
    $router->addRoute('GET', "/api/communes", function() use($response) {
        $model = new Commune();//Crée une instance pour la commune
        $data= $model->show();
        $response['key']= "liste_des_communes";
        $response['datas']['content']= $data;
        $response['success']['message']= count($data)>0  ? "Les communes sont chargées avec succès":"Pas commune disponible";//charge les communes
     
        echo json_encode($response);
        exit;
    });
    
    /*Chargement d'une communes par ID */
    $router->addRoute('GET', "/api/communes/{id}", function($id) use($response) {
        $model = new Commune();//Crée une instance pour la commune
        $id=(int) $id;
        $data=$model->show($id);

        $response['key']= "lire_une_communes_par_id";//charge les communes
        $response['datas']['content']= $data;//charge la commune
        $response['success']['message']= count($data)>0  ? "La commune est chargée avec succès":"Pas commune disponible pour votre commande";//charge les communes
        echo json_encode($response);
        exit;
    });
 
    /*Chargement des provinces */
    
    $router->addRoute('GET', "/api/provinces", function() use($response) {
        $model = new Province();//Crée une instance pour la province
        
        $data= $model->show();
        $response['key']= "liste_des_provinces";//
        $response['datas']['content']= $data;//
        $response['success']['message']= count($data)>0  ? "Les provinces sont chargées avec succès":"Pas Province disponible";//charge les provinces
        echo json_encode($response);
        exit;
    });
    
    /*Chargement d'une province par ID */
    $router->addRoute('GET', "/api/provinces/{id}", function($id) use($response) {
        
        $model = new Province();//Crée une instance pour la province
        $id=(int) $id;
        $data=$model->show($id);

        $response['key']= "lire_une_province_par_id";//
        $response['datas']['content']= $data;//
        $response['success']['message']= count($data)>0  ? "La province est chargée avec succès":"Pas de Province disponible pour votre commande";//charge les communes
        echo json_encode($response);
        exit;
    });
 
    /*Chargement des reservations */
    
    $router->addRoute('GET', "/api/reservations", function() use($response) {
        $id_user= isset($_GET['user_id']) ? (int) $_GET['user_id'] : 0;//Récupère l'ID de l'utilisateur
        $model = new Reservation();//Crée une instance pour la reservation
        $data= $model->show($id_user);
        
        $response['key']= "liste_des_reservations";//
        $response['datas']['content']= $data;//
        $response['success']['message']= count($data)>0  ? "Les reservations sont chargées avec succès":"Pas de Reservation disponible";//charge les provinces
        echo json_encode($response);
        exit;
    });
    
    /*Chargement d'une reservation par ID */
    $router->addRoute('GET', "/api/reservations/{id}", function($id) use($response) {
        $model = new Reservation();//Crée une instance pour la reservation
        $id=(int) $id;
        $data=$model->show($id);

        $response['key']= "lire_une_reservations_par_id";//
        $response['datas']['content']= $data;//
        $response['success']['message']= count($data)>0  ? "La reservation est chargée avec succès":"Pas de Reservations disponible pour votre commande";//charge les communes
        echo json_encode($response,true);
        exit;
    });

 
    /*Chargement des services */
    
    $router->addRoute('GET', "/api/services", function() use($response) {
        $model = new Service();//Crée une instance pour le service
        
        $data= $model->show();
      foreach($data as $i=>$d){

      
      
       echo json_encode($d)."<br><br>";
      }exit;
        $response['key']= "liste_des_services";
        $response['datas']['content']= $data;
        $response['success']['message']= count($data)>0  ? "Les services sont chargés avec succès":"Pas de Service disponible";/*charge les provinces*/
     echo var_dump($response);exit;
        echo json_encode($response);
        exit;
    });
    
    /*Chargement d'une service par ID */
    $router->addRoute('GET', "/api/services/{id}", function($id) use($response) {
        $model = new Service();//Crée une instance pour le service
        $id=(int) $id;
        $data=$model->show($id);

        $response['key']= "lire_un_service_par_id";//
        $response['datas']['content']= $data;//
        $response['success']['message']= count($data)>0  ? "Le service est chargé avec succès":"Pas de Service disponible pour votre commande";//charge les communes
        echo json_encode($response);
        exit;
    });

    /*Chargement des tarifs */
    
    $router->addRoute('GET', "/api/tarifs", function() use($response) {
        $model = new Tarif();//Crée une instance pour le tarif
        $data= $model->show();
        $response['key']= "liste_des_tarifs";//
        $response['datas']['content']= $data;//
        $response['success']['message']= count($data)>0  ? "Les tarifs sont chargés avec succès":"Pas de tarif disponible";//charge les provinces
        echo json_encode($response);
        exit;
    });
    
    /*Chargement d'un tarif par ID */
    $router->addRoute('GET', "/api/tarifs/{id}", function($id) use($response) {
        $model = new Tarif();//Crée une instance pour le tarif
        $id=(int) $id;
        $data=$model->show($id);

        $response['key']= "lire_un_tarif_par_id";//
        $response['datas']['content']= $data;//
        $response['success']['message']= count($data)>0  ? "Le tarif est chargé avec succès":"Pas de Tarif disponible pour votre commande";//charge les communes
        echo json_encode($response);
        exit;
    });

    /*Chargement des utilisateurs */
    
    $router->addRoute('GET', "/api/comptes", function() use($response) {
        $model = new Utilisateur();//Crée une instance pour le Utilisateur
        $data= $model->show();
        $response['key']= "liste_des_comptes";//
        $response['datas']['content']= $data;//
        $response['success']['message']= count($data)>0  ? "Les comptes sont chargés avec succès":"Pas de compte disponible";//charge les provinces
        echo json_encode($response);
        exit;
    });
    
    /*Chargement d'un compte par ID */
    $router->addRoute('GET', "/api/comptes/{id}", function($id) use($response) {
        $model = new Utilisateur();//Crée une instance pour le Utilisateur
        $id=(int) $id;
        $data=$model->show($id);

        $response['key']= "lire_un_compte_par_id";//
        $response['datas']['content']= $data;//
        $response['success']['message']= count($data)>0  ? "Le compte est chargé avec succès":"Pas de compte disponible pour votre commande";//charge les communes
        echo json_encode($response);
        exit;
    });

    /*Chargement des villes */
    
    $router->addRoute('GET', "/api/villes", function() use($response) {
        $model = new Ville();//Crée une instance pour la Ville
        $data= $model->show();
        $response['key']= "liste_des_villes";//
        $response['datas']['content']= $data;//
        $response['success']['message']= count($data)>0  ? "Les villes sont chargées avec succès":"Pas de ville disponible";//charge les provinces
        echo json_encode($response);
        exit;
    });
    
    /*Chargement d'une ville par ID */
    $router->addRoute('GET', "/api/villes/{id}", function($id) use($response) {
        $model = new Ville();//Crée une instance pour le Ville
        $id=(int) $id;
        $data=$model->show($id);

        $response['key']= "lire_un_ville_par_id";//
        $response['datas']['content']= $data;//
        $response['success']['message']= count($data)>0  ? "La ville est chargée avec succès":"Pas de ville disponible pour votre commande";//charge les communes
        echo json_encode($response);
        exit;
    });

    /*Chargement des voitures */
    
    $router->addRoute('GET', "/api/voitures", function() use($response) {
        $model = new Voiture();//Crée une instance pour la Voiture
        $data= $model->show();
        $response['key']= "liste_des_voitures";//
        $response['datas']['content']= $data;//
        $response['success']['message']= count($data)>0  ? "Les voitures sont chargées avec succès":"Pas de voiture disponible";//charge les provinces
        echo json_encode($response);
        exit;
    });
    
    /*Chargement d'une voiture par ID */
    $router->addRoute('GET', "/api/voitures/{id}", function($id) use($response) {
        $model = new Voiture();//Crée une instance pour le Voiture
        $id=(int) $id;
        $data=$model->show($id);

        $response['key']= "lire_un_voiture_par_id";//
        $response['datas']['content']= $data;//
        $response['success']['message']= count($data)>0  ? "La voiture est chargée avec succès":"Pas de voiture disponible pour votre commande";//charge les communes
        echo json_encode($response);
        exit;
    });
 ?>