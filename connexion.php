<?php
session_start();

include("languageDefinition.php");
include("dictionnaireConnexion.php");

if((isset($_POST['userNameInput'])==false AND isset($_POST['passwordInput'])==false) OR isset($_GET['message'])){
    if(isset($_GET['message'])){
        switch($_GET['message']){
            case 'mdpnr':
                $message=$mot_de_passe_non_reconnu[$lang];
                break;
            case 'ace':
                $message=$aucun_compte_enregistre[$lang];
                break;
            default:
                $message="";
        }
    }
    else{
        $message="";
    }
    ?>  
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta lang="<?php echo $lang; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="height=device-height, initial-scale=1.0">
        <title><?php echo $se_connecter[$lang];?></title>
        <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
        <link rel="stylesheet" href="connexion.css">
        <meta name="description" content="<?php echo $descSeConnecterEtCons[$lang]; ?>">
    </head>
    <body>
        <?php
            if(isset($_GET["rubrique"])){
                $_SESSION['rubrique']=htmlspecialchars($_GET["rubrique"]);
            }
            else{
                $_SESSION['rubrique']="portail1";
            }
        ?>
        <header><?php include("header.php") ?></header><br class="br1">
        <nav><img src="photos/Fleche.png"> <a href="accueil.php"><?php echo $retour_a_l_accueil[$lang];?></a></nav>
        <main><h1><?php echo $connexion[$lang];?></h1>
        <p id="message"><?php echo $message; ?></p>
        <form method="post" action="connexion.php"><div id=divs><div class="fakeDiv"></div><table>
                <tr><td class="tdC2"><label for="userNameInput"><?php echo $nom_utilisateur[$lang];?></label></td> <td class="tdC1"><input class="input" type="text" name="userNameInput" id="userName" required></td></tr><br>
                <tr><td class="tdC2"><label for="passwordInput"><?php echo $mot_de_passe[$lang];?></label></td> <td class="tdC1"><input class="input" type="password" name="passwordInput" id="password" required></td></tr><br></table></div><input id="valider" type="submit" value="Se connecter">
            <div class="fakeDiv"></div><br>
        </form>
        <p><a href="motDePasseOublieUserInput.php"><?php echo $mot_de_passe_oublie[$lang];?></a></p>
        <p id="p2"><span><?php echo $pas_de_compte[$lang]; ?></span><span id="inscrivezVous"><a href="inscription.php"><?php echo $inscrivez_vous_ici[$lang]; ?></a></span></p>
        </main>
        <footer><?php include("footer.php") ?></footer>
    </body>
    <?php
}
if(isset($_POST['userNameInput'])==true AND isset($_POST['passwordInput'])==true){
    try{
        $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
    }
    catch(Exception $e){
        die ('Erreur : '.$e->getMessage());
    }
    $requete1 = $bdd->prepare('SELECT COUNT(*) As issetUserName FROM inscrits WHERE nom_utilisateur=?');
    $requete1 -> execute(array(htmlspecialchars($_POST['userNameInput'])));
    $resultat1 = $requete1->fetch();
    $requete1->closeCursor();
    if ($resultat1['issetUserName']==0){
        header('location:connexion.php?message=ace');
    }
    else{
        $requete2 = $bdd->prepare('SELECT * FROM inscrits WHERE nom_utilisateur=?');
        $requete2 -> execute(array(htmlspecialchars($_POST['userNameInput'])));
        $resultat2 = $requete2->fetch();
        if(password_verify($_POST['passwordInput'],$resultat2['mot_de_passe'])){
        
            $_SESSION['user']=$resultat2['nom_utilisateur'];
            $_SESSION['adresse_mail']=$resultat2['adresse_mail'];
            $_SESSION['pays_de_residence']=$resultat2['pays_de_residence'];
            $_SESSION['ville_de_residence']=$resultat2['ville_de_residence'];
            $_SESSION['noms']=$resultat2['noms'];
            $_SESSION['prenoms']=$resultat2['prenoms'];
            $_SESSION['sexe']=$resultat2['sexe']; 
            $_SESSION['description_du_profil']=$resultat2['description_du_profil'];
            $_SESSION['site_entreprise']=$resultat2['site_entreprise'];
            $_SESSION['pages_entreprises']=$resultat2['pages_entreprises'];
            $_SESSION['avatar']=$resultat2['avatar'];
            $_SESSION['mot_de_passe']=$resultat2['mot_de_passe'];
            $_SESSION['message']='';
            $_SESSION['offres_emploi_favoris']=$resultat2['offres_emploi_favoris'];
            $_SESSION['offres_services_favoris']=$resultat2['offres_services_favoris'];
            $requete2 -> closeCursor();
            
            //Enregistrer la connexion
            $requete3 = $bdd -> prepare('INSERT INTO connexions(nom_utilisateur, instant_de_connexion) VALUES(:nom_utilisateur, NOW())');
            $requete3 -> execute(array('nom_utilisateur'=>$_SESSION['user']));
            //Fin
            
            header('location:contenus.php?rubrique='.$_SESSION["rubrique"]);
        }
        else{
            header('location:connexion.php?message=mdpnr');
        }
        
    }
}
?>