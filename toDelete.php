<?php
session_start();
if(isset($_SESSION['val'])==false OR isset($_GET['mdp'])){
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
            <form method="post" action="dashboard.php">
                <label id="lb1">Mot de passe 1: </label><input type="password" name="pass1" required><br>
                <label id="lb2">Mot de passe 2: </label><input type="password" name="pass2" required><br>
                <input type="submit" value="Valider">
            </form>
        </body>
        </html>
        <?php
    }
    else{
        echo 'erreur, veuillez ressayer !';
    }
}
elseif(isset($_SESSION['val']) AND isset($_POST['pass1']) AND isset($_POST['pass2'])){
    if($_POST['pass1']==$_SESSION['val']*2 AND $_POST['pass2']==$_SESSION['pass2']^2){
        include("header.php");
        include('BDConnection.php');
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Tableau de bord</title>
            <link rel=stylesheet href="dashboard.css">
            <link rel=stylesheet href="contenus.css">
            <link rel=stylesheet href="offres.css">
        </head>
        <body>
            <h1>TABLEAU DE BORD</h1>
            <section>
                <aside>
                    <ul>
                    <a href="dashboard.php?rubrique=statistiques"><li id="statistiques">Statistiques générales</li></a>
                    <a href="dashboard.php?rubrique=annonces"><li id="annonces">A propos des annonces</li></a>
                    <a href="dashboard.php?rubrique=annonces&amp;signa=signa"><li id="annonces">Annonces signalées</li></a>
                    <a href="dashboard.php?rubrique=utilisateurs"><li id="utilisateurs">A propos des utilisateurs</li></a>
                    <a href="dashboard.php?rubrique=utilisateurs&amp;blo=blo"><li id="utilisateurs">Utilisateurs bloqués</li></a>
                    <a href="dashboard.php?rubrique=sql"><li id="utilisateurs">Commandes SQL</li></a>
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
        include("footer.php");
    }
    else{
        header('location:dashboard.php?mdp=icrt');
    }
}
else{
    echo 'erreur';
}
?>