<?php session_start();

include("botsAndCrawlersDetectionFunction.php");
include("languageDefinition.php");
include("dictionnaireContenus.php");

if(isset($_SESSION['user'])==false AND crawlerDetect($_SERVER['HTTP_USER_AGENT'])==false){
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

    if(isset($_GET['favNbre']) OR isset($_GET['favNber']) OR isset($_GET['supFavNbre']) OR isset($_GET['supFavNber'])){
        include('ajouterOuSupprimerFavoris.php');
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta lang="<?php echo $lang; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="height=device-height, initial-scale=1.0">
        <?php
        if(isset($_GET['rubrique'])==true AND $_GET['rubrique']=="portail1"){
            ?>
            <title><?php echo $offres_d_emploi_et_demandes[$lang]; ?></title>
            <meta name="description" content="<?php echo $descConsultezLaListeDesEmplois[$lang]; ?>">
            <?php
        }
        elseif($_GET['rubrique']=="portail2"){
            ?>
            <title><?php echo $demandes_d_emploi_et_prop[$lang]; ?></title>
            <meta name="description" content="<?php echo $descConsultezLaListeDesServices[$lang]; ?>">
            <?php
        }
        elseif($_GET['rubrique']=="mesOffres"){
            ?>
            <title><?php echo $mes_publications_sur_liavart[$lang]; ?></title>
            <meta name="description" content="<?php echo $descConsultezLaListeDeMesPubs[$lang]; ?>">
            <?php
        }
        else{
            ?>
            <title>LIAVART</title>
            <meta name="googlebot" content="noindex">
            <?php
        }
        ?>
        <link rel="stylesheet" href="contenus.css">
        <link rel="stylesheet" href="offres.css">
        <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
    </head>
    <body>
        <header><?php include("header.php") ?></header>

        <span id="depliantLeft"><a href="#"><img src="photos/depliantAsides.png"></a></span>
        <span id="depliantRight"><a href="#"><img src="photos/depliantAsides.png"></a></span>

        <div id="body"> 
        <aside id="left">
            <?php include("aside.php") ?>
        </aside>  
        <main> 

            <nav>
              <?php
                if (isset($_GET["rubrique"])){
                $rubrique=htmlspecialchars($_GET["rubrique"]);
                }
                else{
                $rubrique="portail1";
                }
                if ($rubrique=="portail2"){
                echo '<h2>'.$proposition_de_services[$lang].'</h2>';    
                }
                elseif ($rubrique=="mesOffres"){
                echo '<h2>'.$mes_publications[$lang].'</h2>';
                }
                elseif ($rubrique=="favoris"){
                echo '<h2>'.$mes_favoritos[$lang].'</h2>';
                }
                elseif ($rubrique=="parametres"){
                echo '<h2>'.$mes_parametres[$lang].'</h2>';
                }
                elseif ($rubrique=="deconnexion"){
                echo '<h2>'.$se_deconnecter[$lang].'</h2>';
                }
                else{
                echo '<h2>'.$offres_d_emploi_et_demandes[$lang].'</h2>';
                }
              ?>
               <ul> 
                <?php 
                   if (in_array($rubrique,array("deconnexion","parametres"))==false){ 
                        ?><li id="searchBar"><form method="post" action="contenus.php?rubrique=<?php echo $rubrique ;?>"><input id="rechercher"class="input" type="search" placeholder="<?php echo $rechercher[$lang]; ?>" name="search"><button type="submit"><img class="submit" src="photos/search.png" alt="<?php echo $altSearchIcon[$lang]; ?>"></button></form></li> <li id="sort"><form method="post" action="contenus.php?rubrique=<?php echo $rubrique; ?>"><label for="tri"> <?php echo $trier_par[$lang];?></label><SELECT class="input" name="tri" id="tri"><option value="aucun"><?php echo $aucun[$lang];?></option><option value="auteur"><?php echo $entreprise[$lang];?></option><option value="jour"><?php echo $date[$lang];?></option><option value="champ_activite"><?php echo $categorie[$lang] ;?></option></SELECT><button type="submit"><img class="submit" src="photos/search.png" alt="<?php echo $altSearchIcon[$lang]; ?>"></button></form></li> 
                        <?php
                   }
                ?>
            </ul>
        </nav>
        <section>
            <?php
            if(isset($_POST['search'])){
                        include('recherche.php');
                    }
            elseif(isset($_POST['tri'])){
                include('tri.php');
            }
                    else{

                switch($rubrique){

                case "parametres":

                    if(isset($_GET['todo'])){
                        include('profil.php'); ?>
                    <?php                
                    }
                    elseif(isset($_GET['ok'])){
                        include('parametres.php'); ?>
                    <?php
                    }          
                    else{ 
                    ?>
                    <p id='parametresIntro'><?php echo $que_souhaitez_vous_faire[$lang];?></p>
                    <div id='parametresBlock1'><a href='contenus.php?rubrique=<?php echo $rubrique.'&amp;'; ?>todo=profil'><div id='sousBlock1'><?php echo $modifier_mon_logo[$lang];?></div></a><a href='contenus.php?rubrique=<?php echo $rubrique.'&amp;'; ?>todo=password'><div id='sousBlock2'><?php echo $modifier_mon_mot_de_passe[$lang];?></div></a></div>
                    <a href='contenus.php?rubrique=<?php echo $rubrique.'&amp;'; ?>todo=rest'><div id='parametresBlock2'><?php echo $modifier_le_reste_de_mes[$lang];?></div></a>
                    <?php
                    } 
                    if(isset($_GET['rslt'])){
                        include('resultats.php'); ?>
                    <?php 
                    }
                break;



                case "portail2":
                    include('portail2.php');                
                break;

                case "mesOffres":
                    include('mesOffres.php');
                break;

                case "favoris":
                    include('afficherFavoris.php');
                break;

                case "deconnexion":
                    echo '<div id="deconnecter"><p id="p1">'.$voulez_vous_vraiment[$lang].'</p><p id="p2"><a href="accueil.php?J=C">'.$oui[$lang].' </a><a href="contenus.php?rubrique=portail1">'.$non[$lang].'</a></p></div>';
                break;

                default:
                    include('default.php');
                    }

            }
            ?>
        </section>
        </main>
           <aside id="right">
           <form method="post" action="#" id="formChoixLangue1" class="langChoiceCont"><label><?php echo $changer_de_langue[$lang]; ?> </label><div><select name="lang"><option value="fr"<?php if($lang=="fr"){echo "selected";} ?>>Francais</option>
<option value="en"<?php if($lang=="en"){echo "selected";} ?>>English</option>
<option value="zh-Hant"<?php if($lang=="zh-Hant"){echo "selected";} ?>>中國人</option>
<option value="ja"<?php if($lang=="ja"){echo "selected";} ?>>日本語</option>
<option value="de"<?php if($lang=="de"){echo "selected";} ?>>Deutsch</option>
<option value="es"<?php if($lang=="es"){echo "selected";} ?>>Español</option>
<option value="hi"<?php if($lang=="hi"){echo "selected";} ?>>हिंदी</option>
<option value="bn"<?php if($lang=="bn"){echo "selected";} ?>>বাংলা</option>
<option value="pt"<?php if($lang=="pt"){echo "selected";} ?>>Português</option>
<option value="ru"<?php if($lang=="ru"){echo "selected";} ?>>Pусский</option>
<!--<option value="ar">عربي</option>-->
</select>
<button type="submit"><img src="photos/tickValidation.png"></button></div></form>
            <?php
            if ($rubrique=="portail1"){
            echo '<a href="offreEmpoi.php"><figure><img alt="'.$altIconeAjout[$lang].'" id="plus" src="photos/ajout.png"> <figcaption> '.$ajouter_une_offre[$lang].'</figcaption></figure></a>';
            }
            elseif ($rubrique=="portail2"){
            echo '<a href="propositionDeServices.php"><figure><img alt="'.$altIconeAjout[$lang].'" id="plus" class="proposition" src="photos/ajout.png"> <figcaption class="proposition">'.$ajouter_une_proposition[$lang].'</figcaption></figure></a>';
            }
            else{

            }
            ?>
        </aside></div>
        <script type="text/javascript" src="depliants.js"></script>
        <footer><?php include("footer.php") ?></footer>
    </body>
    </html>
    <?php 
} 
?>