<?php
session_start();

if(isset($_SESSION['dash']) AND $_SESSION['dash']=='auth'){           
            include('BDConnection.php');
    $lang='fr';
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Tableau de bord</title>
                <link rel=stylesheet href="dashboard.css">
                <link rel=stylesheet href="contenus.css">
                <link rel=stylesheet href="offres.css">
                <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
                <meta name="googlebot" content="noindex, nofollow, nosnippet, noodp, noimageindex">
            </head>
            <body>
               <header><?php include("header.php"); ?></header>
                <h1>TABLEAU DE BORD</h1>
                <section>
                    <aside>
                        <ul>
                        <a href="dashboard.php?rubrique=statistiques"><li id="statistiques">Statistiques générales</li></a>
                        <a href="dashboard.php?rubrique=annonces"><li id="annonces">A propos des annonces</li></a>
                        <a href="dashboard.php?rubrique=annonces&amp;signa=signa"><li id="annonces">Annonces signalées</li></a>
                        <a href="dashboard.php?rubrique=utilisateurs"><li id="utilisateurs">A propos des utilisateurs</li></a>
                        <a href="dashboard.php?rubrique=utilisateurs&amp;blo=blo"><li id="utilisateurs">Utilisateurs bloqués</li></a>
                        <a href="dashboard.php?rubrique=mail"><li id="utilisateurs">Mail aux utilisateurs</li></a>
                        <a href="dashboard.php?rubrique=nouvelArticle"><li id="nouvelArticle">Ajouter un article sur le shop</li></a>
                        <a href="dashboard.php?rubrique=suppArticle"><li id="suppArticle">Supprimer un article du shop</li></a>
                        <a href="dashboard.php?rubrique=liensRS"><li id="liensRs">Liens réseaux sociaux</li></a>
                        <a href="dashboard.php?rubrique=discon"><li id="dis">Déconnexion</li></a>
                        </ul>
                    </aside>
                    <main>
                        <?php
                        if(isset($_GET['rubrique'])){
                            if($_GET['rubrique']=="utilisateurs"){
                                echo '<h2>A propos des utilisateurs</h2>';
                                include('utilisateurs.php');
                            }
                            elseif($_GET['rubrique']=="annonces"){
                                echo '<h2>A propos des differentes annonces</h2>';
                                include('annonces.php');
                            }
                            elseif($_GET['rubrique']=="mail"){
                                echo '<h2>Mail aux utilisateurs</h2>';
                                include('mailToUsers.php');
                            }
                            elseif($_GET['rubrique']=="nouvelArticle"){
                                echo '<h2>Ajouter un nouvel article sur le shop</h2>';
                                include('shopAddItem.php');
                            }
                            elseif($_GET['rubrique']=="suppArticle"){
                                echo '<h2>Supprimer un article du shop</h2>';
                                include('shopAddItem.php');
                            }
                            elseif($_GET['rubrique']=="liensRS"){
                                echo '<h2>Liens réseaux sociaux</h2>';
                                include('modifLinksRs.php');
                            }
                            elseif($_GET['rubrique']=="discon"){
                                echo '<h2>Déconnexion</h2>';
                                ?>
                                <p>Se déconnecter ?</p>
                                <p><a href="accueil.php?disdash=1">Oui</a> <a href="dashboard.php">Non</a></p>
                                <?php
                            }
                            else{
                                echo '<h2>Statistiques générales</h2>';
                                include('statistiquesGenerales.php');
                        }
                        }
                        ?>
                    </main>
                </section>
            </body>
            </html>

    <?php
}
elseif(isset($_SESSION['val']) AND isset($_POST['pass1']) AND isset($_POST['pass2'])){
    if($_POST['pass1']==$_SESSION['val']*2 AND $_POST['pass2']==$_SESSION['val']^2){
        $_SESSION['dash']="auth";
        header('location:dashboard.php');
    }
    else{
        header('location:dashboard.php?mdp=incrt');
    }
}
else{
    $headers="From: Liavart <liavart21@gmail.com>\n";
    $headers.="MIME-Version: 1.0\n";
    $headers.="Content-type: text/html; charset=utf-8\n";
    $headers.="Content-transfer-Encoding: 8bit";
    $_SESSION['val']=rand(1000,9999);
    if(mail('martialnounga@gmail.com','Authentification dashboard','Code d\'accès: '.$_SESSION['val'],$headers)){
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Authentification</title>
            <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
            <meta name="googlebot" content="noindex, nofollow, nosnippet, noodp, noimageindex">
          
        </head>
        <body>
            <?php 
                if(isset($_GET['mdp'])){
                    ?>
                    <p id="messageErreur">Echèc d'authentification, veuillez ressayer !</p>
                    <?php
                } 
            ?>
            <form method="post" action="dashboard.php">
                <label id="lb1">Clé 1: </label><input type="password" name="pass1" required><br>
                <label id="lb2">Clé 2: </label><input type="password" name="pass2" required><br>
                <input type="submit" value="Valider">
            </form>
        </body>
        </html>
        <?php
    }
    else{
        echo 'erreur dans la mise en place du processus d\'authentification';
    }
}