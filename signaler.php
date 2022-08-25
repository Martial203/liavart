<?php
    session_start();
include("languageDefinition.php");
include("dictionnaireSignaler.php");
if(isset($_POST['problemeSignale'])){
    
try{
    $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
catch(Exception $e){
    die ('Erreur : '.$e->getMessage());
}

    if(isset($_GET['nbre'])){
        $req = $bdd -> prepare('INSERT INTO offres_emploi_signales(ID_offre, nom_utilisateur_signaleur, probleme, date) VALUES(:ID_offre, :nom_utilisateur_signaleur, :probleme, NOW())');
        $req -> execute(array(
            'ID_offre'=> $_GET['nbre'],
            'nom_utilisateur_signaleur'=> $_SESSION['user'],
            'probleme'=> $_POST['problemeSignale']
        ));
        header('location:element.php?nbre='.$_GET["nbre"].'&rs=1&page='.$_GET['page']);
    }
    elseif(isset($_GET['nber'])){
        $req = $bdd -> prepare('INSERT INTO offres_services_signales(ID_offre, nom_utilisateur_signaleur, probleme, date) VALUES(:ID_offre, :nom_utilisateur_signaleur, :probleme, NOW())');  
        $req -> execute(array(
            'ID_offre'=> $_GET['nber'],
            'nom_utilisateur_signaleur'=> $_SESSION['user'],
            'probleme'=> $_POST['problemeSignale']
        ));
        header('location:element.php?nber='.$_GET["nber"].'&rs=1&page='.$_GET['page']);
    }
}
else{
    if(isset($_GET['nbre'])){
        $var='nbre='.$_GET['nbre'];
    }
    elseif(isset($_GET['nber'])){
        $var='nber='.$_GET['nber'];
    }
}

if(isset($var)){
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta lang="<?php echo $lang; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="height=device-height, initial-scale=1.0">
    <title><?php echo $signaler_un_contenu[$lang];?></title>
    <link rel="stylesheet" href="motDePasseOublie.css">
</head>
<body>
    <header><?php include("header.php") ?></header>
    <nav> <a href="element.php?<?php echo $var ;?>&amp;page=<?php echo $_GET['page']; ?>"> <img src="photos/Fleche.png"><?php echo $retour_a_l_offre[$lang];?></a></nav>
    <h1><?php echo $signaler_un_contenu[$lang];?></h1>
    <p><?php echo $veuillez_declarer_de_maniere[$lang];?></p>
    <form method="post" action="signaler.php?<?php echo $var;?>&amp;page=<?php echo $_GET['page']; ?>">
        <textarea id="textarea1" name="problemeSignale" required></textarea><br>
        <input id="submit" type="submit" value="<?php echo $soumettre[$lang];?>">
    </form>
    <footer><?php include("footer.php") ?></footer>
</body>
</html>
<?php
   }
?>