<?php

if(isset($_SESSION['user']) AND isset($jumbo)){
include("dictionnaireAfficherContenus.php");

$numRes=(isset($_GET['pg']))?15*$_GET['pg']-15:0;
$numPag=(isset($_GET['pg']))?$_GET['pg']:1;
if(crawlerDetect($_SERVER['HTTP_USER_AGENT'])==false AND isset($_SESSION['user'])==true){
    $rqt = $bdd -> prepare('(SELECT COUNT(*) as nbreRes FROM offres_services WHERE ville=? ORDER BY date_publication DESC)
    UNION
    (SELECT COUNT(*) as nbreRes FROM offres_services WHERE pays=? AND ville!=? ORDER BY date_publication DESC)
    UNION
    (SELECT COUNT(*) as nbreRes FROM offres_services WHERE pays!=? AND ville!=? ORDER BY date_publication DESC)');
    $rqt -> execute((array($_SESSION['ville_de_residence'], $_SESSION['pays_de_residence'], $_SESSION['ville_de_residence'],$_SESSION['pays_de_residence'],$_SESSION['ville_de_residence'])));
    $nbreRes=0;
    while($rps = $rqt->fetch()){
        $nbreRes += $rps['nbreRes'];
    }
    $rqt->closeCursor();
    $req_portail2 = $bdd->prepare('
    (SELECT *, DATE_FORMAT(date_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_services WHERE ville=? ORDER BY date_publication DESC)
    UNION
    (SELECT *, DATE_FORMAT(date_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_services WHERE pays=? AND ville!=? ORDER BY date_publication DESC)
    UNION
    (SELECT *, DATE_FORMAT(date_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_services WHERE pays!=? AND ville!=? ORDER BY date_publication DESC)
    LIMIT '.$numRes.',15');
                    $req_portail2 -> execute(array($_SESSION['ville_de_residence'], $_SESSION['pays_de_residence'], $_SESSION['ville_de_residence'],$_SESSION['pays_de_residence'],$_SESSION['ville_de_residence']));
}
else{
    $rqt = $bdd -> query('(SELECT COUNT(*) as nbreRes FROM offres_services ORDER BY date_publication DESC)
    UNION
    (SELECT COUNT(*) as nbreRes FROM offres_services ORDER BY date_publication DESC)
    UNION
    (SELECT COUNT(*) as nbreRes FROM offres_services ORDER BY date_publication DESC)');
    $nbreRes=0;
    while($rps = $rqt->fetch()){
        $nbreRes += $rps['nbreRes'];
    }
    $rqt->closeCursor();
    $req_portail2 = $bdd->query('
    (SELECT *, DATE_FORMAT(date_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_services ORDER BY date_publication DESC)
    UNION
    (SELECT *, DATE_FORMAT(date_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_services ORDER BY date_publication DESC)
    UNION
    (SELECT *, DATE_FORMAT(date_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_services ORDER BY date_publication DESC)
    LIMIT '.$numRes.',15');
}
                while($donnees_portail2 = $req_portail2->fetch()){
                    ?>
        <div class='offres'><div class='image'><a href="photos/profils/<?php echo $donnees_portail2['avatar_auteur']; ?>"><img alt="<?php echo $donnees_portail2['auteur']; ?>" src="photos/profils/<?php echo $donnees_portail2['avatar_auteur']; ?>"></a></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_portail2['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_portail2['instant_de_publication']; ?></span><br><span class='titreOffre'><span class="labelAnnonce"><?php echo $objet[$lang]; ?></span><?php echo $donnees_portail2['titre_proposition'] ?><br><span class='champActivite'> <span class="labelAnnonce"><?php echo $champ_d_activite[$lang]; ?></span> <?php echo $donnees_portail2['champ']; ?></span></span><br><span class='ville'><span class="labelAnnonceVille"><?php echo $ville[$lang]; ?></span> <?php echo $donnees_portail2['ville']; ?></span><span class='pays'> <span class="labelAnnoncePays"><?php echo $pays[$lang]; ?></span> <?php echo $donnees_portail2['pays']; ?></span><br class="brPaysPlusInfos"><a href='element.php?nber=<?php echo $donnees_portail2["ID"];?>&amp;page=<?php echo $numPag;?>'><?php echo $plus_d_infos[$lang]; ?></a><br><span class="spanFavorites"><a href="contenus.php?rubrique=portail2&amp;favNber=<?php echo $donnees_portail2["ID"];?>" class="addToFavorites"><?php echo $ajouter_aux_favoris[$lang]; ?></a></span></div><div id="favoris"><a href="contenus.php?rubrique=portail2&amp;favNber=<?php echo $donnees_portail2["ID"];?>"><?php echo $ajouter_aux_favoris[$lang]; ?></a></div></div><br>
                    <?php
               }
                $req_portail2 ->closeCursor();
                
                /*$req_portail2 = $bdd->prepare('SELECT *, DATE_FORMAT(date_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_services WHERE pays=? AND ville!=? ORDER BY date_publication DESC');
                $req_portail2 -> execute(array($_SESSION['pays_de_residence'], $_SESSION['ville_de_residence']));
                while($donnees_portail2 = $req_portail2->fetch()){
                    ?>
            <div class='offres'><div class='image'><a href="photos/profils/<?php echo $donnees_portail2['avatar_auteur']; ?>"><img src="photos/profils/<?php echo $donnees_portail2['avatar_auteur']; ?>"></a></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_portail2['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_portail2['instant_de_publication']; ?></span><br><span class='titreOffre'><span class="labelAnnonce">Objet: </span><?php echo $donnees_portail2['titre_proposition'] ?><br><span class='champActivite'> <span class="labelAnnonce">Champ d'activité : </span><?php echo $donnees_portail2['champ']; ?></span></span><br><span class='ville'><span class="labelAnnonceVille">Ville : </span><?php echo $donnees_portail2['ville']; ?></span><span class='pays'> <span class="labelAnnoncePays">Pays : </span><?php echo $donnees_portail2['pays']; ?></span><br class="brPaysPlusInfos"><a href='element.php?nber=<?php echo $donnees_portail2["ID"];?>'>Plus d'informations...</a><br><span class="spanFavorites"><a href="contenus.php?rubrique=portail2&amp;favNber=<?php echo $donnees_portail2["ID"];?>" class="addToFavorites">Ajouter aux favoris</a></span></div><div id="favoris"><a href="contenus.php?rubrique=portail2&amp;favNber=<?php echo $donnees_portail2["ID"];?>">Ajouter aux favoris</a></div></div><br>
                    <?php
               }
                $req_portail2 ->closeCursor();
                
                $req_portail2 = $bdd->prepare('SELECT *, DATE_FORMAT(date_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_services WHERE pays!=? AND ville!=? ORDER BY date_publication DESC');
                $req_portail2 -> execute(array($_SESSION['pays_de_residence'], $_SESSION['ville_de_residence']));
                while($donnees_portail2 = $req_portail2->fetch()){
                    ?>
            <div class='offres'><div class='image'><a href="photos/profils/<?php echo $donnees_portail2['avatar_auteur']; ?>"><img src="photos/profils/<?php echo $donnees_portail2['avatar_auteur']; ?>"></a></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_portail2['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_portail2['instant_de_publication']; ?></span><br><span class='titreOffre'><span class="labelAnnonce">Objet: </span><?php echo $donnees_portail2['titre_proposition'] ?></span><br><span class='champActivite'> <span class="labelAnnonce">Champ d'activité : </span><?php echo $donnees_portail2['champ']; ?></span><br><span class='ville'><span class="labelAnnonceVille">Ville : </span><?php echo $donnees_portail2['ville']; ?></span><span class='pays'> <span class="labelAnnoncePays">Pays : </span><?php echo $donnees_portail3['pays']; ?></span><br class="brPaysPlusInfos"><a href='element.php?nber=<?php echo $donnees_portail2["ID"];?>'>Plus d'informations...</a><br><span class="spanFavorites"><a href="contenus.php?rubrique=portail2&amp;favNber=<?php echo $donnees_portail2["ID"];?>" class="addToFavorites">Ajouter aux favoris</a></span></div><div id="favoris"><a href="contenus.php?rubrique=portail2&amp;favNber=<?php echo $donnees_portail2["ID"];?>">Ajouter aux favoris</a></div></div><br>
                    <?php
               }
                $req_portail2 ->closeCursor();*/
?>

<?php if($nbreRes==0){?><p class="listeDesOffres"><?php echo $aucune_offre_active[$lang]; ?></p><?php } ?>

<p class="pagesResultats"><?php echo $pages[$lang]; ?>
    <?php
    for($i=0; $i<=($nbreRes-$nbreRes%15)/15; $i++){
        ?>
    <a href="contenus.php?rubrique=portail2&amp;pg=<?php echo $i+1;?>" class="numerosPages"><?php echo $i+1;?></a>
        <?php
    }
    ?>
</p>
<?php
}
?>