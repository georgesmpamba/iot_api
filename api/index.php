<?php
    session_start();//Démarre une session
    header('Access-Control-Allow-Origin: *');//Permet aux serveurs de se connecter sans erreur d'en-tête CORS  
    header('Access-Control-Allow-Credentials: *');//Permet aux serveurs de se connecter sans erreur d'en-tête CORS  
    header('Access-Control-Allow-Methods: GET,POST,DELETE,PATCH');//Permet aux serveurs de se connecter sans erreur d'en-tête CORS  
    header('Access-Control-Allow-Headers:Content-Type,Authorization,X-Requested-With,*');//Permet aux serveurs de se connecter sans erreur d'en-tête CORS  
     
//Tableau des liens qui ne nécessitent pas le TOKEN pour y accéder
    $exclude= ["/api/auth/connexion","/api/auth/deconnexion","/api/comptes/add"];

    /*Début du bloc pour la récupération des URL*/
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if($uri[strlen($uri)-1] =="/"){
       $uri= substr($uri,0,(strlen($uri)-1));//supprime le dernier de l'URL si ça existe
    }
    
    /*Fin du bloc pour la récupération des URL*/


   // $header= apache_request_headers();
    

/**Chargement des fichiers de dépendances */

    $link='auth/authentification.php'; 

    require_once 'router/Router.php';
    require_once 'classes/communes.php';
    require_once 'classes/provinces.php';
    require_once 'classes/reservations.php';
    require_once 'classes/services.php';
    require_once 'classes/tarifs.php';
    require_once 'classes/utilisateurs.php';
    require_once 'classes/villes.php';
    require_once 'classes/voitures.php';
   
    require_once $link;//Charge le module d'authentification

    $router=new Router();

    $response=[ 
        "key"=>"page_principale_pour_API"
    ];

    $user= 0;//ID de l'utilisateur
    $user_data=null ;//Données de l'utilisateur

   // $header= apache_request_headers();
    $token_key='';//Stockera le Token

    /*
    if(isset($header['Authorization'])){
      $token_key=$header['Authorization'];//Récupère le Token s'il existe
    }  */
    
    if(isset($_GET['api_key'])){
      $token_key=$_GET['api_key'];//Récupère le Token s'il existe
        /*echo "'api_key' ${token_key}";
      exit;*/
    }  
    if(isset($_POST['token'])){
      $token_key=$_POST['token'];//Récupère le Token s'il existe
    }  
    $auth= new Auth();//créee une instance d'Authentification 
 
    require_once 'DELETE.php';//Charge le fichier pour les requêtes DELETE
    require_once 'GET.php';//Charge le fichier pour les requêtes GET
    require_once 'POST.php';//Charge le fichier pour les requêtes POST

//pour validation de TOKEN
/*Cette partie bloque l'exécution de la suite du code, car il faut que le compte soit authentique */

try{ 
    if(in_array($uri,$exclude) || $method=='GET'){//Vérifie si la Méthode est GET ou bien le lien saisi est parmi ceux qu'il faut laisser passer sans vérifier
         $router->addRoute('POST', "/api/auth/connexion", function() use($response,$auth,$token_key) {//Pour se connecter
                 /**Charge les données venant du client*/
                $user_data=null;//Récupèrera les informations 
                $login  = isset($_POST['login'])  ? htmlspecialchars($_POST['login'])   : "";
                $mdp    = isset($_POST['mdp'])    ? htmlspecialchars($_POST['mdp'])     : "";
                    
                if($auth->connect($login,$mdp)){//vérifie si la connexion a réussi
                    $user_data = $auth->getAccount();//Récupère les informations du compte
                    $token_key = $user_data['token'];//spécifie la nouvelle valeur du TOKEN
                }
                echo json_encode(["compte"=>$user_data]);
                exit;//stope le script
        });  
    } else{
        if(!$auth->verifyToken($token_key)){//Gestion en cas de TOKEN invalide
          
            echo json_encode(["error"=>"Votre compte n'est pas valide, veuillez vous connecter","info"=>["message"=>"Connectez-vous pour avoir un jéton valide"]]);
            exit;
        }
          $user_data = $auth->getAccount();//Récupère les informations du compte
    }
    
    }
    catch(Exception $e){
        echo json_encode(["message"=>"Exception trouvée : ","error"=>$e]);
        exit;
    }
 
   // Dissipe les routes sur la page principale
     $router->dispatch($method, $uri);
?>