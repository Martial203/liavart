<?php

include("dictionnaireAfficherContenus.php");
if(isset($bdd)){
if(isset($_GET['supNbre']) OR isset($_GET['supNber'])){
    if(isset($_GET['valid'])){
        if(isset($_GET['supNbre'])){
            $req = $bdd -> prepare('DELETE FROM offres_emploi WHERE ID=?');  
            $req -> execute(array($_GET['supNbre']));
        }
        elseif(isset($_GET['supNber'])){
            $req = $bdd -> prepare('DELETE FROM offres_services WHERE ID=?');
            $req -> execute(array($_GET['supNber']));
        }
        header('location:contenus.php?rubrique=mesOffres&rslt=sup');
    }
    else{
        if(isset($_GET['supNbre'])){
            $var='supNbre='.$_GET['supNbre'];
        }
        elseif(isset($_GET['supNber'])){
            $var='supNber='.$_GET['supNber'];
        }
    ?>
    <div id="mesOffresSupprimerOuNon"><p id="validation"><?php echo $voulez_vous_supprimer[$lang]; ?></p><a href="contenus.php?rubrique=mesOffres&amp;<?php echo $var;?>&amp;valid=1" id="oui"><?php echo $oui[$lang]; ?></a> <a href="contenus.php?rubrique=mesOffres" id="non"><?php echo $non[$lang]; ?></a></div>
    <?php
    }
}
else{
    $req_default = $bdd->prepare('SELECT *, DATE_FORMAT(date_de_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_emploi WHERE auteur=? ORDER BY date_de_publication DESC');
                    $req_default -> execute(array($_SESSION['user']));
                ?>
                <h3 id="mesOffresTitre"><?php echo $offres_emploi_et_demandes_services[$lang]; ?></h3>
                <?php
                    while($donnees_default = $req_default->fetch()){
                        ?>
            <div class='offres'><div class='image'><a href="photos/profils/<?php echo $donnees_default['avatar_auteur']; ?>"><img src="photos/profils/<?php echo $donnees_default['avatar_auteur']; ?>"></a></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_default['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_default['instant_de_publication']; ?></span><br><span class='titreOffre'><span class="labelAnnonce"><?php echo $objet[$lang]; ?></span> <?php echo $donnees_default['titre'] ?><br><span class='champActivite'> <span class="labelAnnonce"><?php echo $champ_d_activite[$lang]; ?></span><?php echo $donnees_default['champ_activite']; ?></span></span><br><span class='ville'><span class="labelAnnonceVille"><?php echo $ville[$lang]; ?></span><?php echo $donnees_default['ville']; ?></span><span class='pays'> <span class="labelAnnoncePays"><?php echo $pays[$lang]; ?></span><?php echo $donnees_default['pays']; ?></span><br><a href='element.php?nbre=<?php echo $donnees_default["ID"];?>'><?php echo $plus_d_infos[$lang]; ?></a></div><div class="supprimerEtFavoris"><div id=supprimer><a href="contenus.php?rubrique=mesOffres&amp;supNbre=<?php echo $donnees_default["ID"]?>"><?php echo $supprimer_l_offre[$lang]; ?></a></div><br><div id="favoris"><a href="contenus.php?rubrique=mesOffres&amp;favNbre=<?php echo $donnees_default["ID"];?>"><?php echo $ajouter_aux_favoris[$lang]; ?></a></div></div><div></div></div><br>
                        <?php
                   }
                    $req_default ->closeCursor();


    $req_portail2 = $bdd->prepare('SELECT *, DATE_FORMAT(date_publication,"Le %d/%m/%Y à %Hh%imin") AS instant_de_publication FROM offres_services WHERE auteur=? ORDER BY date_publication DESC');
                    $req_portail2 -> execute(array($_SESSION['user']));
                ?>
                <h3 id="mesOffresTitre"><?php echo $propositions_services_et_demandes_emploi[$lang]; ?></h3>
                <?php
                    while($donnees_portail2 = $req_portail2->fetch()){
                        ?>
                <div class='offres'><div class='image'><a href="photos/profils/<?php echo $donnees_default['avatar_auteur']; ?>"><img alt="<?php echo $donnees_portail2['auteur']; ?>" src="photos/profils/<?php echo $donnees_portail2['avatar_auteur']; ?>"></a></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_portail2['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_portail2['instant_de_publication']; ?></span><br><span class='titreOffre'><span class="labelAnnonce"><?php echo $objet[$lang]; ?></span><?php echo $donnees_portail2['titre_proposition'] ?><br><span class='champActivite'> <span class="labelAnnonce"><?php echo $champ_d_activite[$lang]; ?></span><?php echo $donnees_portail2['champ']; ?></span></span><br><span class='ville'><span class="labelAnnonceVille"><?php echo $ville[$lang]; ?></span><?php echo $donnees_portail2['ville']; ?></span><span class='pays'> <span class="labelAnnoncePays"><?php echo $pays[$lang]; ?></span><?php echo $donnees_portail2['pays']; ?></span><br><a href='element.php?nber=<?php echo $donnees_portail2["ID"];?>'><?php echo $plus_d_infos[$lang]; ?></a></div><div class="supprimer"><div class=""><a href="contenus.php?rubrique=mesOffres&amp;supNber=<?php echo $donnees_portail2["ID"]?>"><?php echo $supprimer_l_offre[$lang]; ?></a></div><br><div class=""><a href="contenus.php?rubrique=mesOffres&amp;favNber=<?php echo $donnees_portail2["ID"];?>"><?php echo $ajouter_aux_favoris[$lang]; ?></a></div></div></div><br>
                        <?php
                   }
                    $req_portail2 ->closeCursor();
}
}