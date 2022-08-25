<!DOCTYPE html>
<?php
include("languageDefinition.php");
include("dictionnaireInscription.php");
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta lang="<?php echo $lang; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="height=device-height, initial-scale=1.0">
    <link rel="stylesheet" href="inscription.css">
    <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
    <title><?php echo $inscription[$lang]; ?></title>
    <meta name="description" content="Inscrivez-vous sur le marché electronique du travail et découvrez les offreurs et demandeurs d'emploi, les demandeurs et proposeurs de services proches de chez vous !">
</head>
<body>
    <header><?php include("header.php") ?></header><br id="br2">
    <nav> <a href="accueil.php"> <img src="photos/Fleche.png"><?php echo $retour_a_l_accueil[$lang]; ?></a></nav>
    <main>
       <h1><?php echo $inscription[$lang]; ?></h1>
        <p id="p1"><?php echo $veuillez_remplir[$lang]; ?></p>
        <div>
            <form method="post" action="inscription2.php">
               <div id="formulaire">
                <table>
                <tr><td class="col1"><label for="noms"><?php echo $noms[$lang]; ?></label></td><td class="col2"><input class="input" required type="text" name="noms"></td></tr>
                <tr><td class="col1"><label for="prenoms"><?php echo $prenoms[$lang]; ?></label></td><td class="col2"><input class="input" required type="text" name="prenoms"></td></tr>
                <tr><td class="col1"><label for="sexe"><?php echo $sexe[$lang]; ?></label></td> <td class="col2"><?php echo $m[$lang]; ?><input type="radio" name="sexe" value="masculin"><?php echo $f[$lang]; ?><input type="radio" name="sexe" value="feminin"></td></tr>
                <tr><td class="col1"><label for="paysDeResidence"><?php echo $pays_de_residence[$lang]; ?></label></td><td class="col2">
                    <select class="input" required name="paysDeResidence">
                       <option></option>
                        <?php
                            switch($lang){
                                case "fr":
                                    include("listeDesPaysFr.html");
                            break;
                                case "en":
                                    include("listeDesPaysEn.html");
                            break;
                                case "zh-Hant":
                                    include("listeDesPaysZh.html");
                            break;
                                case "ja":
                                    include("listeDesPaysJa.html");
                            break;
                                case "de":
                                    include("listeDesPaysDe.html");
                            break;
                                case "es":
                                    include("listeDesPaysEs.html");
                            break;
                                case "pt":
                                    include("listeDesPaysPt.html");
                            break;
                                case "ru":
                                    include("listeDesPaysRu.html");
                            break;
                                case "hi":
                                    include("listeDesPaysHi.html");
                            break;
                                case "bn":
                                    include("listeDesPaysBn.html");
                            break;
                                default:
                                    include("listeDesPaysEn.html");
                            }
                        ?>
                    </select></td></tr>
                <tr><td class="col1"><label for="villeDeResidence"><?php echo $ville_de_residence[$lang]; ?></label></td><td class="col2"><input class="input" type="text" name="villeDeResidence" required></td>
                <tr><td class="col1"><label for="adresseMail"><?php echo $adresse_mail[$lang]; ?></label></td><td class="col2"><input class="input" type="email" required name="adresseMail" pattern="^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$" placeholder="Exemple: user@gmail.com"></td>
                <tr><td class="col1"><label for="userName"><?php echo $nom_utilisateur[$lang]; ?></label></td><td class="col2"><input class="input" type="text" required name="userName" placeholder="<?php echo $nom_qui_sera_vu[$lang]; ?>"></td>
                <tr><td class="col1"><label for="password"><?php echo $mot_de_passe[$lang]; ?></label></td><td class="col2"><input class="input" type="password" required name="password" placeholder="<?php echo $au_moins_cinq[$lang]; ?>" minlength="5" maxlength="30"></td>
                <tr><td class="col1"><label for="description"><?php echo $description_de_votre_profil[$lang]; ?></label> <br><textarea name="description" id="description" placeholder="<?php echo $description_qui_paraitra[$lang]; ?>" required></textarea></td></tr>
                </table>
                <div id="fakeDiv"></div>
                <p id="profil"><br><span id="etape"><?php echo $etape[$lang]; ?></span><br><br><br>
                <label for="siteInternet"><?php echo $site_entreprise[$lang]; ?></label><br><input class="input" id="siteInternet" type="text" name="siteInternet" placeholder="www.exemple.com" title="www.exemple.com" pattern="^w{3}\.[a-z0-9][a-z0-9\.\-]{1,}[a-z0-9]\.[a-z]{2,6}"><br>
                <label for="pagesEntreprise"><?php echo $ou_suivre_l_entreprise[$lang]; ?></label><br><textarea name=pagesEntreprise id="pagesEntreprise" placeholder=
                "<?php echo $adresse_de_la_page[$lang]; ?>"></textarea></p>
                </div>
                <p id="soumissionEtReinitialisation"><input type="submit" value="<?php echo $soumettre[$lang]; ?>"> <input type="reset" value="<?php echo $reinitialiser[$lang]; ?>"></p>
            </form>
        </div>
       
    </main>
    <footer><?php include("footer.php") ?></footer>
</body>
</html>