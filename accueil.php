<?php 
session_start();
if(isset($_GET['disdash']) AND isset($_SESSION['dash'])){
    session_destroy();
    header('location:accueil.php');
}
$acc=1;
try{
    $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
catch(Exception $e){
    die ('Erreur : '.$e->getMessage());
}
include("languageDefinition.php");
include("dictionnaireAccueil.php");

    if (isset($_GET['J'])){
        session_start();

        //Mise à jour deconnexion
        if(isset($_SESSION['user'])){
            $req = $bdd -> prepare('UPDATE connexions SET nom_utilisateur=?, instant_de_deconnexion=NOW() WHERE nom_utilisateur=?');
            $req -> execute(array($_SESSION['user'].'(d)',$_SESSION['user']));
            $req -> closeCursor();
            session_destroy();
        }
        //Fin
}
$bdd -> exec('INSERT INTO visites(heure) VALUES(NOW())');
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <link rel="stylesheet" href="accueil.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="height=device-height, initial-scale=1.0">
    <meta lang="<?php echo $lang; ?>">
    <title>Liavart</title>
    <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
    <meta name="description" content="<?php echo $inscrivez_vous[$lang]; ?>">
</head>
<body>
    <header><?php include("header.php") ?></header>
    <section>
       <br class="br1">
        <h1><div class="fakeDiv"></div><div id="KROW"><img alt="<?php echo $altLogoLiavart[$lang]; ?>" src="photos/iconeLiavart.png" id="logoLiavart"> <img alt="KROW" src="photos/KROW(No%20borders).png" id="imgKrow"><a href="displayShopItems.php"><div id="liavartShopLink"><?php echo $decouvrez_aussi_de_nom[$lang]; ?></div></a></div><div class="fakeDiv"></div></h1>
        <p id="p1"><?php echo $inscrivez_vous[$lang]; ?></p><br>
        <div id="parentPortails">
            <div id="portails">
        <h2><a href="connexion.php"><?php echo $connectez_vous[$lang]; ?></a></h2>
                <a href="connexion.php?rubrique=portail1" id="Portail1"><h3><?php echo $portail1[$lang]; ?></h3><span class="contenuDePortails"><?php echo $connecter_en_tant_que[$lang]; ?><br><?php echo $connecter_demandeur_emploi[$lang]; ?></span></a>
                <a href="connexion.php?rubrique=portail2" id="Portail2"><h3><?php echo $portail2[$lang]; ?></h3><span class="contenuDePortails"><?php echo $connecter_en_tant_que[$lang]; ?> <br><?php echo $connecter_proposeur_service[$lang]; ?></span></a>
            </div>
            <div id="design"><br class="brDesign1"><br class="brDesign2"><img src="photos/ambitious-businessman-worker-climbing-the-ladder-to-management-office-chair-with-vacant-sign-vector.png" alt="<?php echo $altPosteVacant[$lang]; ?>"><a href="displayShopItems.php"><div id="liavartShopLink1"><?php echo $decouvrez_aussi_de_nom[$lang]; ?></div></a></div>
        </div><br>
        <p id="p2"><span id="sp1"><?php echo $pas_de_compte[$lang]; ?></span><span id="inscrivezVous"><a href="inscription.php"><?php echo $inscrivez_vous_ici[$lang]; ?></a></span></p><br><br>
    </section>
    <footer><?php include("footer.php")?></footer>
    <?php 
        if(isset($lang)){
            if($lang=="ja"){
                ?>
                <style type="text/css">
                    #liavartShopLink1{
                        position: absolute;
                    }
                    @media all and (max-width: 455px){
                        #liavartShopLink1{
                            top: 28em;
                        }
                        @media all and (max-width: 307px){
                            #liavartShopLink1{
                                top: 34em;
                            }
                        }
                    }
                </style>
                <?php
            }
        }
?>
</body>
</html>