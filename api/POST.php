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
        /**Charge les données venant du client*/
         
                $modele_dev  = isset($_POST['modele_dev']) ? htmlspecialchars(trim($_POST['modele_dev'])) : "" ; 
                $mac_dev     = isset($_POST['mac_dev']) ?    htmlspecialchars(trim($_POST['mac_dev'])) : "" ; 
                $proprio_dev = isset($_POST['proprio_dev']) ? (int) htmlspecialchars($_POST['proprio_dev']) : 0 ; 

                $content= [];//Contenus à enregistrer dans la base des données

        $data= $model->save($nom,$data);
        $response['key']= "creation_de_data";//
         
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
        $model = new Device();//Crée une instance pour le data
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


    
?>