<?php session_start();

if(isset($_SESSION['user'])){

$userInfos = getenv("HTTP_USER_AGENT");
include("languageDefinition.php");
include("dictionnaireOffreEmploi.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta lang="<?php echo $lang; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="height=device-height, initial-scale=1.0">
    <link rel="stylesheet" href="offreEmploi.css">
    <title><?php echo $publier_une_offre[$lang]; ?></title>
    <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
</head>
<body>
    <header><?php include("header.php") ?></header>
    <nav> <a href="contenus.php?rubrique=portail1"> <img src="photos/Fleche.png"><?php echo $retour_aux_offres_et[$lang]; ?></a></nav>
    <main>
        <h1 id="h11"><?php echo $formulaire_d_ajout_d_offre[$lang]; ?></h1>
        <p><?php echo $veuillez_remplir_ce_formulaire[$lang]; ?></p>
        <form method="post" action="validationOffre.php">
            <fieldset id=fieldset1><legend><?php echo $informations_sur_la_nature[$lang]; ?></legend>
                <label for="titreOffre"><?php echo $titre_de_l_offre[$lang]; ?></label><input type="text" name="titreOffre" id="titreOffre" required><br>
                <label for="nomDuPoste"><?php echo $nom_poste_propose[$lang]; ?></label><input type="text" name="nomDuPoste" id="poste" required><br>
                <label for="champDactivite"><?php echo $champ_d_activite[$lang]; ?></label><select name="champDactivite" id="champ" class="input" required><option> </option><option value="Numérique/Informatique"><?php echo $numerique[$lang]; ?></option><option value="Mecanique"><?php echo $mecanique[$lang]; ?></option><option value="Electricité"><?php echo $electricite[$lang]; ?></option><option value="Electronique"><?php echo $electronique[$lang]; ?></option><option value="Graphisme"><?php echo $graphisme[$lang]; ?></option><option value="Animation"><?php echo $animation[$lang]; ?></option><option value="Enseignement"><?php echo $enseignement[$lang]; ?></option><option value="Ménager"><?php echo $menager[$lang]; ?></option><option value="Commerce"><?php echo $commerce[$lang]; ?></option> <option value="Autre"><?php echo $autres[$lang]; ?></option></select><br>
                <label><?php echo $type_de_travail[$lang]; ?></label><span id="span"><span class="label"><?php echo $presentiel[$lang]; ?></span><input type="checkbox" name="typeDeTravail_presentiel" value="presentiel" class="radio"> <span id="virtuel"><span class="label"><?php echo $a_distance[$lang]; ?></span><input type="checkbox" name="typeDeTravail_distance" class="radio" value="A distance"></span></span><br>
                <label><?php echo $type_de_contrat[$lang]; ?></label><span id="span1"><span class="label"><?php echo $pour_un_service_precis[$lang]; ?></span><input type="radio" name="typeDeTravail" value="Pour un service précis" class="radio"> <span id="longterme"><span class="label"><?php echo $a_long_terme[$lang]; ?></span><input type="radio" name="typeDeTravail" class="radio" value="A long terme"></span></span>
            </fieldset>
            <fieldset><legend><?php echo $a_propos_du_futur_employe[$lang]; ?></legend>
               <table>
                <tr title="<?php echo $ensemble_des_responsabilites[$lang]; ?>"><td class="td21"><label for="missionsAAccomplir"><?php echo $missions_a_accomplir[$lang]; ?></label></td><td class="td"><textarea name="missionsAAccomplir" id="missionsAAccomplir" required></textarea></td></tr>
                <tr title="<?php echo $diplome_requis[$lang]; ?>"><td class="td21"><label for="profilRecherche"><?php echo $profil_et_competences[$lang]; ?></label></td><td class="td"><textarea required name="profilRecherche" id="profilRecherche"></textarea></td></tr>
                <tr title="<?php echo $savoirs_etre[$lang]; ?>"><td class="td21"><label for="qualitesRecherches"><?php echo $qualites_soft_skills[$lang]; ?></label></td><td class="td"><textarea name="qualitesRecherches" id="qualitesRecherches"></textarea></td></tr>
                </table>
            </fieldset>
            <fieldset><legend><?php echo $conditions_de_travail[$lang]; ?></legend>
                <table>
                    <tr title="<?php echo $offrez_vous_des_assurances[$lang]; ?>"><td class="td31"><label for="conditionsDeTravail"><?php echo $conditions_de_travail[$lang]; ?> :</label></td><td class="td"><textarea name="conditionsDeTravail"></textarea></td></tr>
                    <tr title="<?php echo $salaire_pour_le_responsable[$lang]; ?>"><td class="td31"><label for="echelleSalariale"><?php echo $echelle_salariale[$lang]; ?></label></td><td class="td"><input type="number" name="echelleSalariale" class="input" id="salaire" required> <select name="monnaie" id="monnaie" required><option value="Dollars">$(<?php echo $dollars_americain[$lang]; ?>)</option><option value="Euros">€(<?php echo $euro[$lang]; ?>)</option><option value="FCFA"><?php echo $fcfa[$lang]; ?></option><option value="Livre sterling">£(<?php echo $livre_sterling[$lang]; ?>)</option><option value="Yuan">¥(<?php echo $yuan[$lang]; ?>)</option><option value="yen">¥(<?php echo $yen[$lang]; ?>)</option> </select></td></tr>
                </table>
            </fieldset>
            <fieldset><legend><?php echo $a_propos_de_la_reception[$lang]; ?></legend>
                <table>
                    <tr title="<?php echo $date_et_heure_limite[$lang]; ?>"><td class="td41"><label for="dateLimite"><?php echo $date_limite_de_recevabilite[$lang]; ?></label></td><td class="td">
                    <?php if(strpos($userInfos,'Firefox')!==false){?>
                    <input type="date" name="dateLimite" class="input" id="date" placeholder="jj/mm/aaaa hh:mm">
                    <?php
                    }
                    else{?>
                    <input type="datetime-local" name="dateLimite" class="input" id="date" placeholder="jj/mm/aaaa hh:mm">
                    <?php } ?>
                    </td></tr>
                    <tr title="<?php echo $lieux_physiques[$lang]; ?>"><td class="td41"><label for="lieuDeReception"><?php echo $lieux_de_reception[$lang]; ?></label></td><td class="td"><textarea name="lieuDeReception" required></textarea></td></tr>
                    <tr title="<?php echo $par_quels_contacts[$lang]; ?>"><td class="td41"><label for="contactsEmployeur"><?php echo $contacts_employeur[$lang]; ?></label></td><td class="td"><textarea id="contacts" name="contactsEmployeur" required></textarea></td></tr>
                    <tr title="<?php echo $vous_pouvez_ajouter_ici[$lang]; ?>"><td class="td41"><label for="autresInformations"><?php echo $autres_informations_ou_details[$lang]; ?></label></td><td class="td"><textarea name="autresInformations"></textarea></td></tr>
                </table>
            </fieldset>
            <p><?php echo $en_soumettant_ce_formulaire[$lang]; ?></p>
            <input type="hidden" name="hidden" value="1">
            <p><input type="submit" value="<?php echo $soumettre[$lang]; ?>" id="soumission"> <input type="reset" id="reset" value="<?php echo $reinitialiser[$lang]; ?>"></p>
        </form>
    </main>
    <footer><?php include("footer.php") ?></footer>
</body>
</html>
<?php
}
?>