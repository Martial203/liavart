<?php

if(isset($rubrique)){
        include("languageDefinition.php");
        include("dictionnaireAfficherContenus.php");

        if($rubrique=="portail1"){
            if(isset($_POST['tri'])){$categorie=$_POST['tri'];} elseif(isset($_GET['tri'])){$categorie=$_GET['tri'];}
            $numRes=(isset($_GET['pg']))?15*$_GET['pg']-15:0;
            $rqt = $bdd -> prepare('SELECT COUNT(*) as nbreRes FROM offres_emploi GROUP BY ? ORDER BY date_de_publication DESC');
            $rqt -> execute((array($_POST['tri'])));
            $rps = $rqt->fetch();
            $nbreRes = $rps['nbreRes'];
            $rqt->closeCursor();
            $req_default = $bdd->prepare('SELECT *, DATE_FORMAT(date_de_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication, DATE_FORMAT(date_de_publication, "%d/%m/%Y") AS jour FROM offres_emploi GROUP BY ? ORDER BY date_de_publication DESC LIMIT '.$numRes.',15');
                $req_default -> execute(array($categorie));
            $groupe="";
                while($donnees_default = $req_default->fetch()){
                    if($groupe!=$donnees_default[$categorie]){
                        $groupe=$donnees_default[$categorie];
                        ?>
                        <h2 id="groupeDeTri"><?php echo $groupe; ?></h2>
                        <?php
                    }
                    ?>
            <div class='offres'><div class='image'><img src="photos/profils/<?php echo $donnees_default['avatar_auteur']; ?>"></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_default['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_default['instant_de_publication']; ?></span><br><span class='titreOffre'><?php echo $objet[$lang]; ?><?php echo $donnees_default['titre'] ?><br><span class='champActivite'><?php echo $champ_d_activite[$lang]; ?><?php echo $donnees_default['champ_activite']; ?></span></span><br><span class='ville'><?php echo $ville[$lang]; ?><?php echo $donnees_default['ville']; ?></span><span class='pays'><?php echo $pays[$lang]; ?><?php echo $donnees_default['pays']; ?></span><br><a href='element.php?nbre=<?php echo $donnees_default["ID"];?>'><?php echo $plus_d_infos[$lang]; ?></a></div></div><br>
                    <?php
               }
                $req_default ->closeCursor();
                ?>
                <?php if($nbreRes==0){?><p class="listeDesOffres"><?php echo $aucune_offre_active[$lang]; ?></p><?php } ?>
            <p class="pagesResultats"><?php echo $pages[$lang]; ?>
                <?php
                for($i=0; $i<=($nbreRes-$nbreRes%15)/15; $i++){
                    ?>
                <a href="contenus.php?rubrique=portail1&amp;pg=<?php echo $i+1;?>&amp;tri=<?php echo $categorie; ?>" class="numerosPages"><?php echo $i+1;?></a>
                    <?php
                }
                ?>
            </p>
        <?php
            }
        
        elseif($rubrique=="portail2"){
            if(isset($_POST['tri'])){$categorie=$_POST['tri'];
                                    if($categorie=="champ_activite"){$categorie="champ";}} elseif(isset($_GET['tri'])){$categorie=$_GET['tri'];}
            $numRes=(isset($_GET['pg']))?15*$_GET['pg']-15:0;
            $rqt = $bdd -> prepare('SELECT COUNT(*) as nbreRes FROM offres_services GROUP BY ? ORDER BY date_publication DESC');
            $rqt -> execute((array($_POST['tri'])));
            $rps = $rqt->fetch();
            $nbreRes = $rps['nbreRes'];
            $rqt->closeCursor();
         $req_portail2 = $bdd->prepare('SELECT *, DATE_FORMAT(date_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication, DATE_FORMAT(date_publication, "%d\%m\%Y") AS jour FROM offres_services GROUP BY ? ORDER BY date_publication DESC LIMIT '.$numRes.',15');
                $req_portail2 -> execute(array($categorie));
                $groupe="";
                while($donnees_portail2 = $req_portail2->fetch()){
                    if($groupe!=$donnees_portail2[$categorie]){
                        $groupe=$donnees_portail2[$categorie];
                        ?>
                        <h2 id="groupeDeTri"><?php echo $groupe; ?></h2>
                        <?php
                    }
                    ?>
        <div class='offres'><div class='image'><img src="photos/profils/<?php echo $donnees_portail2['avatar_auteur']; ?>"></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_portail2['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_portail2['instant_de_publication']; ?></span><br><span class='titreOffre'><?php echo $objet[$lang]; ?><?php echo $donnees_portail2['titre_proposition'] ?><br><span class='champActivite'><?php echo $champ_d_activite[$lang]; ?><?php echo $donnees_portail2['champ']; ?></span></span><br><span class='ville'><?php echo $ville[$lang]; ?><?php echo $donnees_portail2['ville']; ?></span><span class='pays'><?php echo $pays[$lang]; ?><?php echo $donnees_portail2['pays']; ?></span><br><a href='element.php?nber=<?php echo $donnees_portail2["ID"];?>'><?php echo $plus_d_infos[$lang]; ?></a></div></div><br>
                    <?php
               }
                $req_portail2 ->closeCursor();
            
             if($nbreRes==0){?><p class="listeDesOffres"><?php echo $aucune_offre_active[$lang]; ?></p><?php } ?>
            <p class="pagesResultats"><?php echo $pages[$lang]; ?>
                <?php
                for($i=0; $i<=($nbreRes-$nbreRes%15)/15; $i++){
                    ?>
                <a href="contenus.php?rubrique=portail2&amp;pg=<?php echo $i+1;?>&amp;tri=<?php echo $categorie; ?>" class="numerosPages"><?php echo $i+1;?></a>
                    <?php
                }
                ?>
            </p>
        <?php
        }
}
?>