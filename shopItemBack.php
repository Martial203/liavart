<?php
if(isset($_SESSION['dash']) AND $_SESSION['dash']=="auth"){
try{
    $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
    die ('Erreur : '.$e->getMessage());
}
    
if(isset($_GET['wtd']) AND $_GET['wtd']=="add"){
    
    
    if(isset($_POST['nomItem']) AND isset($_POST['categArticle']) AND isset($_POST['langueContenu']) AND isset($_POST['contenuAnnonce'])){
        $req = $bdd->prepare("INSERT INTO lishop(nom_artice, categorie, contenu, lien, langue) VALUES(:nom_article, :categorie, :contenu, :lien, :langue)");
        $req->execute(array(
            "nom_article"=> htmlspecialchars($_POST['nomItem']),
            "categorie"=> $_POST['nomItem'],
            "contenu"=> $_POST['contenuAnnonce'],
            "lien"=> $_POST['link'],
            "langue"=> $_POST['langueContenu']
        ));
        $req->closeCursor();
        $req->exec("UPDATE shop SET col=1");
    }
}
if(isset($_GET['wtd']) AND $_GET['wtd']=="sup"){
    if(isset($_GET['no'])){
        $rq = $bdd->prepare("DELETE FROM lishop WHERE ID=?");
        $rq -> execute(array($_GET['no']));
    }
}
}
?>