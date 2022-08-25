<?php session_start();
if(isset($_POST['hidden'])){
try{
    $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
catch(Exception $e){
    die ('Erreur : '.$e->getMessage());
}

if ($_POST['hidden']=="P"){
    $req = $bdd->prepare('INSERT INTO offres_services (auteur, titre_proposition, poste, champ, type_travail, missions, profil, competences, prix, monnaie, contact, informations_supplementaires, date_publication, ville, pays, mail, noms_auteur, prenoms_auteur, description_auteur, avatar) VALUES (:auteur, :titre_proposition, :poste, :champ, :type_travail, :missions, :profil, :competences, :prix, :monnaie, :contact, :informations_supplementaires, NOW(), :ville, :pays, :mail, :noms_auteur, :prenoms_auteur, :description_auteur, :avatar)');
    $req -> execute(array(
        'auteur'=>$_SESSION['user'],
        'titre_proposition'=>$_SESSION['titre_proposition'],
        'poste'=>$_SESSION['poste'],
        'champ'=>$_SESSION['champ'],
        'type_travail'=>$_SESSION['type_de_travail'],
        'missions'=>$_SESSION['missions'],
        'profil'=>$_SESSION['profil'],
        'competences'=>$_SESSION['competences'],
        'prix'=>$_SESSION['prix'],
        'monnaie'=>$_SESSION['monnaie'],
        'contact'=>$_SESSION['contact'],
        'informations_supplementaires'=>$_SESSION['informations_supplementaires'],
        'ville'=>$_SESSION['ville_de_residence'],
        'mail'=>$_SESSION['adresse_mail'],
        'noms_auteur'=>$_SESSION['noms'],
        'prenoms_auteur'=>$_SESSION['prenoms'],
        'pays'=>$_SESSION['pays_de_residence'],
        'avatar_auteur'=>$_SESSION['avatar'],
        'description_auteur'=>$_SESSION['description_du_profil']
    ));
    header('location:contenus.php?rubrique=portail2');
}
elseif($_POST['hidden']=="O"){
    $req = $bdd->prepare('INSERT INTO offres_emploi (auteur, titre, poste, champ_activite, type_de_travail, type_de_contrat, missions, profil_recherche, qualites, conditions_de_travail, salaire, monnaie, date_limite, lieu_de_reception, contacts, autres_informations, date_de_publication, ville, pays, mail, noms_auteur, prenoms_auteur, description_auteur, avatar_auteur) VALUES (:auteur, :titre, :poste, :champ_activite, :type_de_travail, :type_de_contrat, :missions, :profil_recherche, :qualites, :conditions_de_travail, :salaire, :monnaie, :date_limite, :lieu_de_reception, :contacts, :autres_informations, NOW(), :ville, :pays, :mail, :noms_auteur, :prenoms_auteur, :description_auteur, :avatar_auteur)');
    $req -> execute(array(
        'auteur'=>$_SESSION['user'],
        'titre'=>$_SESSION['titre'],
        'poste'=>$_SESSION['poste'],
        'champ_activite'=>$_SESSION['champ_activite'],
        'type_de_travail'=>$_SESSION['type_de_travail'],
        'type_de_contrat'=>$_SESSION['type_de_contrat'],
        'missions'=>$_SESSION['missions'],
        'profil_recherche'=>$_SESSION['profil_recherche'],
        'qualites'=>$_SESSION['qualites'],
        'conditions_de_travail'=>$_SESSION['conditions_de_travail'],
        'salaire'=>$_SESSION['salaire'],
        'monnaie'=>$_SESSION['monnaie'],
        'date_limite'=>$_SESSION['date_limite'],
        'lieu_de_reception'=>$_SESSION['lieu_de_reception'],
        'contacts'=>$_SESSION['contacts'],
        'autres_informations'=>$_SESSION['autres_informations'],
        'ville'=>$_SESSION['ville_de_residence'],
        'mail'=>$_SESSION['adresse_mail'],
        'noms_auteur'=>$_SESSION['noms'],
        'prenoms_auteur'=>$_SESSION['prenoms'],
        'pays'=>$_SESSION['pays_de_residence'],
        'avatar_auteur'=>$_SESSION['avatar'],
        'description_auteur'=>$_SESSION['description_du_profil']
    ));
   header('location:contenus.php?rubrique=portail1');
}
}
?>