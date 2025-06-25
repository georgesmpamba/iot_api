<?php
/*Classe pour gérer un Utilisateur */
require_once 'connexion.php';
class Utilisateur{
    private $liste_noms;
    private $liste_prenoms;
    
    private $id;
    
    private $nom;
    private $post_nom;
    private $prenom;
    private $sexe;
    private $num_tel;
    private $adresse;

    private $date_enre;
    private $str_db;
    function __construct(){
        global $connexion;
            $this->liste_noms= ['Ilunga','Ngoy','Kasongo','Banza','Ntumba','Mujinga','Ngalula','Nkulu','Kyungu','Ngoie','Kapinga','Mbuyi','Mwamba','Mutombo','Kazadi','Mbombo','Kalenga','Monga','Mputu','Mbuyu','Umba','Numbi','Mukalay','Tshibola','Kayembe','Kanku','Banze','Kabange','Mumba','Kabamba','Nzuzi','Mbayo','Kisimba','Bahati','Ngalamulume','Nsenga','Kabeya','Nlandu','Nsimba','Ngoyi','Nyembo','Yumba','Maloba','Kabongo','Kalala','Misenga','Mbumba','Furaha','Muamba','Kongolo','Mwilambwe','Mulumba','Kakudji','Kabulo','Kalunga','Kabila','Ngombe','Kayumba','Mbuya','Matondo','Mwanza','Ngoma','Mande','Masengo','Mukendi','Tshibuabua','Kitenge','Tsimba','Mulongo','Fatuma','Beya','Mwepu','Ngandu','Mboyo','Lunda','Nkongolo','Sifa','Muteba','Mwape','Feza','Nsimire','Mpanga','Tshimanga','Kalombo','Muzinga','Ngongo','Lenge','Kishimba','Mwange','Mwenze','Milolo','Ndala','Safi','Tshibangu','Nyota','Nday','Kabwe','Amisi','Kapya','Lelo','Mwema','Kunda','Kalonda','Tambwe','Makonga','Lusamba','Faida','Kalumba','Ntambue','Kabemba','Muanda','Malu','Phemba','Lukadi','Mulamba','Kabasele','Kiluba','Badibanga','Meta','Mushiya','Ramazani','Tshiela','Nzigire','Mapendo','Kumwimba','Mbala','Bondo','Ngoya','Kalumbu','Ndaya','Kasonga','Masangu','Samba','Kamwanya','Vumilia','Kayombo','Malonda','Bilonda','Mutonkole','Khonde','Kalonji','Nabintu','Odia','Mawazo','Kaj','Neema','Sango','Kashala','Mwayuma','Byamungu','Ndongo','Mwelwa','Kabuya','Mambwe','Musau','Omba','Kabedi','Kitwa','Yav','Mwadi','Mpoyo','Kabunda','Mangaza','Bukasa','Kibwe','Mabiala','Kamona','Seya','Kalamba','Nzau','Mamba','Muanza','Bipendu','Kamba','Ngolela','Kabala','Kahilu','Kalume','Kalanga','Bolumbu','Zawadi','Mafuta','Tabu','Mvumbi','Safari','Mwenge','Sangwa','Masiala','Amani','Tumba','Muyumba','Luzolo','Masudi','Mulanga','Salumu','Shabani','Moma','Ndaye','Mitonga','Nzeba','Katempa','Manda','Makenga','Mukadi','Muaka','Tshituka','Mukenge','Kwete','Bope','Buanga','Nyemba','Kyembe','Riziki','Mwansa','Kabangu','Zaina','Lwamba','Nshimba','Mwamini','Kadima','Nzita','Mpemba','Kapenda','Kaji','Mateso','Kibawa','Mukanya','Kalubi','Mwewa','Lokuli','Faila','Tshilanda','Betu','Mbungu','Yenga','Ekila','Twite','Sakina','Tshijika','Mukonkole','Machozi','Maombi','Mikombe','Yuma','Mavungu','Ntakwinja','Kabembo','Lumbu','Mwila','Mbula','Madilu','Mbambi','Bora','Omari','Nawej','Vangu','Lukombo','Lumbwe','Ndumba','Longo','Tshilomba','Kaya','Bisimwa','Shukuru','Mbiya','Mwika','Kyondwa','Senga','Buyamba','Kanyinda','Mondonga','Tshianda','Mulunda','Ombeni','Makambo','Mauwa','Kaimba','Muleka','Mbulu','Bambi','Ngimbi','Makaya','Tundwa','Mukumbi','Ntambwe','Ndayi','Aziza','Amuri','Mbaya','Musonda','Kapend','Mukengeshayi','Lukusa','Mbelu','Kilufya','Nsungu','Lokwa','Matembe','Mbongo','Kazembe'];//Initialise la valeur de l'attribut (id)
            $this->liste_prenoms= ["Abel","Achille","Adam","Adolphe","Adrien","Aimable","Aimé","Alain","Alan","Alban","Albert","Albin","Alex","Alexandre","Alexis","Alfred","Aliaume","Alix","Aloïs","Alphonse","Amaury","Ambroise","Amédée","Amour","Ananie","Anastase","Anatole","André","Andréa","Ange","Anicet","Anselme","Antelme","Anthelme","Anthony","Antoine","Antonin","Apollinaire","Ariel","Aristide","Armand","Armel","Arnaud","Arsène","Arthur","Aubin","Auguste","Augustin","Aurélien","Axel","Aymard","Aymeric","Balthazar","Baptiste","Baptistin","Barnabé","Barnard","Barthélémy","Basile","Bastien","Baudouin","Benjamin","Benoît","Bérenger","Bernard","Bernardin","Bertrand","Bienvenu","Blaise","Boris","Briac","Brice","Bruno","Calixte","Camille","Casimir","Cédric","Céleste","Célestin","César","Charles","Charlie","Christian","Christophe","Claude","Clément","Clovis","Colin","Côme","Constant","Constantin","Corentin","Crépin","Cyprien","Cyril","Cyrille","Damien","Daniel","Dany","David","Davy","Denis","Désiré","Didier","Dimitri","Dominique","Donald","Donatien","Dorian","Eden","Edgar","Edgard","Edmond","Edouard","Elias","Elie","Eloi","Emile","Emilien","Emmanuel","Eric","Ernest","Erwan","Erwann","Etienne","Eudes","Eugène","Evrard","Fabien","Fabrice","Faustin","Félicien","Félix","Ferdinand","Fernand","Fiacre","Fidèle","Firmin","Flavien","Florent","Florentin","Florian","Floribert","Fortuné","Francis","Franck","François","Frédéric","Fulbert","Gabin","Gabriel","Gaël","Gaétan","Gaëtan","Gaspard","Gaston","Gatien","Gauthier","Gautier","Geoffroy","Georges","Gérald","Gérard","Géraud","Germain","Gervais","Ghislain","Gilbert","Gildas","Gilles","Godefroy","Goeffrey","Gontran","Gonzague","Gratien","Grégoire","Gregory","Guénolé","Guilain","Guilem","Guillaume","Gustave","Guy","Guylain","Gwenaël","Gwendal","Habib","Hadrien","Hector","Henri","Herbert","Hercule","Hermann","Hervé","Hippolythe","Honoré","Honorin","Horace","Hubert","Hugo","Hugues","Hyacinthe","Ignace","Igor","Isidore","Ismaël","Jacky","Jacob","Jacques","Jean","Jérémie","Jérémy","Jérôme","Joachim","Jocelyn","Joël","Johan","Jonas","Jonathan","Jordan","José","Joseph","Joshua","Josselin","Josué","Judicaël","Jules","Julian","Julien","Juste","Justin","Kévin","Lambert","Lancelot","Landry","Laurent","Lazare","Léandre","Léger","Léo","Léon","Léonard","Léonce","Léopold","Lilian","Lionel","Loan","Loïc","Loïck","Loris","Louis","Louison","Loup","Luc","Luca","Lucas","Lucien","Ludovic","Maël","Mahé","Maixent","Malo","Manuel","Marc","Marceau","Marcel","Marcelin","Marcellin","Marin","Marius","Martial","Martin","Martinien","Matéo","Mathéo","Mathias","Mathieu","Mathis","Mathurin","Mathys","Mattéo","Matthias","Matthieu","Maurice","Maxence","Maxime","Maximilien","Médard","Melchior","Merlin","Michae","Michel","Milo","Modeste","Morgan","Naël","Narcisse","Nathan","Nathanaël","Nestor","Nicolas","Noa","Noah","Noé","Noël","Norber","Octave","Octavien","Odilon","Olive","Pacôme","Parfait","Pascal","Patrice","Patrick","Paul","Paulin","Perceval","Philémon","Philibert","Philippe","Pierre","Pierrick","Prosper","Quentin","Rafaël","Raoul","Raphaël","Raymond","Réginald","Régis","Rémi","Rémy","Renaud","René","Reynald","Richard","Robert","Robin","Rodolphe","Rodrigue","Roger","Roland","Romain","Romaric","Roméo","Romuald","Ronan","Sacha","Salomon","Sam","Sami","Samson","Samuel","Samy","Sasha","Saturnin","Sébastien","Séraphin","Serge","Séverin","Sidoine","Siméon","Simon","Sixte","Stanislas","Stéphane","Sylvain","Sylvère","Sylvestre","Tancrède","Tanguy","Théo","Théodore","Théophane","Théophile","Thibaud","Thibaut","Thierry","Thilbault","Thomas","Tibère","Timéo","Timothé","Timothée","Titouan","Tristan","Tyméo","Ulrich","Ulysse","Urbain","Uriel","Valentin","Valère","Valérien","Valéry","Valmont","Venceslas","Vianney","Victor","Victorien","Vincent","Virgile","Vivien","Wilfrid","William","Xavier","Yaël","Yanis","Yann","Yannick","Yohan","&","dérivés","Yves","Yvon","Yvonnick","Zacharie","Zéphirin"];
            $int_prenom=random_int(0,count($this->liste_prenoms));
            $int_nom=random_int(0,count($this->liste_noms));
            $int_postnom=random_int(0,count($this->liste_noms));
            
            $this->id= 0;//Initialise la valeur de l'attribut (id)

            $this->nom= $this->liste_noms[$int_nom];//Initialise la valeur de l'attribut (nom)
            $this->post_nom= $this->liste_noms[$int_postnom];//Initialise la valeur de l'attribut (post_nom)
            $this->prenom= $this->liste_prenoms[$int_prenom];//Initialise la valeur de l'attribut (prenom)

            $this->sexe= "Masculin" || "Féminin";//Initialise la valeur de l'attribut (sexe)
            $this->num_tel= "";//Initialise la valeur de l'attribut (num_tel)
            $this->adresse= "";//Initialise la valeur de l'attribut (adresse)

            $this->date_enre=date("Y-m-d H:m:i");//Initialise la valeur de l'attribut (date_enre)
            $this->str_db=$connexion;
    }
     public  function show(int $id=0,bool $all=true){
            /*Méthode pour récupérer un Utilisateur d'ID passé en paramètre */
            if($id>0){
                $all=false;
            }
            $db_con= $this->str_db;
            $sql= $db_con->prepare($all ? "SELECT * FROM utilisateurs WHERE :id" : "SELECT * FROM utilisateurs WHERE id=:id" );
            $car=[];
                
            try {
                $sql->execute([':id'=>$all ? 1: $id]);//Exécute la requête dynamiquement
                while($user=$sql->fetch(PDO::FETCH_ASSOC)){
                    $user['id']=(int) $user['id'];
                    if(isset($user['mdp'])){
                        unset($user['mdp']);
                    }
                    $car[]=$user;
                }
            } catch (Exception $ex) { 
                return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
            return $car;
        }
        
    /*Méthode pour enregistrer un Utilisateur */
        public function save(string $nom="",string $post_nom="",string $prenom="",string $sexe="",string $num_tel="",string $adresse="",string $mdp="1234",string $temp=""){
            /*Méthode pour enregistrer une voiture*/

            //Génère automatiquement les Noms par défaut
            if($nom==''){$nom=$this->nom;}
            if($post_nom==''){$post_nom=$this->post_nom;}
            if($prenom==''){$prenom=$this->prenom;}
            if($sexe==''){$sexe=$this->sexe;}
            if($num_tel==''){$num_tel=$this->num_tel;}
            if($adresse==''){$adresse=$this->adresse;}
 
            $db_con=$this->str_db;//Récupère la connexion
            $sql=$db_con->prepare("INSERT INTO utilisateurs(nom,post_nom,prenom,sexe,num_tel,adresse,mdp,temp) VALUES (:nom,:post_nom,:prenom,:sexe,:num_tel,:adresse,:mdp,:temp)");
            try {
                if($sql->execute([':nom'=>$nom,':post_nom'=>$post_nom,':prenom'=>$prenom,':sexe'=>$sexe,':num_tel'=>$num_tel,':adresse'=>$adresse,':mdp'=>password_hash ($mdp,PASSWORD_DEFAULT),':temp'=>$temp])){
                    return ["success"=>true,"message"=> "Compte créé avec succès"];
                }
            } catch (Exception $ex) {
                    return ["error"=>true,"message"=> "Une erreur empêche que la requête réussisse","info"=>$ex];
            }
        }
    
    /*Méthode pour modifier les informations d'un Utilisateur */
    public function update(array $fields,int $id){//Méthode pour actualiser les informations d'un Utilisateur
            $index =0;
            $params=[];
            $str="UPDATE utilisateurs SET ";
            foreach ($fields as $key => $value) {
                $params[$index]=$value ;    
                if($index<(count($fields)-1)){
                    $str=$str.' '.$key."=?".", "; 
                }  else{
                    $str=$str.''.$key."=? WHERE id=".$id; 
                }
                $index++;//incrémente  l'index
            }
            if(count($params)<1){//Bloque l'exécution s'il n'y a pas de paramètre à modifier
                return ["error"=>"Aucune modification ne sera faite"];
            }
            $req= $this->str_db ->prepare($str);
            try{
                if($req->execute($params)){
                    $response= ["success"=>true,"message"=>"Les informations sur le compte ont été actualisées avec succès"];
             }
            }catch(Exception $ex){
               $response= ["error"=>$ex];
            }
            return $response;
        }
    /*Les communtateurs des données  */
        public function delete(int $id=0){
            /*Méthode pour supprimer un Utilisateur*/
                $db_con=$this->str_db;//Récupère la connexion
                $sql=$db_con->prepare("DELETE FROM utilisateurs WHERE id =:id");
            try {
                if($sql->execute([':id'=>$id])){
                    return ["success"=>true,"message"=> "Compte supprimé avec succès"];
                }else{
                    return ["error"=>true,"message"=> "Aucun Utilisateur ne correspond à votre demande de suppression"];
                }
            } catch (Exception $ex) {
                return ["success"=>true,"message"=> "Compte supprimé avec succès","info"=>$ex];
            }
        }
}
?>