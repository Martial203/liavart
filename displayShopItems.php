<?php
    $shop=0;
    $compteur=0;
    include("botsAndCrawlersDetectionFunction.php");
    include("languageDefinition.php");
    include("dictionnaireDisplayShopItems.php");
    try{
        $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       }
    catch(Exception $e){
        die ('Erreur : '.$e->getMessage());
    }
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta lang="fr">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="height=device-height, initial-scale=1.0">
        <title><?php echo $produits_en_vente[$lang]; ?></title>
        <meta name="description" content="<?php echo $decouvrez_divers_produits[$lang]; ?>">
            
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
            <h2><?php echo $categoris_d_articles[$lang]; ?></h2>
            <h3><a href="displayShopItems.php?categ=recents"><?php echo $les_plus_recents[$lang]; ?></a></h3>
            <h3><a href="displayShopItems.php?categ=menager"><?php echo $menager[$lang]; ?></a></h3>
            <h3><a href="displayShopItems.php?categ=livre"><?php echo $livres[$lang]; ?></a></h3>
            <h3><a href="displayShopItems.php?categ=highTech"><?php echo $high_tech[$lang]; ?></a></h3>
            <h3><a href="displayShopItems.php?categ=informatique"><?php echo $informatique[$lang]; ?></a></h3>
            <h3><a href="displayShopItems.php?categ=vetements"><?php echo $vetements_et_mode[$lang]; ?></a></h3>
            <h3><a href="displayShopItems.php?categ=logiciels"><?php echo $logiciels[$lang]; ?></a></h3>
            <h3><a href="displayShopItems.php?categ=autres"><?php echo $autres[$lang]; ?></a></h3>
        </aside>  
        <main> 

            <nav>
              <h2>
                 <?php 
                if(isset($_GET['categ'])){
                    switch($_GET['categ']){
                        case "menager":
                            $categ = "Ménager";
                            $catego = $menager[$lang];
                        break;
                            
                        case "livre":
                            $categ = "Livres";
                            $catego = $livres[$lang];
                        break;
                            
                        case "highTech":
                            $categ = "High-tech";
                            $catego = $high_tech[$lang];
                        break;
                            
                        case "informatique":
                            $categ = "Informatique";
                            $catego = $informatique[$lang];
                        break;
                            
                        case "vetements":
                            $categ = "Vêtements et mode";
                            $catego = $vetements_et_mode[$lang];
                        break;
                            
                        case "logiciels":
                            $categ = "Logiciel";
                            $catego = $logiciels[$lang];
                        break;
                        
                        case "autres":
                            $categ = "Autres";
                            $catego = $autres[$lang];
                        break;
                        
                        case "recherche":
                            $categ = "Recherche";
                            $catego = $recherche[$lang];
                        break;
                            
                        default:
                            $categ = "Les produits les plus recents";
                            $catego = $les_produits_les_plus[$lang];
                    }
                    if($categ=="Recherche"){
                        echo $resultats_de_la_recherche[$lang];
                    } 
                    else{
                        echo $catego;
                    }
                }
            else{
                echo $les_produits_les_plus[$lang];
            }
                  ?>
                </h2>
               <ul> 
                      <li id="searchBar"><form method="post" action="displayShopItems.php?categ=recherche"><input id="rechercher" class="input" type="search" placeholder="<?php echo $rechercher[$lang]; ?>" name="search"><button type="submit"><img class="submit" src="photos/search.png" alt="altSearchIcon"></button></form></li> <li id="sort"></li> 
                       
            </ul>
        </nav>
        <section class="sectionAnnonces">
            <?php
                $reqCom=$bdd->query('SELECT col FROM shop');
                $repCom=$reqCom->fetch();
                if($repCom['col']==0){
                    ?>
                    <img id="comingSoon" alt="Liavart Shop Will be available soon" src="photos/coming%20soon.png">
                    <style type="text/css">
                        #comingSoon{
                            width: 100%;
                            height: 100%;
                        }
                    </style>
                    <?php
                }
                else{
                if(isset($_GET['categ'])){
                    
                    if($categ=="Recherche"){
                        $recherche = (isset($_GET['recherche']))?$_GET['recherche']:$_POST['search'];
                        $numPage = (isset($_GET['pg']))?$_GET['pg']: 1;
                        $req = $bdd->prepare('SELECT COUNT(*) as nbre FROM lishop WHERE nom_article LIKE ? ORDER BY ID DESC');
                        $req->execute(array('%'.htmlspecialchars($recherche).'%'));
                        $rep = $req->fetch();
                        $nbreRes = $rep['nbre'];
                        $nbrePages = ($nbreRes - $nbreRes%30)/30;
                        $req->closeCursor();
                        $req = $bdd->prepare('(SELECT * FROM lishop WHERE nom_article LIKE :recherche AND langue=:lang)
                        UNION
                        (SELECT * FROM lishop WHERE nom_article LIKE :recherche AND langue="en" AND langue!=:lang)
                        UNION
                        (SELECT * FROM lishop WHERE nom_article LIKE :recherche AND langue!="en" AND langue!=:lang GROUP BY langue)
                        ORDER BY ID DESC 
                        LIMIT '.($numPage-1).',30');
                        $req->execute(array(
                            "recherche"=>'%'.htmlspecialchars($recherche).'%',
                            "lang"=>$lang
                        ));
                        if($nbreRes==0){
                            ?>
            <style type="text/css">.sectionAnnonces{display: block;}</style>
                            <p class="aucunResultat"><?php echo $aucun_produit_recherche[$lang]; ?></p>
                            <?php
                        }
                        while($res = $req->fetch()){
                            ?>
                            <a class="aAnnonce" href="<?php echo $res['lien']; ?>" target="_blank"><div class="divAnnonce"><?php echo $res['contenu']; ?></div></a>
                            <?php
                        }?>
                        <p class="pagesResultats"><?php echo $pages[$lang]; ?> <?php for($i=0; $i<=$nbrePages; $i++){
                            ?>
                            <a href="displayShopItems.php?categ=<?php echo $_GET['categ']; ?>&amp;pg=<?php echo $i+1; ?>&amp;recherche=<?php echo $_POST['search']; ?>"><?php echo $i+1; ?></a></p>
                            <?php
                        }
                    }
                    elseif($categ != "Les produits les plus recents"){
                        $numPage = (isset($_GET['pg']))?$_GET['pg']: 1;
                        $req = $bdd->prepare('SELECT COUNT(*) as nbre FROM lishop WHERE categorie=? ORDER BY ID DESC');
                        $req->execute(array($categ));
                        $rep = $req->fetch();
                        $nbreRes = $rep['nbre'];
                        $nbrePages = ($nbreRes - $nbreRes%30)/30;
                        $req->closeCursor();
                        $req = $bdd->prepare('(SELECT * FROM lishop WHERE categorie=:categorie AND langue=:lang)
                        UNION
                        (SELECT * FROM lishop WHERE categorie=:categorie AND langue="en" AND langue!=:lang)
                        UNION
                        (SELECT * FROM lishop WHERE categorie=:categorie AND langue!="en" AND langue!=:lang GROUP BY langue)
                        ORDER BY ID DESC 
                        LIMIT '.($numPage-1).',30');
                        $req->execute(array(
                            "categorie"=>$categ,
                            "lang"=>$lang
                        ));
                        if($nbreRes==0){
                            ?>
                            <style type="text/css">.sectionAnnonces{display: block;}</style>
                            <p class="aucunResultat"><?php echo $aucun_produit_disponible_dans_la[$lang]; ?></p>
                            <?php
                        }
                        while($res = $req->fetch()){
                            ?>
                            <a class="aAnnonce" href="<?php echo $res['lien']; ?>" target="_blank"><div class="divAnnonce"><?php echo $res['contenu']; ?></div></a>
                            <?php
                        }?>
                        <p class="pagesResultats"><?php echo $pages[$lang]; ?> <?php for($i=0; $i<=$nbrePages; $i++){
                            ?>
                            <a href="displayShopItems.php?categ=<?php echo $_GET['categ']; ?>&amp;pg=<?php echo $i+1; ?>"><?php echo $i+1; ?></a></p>
                            <?php
                        }
                    }
                    else{
                        $numPage = (isset($_GET['pg']))?$_GET['pg']: 1;
                        $req = $bdd->query('SELECT COUNT(*) as nbre FROM lishop ORDER BY ID DESC');
                        $rep = $req->fetch();
                        $nbreRes = $rep['nbre'];
                        $nbrePages = ($nbreRes - $nbreRes%30)/30;
                        $req->closeCursor();
                        $req = $bdd->prepare('(SELECT * FROM lishop WHERE langue=:lang)
                    UNION
                    (SELECT * FROM lishop WHERE langue="en" AND langue!=:lang)
                    UNION
                    (SELECT * FROM lishop WHERE langue!="en" AND langue!=:lang GROUP BY langue)
                    ORDER BY ID DESC
                    LIMIT '.($numPage-1).',30');
                    $req->execute(array(
                    "lang"=>$lang
                    ));
                        if($nbreRes==0){
                            ?>
                            <style type="text/css">.sectionAnnonces{display: block;}</style>
                            <p class="aucunResultat"><?php echo $aucun_produit_disponible_actu[$lang]; ?></p>
                            <?php
                        }
                        while($res = $req->fetch()){
                            ?>
                            <a class="aAnnonce" href="<?php echo $res['lien']; ?>" target="_blank"><div class="divAnnonce"><?php echo $res['contenu']; ?></div></a>
                            <?php
                        }?>
                        <p class="pagesResultats"><?php echo $pages[$lang]; ?> <?php for($i=0; $i<=$nbrePages; $i++){
                            ?>
                            <a href="displayShopItems.php?categ=<?php echo $_GET['categ']; ?>&amp;pg=<?php echo $i+1; ?>"><?php echo $i+1; ?></a></p>
                            <?php
                        }
                    }
                    
                }
                else{
                    $numPage = (isset($_GET['pg']))?$_GET['pg']: 1;
                    $req = $bdd->query('SELECT COUNT(*) as nbre FROM lishop ORDER BY ID DESC');
                    $rep = $req->fetch();
                    $nbreRes = $rep['nbre'];
                    $nbrePages = ($nbreRes - $nbreRes%30)/30;
                    $req->closeCursor();
                    $req = $bdd->prepare('(SELECT * FROM lishop WHERE langue=:lang)
                    UNION
                    (SELECT * FROM lishop WHERE langue="en" AND langue!=:lang)
                    UNION
                    (SELECT * FROM lishop WHERE langue!="en" AND langue!=:lang GROUP BY langue)
                    ORDER BY ID DESC
                    LIMIT '.($numPage-1).',30');
                    $req->execute(array(
                    "lang"=>$lang
                    ));
                    if($nbreRes==0){
                            ?>
                            <style type="text/css">.sectionAnnonces{display: block;}</style>
                            <p class="aucunResultat"><?php echo $aucun_produit_disponible_actu[$lang]; ?></p>
                            <?php
                        }
                    while($res = $req->fetch()){
                        ?>
                        <a class="aAnnonce" href="<?php echo $res['lien']; ?>" target="_blank"><div class="divAnnonce"><?php echo $res['contenu']; ?></div></a>
                        <?php
                    }?>
                    <p class="pagesResultats"><?php echo $pages[$lang]; ?> <?php for($i=0; $i<=$nbrePages; $i++){
                        ?>
                        <a href="displayShopItems.php?pg=<?php echo $i+1; ?>"><?php echo $i+1; ?></a></p>
                        <?php
                    }
                }
                }
            ?>
        </section>
        </main>
           <aside id="right" id="displayRight">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <form method="post" action="#" id="formChoixLangue1" class="langChoiceCont" class="displayFormLang"><label><?php echo $changer_de_langue[$lang]; ?></label><div><select name="lang"><option value="fr"<?php if($lang=="fr"){echo "selected";} ?>>Francais</option>
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
        </aside></div>
        <script type="text/javascript" src="depliants.js"></script>
        <style type="text/css">
            #right{
                flex: 0.20;
                border-left: none;
                border-width: 1px;
                margin-left: auto;
                margin-top: 0em;
                margin-right: auto;
                align-self: center;
            }
            section{
                text-align: center;
            }
            #LIAVART{
                width: 160px;
                margin: 0em;
            }
        </style>
        <footer><?php include("footer.php") ?></footer>
    </body>
    </html>
    