<?php
session_start();
ob_start();
    require __DIR__.'/vendor/autoload.php';

    use Spipu\Html2Pdf\Html2Pdf;

include("languageDefinition.php");
include("dictionnaireElements.php");
include("botsAndCrawlersDetectionFunction.php");

if(isset($_SESSION['user'])==false){
    header('location:connexion.php');
}
else{
    try{
        $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       }
    catch(Exception $e){
        die ('Erreur : '.$e->getMessage());
    }

    if(isset($_GET['nbre'])){
        if(isset($_GET['rubrique'])){
            if($_GET['rubrique']=='favoris'){
                $rub='favoris';
            }
            else{
                $rub='mesOffres';
            }
        }
        else{
            $rub='portail1';
        }
        $req = $bdd -> prepare('SELECT *, DATE_FORMAT(date_de_publication, "%d/%m/%Y %H:%i") AS date_formatee FROM offres_emploi WHERE ID=?');
        $req -> execute(array($_GET['nbre']));
        $donnees = $req->fetch();
        $req ->closeCursor();
        $req2= $bdd -> prepare('SELECT * FROM inscrits WHERE nom_utilisateur=?');
        $req2 -> execute(array($donnees['auteur']));
        $donnees2 = $req2 ->fetch();
        
        if(isset($_GET['export'])==false){
        ?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
               <meta charset="UTF-8">
               <meta lang="<?php echo $lang; ?>">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta name="viewport" content="height=device-height, initial-scale=1.0">
               <link rel="stylesheet" href="validations.css">
               <link rel="stylesheet" href="offreEmploi.css">
               <title><?php echo $donnees['auteur'].': '.$donnees['poste']; ?></title>
               <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
               <meta name="description" content="Objet: <?php echo $donnees['poste'];?>;  Type de contrat: <?php echo $donnees['type_de_contrat'];?>;  Date limite pour candidatures: <?php echo $donnees['date_limite'];?>">
           </head>
           <body>
               <header><?php include('header.php') ?></header>
               <?php

               ?>
            <nav> <span class="navRetour"><a href="contenus.php?rubrique=<?php echo $rub; ?>&amp;pg=<?php echo $_GET['page']; ?>#<?php echo $_GET['nbre']; ?>"> <img alt="Flèche retour" src="photos/Fleche.png"><?php echo $retour_aux_offres[$lang]; ?></a></span><span class="navSpan2Img"><a href="element.php?nbre=<?php echo $_GET['nbre']; ?>&amp;page=<?php echo $_GET['page']; ?>&amp;export=y" download><img alt="Exporter en pdf" src="photos/iconeDownload.png" class="pdfExportIcon" id="eIco"></a></span></nav><br>
            <figure id="figureProfil"><img alt="<?php echo $donnees['auteur']; ?>" src="photos/profils/<?php echo $donnees['avatar_auteur']; ?>"></figure>
            <main>
                <h1 id="h11"><?php echo $donnees['titre']; ?></h1>
                <p><?php echo $informations_sur_l_offre[$lang]; ?></p>
                <form method="post" action="envoiProposition.php">
                    <fieldset id=fieldset1><legend><?php echo $infos_sur_la_nature_de_l_emploi[$lang]; ?></legend>
                        <label for="nomDuPoste"><?php echo $nom_poste[$lang]; ?></label><input type="text" name="nomDuPoste" id="poste" readonly value="<?php echo $donnees['poste'];?>"><br>
                        <label for="champDactivite"><?php echo $champ_activite[$lang]; ?></label><input type="text" readonly id="champ" value="<?php echo $donnees['champ_activite'];?>"><br>
                        <label><?php echo $type_travail[$lang]; ?></label><span id="span"><span class="label"><?php echo $presentiel[$lang]; ?></span><input type="checkbox" <?php if(in_array($donnees['type_de_travail'],array("Présentiel","Présentiel et distant"))){echo "checked";}?> name="typeDeTravail_presentiel" value="presentiel" class="radio" readonly> <span id="virtuel"><span class="label"><?php echo $a_distance[$lang]; ?> </span><input type="checkbox" <?php if(in_array($donnees['type_de_travail'],array("A distance","Présentiel et distant"))){echo "checked";}?> name="typeDeTravail_distance" class="radio" value="A distance" readonly></span></span><br>
                        <label><?php echo $type_de_contrat[$lang]; ?></label><span id="span1"><span class="label"><?php echo $pour_un_service_precis[$lang]; ?> </span><input type="radio" <?php if($donnees['type_de_contrat']=="Pour un service précis"){echo "checked";}?> name="typeDeTravail" value="Pour un service précis" class="radio" readonly> <span id="longterme"><span class="label"><?php echo $long_terme[$lang]; ?> </span><input type="radio" <?php if($donnees['type_de_contrat']=="A long terme"){echo "checked";}?> name="typeDeTravail" class="radio" value="A long terme" readonly></span></span>
                    </fieldset>
                    <fieldset><legend><?php echo $a_propos_futur_employe[$lang]; ?></legend>
                       <table>
                        <tr title="<?php echo $ensemble_des_responsabilites[$lang]; ?>"><td class="td21"><label for="missionsAAccomplir"><?php echo $missions[$lang]; ?></label></td><td class="td"><textarea name="missionsAAccomplir" id="missionsAAccomplir" readonly><?php echo $donnees['missions'];?></textarea></td></tr>
                        <tr title="<?php echo $diplome_requis[$lang]; ?>"><td class="td21"><label for="profilRecherche"><?php echo $profil_et_competences[$lang]; ?></label></td><td class="td"><textarea readonly name="profilRecherche" id="profilRecherche"><?php echo $donnees['profil_recherche'];?></textarea></td></tr>
                        <tr title="<?php echo $savoirs_etre[$lang]; ?>"><td class="td21"><label for="qualitesRecherches"><?php echo $qualites_et_soft_skills[$lang]; ?></label></td><td class="td"><textarea name="qualitesRecherches" id="qualitesRecherches" readonly><?php echo $donnees['qualites'];?></textarea></td></tr>
                        </table>
                    </fieldset>
                    <fieldset><legend><?php echo $conditions_travail[$lang]; ?></legend>
                        <table>
                            <tr title="<?php echo $offre_assurances[$lang]; ?>"><td class="td31"><label for="conditionsDeTravail"><?php echo $conditions_travail[$lang]; ?></label></td><td class="td"><textarea name="conditionsDeTravail" readonly><?php echo $donnees['conditions_de_travail'];?></textarea></td></tr>
                            <tr title="<?php echo $salaire_pour_le[$lang]; ?>"><td class="td31"><label for="echelleSalariale"><?php echo $echelle_salariale[$lang]; ?></label></td><td class="td"><input type="text" value="<?php echo $donnees['salaire'];?>" name="echelleSalariale" class="input" id="salaire" readonly> <input type="text" readonly id="monnaie" value="<?php echo $donnees['monnaie'];?>"></td></tr>
                        </table>
                    </fieldset>
                    <fieldset><legend><?php echo $a_propos_reception[$lang]; ?></legend>
                        <table>
                            <tr title="<?php echo $date_et_heure_limites[$lang]; ?>"><td class="td41"><label for="dateLimite"><?php echo $date_limite[$lang]; ?></label></td><td class="td"><input type="datetime-local" readonly value="<?php echo $donnees['date_formatee'];?>" name="dateLimite" class="input" id="date"></td></tr>
                            <tr title="<?php echo $lieux_physiques[$lang]; ?>"><td class="td41"><label for="lieuDeReception"><?php echo $lieux_de_reception[$lang]; ?></label></td><td class="td"><textarea name="lieuDeReception" readonly><?php echo $donnees['lieu_de_reception'];?></textarea></td></tr>
                            <tr title="<?php echo $par_quels_contacts[$lang]; ?>"><td class="td41"><label for="contactsEmployeur"><?php echo $contacts_employeur[$lang]; ?></label></td><td class="td"><textarea id="contacts" name="contactsEmployeur" readonly><?php echo $donnees['contacts'];?></textarea></td></tr>
                            <tr title="<?php echo $vous_pouvez_ajouter[$lang]; ?>"><td class="td41"><label for="autresInformations"><?php echo $autres_informations[$lang]; ?></label></td><td class="td"><textarea name="autresInformations" readonly><?php echo $donnees['autres_informations'];?></textarea></td></tr>
                        </table>
                    </fieldset>
                    <fieldset id="lastFieldset">
                        <div id="auteur"><p><?php echo $auteur[$lang]; ?><?php echo $donnees['noms_auteur'].' '.$donnees['prenoms_auteur']; ?></p> <p><?php echo $donnees['description_auteur'];?></p></div>
                        <div id="contacterAuteur"> <a href="mailto:<?php echo $donnees['mail']; ?>" target='_blank'><?php echo $contacter_employeur[$lang]; ?></a></div>
                        <div id="suivreAuteur"><p><?php echo $site_internet_entreprise[$lang]; ?><a href="<?php echo $donnees2['site_entreprise'];?>" target='_blank'><?php echo $donnees2['site_entreprise'];?></a></p></div>
                    </fieldset>
                    <input type="hidden" value="O" name="hidden">
                    <p id="signaler"><a href="signaler.php?nbre=<?php echo $_GET['nbre'];?>&amp;page=<?php echo $_GET['page']; ?>"><?php echo $signaler_le_contenu[$lang]; ?></a></p>
                </form>
            </main>
            <footer><?php include("footer.php") ?></footer>
           </body>
           </html>
        <?php
        }
        
        else{ ?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
               <meta charset="UTF-8">
               <meta lang="<?php echo $lang; ?>">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta name="viewport" content="height=device-height, initial-scale=1.0">
               <link rel="stylesheet" href="validations.css">
               <link rel="stylesheet" href="offreEmploi.css">
               <title><?php echo $donnees['auteur'].': '.$donnees['poste']; ?></title>
               <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
               <meta name="description" content="Objet: <?php echo $donnees['poste'];?>;  Type de contrat: <?php echo $donnees['type_de_contrat'];?>;  Date limite pour candidatures: <?php echo $donnees['date_limite'];?>">
           </head>
           <body>
              
                <style type="text/css">
                    #figureProfil img{
                        width: 250px;
                    }
                    #figureProfil{
                        width: 100%;
                        text-align: center;
                    }
                    #h11{
                        width: 100%;
                        text-align: center;
                        text-decoration: underline;
                    }
                    fieldset{
                        width: 97%;
                    }
                    label{
                        font-weight: 500;
                    }
                    legend{
                        font-weight: bold;
                        background-color: #2f2c2c;
                        color: beige;
                        text-align: center;
                        width: 98%;
                    }
                    #poste{
                        width: 20em;
                    }
                    #auteur, #contacterAuteur, #suivreAuteur{
                        width: 100%;
                        text-align: center;
                    }
                    #header{
                        background-color: #b8d6cf;
                        margin: 0em;
                        color: aqua;
                        margin-bottom: 1em;
                    }
                    .tSpan{
                        padding-left: 5em;
                        font-style: italic;
                        text-decoration: underline;
                    }
                    #header{
                        font-size: 50em;
                        text-align: center;
                        color: black;
                    }
                </style>
              
               <div id="header"><img id="LIAVART" alt="Liavart" src="photos/liavartElt.png"></div>
            
            <div id="figure" id="figureProfil"><img alt="<?php echo $donnees['auteur']; ?>" src="photos/profils/<?php echo $donnees['avatar_auteur']; ?>"></div>
            <div id="main">
                <h1 id="h11"><?php echo $donnees['titre']; ?></h1>
                <p><?php echo $informations_sur_l_offre[$lang]; ?></p>
                <form method="post" action="envoiProposition.php">
                    <fieldset id=fieldset1><legend><?php echo $infos_sur_la_nature_de_l_emploi[$lang]; ?></legend>
                       <table>
                        <tr><td><label for="nomDuPoste"><?php echo $nom_poste[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['poste'];?></span></td></tr>
                        <tr><td><label for="champDactivite"><?php echo $champ_activite[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['champ_activite'];?></span></td></tr>
                        <tr><td><label><?php echo $type_travail[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['type_de_travail']; ?></span></td></tr>
                        <tr><td><label><?php echo $type_de_contrat[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php $donnees['type_de_contrat']; ?></span></td></tr>
                        </table>
                    </fieldset><br>
                    <fieldset><legend><?php echo $a_propos_futur_employe[$lang]; ?></legend>
                       <table>
                           <tr title="<?php echo $ensemble_des_responsabilites[$lang]; ?>"><td class="td21"><label for="missionsAAccomplir"><?php echo $missions[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['missions'];?></span></td></tr>
                           <tr title="<?php echo $diplome_requis[$lang]; ?>"><td class="td21"><label for="profilRecherche"><?php echo $profil_et_competences[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['profil_recherche'];?></span></td></tr>
                           <tr title="<?php echo $savoirs_etre[$lang]; ?>"><td class="td21"><label for="qualitesRecherches"><?php echo $qualites_et_soft_skills[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['qualites'];?></span></td></tr>
                        </table>
                    </fieldset><br>
                    <fieldset><legend><?php echo $conditions_travail[$lang]; ?></legend>
                        <table>
                            <tr title="<?php echo $offre_assurances[$lang]; ?>"><td class="td31"><label for="conditionsDeTravail"><?php echo $conditions_travail[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['conditions_de_travail'];?></span></td></tr>
                            <tr title="<?php echo $salaire_pour_le[$lang]; ?>"><td class="td31"><label for="echelleSalariale"><?php echo $echelle_salariale[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['salaire'];?> <?php echo $donnees['monnaie'];?></span></td></tr>
                        </table>
                    </fieldset><br>
                    <fieldset><legend><?php echo $a_propos_reception[$lang]; ?></legend>
                        <table>
                            <tr title="<?php echo $date_et_heure_limites[$lang]; ?>"><td class="td41"><label for="dateLimite"><?php echo $date_limite[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['date_limite'];?></span></td></tr>
                            <tr title="<?php echo $lieux_physiques[$lang]; ?>"><td class="td41"><label for="lieuDeReception"><?php echo $lieux_de_reception[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['lieu_de_reception'];?></span></td></tr>
                            <tr title="<?php echo $par_quels_contacts[$lang]; ?>"><td class="td41"><label for="contactsEmployeur"><?php echo $contacts_employeur[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['contacts'];?></span></td></tr>
                            <tr title="<?php echo $vous_pouvez_ajouter[$lang]; ?>"><td class="td41"><label for="autresInformations"><?php echo $autres_informations[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['autres_informations'];?></span></td></tr>
                        </table>
                    </fieldset>
                    <fieldset id="lastFieldset">
                        <div id="auteur"><p><?php echo $auteur[$lang]; ?><?php echo $donnees['noms_auteur'].' '.$donnees['prenoms_auteur']; ?></p> <p><?php echo $donnees['description_auteur'];?></p></div>
                        <div id="contacterAuteur"> <a href="mailto:<?php echo $donnees['mail']; ?>" target='_blank'><?php echo $contacter_employeur[$lang]; ?></a></div>
                        <div id="suivreAuteur"><p><?php echo $site_internet_entreprise[$lang]; ?><a href="<?php echo $donnees2['site_entreprise'];?>" target='_blank'><?php echo $donnees2['site_entreprise'];?></a></p></div>
                    </fieldset>
                </form>
            </div>
           </body>
           </html>
           <?php
        }
       
        
        
    }
    elseif(isset($_GET['nber'])){
        if(isset($_GET['rubrique'])){
            if($_GET['rubrique']=='favoris'){
                $rub='favoris';
            }
            else{
                $rub='mesOffres';
            }
        }
        else{
            $rub='portail2';
        }
        $req = $bdd -> prepare('SELECT *, DATE_FORMAT(date_publication, "Le %d\%m\%Y à %H:%i") AS date_formatee FROM offres_services WHERE ID=?');
        $req -> execute(array($_GET['nber']));
        $donnees = $req->fetch();
        $req ->closeCursor();
        $req2= $bdd -> prepare('SELECT * FROM inscrits WHERE nom_utilisateur=?');
        $req2 -> execute(array($donnees['auteur']));
        $donnees2 = $req2 ->fetch();
        
        if(isset($_GET['export'])){
        ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta lang="<?php echo $lang; ?>">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta name="viewport" content="height=device-height, initial-scale=1.0">
                <link rel="stylesheet" href="elementPdf.css">
                <title><?php echo $donnees['auteur'].': '.$donnees['poste']; ?></title>
                <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
                <meta name="description" content="Objet: <?php echo $donnees['poste'];?>;  Champ d'activité: <?php echo $donnees['champ'];?>;  Type de travail: <?php echo $donnees['type_travail'];?>;">
            </head>
            <body>
                <style type="text/css">
                    #figureProfil img{
                        width: 250px;
                    }
                    #figureProfil{
                        width: 100%;
                        text-align: center;
                    }
                    #h12{
                        width: 100%;
                        text-align: center;
                        text-decoration: underline;
                    }
                    fieldset{
                        width: 97%;
                    }
                    label{
                        font-weight: 500;
                    }
                    legend{
                        font-weight: bold;
                        background-color: #2f2c2c;
                        color: beige;
                        text-align: center;
                        width: 98%;
                    }
                    #poste{
                        width: 20em;
                    }
                    #auteur, #contacterAuteur, #suivreAuteur{
                        width: 100%;
                        text-align: center;
                    }
                    #header{
                        background-color: #b8d6cf;
                        margin: 0em;
                        color: aqua;
                        margin-bottom: 1em;
                        text-align: center;
                    }
                    .tSpan{
                        padding-left: 5em;
                        font-style: italic;
                        text-decoration: underline;
                    }
                </style>
                <div id="header"><img id="LIAVART" alt="Liavart" src="photos/liavartElt.png"></div>
                <div id="figure" id="figureProfil"><img src="photos/profils/<?php echo $donnees['avatar_auteur']; ?>"></div>
                <div id="main">
                    <h1 id="h12"><?php echo $donnees['titre_proposition']; ?></h1>
                    <p><?php echo $informations_sur_l_offre[$lang]; ?></p>
                    <form method="post" action="envoiProposition.php">
                        <fieldset id=fieldset1><legend><?php echo $infos_sur_nature_service[$lang]; ?></legend>
                         <table><tr>
                          <td><label for="nomDuService"><?php echo $nom_poste[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['poste']; ?></span></td></tr>
                            <tr><td><label for="champDactivite"><?php echo $champ_activite[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['champ']; ?></span></td></tr>
                             <tr><td><label><?php echo $type_travail[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['type_travail']; ?></span></td></tr></table>
                            <table id="tableAdditive" title="<?php echo $que_faites_vous_concretement[$lang]; ?>"><tr><td><label for="missionsAAccomplir"><?php echo $missions[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['missions']; ?></span></td></tr></table>
                        </fieldset><br>
                         <fieldset><legend><?php echo $a_prop_de_moi[$lang]; ?></legend>
                           <table>
                            <tr title="<?php echo $qu_avez_vous_de_notable[$lang]; ?>"><td class="td21"><label for="monProfil"><?php echo $mon_profil[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['profil']; ?></span></td></tr>
                            <tr title="<?php echo $vos_competences_associees[$lang]; ?>"><td class="td21"><label for="mesCompetances"><?php echo $mes_competences[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['competences']; ?></span></td></tr>
                            </table>
                        </fieldset><br>
                        <fieldset id="autresInf"><legend><?php echo $autres_inf[$lang]; ?></legend>
                            <table>
                                <tr title="<?php echo $a_quel_prix[$lang]; ?>"><td class="td41"><label for="prixDuService"><?php echo $prix_service[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['prix']; ?> <?php echo $donnees['monnaie']; ?></span></td></tr>
                                <tr title="<?php echo $adresse_mail[$lang]; ?>"><td class="td41"><label for="monContact"><?php echo $mon_contact[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['contact']; ?></span></td></tr>
                                <tr title="<?php echo $infos_sup[$lang]; ?>"><td class="td41" id="td41"><label for="autresInformations"><?php echo $infos_sup[$lang]; ?></label></td></tr><tr><td class="col2">&nbsp;&nbsp;&nbsp;<span class="tSpan"><?php echo $donnees['informations_supplementaires']; ?></span></td></tr>
                            </table>
                        </fieldset><br>
                        <fieldset id="lastFieldset">
                            <div id="auteur"><p><?php echo $auteur[$lang]; ?><?php echo $donnees['noms_auteur'].' '.$donnees['prenoms_auteur']; ?></p> <p><?php echo $donnees['description_auteur'];?></p></div>
                            <div id="contacterAuteur"> <a href="mailto:<?php echo $donnees['mail']; ?>" target='_blank'><?php echo $contacter_offreur[$lang]; ?></a></div>
                            <div id="suivreAuteur"><p><?php echo $site_internet_entreprise[$lang]; ?><a href="<?php echo $donnees2['site_entreprise'];?>" target='_blank'><?php echo $donnees2['site_entreprise'];?></a></p></div>
                        </fieldset>
                    </form>
                </div>
            </body>
            </html>
        <?php
        }
        
        
        else{
            ?>
            
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta lang="<?php echo $lang; ?>">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta name="viewport" content="height=device-height, initial-scale=1.0">
                <link rel="stylesheet" href="validations.css">
                <link rel="stylesheet" href="offreEmploi.css">
                <title><?php echo $donnees['auteur'].': '.$donnees['poste']; ?></title>
                <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
                <meta name="description" content="Objet: <?php echo $donnees['poste'];?>;  Champ d'activité: <?php echo $donnees['champ'];?>;  Type de travail: <?php echo $donnees['type_travail'];?>;">
            </head>
            <body>
                <header><?php include("header.php") ?></header>
                <nav> <span class="navRetour"><a href="contenus.php?rubrique=<?php echo $rub; ?>&amp;pg=<?php echo $_GET['page']; ?>#<?php echo $_GET['nber']; ?>"> <img alt="<?php echo $donnees['auteur']; ?>" src="photos/Fleche.png"><?php echo $retour_aux_offres[$lang]; ?>.</a></span><span class="navSpan2Img"><a href="element.php?nber=<?php echo $_GET['nber']; ?>&amp;page=<?php echo $_GET['page']; ?>&amp;export=y" download><img alt="Exporter en pdf" src="photos/iconeDownload.png" class="pdfExportIcon" id="eIco"></a></span></nav><br>
                <figure id="figureProfil"><img src="photos/profils/<?php echo $donnees['avatar_auteur']; ?>"></figure>
                <main>
                    <h1 id="h12"><?php echo $donnees['titre_proposition']; ?></h1>
                    <p><?php echo $informations_sur_l_offre[$lang]; ?></p>
                    <form method="post" action="envoiProposition.php">
                        <fieldset id=fieldset1><legend><?php echo $infos_sur_nature_service[$lang]; ?></legend>
                          <label for="nomDuService"><?php echo $nom_poste[$lang]; ?></label><input type="text" name="nomDuService" id="poste" value="<?php echo $donnees['poste']; ?>" readonly><br>
                            <label for="champDactivite"><?php echo $champ_activite[$lang]; ?></label><input type="text" id="champ" value="<?php echo $donnees['champ']; ?>" readonly><br>
                            <label><?php echo $type_travail[$lang]; ?></label><span id="span"><span class="label"><?php echo $presentiel[$lang]; ?></span><input type="checkbox" <?php if(in_array($donnees['type_travail'],array("Présentiel","Présentiel et distant"))){echo "checked";}?> name="typeDeService_presentiel" value="presentiel" class="radio" readonly> <span id="virtuel"><span class="label"><?php echo $a_distance[$lang]; ?></span><input type="checkbox" <?php if(in_array($donnees['type_travail'],array("A distance","Présentiel et distant"))){echo "checked";}?> name="typeDeService_distance" class="radio" value="A distance" readonly></span></span><br>
                            <table id="tableAdditive" title="<?php echo $que_faites_vous_concretement[$lang]; ?>"><tr><td><label for="missionsAAccomplir"><?php echo $missions[$lang]; ?></label></td><td id="col2"><textarea name="missionsAAccomplir" id="missionsAAccomplir" readonly><?php echo $donnees['missions']; ?></textarea></td></tr></table>
                        </fieldset>
                         <fieldset><legend><?php echo $a_prop_de_moi[$lang]; ?></legend>
                           <table>
                            <tr title="<?php echo $qu_avez_vous_de_notable[$lang]; ?>"><td class="td21"><label for="monProfil"><?php echo $mon_profil[$lang]; ?></label></td><td class="td"><textarea name="monProfil" id="monProfil" readonly><?php echo $donnees['profil']; ?></textarea></td></tr>
                            <tr title="<?php echo $vos_competences_associees[$lang]; ?>"><td class="td21"><label for="mesCompetances"><?php echo $mes_competences[$lang]; ?></label></td><td class="td"><textarea name="mesCompetances" id="mesCompetances" readonly><?php echo $donnees['competences']; ?></textarea></td></tr>
                            </table>
                        </fieldset>
                        <fieldset><legend><?php echo $autres_inf[$lang]; ?></legend>
                            <table>
                                <tr title="<?php echo $a_quel_prix[$lang]; ?>"><td class="td41"><label for="prixDuService"><?php echo $prix_service[$lang]; ?></label></td><td class="td"><input type="number" name="prixDuService" class="input" id="salaire" readonly value="<?php echo $donnees['prix']; ?>"> <input type="text" id="monnaie" value="<?php echo $donnees['monnaie']; ?>" readonly></td></tr>
                                <tr title="<?php echo $adresse_mail[$lang]; ?>"><td class="td41"><label for="monContact"><?php echo $mon_contact[$lang]; ?></label></td><td class="td"><textarea id="monContact" name="monContact" readonly><?php echo $donnees['contact']; ?></textarea></td></tr>
                                <tr title="<?php echo $infos_sup[$lang]; ?>"><td class="td41"><label for="autresInformations"><?php echo $infos_sup[$lang]; ?></label></td><td class="td"><textarea name="autresInformations" readonly><?php echo $donnees['informations_supplementaires']; ?></textarea></td></tr>
                            </table>
                        </fieldset>
                        <fieldset id="lastFieldset">
                            <div id="auteur"><p><?php echo $auteur[$lang]; ?><?php echo $donnees['noms_auteur'].' '.$donnees['prenoms_auteur']; ?></p> <p><?php echo $donnees['description_auteur'];?></p></div>
                            <div id="contacterAuteur"> <a href="mailto:<?php echo $donnees['mail']; ?>" target='_blank'><?php echo $contacter_offreur[$lang]; ?></a></div>
                            <div id="suivreAuteur"><p><?php echo $site_internet_entreprise[$lang]; ?><a href="<?php echo $donnees2['site_entreprise'];?>" target='_blank'><?php echo $donnees2['site_entreprise'];?></a></p></div>
                        </fieldset>
                        <input type="hidden" name="hidden" value="P">
                        <p id="signaler"><a href="signaler.php?nber=<?php echo $_GET['nber'];?>&amp;page=<?php echo $_GET['page']; ?>"><?php echo $signaler_le_contenu[$lang]; ?></a></p>
                    </form>
                </main>
                <footer><?php include("footer.php") ?></footer>
            </body>
            </html>
            
            <?php
        }
        
        
    }
    if(isset($_GET['rs'])){
                        ?>
                        <script type="text/javascript">alert('<?php echo $votre_signal[$lang]; ?>');</script>
                        <?php
                    }
}

if(isset($_GET['export'])){
    $content=ob_get_clean();
    $html2pdf = new Html2Pdf('P', 'A4', 'en');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->output($donnees['poste'].': '.$donnees['auteur'].'.pdf');
}
?>
