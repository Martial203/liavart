<?php

include("dictionnaireAfficherContenus.php");
if(isset($_SESSION['user']) AND isset($jumbo)){
    
$numRes=(isset($_GET['pg']))?15*$_GET['pg']-15:0;
$numPag=(isset($_GET['pg']))?$_GET['pg']:1;
if(crawlerDetect($_SERVER['HTTP_USER_AGENT'])==false AND isset($_SESSION['user'])==true){
    $rq = $bdd -> prepare('(SELECT COUNT(*) as nbreRes FROM offres_emploi WHERE ville=? AND NOW()<date_limite ORDER BY date_de_publication DESC)
    UNION
    (SELECT COUNT(*) as nbreRes FROM offres_emploi WHERE pays=? AND ville !=? AND NOW()<date_limite ORDER BY date_de_publication DESC)
    UNION
    (SELECT COUNT(*) as nbreRes FROM offres_emploi WHERE pays!=? AND ville !=? AND NOW()<date_limite ORDER BY date_de_publication DESC)');
    $rq -> execute((array($_SESSION['ville_de_residence'], $_SESSION['pays_de_residence'], $_SESSION['ville_de_residence'],$_SESSION['pays_de_residence'],$_SESSION['ville_de_residence'])));
    $nbreRes=0;
    while($rp = $rq->fetch()){
        $nbreRes += $rp['nbreRes'];
    }
    $rq ->closeCursor();
    $req_default = $bdd->prepare('
    (SELECT *, DATE_FORMAT(date_de_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_emploi WHERE ville=? AND NOW()<date_limite ORDER BY date_de_publication DESC)
    UNION
    (SELECT *, DATE_FORMAT(date_de_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_emploi WHERE pays=? AND ville !=? AND NOW()<date_limite ORDER BY date_de_publication DESC)
    UNION
    (SELECT *, DATE_FORMAT(date_de_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_emploi WHERE pays!=? AND ville !=? AND NOW()<date_limite ORDER BY date_de_publication DESC)
    LIMIT '.$numRes.',15');
                    $req_default -> execute(array($_SESSION['ville_de_residence'], $_SESSION['pays_de_residence'], $_SESSION['ville_de_residence'],$_SESSION['pays_de_residence'],$_SESSION['ville_de_residence']));
}
else{
        $rq = $bdd -> query('(SELECT COUNT(*) as nbreRes FROM offres_emploi ORDER BY date_de_publication DESC)');
    $nbreRes=0;
    while($rp = $rq->fetch()){
        $nbreRes += $rp['nbreRes'];
    }
    $rq ->closeCursor();
    $req_default = $bdd->query('
    SELECT *, DATE_FORMAT(date_de_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_emploi ORDER BY date_de_publication DESC LIMIT '.$numRes.',15');
}
                while($donnees_default = $req_default->fetch()){
                    ?>
            <div class='offres'><div class='image'><a href="photos/profils/<?php echo $donnees_default['avatar_auteur']; ?>"><img alt="<?php echo $donnees_default['auteur']; ?>" src="photos/profils/<?php echo $donnees_default['avatar_auteur']; ?>"></a></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_default['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_default['instant_de_publication']; ?></span><br><span class='titreOffre'><span class="labelAnnonce"><?php echo $objet[$lang]; ?></span><?php echo $donnees_default['titre'] ?></span><br><span class='champActivite'> <span class="labelAnnonce"><?php echo $champ_d_activite[$lang]; ?></span><?php echo $donnees_default['champ_activite']; ?></span><br><span class='ville'><span class="labelAnnonceVille"><?php echo $ville[$lang]; ?></span><?php echo $donnees_default['ville']; ?></span><span class='pays'> <span class="labelAnnoncePays"><?php echo $pays[$lang]; ?></span><?php echo $donnees_default['pays']; ?></span><br class="brPaysPlusInfos"><a href='element.php?nbre=<?php echo $donnees_default["ID"];?>&amp;page=<?php echo $numPag;?>'><?php echo $plus_d_infos[$lang]; ?></a><br><span class="spanFavorites"><a href="contenus.php?rubrique=portail1&amp;favNbre=<?php echo $donnees_default["ID"];?>" class="addToFavorites"><?php echo $ajouter_aux_favoris[$lang]; ?></a></span></div><div id="favoris"><a href="contenus.php?rubrique=portail1&amp;favNbre=<?php echo $donnees_default["ID"];?>"><?php echo $ajouter_aux_favoris[$lang]; ?></a></div></div><br>
                    <?php
               }
                $req_default ->closeCursor();
                
                /*$req_default = $bdd->prepare('SELECT *, DATE_FORMAT(date_de_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_emploi WHERE pays=? AND ville != ? ORDER BY date_de_publication DESC');
                $req_default -> execute(array($_SESSION['pays_de_residence'], $_SESSION['ville_de_residence']));
                while($donnees_default = $req_default->fetch()){
                    ?>
            <div class='offres'><div class='image'><a href="photos/profils/<?php echo $donnees_default['avatar_auteur']; ?>"><img src="photos/profils/<?php echo $donnees_default['avatar_auteur']; ?>"></a></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_default['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_default['instant_de_publication']; ?></span><br><span class='titreOffre'><span class="labelAnnonce">Objet: </span><?php echo $donnees_default['titre'] ?><br><span class='champActivite'> <span class="labelAnnonce">Champ d'activité : </span><?php echo $donnees_default['champ_activite']; ?></span></span><br><span class='ville'><span class="labelAnnonceVille">Ville : </span><?php echo $donnees_default['ville']; ?></span><span class='pays'> <span class="labelAnnoncePays">Pays : </span><?php echo $donnees_default['pays']; ?></span><br class="brPaysPlusInfos"><a href='element.php?nbre=<?php echo $donnees_default["ID"];?>'>Plus d'informations...</a><br><span class="spanFavorites"><a href="contenus.php?rubrique=portail1&amp;favNbre=<?php echo $donnees_default["ID"];?>" class="addToFavorites">Ajouter aux favoris</a></span></div><div id="favoris"><a href="contenus.php?rubrique=portail1&amp;favNbre=<?php echo $donnees_default["ID"];?>">Ajouter aux favoris</a></div></div><br>
                    <?php
               }
                $req_default ->closeCursor();
                
                $req_default = $bdd->prepare('SELECT *, DATE_FORMAT(date_de_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_emploi WHERE pays!=? AND ville != ? ORDER BY date_de_publication DESC');
                $req_default -> execute(array($_SESSION['pays_de_residence'], $_SESSION['ville_de_residence']));
                while($donnees_default = $req_default->fetch()){
                    ?>
        <div class='offres'><div class='image'><a href="photos/profils/<?php echo $donnees_default['avatar_auteur']; ?>"><img src="photos/profils/<?php echo $donnees_default['avatar_auteur']; ?>"></a></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_default['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_default['instant_de_publication']; ?></span><br><span class='titreOffre'><span class="labelAnnonce">Objet: </span><?php echo $donnees_default['titre'] ?></span><br><span class='champActivite'> <span class="labelAnnonce">Champ d'activité : </span><?php echo $donnees_default['champ_activite']; ?></span><br><span class='ville'><span class="labelAnnonceVille">Ville : </span><?php echo $donnees_default['ville']; ?></span><span class='pays'> <span class="labelAnnoncePays">Pays : </span><?php echo $donnees_default['pays']; ?></span><br class="brPaysPlusInfos"><a href='element.php?nbre=<?php echo $donnees_default["ID"];?>'>Plus d'informations...</a><br><span class="spanFavorites"><a href="contenus.php?rubrique=portail1&amp;favNbre=<?php echo $donnees_default["ID"];?>" class="addToFavorites">Ajouter aux favoris</a></span></div><div id="favoris"><a href="contenus.php?rubrique=portail1&amp;favNbre=<?php echo $donnees_default["ID"];?>">Ajouter aux favoris</a></div></div><br>
                    <?php
               }
                $req_default ->closeCursor();*/
?>
<?php if($nbreRes==0){?><p class="listeDesOffres"><?php echo $aucune_offre_active[$lang]; ?></p><?php } ?>
<p class="pagesResultats"><?php echo $pages[$lang]; ?>
    <?php
    for($i=0; $i<=($nbreRes-$nbreRes%15)/15; $i++){
        ?>
    <a href="contenus.php?rubrique=portail1&amp;pg=<?php echo $i+1;?>" class="numerosPages"><?php echo $i+1;?></a>
        <?php
    }
    ?>
</p>
<?php
}
?>