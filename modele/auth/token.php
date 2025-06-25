<?php
//Classe pour la gestion de Token
require_once ("connexion.php");
class Token{
    public function addToken(string $p_valeur="" ,int $p_user = 0,int $p_interval = 6){
        global $connexion;
    //Méthode pour créer un token
        $update_token=$connexion->prepare("UPDATE tokens SET valide=0 WHERE id_token AND user_id=:p_user");//prépare la requête pour actualiser le token
        if($update_token->execute([":p_user"=>$p_user])){
            //Si la requête passe avec succès
            $save_token=$connexion->prepare("INSERT INTO tokens SET  valeur=:p_valeur, user_id=:p_user, tokens.expire=(DATE_ADD(NOW(),INTERVAL ".$p_interval." HOUR))");//Pour enregistrer un nouveau TOKEN
            $save_token->execute([":p_valeur"=>$p_valeur,":p_user"=>$p_user]);//Exécute la requête

             $query_srt="SELECT
		        	utilisateurs.id,
		        	nom AS  nom,
		        	post_nom AS  post_nom,
		        	prenom AS  prenom,
		        	sexe AS  sexe,
		        	adresse ,
		        	num_tel,
		        	privi,
		        	valeur AS token,
		        	date_enre AS date_inscrit
		        FROM tokens
                INNER JOIN utilisateurs 
                ON utilisateurs.id=tokens.user_id
		        WHERE tokens.user_id=:p_user AND tokens.valide=1  ORDER BY tokens.creation DESC LIMIT 1";

             $get_Token=$connexion->prepare($query_srt);
             $get_Token->execute([":p_user"=>$p_user]);
             $data= $get_Token->fetch(PDO::FETCH_ASSOC);//Récupère les données
             return $data;
        }
    }

    public function verifyToken(string $p_token="" ){//Méthode pour vérifier le Token 
        global $connexion;
        $number_token=$connexion->prepare("SELECT * FROM tokens WHERE valeur=:p_token AND valide=1 ORDER BY creation DESC LIMIT 1");
        $number_token->execute([":p_token"=>$p_token]);
        if($number_token->rowCount()>0){//S'il existe des données
            $query="
                SELECT
		        	1 AS success, 
                    'Token valide' AS message, 
                    (JSON_ARRAY()) AS details,
		        	utilisateurs.id,
		        	nom,
		        	post_nom,
		        	prenom,
		        	sexe,
		        	adresse ,
		        	num_tel,
		        	privi,
		        	valeur AS token,
		        	date_enre AS date_inscrit
		        FROM tokens
                INNER JOIN utilisateurs 
                ON utilisateurs.id=tokens.user_id
		        WHERE tokens.user_id=utilisateurs.id AND tokens.valide=1  ORDER BY tokens.creation DESC LIMIT 1
            ";
            $ex=$connexion->query($query);//Exécute la requête
            $data_token=$ex->fetch(PDO::FETCH_ASSOC);//Récupère toutes les lignes disponibles
            return $data_token;//retourne les données
        }
    }
}

?>