<?php

include("dictionnaireAfficherContenus.php");
   if(isset($_SESSION['offres_emploi_favoris']) AND isset($lang) AND isset($_SESSION['offres_services_favoris'])){ $emploi_favoris=explode(',',$_SESSION['offres_emploi_favoris']);
    $services_favoris=explode(',',$_SESSION['offres_services_favoris']);
    
    $req_default = $bdd->query('SELECT *, DATE_FORMAT(date_de_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_emploi ORDER BY date_de_publication DESC');
                ?>
                <h3 id="mesOffresTitre"><?php echo $offres_emploi_et_demandes_services[$lang]; ?></h3>
                <?php
                    while($donnees_default = $req_default->fetch()){
                        if(in_array($donnees_default['ID'],$emploi_favoris)){
                        ?>
            <div class='offres'><div class='image'><img alt="<?php echo $donnees_default['auteur']; ?>"  src="photos/profils/<?php echo $donnees_default['avatar_auteur']; ?>"></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_default['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_default['instant_de_publication']; ?></span><br><span class='titreOffre'><?php echo $objet[$lang]; ?><?php echo $donnees_default['titre'] ?><br><span class='champActivite'><?php echo $champ_d_activite[$lang]; ?><?php echo $donnees_default['champ_activite']; ?></span></span><br><span class='ville'><?php echo $ville[$lang]; ?><?php echo $donnees_default['ville']; ?></span><span class='pays'><?php echo $pays[$lang]; ?><?php echo $donnees_default['pays']; ?></span><br><a href='element.php?rubrique=favoris&amp;nbre=<?php echo $donnees_default["ID"];?>&amp;page=1'><?php echo $plus_d_infos[$lang]; ?></a><br><span class="spanFavorites"><a href="contenus.php?rubrique=favoris&amp;supFavNbre=<?php echo $donnees_default["ID"]?>"><?php echo $supprimer_des_favoris[$lang]; ?></a></span></div><div id="favoris"><a href="contenus.php?rubrique=favoris&amp;supFavNbre=<?php echo $donnees_default["ID"]?>"><?php echo $supprimer_des_favoris[$lang]; ?></a></div></div><br>
                        <?php
                        }
                   }
                    $req_default ->closeCursor();

    $req_portail2 = $bdd->query('SELECT *, DATE_FORMAT(date_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_services ORDER BY date_publication DESC');
                ?>
                <h3 id="mesOffresTitre"><?php echo $propositions_services_et_demandes_emploi[$lang]; ?></h3>
                <?php
                    while($donnees_portail2 = $req_portail2->fetch()){
                        if(in_array($donnees_portail2['ID'],$services_favoris)){
                        ?>
                <div class='offres'><div class='image'><img alt="<?php echo $donnees_portail2['auteur']; ?>" src="photos/profils/<?php echo $donnees_portail2['avatar_auteur']; ?>"></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_portail2['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_portail2['instant_de_publication']; ?></span><br><span class='titreOffre'><?php echo $objet[$lang]; ?><?php echo $donnees_portail2['titre_proposition'] ?><br><span class='champActivite'><?php echo $champ_d_activite[$lang]; ?><?php echo $donnees_portail2['champ']; ?></span></span><br><span class='ville'><?php echo $ville[$lang]; ?><?php echo $donnees_portail2['ville']; ?></span><span class='pays'><?php echo $pays[$lang]; ?><?php echo $donnees_portail2['pays']; ?></span><br><a href='element.php?rubrique=favoris&amp;nber=<?php echo $donnees_portail2["ID"];?>&amp;page=1'><?php echo $plus_d_infos[$lang]; ?></a><br><span class="spanFavorites"><a href="contenus.php?rubrique=favoris&amp;supFavNber=<?php echo $donnees_portail2["ID"]?>"><?php echo $supprimer_des_favoris[$lang]; ?></a></span></div><div id="favoris"><a href="contenus.php?rubrique=favoris&amp;supFavNber=<?php echo $donnees_portail2["ID"]?>"><?php echo $supprimer_des_favoris[$lang]; ?></a></div></div><br>
                        <?php
                        }
                   }
                    $req_portail2 ->closeCursor();
    }
?>