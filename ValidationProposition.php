<?php session_start();

    include("languageDefinition.php");
    include("dictionnairePropositionDeServices.php");
if(isset($_SESSION['poste']) AND isset($_SESSION['champ']) AND isset($_POST['titreDuService']) AND isset($_POST['monnaie'])){

$_SESSION['titre_proposition']=$_POST['titreDuService'];
$_SESSION['poste']=$_POST['nomDuService'];
$_SESSION['champ']=$_POST['champDactivite'];
if (isset($_POST['typeDeService_presentiel']) AND isset($_POST['typeDeService_distance'])){$_SESSION['type_de_travail']="Présentiel et distant";}
elseif(isset($_POST['typeDeService_presentiel'])){$_SESSION['type_de_travail']="Présentiel";}
elseif(isset($_POST['typeDeService_distance'])){$_SESSION['type_de_travail']="A distance";};
$_SESSION['missions']=$_POST['missionsAAccomplir'];
$_SESSION['profil']=$_POST['monProfil'];
$_SESSION['competences']=$_POST['mesCompetances'];
$_SESSION['prix']=$_POST['prixDuService'];
$_SESSION['monnaie']=$_POST['monnaie'];
$_SESSION['contact']=$_POST['monContact'];
$_SESSION['informations_supplementaires']=$_POST['autresInformations'];
?>
<!DOCTYPE html>
<html lang="en">
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
    <header><?php include("header.php") ?></header>
    <nav> <a href="propositionDeServices.php"> <img src="photos/Fleche.png"><?php echo $retour_au_formulaire[$lang]; ?></a></nav>
    <figure id="figureProfil"><img src="photos/profils/<?php echo $_SESSION['avatar']; ?>"></figure>
    <main>
        <h1 id="h12"><?php echo $_SESSION['titre_proposition']; ?></h1>
        <p><?php echo $informations_relatives_a[$lang]; ?></p>
        <form method="post" action="envoiProposition.php">
            <fieldset id=fieldset1><legend><?php echo $informations_sur_la_nature[$lang]; ?></legend>
              <label for="nomDuService"><?php echo $nom_poste_propose[$lang]; ?> </label><input type="text" name="nomDuService" id="poste" value="<?php echo $_SESSION['poste']; ?>" readonly><br>
                <label for="champDactivite"><?php echo $champ_d_activite[$lang]; ?></label><input type="text" id="champ" value="<?php echo $_SESSION['champ']; ?>" readonly><br>
                <label><?php echo $type_de_travail[$lang]; ?></label><span id="span"><span class="label"><?php echo $presentiel[$lang]; ?></span><input type="checkbox" <?php if(in_array($_SESSION['type_de_travail'],array("Présentiel","Présentiel et distant"))){echo "checked";}?> name="typeDeService_presentiel" value="presentiel" class="radio" readonly> <span id="virtuel"><span class="label"><?php echo $a_distance[$lang]; ?></span><input type="checkbox" <?php if(in_array($_SESSION['type_de_travail'],array("A distance","Présentiel et distant"))){echo "checked";}?> name="typeDeService_distance" class="radio" value="A distance" readonly></span></span><br>
                <table id="tableAdditive" title="<?php echo $que_faites_vous_concretement[$lang]; ?>"><td><label for="missionsAAccomplir"><?php echo $missions_a_accomplir[$lang]; ?></label></td><td id="col2"><textarea name="missionsAAccomplir" id="missionsAAccomplir" readonly><?php echo $_SESSION['missions']; ?></textarea></td></table>
            </fieldset>
             <fieldset><legend><?php echo $a_propos_de_moi[$lang]; ?></legend>
               <table>
                <tr title="<?php echo $qu_avez_vous_de_notable[$lang]; ?>"><td class="td21"><label for="monProfil"><?php echo $mon_profil[$lang]; ?></label></td><td class="td"><textarea name="monProfil" id="monProfil" readonly><?php echo $_SESSION['profil']; ?></textarea></td></tr>
                <tr title="<?php echo $vou_competences[$lang]; ?>"><td class="td21"><label for="mesCompetances"><?php echo $mes_competences[$lang]; ?></label></td><td class="td"><textarea name="mesCompetances" id="mesCompetances" readonly><?php echo $_SESSION['competences']; ?></textarea></td></tr>
                </table>
            </fieldset>
            <fieldset><legend><?php echo $autres_informations[$lang]; ?></legend>
                <table>
                    <tr title="<?php echo $a_queil_prix_vendez_vous[$lang]; ?>"><td class="td41"><label for="prixDuService"><?php echo $prix_du_service[$lang]; ?></label></td><td class="td"><input type="number" name="prixDuService" class="input" id="salaire" readonly value="<?php echo $_SESSION['prix']; ?>"> <input type="text" id="monnaie" value="<?php echo $_SESSION['monnaie']; ?>" readonly></td></tr>
                    <tr title="<?php echo $adresse_mail[$lang]; ?>"><td class="td41"><label for="monContact"><?php echo $mon_contact[$lang]; ?></label></td><td class="td"><textarea id="monContact" name="monContact" readonly><?php echo $_SESSION['contact']; ?></textarea></td></tr>
                    <tr title="<?php echo $informations_supplementaires_ou[$lang]; ?>"><td class="td41"><label for="autresInformations"><?php echo $informations_supplementaires_ou[$lang]; ?> :</label></td><td class="td"><textarea name="autresInformations" readonly><?php echo $_SESSION['informations_supplementaires']; ?></textarea></td></tr>
                </table>
            </fieldset>
            <fieldset id="lastFieldset">
                <div id="auteur"><p><?php echo $auteur[$lang]; ?><?php echo $_SESSION['noms'].' '.$_SESSION['prenoms']; ?></p> <p><?php echo $_SESSION['description_du_profil'];?></p></div>
                <div id="contacterAuteur"> <a href="mailto:<?php echo $_SESSION['adresse_mail']; ?>"><?php echo $contacter_l_employeur[$lang]; ?></a></div>
                <div id="suivreAuteur"><p><?php echo $site_internet_entreprise[$lang]; ?><?php echo $_SESSION['site_entreprise'];?></p></div>
            </fieldset>
            <input type="hidden" name="hidden" value="P">
            <p><input type="submit" value="<?php echo $publier[$lang]; ?>" id="soumission"></p>
        </form>
    </main>
    <footer><?php include("footer.php") ?></footer>
</body>
</html>
<?php 
}
?>