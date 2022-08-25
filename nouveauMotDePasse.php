<?php
session_start();
include("languageDefinition.php");
include("dictionnaireNouveauMotDePasse.php");
if(isset($_POST['nouveauMotDePasse']) AND isset($_POST['confirmNouveauMotDePasse'])){
    if($_POST['nouveauMotDePasse']==$_POST['confirmNouveauMotDePasse']){
        
try{
    $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
catch(Exception $e){
    die ('Erreur : '.$e->getMessage());
}

        $_SESSION['mot_de_passe']=password_hash($_POST['nouveauMotDePasse'], PASSWORD_DEFAULT);
        $req = $bdd -> prepare('UPDATE inscrits SET (mot_de_passe) VALUES(?) WHERE nom_utilisateur=?');
        $req -> execute(array($_SESSION['mot_de_passe'], $_SESSION['userOublie']));
        $req ->closeCursor();
        
        $requete = prepare('SELECT * FROM inscrits WHERE nom_utilisateur=?');
        $requete -> execute(array($_SESSION['userOublie']));
        $resultat2 = $requete->fetch();
        
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
        header('location:contenus.php');
    }
    else{
        ?>
        <script type="text/javascript">alert("<?php echo $la_confirmation_et_le[$lang]; ?>");</script>
        <?php
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta lang="<?php echo $lang; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="height=device-height, initial-scale=1.0">
    <title><?php echo $nouveau_mot_de_passe[$lang]; ?></title>
    <link rel="stylesheet" href="motDePasseOublie.css">
    <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
</head>
<body>
    <header><?php include("header.php") ?></header>
    <h1><?php echo $nouveau_mot_de_passe[$lang]; ?></h1>
    <p><?php echo $veuillez_definir_un_nouveau[$lang]; ?></p>
    <form method="post" action="nouveauMotDePasse">
        <input id="input1" type="text" name="nouveauMotDePasse" placeholder="<?php echo $nouveau_mot_de_passe[$lang]; ?>" required><br>
        <input id="input2" type="text" name="confirmNouveauMotDePasse" placeholder="<?php echo $nouveau_mot_de_passe[$lang]; ?>" required><br>
        <input id="submit" type="submit" value="<?php echo $valider[$lang]; ?>">
    </form>
    <footer><?php include("footer.php") ?></footer>
</body>
</html>
<?php
}
?>