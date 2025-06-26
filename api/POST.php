<?php
//Fichier pour Stocker les méthode de Création et Modification des ressources.
    
    /*Création d'un commune */
    
    $router->addRoute('POST', "/api/communes/add", function() use($response,$token_key) {
        $model = new Commune();//Crée une instance pour la commune
        /**Charge les données venant du client*/
        $nom   = isset($_POST['nom'])  ? htmlspecialchars($_POST['nom']): "Nouvelle commune";
        $ville = isset($_POST['ville'])?(int) htmlspecialchars($_POST['ville']): 0;

        $data= $model->save($nom,$ville);
        $response['key']= "creation_de_commune";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    
    /*Modification d'une communes par ID */
    $router->addRoute('POST', "/api/communes/{id}", function($id) use($response,$token_key) {
        $model = new Commune();//Crée une instance pour la commune
        $params=[];//stocke la liste des données à modifier
        if(isset($_POST['nom'])){
            $params['nom']=htmlspecialchars($_POST['nom']);
        }
        if(isset($_POST['ville'])){
            $params['ville']=(int) htmlspecialchars($_POST['ville']);
        } 

        $data= $model->update($params,(int) $id);
        $response['key']= "modification_de_commune";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    
    
    /*Création d'un province */
    $router->addRoute('POST', "/api/provinces/add", function() use($response,$token_key) {
        $model = new Province();//Crée une instance pour la province
        /**Charge les données venant du client*/
        $nom   = isset($_POST['nom'])  ? htmlspecialchars($_POST['nom']): "Nouvelle Province Automatique";
 
        $data= $model->save($nom);
        $response['key']= "creation_de_province";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    
    /*Modification d'une province par ID */
    $router->addRoute('POST', "/api/provinces/{id}", function($id) use($response,$token_key) {
        $model = new Province();//Crée une instance pour la province
        $params=[];//stocke la liste des données à modifier
        if(isset($_POST['nom'])){
            $params['nom']=htmlspecialchars($_POST['nom']);
        }
        $data= $model->update($params,(int) $id);
        $response['key']= "modification_de_province";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });

    /*Création d'une reservation */
    $router->addRoute('POST', "/api/reservations/add", function() use($response,$user_data,$token_key,$auth) {
        $model = new Reservation();//Crée une instance pour la reservation
        /**Charge les données venant du client*/
        if($auth->verifyToken($token_key)){//valide le compte
            $user_data=$auth->getAccount();//Ajoute les données du compte
        }


        $utilisateur= isset($user_data['id']) ? (int) ($user_data['id']) : 0 ;
        $taxi= isset($_POST['taxi']) ? (int) htmlspecialchars($_POST['taxi']) : 0 ;
        $ville= isset($_POST['ville']) ? (int) htmlspecialchars($_POST['ville']) : 0 ;
        $service= isset($_POST['service']) ? (int) htmlspecialchars($_POST['service']) : 0 ;
        $adresse= isset($_POST['adresse']) ? htmlspecialchars($_POST['adresse']) : "Kinshasa, Gombe, ISIPA/SHAUMBA, n°451-Bil" ;
        $date_valide= isset($_POST['date_valide']) ?  htmlspecialchars($_POST['date_valide']) : date("Y-m-d H:m:i");
        
        $data= $model->save($utilisateur,$taxi,$ville,$service,$adresse,$date_valide);
        $response['key']= "creation_de_reservation";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    
    /*Modification d'une reservation par ID */
    $router->addRoute('POST', "/api/reservations/{id}", function($id) use($response,$token_key) {
        $model = new Reservation();//Crée une instance pour la province
        $params=[];//stocke la liste des données à modifier
       
        if(isset($_POST['etat'])){
            $params['etat']=(int) htmlspecialchars($_POST['etat']);//récupère la valeur de (etat) depuis le client
        }
        if(isset($_POST['date_valide'])){
            $params['date_valide']=htmlspecialchars($_POST['date_valide']);//récupère la valeur de (date_valide) depuis le client
        }

        $data= $model->update($params,(int) $id);
        $response['key']= "modification_de_reservation";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });



    /*Création d'un Service */
    $router->addRoute('POST', "/api/services/add", function() use($response,$token_key) {
        $model = new Service();//Crée une instance pour le service
        /**Charge les données venant du client*/
 
        $duree= isset($_POST['duree']) ?(int) htmlspecialchars($_POST['duree']) : 4 ;
        $nom= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : "Déplacement Simple" ;
        $sorte= isset($_POST['sorte']) ? htmlspecialchars($_POST['sorte']) : "Transport personnel" ;
         
        $data= $model->save($nom,$duree,$sorte);
        $response['key']= "creation_de_service";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    
    /*Modification d'un Service par ID */
    $router->addRoute('POST', "/api/services/{id}", function($id) use($response,$token_key) {
        $model = new Service();//Crée une instance pour le Service
        $params=[];//stocke la liste des données à modifier

        if(isset($_POST['nom'])){
            $params['nom_service']= trim(htmlspecialchars($_POST['nom']));//récupère la valeur de (etanom_service) depuis le client
        }
        if(isset($_POST['sorte'])){
            $params['sorte']=trim(htmlspecialchars($_POST['sorte']));//récupère la valeur de (date_valide) depuis le client
        }
        if(isset($_POST['duree'])){
            $params['duree']=(int) htmlspecialchars($_POST['duree']);//récupère la valeur de (date_valide) depuis le client
        }

        $data= $model->update($params,(int) $id);
        $response['key']= "modification_de_service";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });

    /*Création d'un Tarif */
    $router->addRoute('POST', "/api/tarifs/add", function() use($response,$token_key) {
        $model = new Tarif();//Crée une instance pour le Tarif

        /**Charge les données venant du client*/

        $montant= isset($_POST['montant']) ?(int) htmlspecialchars($_POST['montant']) : 1500 ;
        $devise= isset($_POST['devise']) ? htmlspecialchars($_POST['devise']) : "FC" ;
        $service= isset($_POST['service']) ? (int) htmlspecialchars($_POST['service']) : 0;

        $data= $model->save($montant,$devise,$service);
        $response['key']= "creation_de_tarif";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    
    /*Modification d'un Tarif par ID */
    $router->addRoute('POST', "/api/tarifs/{id}", function($id) use($response,$token_key) {
        $model = new Tarif();//Crée une instance pour le Tarif
        $params=[];//stocke la liste des données à modifier
       
        if(isset($_POST['montant'])){
            $params['montant']=(int) trim(htmlspecialchars($_POST['montant']));//récupère la valeur de (montant) depuis le client
        }
        if(isset($_POST['devise'])){
            $params['devise']=trim(htmlspecialchars($_POST['devise']));//récupère la valeur de (devise) depuis le client
        }
        if(isset($_POST['service'])){
            $params['service']=(int) htmlspecialchars($_POST['service']);//récupère la valeur de (date_valide) depuis le client
        }
        $data= $model->update($params,(int) $id);
        $response['key']= "modification_de_tarif";//
         
        if(isset($data["success"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });


    /*Création d'un Compte */
    $router->addRoute('POST', "/api/comptes/add", function() use($response,$token_key,$auth) {
        $model = new Utilisateur();//Crée une instance pour le Utilisateur
        /**Charge les données venant du client*/
       
        $mdp=isset($_POST['mdp']) ? htmlspecialchars($_POST['mdp']) : "1234";
        $mdp_conf=isset($_POST['mdp_conf']) ? htmlspecialchars($_POST['mdp_conf']) : "";

        if($mdp!=$mdp_conf){
            $response['key']= "echec_creation_de_compte_mot_de_passe_different";//
            $response['error']=["type"=>"Mots de pass différents","message"=>"Les mots de passe ne correspondent pas","info"=>"Corrigez vos mots de paase"];
            echo json_encode($response);
            exit;
        }
        $temp_login=session_id();//Le Login temporaire du compte
        $nom=isset($_POST['nom']) ? trim(htmlspecialchars($_POST['nom'])) : "";
        $post_nom=isset($_POST['post_nom']) ? trim(htmlspecialchars($_POST['post_nom'])) : "";
        $prenom=isset($_POST['prenom']) ? trim(htmlspecialchars($_POST['prenom'])) : "";
        $sexe=isset($_POST['sexe']) ? trim(htmlspecialchars($_POST['sexe'])) : "Masculin";
        $num_tel=isset($_POST['num_tel']) ? trim(htmlspecialchars($_POST['num_tel'])) : "";
        $adresse=isset($_POST['adresse']) ? trim(htmlspecialchars($_POST['adresse'])) : "";

        $data= $model->save($nom,$post_nom,$prenom,$sexe,$num_tel,$adresse,$mdp,$temp_login);
        if($auth->validate($temp_login,$mdp)){//valide le compte
            $response['compte']=$auth->getAccount();//Ajoute les données du compte dans les réponses à renvoyer au client
        }
        $response['key']= "creation_de_compte";//
        $response['token']= session_id();//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    
    /*Modification d'un Compte par ID */
    $router->addRoute('POST', "/api/comptes/{id}", function($id) use($response,$token_key) {
        $model = new Utilisateur();//Crée une instance pour le Tarif
        $params=[];//stocke la liste des données à modifier
        
        
            if(isset($_POST['nom'])){$params['nom']= htmlspecialchars(trim($_POST['nom']));}
            if(isset($_POST['post_nom'])){$params['post_nom']= htmlspecialchars(trim($_POST['post_nom']));}
            if(isset($_POST['prenom'])){$params['prenom']= htmlspecialchars(trim($_POST['prenom']));}
            if(isset($_POST['sexe'])){$params['sexe']= htmlspecialchars(trim($_POST['sexe']));}
            if(isset($_POST['num_tel'])){$params['num_tel']= htmlspecialchars(trim($_POST['num_tel']));}
            if(isset($_POST['adresse'])){$params['adresse']= htmlspecialchars(trim($_POST['adresse']));}

        $data= $model->update($params,(int) $id);
        $response['key']= "modification_de_compte";//
         
        if(isset($data["success"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });


    /*Création d'une Province */
    $router->addRoute('POST', "/api/villes/add", function() use($response,$token_key) {
        $model = new Ville();//Crée une instance pour le Voiture
        /**Charge les données venant du client*/
         
        $nom=isset($_POST['nom']) ? trim(htmlspecialchars($_POST['nom'])) : "";
        $ville=isset($_POST['province']) ?(int) trim(htmlspecialchars($_POST['province'])) : 0; 

        $data= $model->save($nom,$ville);
        $response['key']= "creation_de_ville";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    
    /*Modification d'un Ville par ID */
    $router->addRoute('POST', "/api/villes/{id}", function($id) use($response,$token_key) {
        $model = new Ville();//Crée une instance pour le Ville
        $params=[];//stocke la liste des données à modifier

            if(isset($_POST['nom'])){$params['nom']= htmlspecialchars(trim($_POST['nom']));}
            if(isset($_POST['province'])){$params['province']=(int) htmlspecialchars(trim($_POST['province']));}
             
        $data= $model->update($params,(int) $id);
        $response['key']= "modification_de_ville";//
         
        if(isset($data["success"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });


    /*Création d'une Voiture */
    $router->addRoute('POST', "/api/voitures/add", function() use($response,$token_key) {
        $model = new Voiture();//Crée une instance pour le Voiture
        /**Charge les données venant du client*/
 
        $image_from_client   = isset($_POST['image']) && $_POST['image']!=null    ?       htmlspecialchars(trim($_POST['image'])) : "image.png";
        $image               = $model->saveImage($image_from_client,$_FILES);
        
        $capacite   = isset($_POST['capacite']) ?(int)  htmlspecialchars(trim($_POST['capacite'])) : 4;
        $marque     = isset($_POST['marque'])   ?       htmlspecialchars(trim($_POST['marque'])) : "Range Rover 2018";
        $data= $model->save($capacite,$marque,$image);
        $response['key']= "creation_de_voiture";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    
    /*Modification d'un Ville par ID */
    $router->addRoute('POST', "/api/voitures/{id}", function($id) use($response,$token_key) {
        $model = new Voiture();//Crée une instance pour le Voiture
        $params=[];//stocke la liste des données à modifier

            $image_from_client     = isset($_POST['image']) && $_POST['image']!=null    ?     htmlspecialchars(trim($_POST['image'])) : "image.png";
        
            if(isset($_POST['capacite'])){$params['capacite'] =(int) htmlspecialchars($_POST['capacite']);}
            if(isset($_POST['marque'])){$params['marque']     =      htmlspecialchars($_POST['marque']);}

            if(count($_FILES)){//Si la photo existe
                $params['image']=$model->saveImage($image_from_client,$_FILES);//génère le nom du fichier
            }
             
        $data= $model->update($params,(int) $id);
        $response['key']= "modification_de_voiture";//
         
        if(isset($data["success"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }

        echo json_encode($response);
        exit;
    });
?>