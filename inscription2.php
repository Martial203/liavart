<?php
    session_start();
include("languageDefinition.php");
include("dictionnaireInscription2.php");

if(isset($_POST['userName'])){
try{
    $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
catch(Exception $e){
    die ('Erreur : '.$e->getMessage());
}

if(isset($_SESSION['controleur'])==false){
    $_SESSION['noms']=htmlspecialchars($_POST['noms']);
    $_SESSION['prenoms']=htmlspecialchars($_POST['prenoms']);
    $_SESSION['paysDeResidence']=htmlspecialchars($_POST['paysDeResidence']);
    $_SESSION['villeDeResidence']=htmlspecialchars($_POST['villeDeResidence']);
    $_SESSION['adresseMail']=htmlspecialchars($_POST['adresseMail']);
    $_SESSION['password']=password_hash($_POST['password'],PASSWORD_DEFAULT);
    $_SESSION['sexe'] = (isset($_POST['sexe'])) ? htmlspecialchars($_POST['sexe']) : "";
    $_SESSION['description'] = (isset($_POST['description'])) ? htmlspecialchars($_POST['description']) : "";
    $_SESSION['siteInternet'] = (isset($_POST['siteInternet'])) ? htmlspecialchars($_POST['siteInternet']) : "";
    $_SESSION['pagesEntreprise'] = (isset($_POST['pagesEntreprise'])) ? htmlspecialchars($_POST['pagesEntreprise']) : "";
}

$_SESSION['userName']=$_POST['userName'];
$requete = $bdd->prepare('SELECT COUNT(*) As nbreUsers FROM inscrits WHERE nom_utilisateur=?');
$requete ->execute(array($_SESSION['userName']));
$donnees = $requete->fetch();
    
if($donnees['nbreUsers']>0){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="motDePasseOublie.css">
        <title><?php echo $nom_utilisateur[$lang]; ?></title>
        <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
    </head>
    <body>
        <header><?php include ('header.php') ?></header>
        <h1><?php echo $nom_utilisateur_existant[$lang]; ?></h1>
        <p><?php echo $sachez_que_vous_pouvez[$lang]; ?> "@",".",...<?php echo $ainsi_que[$lang]; ?></p>
       <form method="post" action="inscription2.php">
            <input id="input1" type="text" name="userName"><br>
            <input id="submit" type="submit" value="<?php echo $valider[$lang]; ?>">
       </form>
        <footer><?php include ('footer.php') ?></footer>
    </body>
    </html>
    <?php
        $_SESSION['controleur']="Je suis maintenant là";
}
else{
    include('validationInscriptionMail.php');
}
}
?>
