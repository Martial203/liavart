<?php session_start(); 
if(isset($_SESSION['user'])){
include("languageDefinition.php");
include("dictionnairePropositionDeServices.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta lang="<?php echo $lang; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="height=device-height, initial-scale=1.0">
    <link rel="stylesheet" href="offreEmploi.css">
    <title><?php echo $publier_une_proposition_de[$lang]; ?></title>
    <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
</head>
<body>
    <header><?php include("header.php") ?></header>
    <nav> <a href="contenus.php?rubrique=portail2"> <img src="photos/Fleche.png"><?php echo $retour_aux_propositions_de[$lang]; ?></a></nav>
    <main>
        <h1 id="h12"><?php echo $formulaire_d_ajout_de_proposition[$lang]; ?></h1>
        <p><?php echo $veuillez_remplir_ce_formulaire[$lang]; ?></p>
        <form method="post" action="validationProposition.php">
            <fieldset id=fieldset1><legend><?php echo $informations_sur_la_nature[$lang]; ?></legend>
             <label for="titreDuService"><?php echo $titre_de_la_proposition[$lang]; ?></label><input type="text" name="titreDuService" id="poste" required><br>
              <label for="nomDuService"><?php echo $nom_poste_propose[$lang]; ?></label><input type="text" name="nomDuService" id="poste" required><br>
                <label for="champDactivite"><?php echo $champ_d_activite[$lang]; ?></label><select name="champDactivite" id="champ" required><option> </option><option value="Numérique/Informatique"><?php echo $numerique[$lang]; ?></option><option value="Mecanique"><?php echo $mecanique[$lang]; ?></option><option value="Electricité"><?php echo $electricite[$lang]; ?></option><option value="Electronique"><?php echo $electronique[$lang]; ?></option><option value="Graphismes"><?php echo $graphisme[$lang]; ?></option><option value="Animation"><?php echo $animation[$lang]; ?></option><option value="Enseignement"><?php echo $enseignement[$lang]; ?></option><option value="Ménager"><?php echo $menager[$lang]; ?></option> <option value="Commerce"><?php echo $commerce[$lang]; ?></option> <option value="Autre"><?php echo $autres[$lang]; ?></option></select><br>
                <label><?php echo $type_de_travail[$lang]; ?></label><span id="span"><span class="label"><?php echo $presentiel[$lang]; ?></span><input type="checkbox" name="typeDeService_presentiel" value="presentiel" class="radio"> <span id="virtuel"><span class="label"><?php echo $a_distance[$lang]; ?></span><input type="checkbox" name="typeDeService_distance" class="radio" value="A distance"></span></span><br>
                <table id="tableAdditive" title="<?php echo $que_faites_vous_concretement[$lang]; ?>"><td><label for="missionsAAccomplir"><?php echo $missions_a_accomplir[$lang]; ?></label></td><td id="col2"><textarea name="missionsAAccomplir" id="missionsAAccomplir" required></textarea></td></table>
            </fieldset>
             <fieldset><legend><?php echo $a_propos_de_moi[$lang]; ?></legend>
               <table>
                <tr title="<?php echo $qu_avez_vous_de_notable[$lang]; ?>"><td class="td21"><label for="monProfil"><?php echo $mon_profil[$lang]; ?></label></td><td class="td"><textarea name="monProfil" id="monProfil"></textarea></td></tr>
                <tr title="<?php echo $vou_competences[$lang]; ?>"><td class="td21"><label for="mesCompetances"><?php echo $mes_competences[$lang]; ?></label></td><td class="td"><textarea name="mesCompetances" id="mesCompetances" required></textarea></td></tr>
                </table>
            </fieldset>
            <fieldset><legend><?php echo $autres_informations[$lang]; ?></legend>
                <table>
                    <tr title="<?php echo $a_queil_prix_vendez_vous[$lang]; ?>"><td class="td41"><label for="prixDuService"><?php echo $prix_du_service[$lang]; ?></label></td><td class="td"><input type="number" name="prixDuService" class="input" id="salaire" required> <select name="monnaie" id="monnaie" required><option value="Dollars">$(<?php echo $dollars_americain[$lang]; ?>)</option><option value="Euros">€(<?php echo $euro[$lang]; ?>)</option><option value="FCFA"><?php echo $fcfa[$lang]; ?></option><option value="Livre sterling">£(<?php echo $livre_sterling[$lang]; ?>)</option><option value="Yuan">¥(<?php echo $yuan[$lang]; ?>)</option><option value="yen">¥(<?php echo $yen[$lang]; ?>)</option> </select></td></tr>
                    <tr title="<?php echo $adresse_mail[$lang]; ?>"><td class="td41"><label for="monContact"><?php echo $mon_contact[$lang]; ?></label></td><td class="td"><textarea id="monContact" name="monContact" required></textarea></td></tr>
                    <tr title="<?php echo $informations_supplementaires_ou[$lang]; ?>"><td class="td41"><label for="autresInformations"><?php echo $informations_supplementaires_ou[$lang]; ?></label></td><td class="td"><textarea name="autresInformations"></textarea></td></tr>
                </table>
            </fieldset>
            <p><?php echo $en_soumetttant_ce_formulaire[$lang]; ?></p>
            <input type="hidden" name="hidden" value="2">
            <p><input type="submit" value="<?php echo $soumettre[$lang]; ?>" id="soumission"> <input type="reset" id="reset" value="<?php echo $reinitialiser[$lang]; ?>"></p>
        </form>
    </main>
    <footer><?php include("footer.php") ?></footer>
</body>
</html>
<?php
}
?>