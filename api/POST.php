<?php
//Fichier pour Stocker les méthode de Création et Modification des ressources.
    

    /*Création d'une infomation depuis un équipement */
    $router->addRoute('POST', "/api/datas/add", function() use($response,$token_key) {
        $model = new Data();//Crée une instance pour le Voiture
        /**Charge les données venant du client*/
         
        $content=isset($_POST['content']) ? json_decode(htmlspecialchars($_POST['content'])) : ["hum"=>50, "mac"=>"00:00:00:00:00:00:00:00","temp"=>25];
         
        $data= $model->save($content);
        $response['key']= "creation_de_data";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    
    /*Modification d'une data par ID */
    $router->addRoute('POST', "/api/datas/{id}", function($id) use($response,$token_key) {
        $model = new Data();//Crée une instance pour le data
        $params=[];//stocke la liste des données à modifier

            if(isset($_POST['content'])){$params['content_dev']= ($_POST['content']);}
            if(isset($_POST['device'])){$params['id_dev']=(int) htmlspecialchars(trim($_POST['device']));}
             
        $data= $model->update($params,(int) $id);
        $response['key']= "modification_de_donnee";//
         
        if(isset($data["success"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });

    /*Création d'un équipement */
    $router->addRoute('POST', "/api/devices/add", function() use($response,$token_key) {
        $model = new Device();//Crée une instance pour le Voiture
        /*Charge les données venant du client*/
            $modele_dev  = isset($_POST['modele']) ? htmlspecialchars(trim($_POST['modele'])) : "" ; 
            $mac_dev     = isset($_POST['mac']) ?    htmlspecialchars(trim($_POST['mac'])) : "" ; 
            $proprio_dev = isset($_POST['proprio']) ? (int) htmlspecialchars($_POST['proprio']) : 0 ; 

        $data= $model->save($modele_dev,$mac_dev,$proprio_dev);//Enregistre l'équipement 
        $response['key']= "creation_de_device";//
         
        if(isset($data["success"],$data["message"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
    
    /*Modification d'un équipement par ID */
    $router->addRoute('POST', "/api/devices/{id}", function($id) use($response,$token_key) {
        $model = new Device();//Crée une instance pour l'équipement
        $params=[];//stocke la liste des données à modifier

        if(isset($_POST['modele'])){   $params['modele_dev'] = htmlspecialchars(trim($_POST['modele'])); }
        if(isset($_POST['mac'])){  $params['mac_dev'] = htmlspecialchars(trim($_POST['mac'])); }
        if(isset($_POST['proprio'])){  $params['proprio_dev'] =(int) htmlspecialchars(trim($_POST['proprio'])); }

        $data= $model->update($params,(int) $id);
        $response['key']= "modification_de_equipement";//
         
        if(isset($data["success"])){//si la requête passe avec succès
            $response['success']=$data;
        }else{
            $response['error']=$data;
        }
        echo json_encode($response);
        exit;
    });
?>