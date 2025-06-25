<?php
//Classe pour gérer les connexion (Authentifications)
$tag= dirname(dirname(__DIR__)).'/api/controllers/connexion.php';//Charge le fichier de connexion à la base des données

require_once $tag;
 
class Auth{
    private $password;
    private $login;
    private $token;
    private $account=NULL;//Stockera les informations du compte

    public function connect(string $login, string $pass) {
        global $connexion;
        //$open= $connexion->prepare("SELECT * FROM utilisateurs WHERE login=:login OR temp=:login LIMIT 1");
        $open= $connexion->prepare("SELECT * FROM utilisateurs WHERE login=:login OR temp=:login LIMIT 1");
        $open->execute([":login"=>$login]);
        
        $user= $open->fetch(PDO::FETCH_ASSOC);
        if($open->rowCount()>0){//Si les informations sont trouvées
            if(password_verify($pass,$user['mdp'])){//si les informations de connexion sont valides
                $this->generateToken();//génère le TOKEN  
                $this->account=[
                    'id'=>(int) ($user['id']),
                    'nom'=> $user['nom'],
                    'post_nom'=> $user['post_nom'],
                    'prenom'=> $user['prenom'],
                    'sexe'=> $user['sexe'],
                    'admin'=> $user['privi']=="a"?true:false,
                    'login'=> $user['login'],
                    'num_tel'=> $user['num_tel'],
                    'adresse'=> $user['adresse'],
                   'token'=>$this->token,
                    'date_enre'=>$user['date_enre']
                 ];
                //Enregistre le Token dans la Base des données
                $saveTkn=$connexion->prepare("CALL proc_add_token(:valeur,:user,:interval)");
                $saveTkn->execute([
                    ':valeur'=>$this->token,
                    ':user'=>(int) $user['id'], 
                    ':interval'=>12
                 ]);
                 return true;
            }
        }
        return false;
    }
    public function validate(string $login, string $pass) {//Cette méthode permet de valider un compte nouvellement créé mais qui n'a pas de login valide
        global $connexion;
        
        $open= $connexion->prepare("SELECT * FROM utilisateurs WHERE temp=:login ORDER BY id DESC LIMIT 1");
        $open->execute([":login"=>$login]);
        
        $user= $open->fetch(PDO::FETCH_ASSOC);
 
        if(password_verify($pass,$user['mdp'])){
            $update_query= $connexion->prepare("UPDATE utilisateurs SET login=LOWER(CONCAT('@',nom,id)), temp='' WHERE id=:id");
            try{
                if($update_query->execute([":id"=>(int) $user['id']])){
                    $open= $connexion->prepare("SELECT * FROM utilisateurs WHERE id=:id ORDER BY id DESC LIMIT 1");
                    $open->execute([":id"=>(int) $user['id']]);
                    $user_final= $open->fetch(PDO::FETCH_ASSOC);
                    
                    $this->account=[
                        'id'=>(int) ($user_final['id']),
                        'nom'=> $user_final['nom'],
                        'post_nom'=> $user_final['post_nom'],
                        'prenom'=> $user_final['prenom'],
                        'sexe'=> $user_final['sexe'],
                        'login'=> $user_final['login'],
                        'admin'=> $user_final['privi']=="a"?true:false,
                        'num_tel'=> $user_final['num_tel'],
                        'adresse'=> $user_final['adresse'],
                        'token'=>$this->generateToken(),
                        'date_enre'=>$user_final['date_enre']
                    ];
                }
            //Enregistre le Token dans la Base des données
            $saveTkn=$connexion->prepare("CALL proc_add_token(:valeur,:user,:interval)");
            $saveTkn->execute([
                ':valeur'=>$this->token,
                ':user'=>(int) $user['id'], 
                ':interval'=>12
             ]);
             return true;//renvoie TRUE si le compte est validé avec succès
            }catch(Exception $e){
                return false;
            }
        }
        return false;
    }
    public function getAccount(){//Méthode pour retourner les informations du compte connecté
        return $this->account;//retourne le compte connecté
    }
    public function verifyToken(string $token=''){
        global $connexion;
        $this->token=$token;//actualise la valeur du Token courant
        $verif = $connexion->prepare("CALL proc_token_verify(:token)");
        $verif->execute([':token'=>$token]);
        $got=$verif->fetch(PDO::FETCH_ASSOC);//récupère les champs
        
        if(isset($got['success']) && (int) $got['success']==1){//Vérifie la validité du Token passé en paramètres
            $data_reponse=[   
                'id'=>(int) ($got['id']),
                'nom'=> $got['nom'],
                'post_nom'=> $got['post_nom'],
                'prenom'=> $got['prenom'],
                'sexe'=> $got['sexe'], 
                'admin'=> $got['privi']=="a"?true:false,
                'num_tel'=> $got['num_tel'],
                'adresse'=> $got['adresse'],
                'token'=>$token
            ];
            $this->account=$data_reponse;//Change les informations du compte
            return true;
        }
            return false;
    }
    private function generateToken(){
        $letters=['A','B','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','0','1','2','3','4','5','6','7','8','9'];
        $token="";
        for ($i=0; $i <255 ; $i++) { 
            $maj=random_int(1,3);
            $n=random_int(0,count($letters)-7);//
            
            $token[0]=$letters[$n];
             if($maj%2==0){
                $token=$token.strtolower($letters[$n]);
            }else{
                $token=$token.( $letters[$n]);
            }
        }
        $this->token=$token;//Assigne la valeur de Token
        return $token;
    }
}
?>