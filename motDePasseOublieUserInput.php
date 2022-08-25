<?php
session_start();

include("languageDefinition.php");
include("dictionnaireMotDePaseeOublieUserInput.php");

if(isset($_POST['userOublie'])){
    
try{
    $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
catch(Exception $e){
    die ('Erreur : '.$e->getMessage());
}

    $req = $bdd ->prepare('SELECT adresse_mail FROM inscrits WHERE nom_utilisateur=?');
    $req -> execute(array($_POST['userOublie']));
    
    if($res = $req ->fetch()){
        $_SESSION['code']=rand(100000,900000);
        $_SESSION['mailOublie']=$res['adresse_mail'];
        $_SESSION['userOublie']=$_POST['userOublie'];
        header('location:motDePasseOublie.php');
    }
    else{
        ?>
        <script type="text/javascript">alert("<?php echo $aucun_compte_n_a[$lang]; ?>");</script>
        <?php
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta lang="<?php echo $lang; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="height=device-height, initial-scale=1.0">
    <title><?php echo $mot_de_passe_oublie[$lang]; ?></title>
    <link rel="stylesheet" href="motDePasseOublie.css">
    <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
</head>
<body>
    <header><?php include("header.php") ?></header>
   <h1><?php echo $mot_de_passe_oublie[$lang]; ?></h1>
   <p><?php echo $veuillez_entrer_votre_nom[$lang]; ?></p>
   <form method="post" action="motDePasseOublieUserInput.php">
        <input id="input1" type="text" name="userOublie" required><br>
        <input id="submit" type="submit" value="<?php echo $valider[$lang]; ?>">
   </form>
    <footer><?php include("footer.php") ?></footer>
</body>
</html>