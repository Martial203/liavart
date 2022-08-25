<?php 
include("languageDefinition.php");
include("dictionnaireParametres.php");
try{
    $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
catch(Exception $e){
    die ('Erreur : '.$e->getMessage());
}

    if(isset($_GET['ok'])){
        if($_GET['ok']=='prof'){
            $req = $bdd -> prepare('UPDATE inscrits SET avatar=? WHERE nom_utilisateur=?');
            $req -> execute(array($_SESSION['avatar'], $_SESSION['user']));
            $req -> closeCursor();
            header('location:contenus.php?rubrique=parametres&rslt=profil');
        }
        
        elseif($_GET['ok']=='rest'){
            
            $_SESSION['rest_noms']=$_POST['noms'];
            $_SESSION['rest_prenoms']=$_POST['prenoms'];
            $_SESSION['rest_sexe']= (isset($_POST['sexe']))? $_POST['sexe'] : '';
            $_SESSION['rest_pays_de_residence']=$_POST['paysDeResidence'];
            $_SESSION['rest_ville_de_residence']=$_POST['villeDeResidence'];
            $_SESSION['rest_adresse_mail']=$_POST['adresseMail'];
            $_SESSION['rest_user']=$_POST['userName'];
            $_SESSION['rest_description_du_profil']=$_POST['description'];
            $_SESSION['rest_site_entreprise']=$_POST['siteInternet'];
            $_SESSION['rest_pages_entreprises']=$_POST['pagesEntreprises'];
            
            if(password_verify($_POST['password'], $_SESSION['mot_de_passe'])){
            $req = $bdd ->prepare('SELECT COUNT(*) AS nbreUsers FROM inscrits WHERE nom_utilisateur=? AND nom_utilisateur!=?');
            $req -> execute(array($_POST['userName'], $_SESSION['user']));
            $donnees = $req -> fetch();
            if($donnees['nbreUsers']==0){
                $req = $bdd -> prepare('UPDATE inscrits SET noms=:noms, prenoms=:prenoms, sexe=:sexe, pays_de_residence=:pays_de_residence, ville_de_residence=:ville_de_residence, adresse_mail=:adresse_mail, nom_utilisateur=:nouveau_nom_utilisateur, description_du_profil=:description_du_profil, site_entreprise=:site_entreprise, pages_entreprises=:pages_entreprises WHERE nom_utilisateur=:nom_utilisateur');
                $req -> execute(array(
                    'noms' => $_SESSION['rest_noms'],
                    'prenoms' => $_SESSION['rest_prenoms'],
                    'sexe' => $_SESSION['rest_sexe'],
                    'pays_de_residence' => $_SESSION['rest_pays_de_residence'],
                    'ville_de_residence' => $_SESSION['rest_ville_de_residence'],
                    'adresse_mail' => $_SESSION['rest_adresse_mail'],
                    'nouveau_nom_utilisateur' => $_SESSION['rest_user'],
                    'description_du_profil' => $_SESSION['rest_description_du_profil'],
                    'site_entreprise' => $_SESSION['rest_site_entreprise'],
                    'pages_entreprises' => $_SESSION['rest_pages_entreprises'],
                    'nom_utilisateur' => $_SESSION['user']
                ));
                
                //Mise à jour connexions
                $requete = $bdd -> prepare('UPDATE connexions SET nom_utilisateur=? WHERE nom_utilisateur=?');
                $requete -> execute(array($_SESSION['rest_user'], $_SESSION['user']));
                //Fin 
                
                $_SESSION['noms']=$_SESSION['rest_noms'];
                $_SESSION['prenoms']=$_SESSION['rest_prenoms'];
                $_SESSION['sexe']=$_SESSION['rest_sexe'];
                $_SESSION['pays_de_residence']=$_SESSION['rest_pays_de_residence'];
                $_SESSION['ville_de_residence']=$_SESSION['rest_ville_de_residence'];
                $_SESSION['adresse_mail']=$_SESSION['rest_adresse_mail'];
                $_SESSION['user']=$_SESSION['rest_user'];
                $_SESSION['description_du_profil']=$_SESSION['rest_description_du_profil'];
                $_SESSION['site_entreprise']=$_SESSION['rest_site_entreprise'];
                $_SESSION['pages_entreprises']=$_SESSION['rest_pages_entreprises'];
            
                header('location:contenus.php?rubrique=parametres&rslt=rest');
                }
                
            else{
                ?>
                <script type="text/javascript">alert("<?php echo $le_nom_d_utilisateur_que[$lang]; ?>");</script>
                <?php
            }
        }
            else{
                ?>
                <script type="text/javascript">alert("<?php echo $mot_de_passe_incorrect[$lang]; ?>");</script>
                <?php
            }
    }
    }