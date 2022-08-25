<?php 
$compteur=0;

include("languageDefinition.php");
include("dictionnaireRecherche.php");
include("dictionnaireAfficherContenus.php");

if(isset($_POST['search'])){
    if(isset($_POST['search'])){$recherche=htmlspecialchars($_POST['search']);} elseif(isset($_GET['search'])){$recherche=htmlspecialchars($_GET['search']);}
    if (in_array($rubrique, array("portail2", "parametres", "mesOffres", "favoris", "deconnexion"))==false){
        $numRes=(isset($_GET['pg']))?15*$_GET['pg']-15:0;
        $rq = $bdd -> prepare('SELECT COUNT(*) as nbreRes FROM offres_emploi WHERE ville LIKE :ville OR pays LIKE :pays OR titre LIKE :titre OR poste LIKE :poste OR auteur LIKE :auteur OR noms_auteur LIKE :noms_auteur OR prenoms_auteur LIKE :prenoms_auteur OR champ_activite LIKE :champ_activite OR type_de_travail LIKE :type_de_travail OR type_de_contrat LIKE :type_de_contrat ORDER BY date_de_publication DESC');
        $rq -> execute(array(
                    'ville'=>'%'.$recherche.'%',
                    'titre'=>'%'.$recherche.'%',
                    'poste'=>'%'.$recherche.'%',
                    'auteur'=>'%'.$recherche.'%',
                    'noms_auteur'=>'%'.$recherche.'%',
                    'prenoms_auteur'=>'%'.$recherche.'%',
                    'champ_activite'=>'%'.$recherche.'%',
                    'type_de_travail'=>'%'.$recherche.'%',
                    'type_de_contrat'=>'%'.$recherche.'%',
                    'pays'=>'%'.$recherche.'%'
                ));
        $rp = $rq->fetch();
        $nbreRes = $rp['nbreRes'];
        $rq ->closeCursor();
        $req1 = $bdd->prepare('SELECT *, DATE_FORMAT(date_de_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_emploi WHERE ville LIKE :ville OR pays LIKE :pays OR titre LIKE :titre OR poste LIKE :poste OR auteur LIKE :auteur OR noms_auteur LIKE :noms_auteur OR prenoms_auteur LIKE :prenoms_auteur OR champ_activite LIKE :champ_activite OR type_de_travail LIKE :type_de_travail OR type_de_contrat LIKE :type_de_contrat ORDER BY date_de_publication DESC LIMIT '.$numRes.',15');
                $req1 -> execute(array(
                    'ville'=>'%'.$recherche.'%',
                    'titre'=>'%'.$recherche.'%',
                    'poste'=>'%'.$recherche.'%',
                    'auteur'=>'%'.$recherche.'%',
                    'noms_auteur'=>'%'.$recherche.'%',
                    'prenoms_auteur'=>'%'.$recherche.'%',
                    'champ_activite'=>'%'.$recherche.'%',
                    'type_de_travail'=>'%'.$recherche.'%',
                    'type_de_contrat'=>'%'.$recherche.'%',
                    'pays'=>'%'.$recherche.'%'
                ));
                while($donnees_default1 = $req1->fetch()){
                    if($donnees_default1==false AND $compteur==0){
                        echo $aucun_resultat_ne_correspond[$lang];
                    }
                    ?>
            <div class='offres'><div class='image'><img src="photos/profils/<?php echo $donnees_default1['avatar_auteur']; ?>"></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_default1['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_default1['instant_de_publication']; ?></span><br><span class='titreOffre'><?php echo $objet[$lang]; ?><?php echo $donnees_default1['titre'] ?><br><span class='champActivite'><?php echo $champ_d_activite[$lang]; ?><?php echo $donnees_default1['champ_activite']; ?></span></span><br><span class='ville'><?php echo $ville[$lang]; ?><?php echo $donnees_default1['ville']; ?></span><span class='pays'><?php echo $pays[$lang]; ?><?php echo $donnees_default1['pays']; ?></span><br><a href='element.php?nbre=<?php echo $donnees_default1["ID"];?>'><?php echo $plus_d_infos[$lang]; ?></a></div></div><br>
                    <?php
               }
                $req1 ->closeCursor();
        
        if($nbreRes==0){?><p class="listeDesOffres"><?php echo $aucun_resultat_ne_correspond[$lang]; ?></p><?php } ?>
<p class="pagesResultats"><?php echo $pages[$lang]; ?>
    <?php
    for($i=0; $i<=($nbreRes-$nbreRes%15)/15; $i++){
        ?>
    <a href="contenus.php?rubrique=portail1&amp;pg=<?php echo $i+1;?>&amp;search=<?php echo $recherche;?>" class="numerosPages"><?php echo $i+1;?></a>
        <?php
    }
    ?>
</p>
   <?php
    }
    elseif($rubrique=="portail2"){
        if(isset($_POST['search'])){$recherche=htmlspecialchars($_POST['search']);} elseif(isset($_GET['search'])){$recherche=htmlspecialchars($_GET['search']);}
        $numRes=(isset($_GET['pg']))?15*$_GET['pg']-15:0;
        $rq = $bdd -> prepare('SELECT COUNT(*) as nbreRes FROM offres_services WHERE ville LIKE :ville OR pays LIKE :pays OR titre_proposition LIKE :titre OR poste LIKE :poste OR auteur LIKE :auteur OR noms_auteur LIKE :noms_auteur OR prenoms_auteur LIKE :prenoms_auteur OR champ LIKE :champ_activite OR type_travail LIKE :type_de_travail ORDER BY date_publication DESC');
        $rq -> execute(array(
                    'ville'=>'%'.$recherche.'%',
                    'titre'=>'%'.$recherche.'%',
                    'poste'=>'%'.$recherche.'%',
                    'auteur'=>'%'.$recherche.'%',
                    'noms_auteur'=>'%'.$recherche.'%',
                    'prenoms_auteur'=>'%'.$recherche.'%',
                    'champ_activite'=>'%'.$recherche.'%',
                    'type_de_travail'=>'%'.$recherche.'%',
                    'pays'=>'%'.$recherche.'%'
                ));
        $rp = $rq->fetch();
        $nbreRes = $rp['nbreRes'];
        $rq ->closeCursor();
        $req1 = $bdd->prepare('SELECT *, DATE_FORMAT(date_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_services WHERE ville LIKE :ville OR pays LIKE :pays OR titre_proposition LIKE :titre OR poste LIKE :poste OR auteur LIKE :auteur OR noms_auteur LIKE :noms_auteur OR prenoms_auteur LIKE :prenoms_auteur OR champ LIKE :champ_activite OR type_travail LIKE :type_de_travail ORDER BY date_publication DESC LIMIT '.$numRes.',15');
                $req1 -> execute(array(
                    'ville'=>'%'.$recherche.'%',
                    'titre'=>'%'.$recherche.'%',
                    'poste'=>'%'.$recherche.'%',
                    'auteur'=>'%'.$recherche.'%',
                    'noms_auteur'=>'%'.$recherche.'%',
                    'prenoms_auteur'=>'%'.$recherche.'%',
                    'champ_activite'=>'%'.$recherche.'%',
                    'type_de_travail'=>'%'.$recherche.'%',
                    'pays'=>'%'.$recherche.'%'
                ));
                while($donnees_default1 = $req1->fetch()){
                    if($donnees_default1==false AND $compteur==0){
                        echo $aucun_resultat_ne_correspond[$lang];
                    }
                    ?>
            <div class='offres'><div class='image'><img src="photos/profils/<?php echo $donnees_default1['avatar_auteur']; ?>"></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_default1['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_default1['instant_de_publication']; ?></span><br><span class='titreOffre'><?php echo $objet[$lang]; ?><?php echo $donnees_default1['titre_proposition'] ?><br><span class='champActivite'><?php echo $champ_d_activite[$lang]; ?><?php echo $donnees_default1['champ']; ?></span></span><br><span class='ville'><?php echo $ville[$lang]; ?><?php echo $donnees_default1['ville']; ?></span><span class='pays'><?php echo $pays[$lang]; ?><?php echo $donnees_default1['pays']; ?></span><br><a href='element.php?nber=<?php echo $donnees_default1["ID"];?>'><?php echo $plus_d_infos[$lang]; ?></a></div></div><br>
                    <?php
               }
                $req1 ->closeCursor();
        
            if($nbreRes==0){?><p class="listeDesOffres"><?php echo $aucun_resultat_ne_correspond[$lang];?></p><?php } ?>
<p class="pagesResultats"><?php echo $pages[$lang]; ?>
    <?php
    for($i=0; $i<=($nbreRes-$nbreRes%15)/15; $i++){
        ?>
    <a href="contenus.php?rubrique=portail2&amp;pg=<?php echo $i+1;?>&amp;search=<?php echo $recherche;?>" class="numerosPages"><?php echo $i+1;?></a>
        <?php
    }
    ?>
</p>
   <?php
    }
}