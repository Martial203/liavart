<?php
session_start();
if(isset($_SESSION['noms']) AND isset($_SESSION['userName']) AND isset($_SESSION['sexe'])){
try{
    $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
catch(Exception $e){
    die ('Erreur : '.$e->getMessage());
}


$requete= $bdd->prepare('INSERT INTO inscrits(noms, prenoms, sexe, pays_de_residence, ville_de_residence, adresse_mail, nom_utilisateur, mot_de_passe, description_du_profil, site_entreprise, pages_entreprises, avatar) VALUES(:noms, :prenoms, :sexe, :pays_de_residence, :ville_de_residence, :adresse_mail, :nom_utilisateur, :mot_de_passe, :description_du_profil, :site_entreprise, :pages_entreprises, :avatar)');

$requete->execute(array(
    'noms' => $_SESSION['noms'],
    'prenoms' => $_SESSION['prenoms'],
    'sexe' => $_SESSION['sexe'],
    'pays_de_residence' => $_SESSION['paysDeResidence'],
    'ville_de_residence' => $_SESSION['villeDeResidence'],
    'adresse_mail' => $_SESSION['adresseMail'],
    'nom_utilisateur' => $_SESSION['userName'],
    'mot_de_passe' => $_SESSION['password'],
    'description_du_profil' => $_SESSION['description'],
    'site_entreprise' => $_SESSION['siteInternet'],
    'pages_entreprises' => $_SESSION['pagesEntreprise'],
    'avatar' => $_SESSION['photoDeProfil']
));
$_SESSION['user']=$_SESSION['userName'];
$_SESSION['adresse_mail']=$_SESSION['adresseMail'];
$_SESSION['pays_de_residence']=$_SESSION['paysDeResidence'];
$_SESSION['ville_de_residence']=$_SESSION['villeDeResidence'];
$_SESSION['site_entreprise']=$_SESSION['siteInternet'];
$_SESSION['pages_entreprises']=$_SESSION['pagesEntreprise'];
$_SESSION['avatar']=$_SESSION['photoDeProfil'];
$_SESSION['mot_de_passe']=$_SESSION['password'];
$_SESSION['description_du_profil']=$_SESSION['description'];
$_SESSION['offres_emploi_favoris']="";
$_SESSION['offres_services_favoris']="";

$req = $bdd -> prepare('INSERT INTO connexions(nom_utilisateur,instant_de_connexion) VALUES(?,NOW())');
$req -> execute(array($_SESSION['user']));

header("location:bienvenue.php");
}
?>