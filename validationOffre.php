<?php
session_start();

if(isset($_POST['titreOffre']) AND isset($_POST['missionsAAccomplir'])){
include("languageDefinition.php");
include("dictionnaireOffreEmploi.php");

$_SESSION['titre']=$_POST['titreOffre'];
$_SESSION['poste']=$_POST['nomDuPoste'];
$_SESSION['champ_activite']=$_POST['champDactivite'];
if (isset($_POST['typeDeTravail_presentiel']) AND isset($_POST['typeDeTravail_distance'])){$_SESSION['type_de_travail']="Présentiel et distant";}
elseif(isset($_POST['typeDeTravail_presentiel'])){$_SESSION['type_de_travail']="Présentiel";}
elseif(isset($_POST['typeDeTravail_distance'])){$_SESSION['type_de_travail']="A distance";}
$_SESSION['type_de_contrat']=$_POST['typeDeTravail'];
$_SESSION['missions']=$_POST['missionsAAccomplir'];
$_SESSION['profil_recherche']=$_POST['profilRecherche'];
$_SESSION['qualites']=$_POST['qualitesRecherches'];
$_SESSION['conditions_de_travail']=$_POST['conditionsDeTravail'];
$_SESSION['salaire']=$_POST['echelleSalariale'];
$_SESSION['monnaie']=$_POST['monnaie'];
$_SESSION['date_limite']=$_POST['dateLimite'];
$_SESSION['lieu_de_reception']=$_POST['lieuDeReception'];
$_SESSION['contacts']=$_POST['contactsEmployeur'];
$_SESSION['autres_informations']=$_POST['autresInformations'];
?>
   <!DOCTYPE html>
   <html lang="fr">
   <head>
       <meta charset="UTF-8">
       <meta lang="<?php echo $lang; ?>">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="height=device-height, initial-scale=1.0">
       <link rel="stylesheet" href="validations.css">
       <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
       <title><?php echo $apercu_de_l_offre[$lang]; ?></title>
   </head>
   <body>
       <header><?php include('header.php') ?></header>
    <nav> <a href="propositionDeServices.php"> <img src="photos/Fleche.png"><?php echo $retour_au_formulaire[$lang]; ?></a></nav>
    <figure id="figureProfil"><img src="photos/profils/<?php echo $_SESSION['avatar']; ?>"></figure>
    <main>
        <h1 id="h11"><?php echo $_SESSION['titre']; ?></h1>
        <p><?php echo $informations_relatives_a_l_offre[$lang]; ?></p>
        <form method="post" action="envoiProposition.php">
            <fieldset id=fieldset1><legend><?php echo $informations_sur_la_nature[$lang]; ?></legend>
                <label for="nomDuPoste"><?php echo $nom_poste_propose[$lang]; ?></label><input type="text" name="nomDuPoste" id="poste" readonly value="<?php echo $_SESSION['poste'];?>"><br>
                <label for="champDactivite"><?php echo $champ_d_activite[$lang]; ?></label><input type="text" readonly id="champ" value="<?php echo $_SESSION['champ_activite'];?>"><br>
                <label><?php echo $type_de_travail[$lang]; ?></label><span id="span"><span class="label"><?php echo $presentiel[$lang]; ?></span><input type="checkbox" <?php if(in_array($_SESSION['type_de_travail'],array("Présentiel","Présentiel et distant"))){echo "checked";}?> name="typeDeTravail_presentiel" value="presentiel" class="radio" readonly> <span id="virtuel"><span class="label"><?php echo $a_distance[$lang]; ?></span><input type="checkbox" <?php if(in_array($_SESSION['type_de_travail'],array("A distance","Présentiel et distant"))){echo "checked";}?> name="typeDeTravail_distance" class="radio" value="A distance" readonly></span></span><br>
                <label><?php echo $type_de_contrat[$lang]; ?></label><span id="span1"><span class="label"><?php echo $pour_un_service_precis[$lang]; ?></span><input type="radio" <?php if($_SESSION['type_de_contrat']=="Pour un service précis"){echo "checked";}?> name="typeDeTravail" value="Pour un service précis" class="radio" readonly> <span id="longterme"><span class="label"><?php echo $a_long_terme[$lang]; ?></span><input type="radio" <?php if($_SESSION['type_de_contrat']=="A long terme"){echo "checked";}?> name="typeDeTravail" class="radio" value="A long terme" readonly></span></span>
            </fieldset>
            <fieldset><legend><?php echo $a_propos_du_futur_employe[$lang]; ?></legend>
               <table>
                <tr title="<?php echo $ensemble_des_responsabilites[$lang]; ?>"><td class="td21"><label for="missionsAAccomplir"><?php echo $missions_a_accomplir[$lang]; ?></label></td><td class="td"><textarea name="missionsAAccomplir" id="missionsAAccomplir" readonly><?php echo $_SESSION['missions'];?></textarea></td></tr>
                <tr title="<?php echo $diplome_requis[$lang]; ?>"><td class="td21"><label for="profilRecherche"><?php echo $profil_et_competences[$lang]; ?></label></td><td class="td"><textarea readonly name="profilRecherche" id="profilRecherche"><?php echo $_SESSION['profil_recherche'];?></textarea></td></tr>
                <tr title="<?php echo $savoirs_etre[$lang]; ?>"><td class="td21"><label for="qualitesRecherches"><?php echo $qualites_soft_skills[$lang]; ?></label></td><td class="td"><textarea name="qualitesRecherches" id="qualitesRecherches" readonly><?php echo $_SESSION['qualites'];?></textarea></td></tr>
                </table>
            </fieldset>
            <fieldset><legend><?php echo $conditions_de_travail[$lang]; ?></legend>
                <table>
                    <tr title="<?php echo $offrez_vous_des_assurances[$lang]; ?>"><td class="td31"><label for="conditionsDeTravail"><?php echo $conditions_de_travail[$lang]; ?> :</label></td><td class="td"><textarea name="conditionsDeTravail" readonly><?php echo $_SESSION['conditions_de_travail'];?></textarea></td></tr>
                    <tr title="<?php echo $salaire_pour_le_responsable[$lang]; ?>"><td class="td31"><label for="echelleSalariale"><?php echo $echelle_salariale[$lang]; ?></label></td><td class="td"><input type="text" value="<?php echo $_SESSION['salaire'];?>" name="echelleSalariale" class="input" id="salaire" readonly> <input type="text" readonly id="monnaie" value="<?php echo $_SESSION['monnaie'];?>"></td></tr>
                </table>
            </fieldset>
            <fieldset><legend><?php echo $a_propos_de_la_reception[$lang]; ?></legend>
                <table>
                    <tr title="<?php echo $date_et_heure_limite[$lang]; ?>"><td class="td41"><label for="dateLimite"><?php echo $date_limite_de_recevabilite[$lang]; ?></label></td><td class="td"><input type="datetime-local" readonly value="<?php echo $_SESSION['date_limite'];?>" name="dateLimite" class="input" id="date"></td></tr>
                    <tr title="<?php echo $lieux_physiques[$lang]; ?>"><td class="td41"><label for="lieuDeReception"><?php echo $lieux_de_reception[$lang]; ?></label></td><td class="td"><textarea name="lieuDeReception" readonly><?php echo $_SESSION['lieu_de_reception'];?></textarea></td></tr>
                    <tr title="<?php echo $par_quels_contacts[$lang]; ?>"><td class="td41"><label for="contactsEmployeur"><?php echo $contacts_employeur[$lang]; ?></label></td><td class="td"><textarea id="contacts" name="contactsEmployeur" readonly><?php echo $_SESSION['contacts'];?></textarea></td></tr>
                    <tr title="<?php echo $vous_pouvez_ajouter_ici[$lang]; ?>"><td class="td41"><label for="autresInformations"><?php echo $autres_informations_ou_details[$lang]; ?></label></td><td class="td"><textarea name="autresInformations" readonly><?php echo $_SESSION['autres_informations'];?></textarea></td></tr>
                </table>
            </fieldset>
            <fieldset id="lastFieldset">
                <div id="auteur"><p><?php echo $auteur[$lang]; ?><?php echo $_SESSION['noms'].' '.$_SESSION['prenoms']; ?></p> <p><?php echo $_SESSION['description_du_profil'];?></p></div>
                <div id="contacterAuteur"> <a href="mailto:<?php echo $_SESSION['adresse_mail']; ?>"><?php echo $contacter_l_employeur[$lang]; ?></a></div>
                <div id="suivreAuteur"><p><?php echo $site_internet_entreprise[$lang]; ?><?php echo $_SESSION['site_entreprise'];?></p></div>
            </fieldset>
            <input type="hidden" value="O" name="hidden">
            <p><input type="submit" value="<?php echo $publier[$lang]; ?>" id="soumission"></p>
        </form>
    </main>
    <footer><?php include("footer.php") ?></footer>
   </body>
   </html>
   <?php
}
?>