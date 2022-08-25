<?php

    include("dictionnaireAfficherContenus.php");
    include("dictionnaireAnnonces.php");
if(isset($_SESSION['dash']) AND $_SESSION['dash']=="auth" AND isset($lang)){
    if(isset($_GET['signa'])){
        if(isset($_GET['servdef']) OR isset($_GET['offdef'])){
                if(isset($_GET['servdef'])){
                    if(isset($_GET['confirm']) AND $_GET['confirm']=='yes'){
                        $req = $bdd -> prepare('DELETE FROM offres_services_signales WHERE ID_offre=?');
                        $req -> execute(array($_GET['servdef']));
                        $req -> closeCursor();
                        $req = $bdd -> prepare('DELETE FROM offres_services WHERE ID=?');
                        $req -> execute(array($_GET['servdef']));
                        $req -> closeCursor();
                    }
                    else{
                        ?>
                        <p><?php echo $voulez_vous_supprimer_def[$lang]; ?></p>
                        <p><a href="dashboard.php?rubrique=annonces&amp;signa=signa&amp;servdef=<?php echo htmlspecialchars($_GET['servdef']);?>&amp;confirm=yes"><?php echo $oui[$lang]; ?></a> <a href="dashboard.php?rubrique=annonces&amp;signa=signa"><?php echo $non[$lang]; ?></a></p>
                        <?php
                    }
                }
                elseif(isset($_GET['offdef'])){
                    if(isset($_GET['confirm']) AND $_GET['confirm']=='yes'){
                        $req = $bdd -> prepare('DELETE FROM offres_emploi_signales WHERE ID_offre=?');
                        $req -> execute(array($_GET['offdef']));
                        $req -> closeCursor();
                        $req = $bdd -> prepare('DELETE FROM offres_emploi WHERE ID=?');
                        $req -> execute(array($_GET['offdef']));
                        $req -> closeCursor();
                    }
                    else{
                        ?>
                        <p><?php echo $voulez_vous_supprimer_def[$lang]; ?></p>
                        <p><a href="dashboard.php?rubrique=annonces&amp;signa=signa&amp;offdef=<?php echo htmlspecialchars($_GET['offdef']);?>&amp;confirm=yes"><?php echo $oui[$lang]; ?></a> <a href="dashboard.php?rubrique=annonces&amp;signa=signa"><?php echo $non[$lang]; ?></a></p>
                        <?php
                    }
                }
        }
        elseif(isset($_GET['servsign']) OR isset($_GET['offsign'])){
            if(isset($_GET['servsign'])){
                if(isset($_GET['confirm']) AND $_GET['confirm']=='yes'){
                $req = $bdd -> prepare('DELETE FROM offres_services_signales WHERE ID_offre=?');
                $req -> execute(array($_GET['servsign']));
                $req -> closeCursor();
            }
            else{
                ?>
                <p><?php echo $voulez_vous_supprimer_des_signales[$lang]; ?></p>
                <p><a href="dashboard.php?rubrique=annonces&amp;signa=signa&amp;servsign=<?php echo htmlspecialchars($_GET['servsign']);?>&amp;confirm=yes"><?php echo $oui[$lang]; ?></a> <a href="dashboard.php?rubrique=annonces&amp;signa=signa"><?php echo $non[$lang]; ?></a></p>
                <?php
            }
            }
            elseif(isset($_GET['offsign'])){
                if(isset($_GET['confirm']) AND $_GET['confirm']=='yes'){
                    $req = $bdd -> prepare('DELETE FROM offres_emploi_signales WHERE ID_offre=?');
                    $req -> execute(array($_GET['offsign']));
                    $req -> closeCursor();
                }
            else{
                ?>
                <p><?php echo $voulez_vous_supprimer_des_signales[$lang]; ?></p>
                <p><a href="dashboard.php?rubrique=annonces&amp;signa=signa&amp;offsign=<?php echo htmlspecialchars($_GET['offsign']);?>&amp;confirm=yes"><?php echo $oui[$lang]; ?></a> <a href="dashboard.php?rubrique=annonces&amp;signa=signa"><?php echo $non[$lang]; ?></a></p>
                <?php
            }
            }
        }
        ?>
        <h2><?php echo $offres_emploi_et_demandes_services[$lang]; ?></h2>
        <?php
        $req = $bdd -> query('SELECT ID_offre, nom_utilisateur_signaleur, probleme, date, DATE_FORMAT(date, "Le %d/%m/%Y à %Hh:%imin") as instant_de_signal, ID, auteur, titre, poste, champ_activite, noms_auteur, prenoms_auteur, date_de_publication, DATE_FORMAT(date_de_publication, "Le %d/%m/%Y à %Hh:%imin") as instant_de_publication, avatar_auteur, ville, pays FROM offres_emploi_signales, offres_emploi WHERE ID_offre=ID');
         while($donnees_default1 = $req->fetch()){
                    if($donnees_default1==false AND $compteur==0){
                        echo $aucune_offre_signalee[$lang];
                    }
                    ?>
            <div class='offres'><div class='image'><img src="photos/profils/<?php echo $donnees_default1['avatar_auteur']; ?>"></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_default1['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_default1['instant_de_publication']; ?></span><br><span class='titreOffre'><?php echo $objet[$lang]; ?><?php echo $donnees_default1['titre'] ?><br><span class='champActivite'><?php echo $champ_d_activite[$lang]; ?><?php echo $donnees_default1['champ_activite']; ?></span></span><br><span class='ville'><?php echo $ville[$lang]; ?><?php echo $donnees_default1['ville']; ?></span><span class='pays'><?php echo $pays[$lang]; ?><?php echo $donnees_default1['pays']; ?></span><br><a href='element.php?nbre=<?php echo $donnees_default1["ID"];?>'><?php echo $plus_d_infos[$lang]; ?></a></div>
            <div><?php echo $donnees_default1['instant_de_signal']; ?><br><?php echo $motif[$lang]; ?><?php echo $donnees_default1['probleme']; ?><br><a href="dashboard.php?rubrique=annonces&amp;signa=signa&amp;offsign=<?php echo $donnees_default1['ID']; ?>"><?php echo $supprimer_des_signales[$lang]; ?></a><br><a href="dashboard.php?rubrique=annonces&amp;signa=signa&amp;offdef=<?php echo $donnees_default1['ID']; ?>"><?php echo $supprimer_definitivement[$lang]; ?></a></div></div><br>
                    <?php
               }
                $req ->closeCursor();
        ?>
        <h2><?php echo $propositions_services_et_demandes_emploi[$lang]; ?></h2>
        <?php
        $req = $bdd -> query('SELECT ID_offre, nom_utilisateur_signaleur, probleme, date, DATE_FORMAT(date, "Le %d/%m/%Y à %Hh:%imin") as instant_de_signal, ID, auteur, titre_proposition, poste, champ, noms_auteur, prenoms_auteur, date_publication, DATE_FORMAT(date_publication, "Le %d/%m/%Y à %Hh:%imin") as instant_de_publication, avatar_auteur, ville, pays FROM offres_services_signales, offres_services WHERE ID_offre=ID');
         while($donnees_default1 = $req->fetch()){
                    if($donnees_default1==false AND $compteur==0){
                        echo $aucune_offre_signalee[$lang];
                    }
                    ?>
            <div class='offres'><div class='image'><img src="photos/profils/<?php echo $donnees_default1['avatar_auteur']; ?>"></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_default1['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_default1['instant_de_publication']; ?></span><br><span class='titreOffre'><?php echo $objet[$lang]; ?><?php echo $donnees_default1['titre_proposition'] ?><br><span class='champActivite'><?php echo $champ_d_activite[$lang]; ?><?php echo $donnees_default1['champ']; ?></span></span><br><span class='ville'><?php echo $ville[$lang]; ?><?php echo $donnees_default1['ville']; ?></span><span class='pays'><?php echo $pays[$lang]; ?><?php echo $donnees_default1['pays']; ?></span><br><a href='element.php?nbre=<?php echo $donnees_default1["ID"];?>'><?php echo $plus_d_infos[$lang]; ?></a></div>
            <div><?php echo $donnees_default1['instant_de_signal']; ?><br><?php echo $motif[$lang]; ?><?php echo $donnees_default1['probleme']; ?><br><a href="dashboard.php?rubrique=annonces&amp;signa=signa&amp;servsign=<?php echo $donnees_default1['ID']; ?>"><?php echo $supprimer_des_signales[$lang]; ?></a><br><a href="dashboard.php?rubrique=annonces&amp;signa=signa&amp;servdef=<?php echo $donnees_default1['ID']; ?>"><?php echo $supprimer_definitivement[$lang]; ?></a></div></div><br>
                    <?php
               }
                $req ->closeCursor();
        
    }
else{
    if(isset($_GET['offdef'])){
        if(isset($_GET['confirm']) AND $_GET['confirm']=='yes'){
            $req = $bdd->prepare("DELETE FROM offres_emploi WHERE ID=?");
            $req -> execute(array($_GET['offdef']));
            $req -> closeCursor();
            $req = $bdd->prepare("DELETE FROM offres_emploi_signales WHERE ID_offre=?");
            $req -> execute(array($_GET['offdef']));
            $req -> closeCursor();
        }
        else{
            ?>
            <p><?php echo $voulez_vous_supprimer_def[$lang]; ?></p>
            <p><a href="dashboard.php?rubrique=annonces&amp;servdef=<?php echo htmlspecialchars($_GET['servdef']);?>&amp;confirm=yes"><?php echo $oui[$lang]; ?></a> <a href="dashboard.php?rubrique=annonces&amp;"><?php echo $non[$lang]; ?></a></p>
            <?php
        }
    }
    elseif(isset($_GET['servdef'])){
        if(isset($_GET['confirm']) AND $_GET['confirm']=='yes'){
            $req = $bdd->prepare("DELETE FROM offres_services WHERE ID=?");
            $req -> execute(array($_GET['servdef']));
            $req -> closeCursor();
            $req = $bdd->prepare("DELETE FROM offres_services_signales WHERE ID_offre=?");
            $req -> execute(array($_GET['servdef']));
            $req -> closeCursor();
        }
        else{
            ?>
            <p><?php echo $voulez_vous_supprimer_def[$lang]; ?></p>
            <p><a href="dashboard.php?rubrique=annonces&amp;servdef=<?php echo htmlspecialchars($_GET['servdef']);?>&amp;confirm=yes"><?php echo $oui[$lang]; ?></a> <a href="dashboard.php?rubrique=annonces"><?php echo $non[$lang]; ?></a></p>
            <?php
        }
    }
    else{
        ?>
        <form method="post" action="dashboard.php?rubrique=annonces">
        <input type='search' placeholder='<?php echo $searchP[$lang]; ?>' name="dashAnnoncesSearch" id="dashAnnoncesSearch"><button type="submit"><img src="photos/search.png" alt='search'></button>
        </form>
        <?php
        if(isset($_POST['dashAnnoncesSearch'])){
            $req = $bdd -> prepare('SELECT *, DATE_FORMAT(date_de_publication, "Le %d/%m/%Y à %H:%i") FROM offres_emploi WHERE ID=:ID OR auteur LIKE :auteur OR titre LIKE :titre OR poste LIKE :poste OR champ_activite LIKE :champ_activite OR type_de_travail LIKE :type_de_travail OR type_de_contrat LIKE :type_de_contrat OR ville LIKE :ville OR pays LIKE :pays OR noms_auteur LIKE :noms_auteur OR prenoms_auteur LIKE :prenoms_auteur OR date_de_publication LIKE :date_de_publication');
            $req -> execute(array(
            "ID"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
            "auteur"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
            "titre"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
            "poste"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
            "champ_activite"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
            "type_de_travail"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
            "type_de_contrat"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
            "ville"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
            "pays"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
            "noms_auteur"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
            "prenoms_auteur"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
            "date_de_publication"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%'
            ));
                 while($donnees_default1 = $req->fetch()){
                        if($donnees_default1==false AND $compteur==0){
                            echo $aucun_resultat_ne_correspond_a[$lang];
                        }
                        ?>
                <div class='offres'><div class='image'><img src="photos/profils/<?php echo $donnees_default1['avatar_auteur']; ?>"></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_default1['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_default1['instant_de_publication']; ?></span><br><span class='titreOffre'><?php echo $objet[$lang]; ?><?php echo $donnees_default1['titre'] ?><br><span class='champActivite'><?php echo $champ_d_activite[$lang]; ?><?php echo $donnees_default1['champ_activite']; ?></span></span><br><span class='ville'><?php echo $ville[$lang]; ?><?php echo $donnees_default1['ville']; ?></span><span class='pays'><?php echo $pays[$lang]; ?><?php echo $donnees_default1['pays']; ?></span><br><a href='element.php?nbre=<?php echo $donnees_default1["ID"];?>'><?php echo $plus_d_infos[$lang]; ?></a></div>
               <div><a href="dashboard.php?rubrique=annonces&amp;&amp;offdef=<?php echo $donnees_default1['ID']; ?>"><?php echo $supprimer_definitivement[$lang]; ?></a></div></div><br>
                <?php
                   }
                    $req ->closeCursor();

            $req = $bdd -> prepare('SELECT *, DATE_FORMAT(date_publication, "Le %d/%m/%Y à %H:%i") as instant_de_publication FROM offres_services WHERE ID=:ID OR auteur LIKE :auteur OR titre_proposition LIKE :titre_proposition OR poste LIKE :poste OR champ LIKE :champ OR type_travail LIKE :type_travail OR contact LIKE :contact OR ville LIKE :ville OR pays LIKE :pays OR noms_auteur LIKE :noms_auteur OR prenoms_auteur LIKE :prenoms_auteur OR date_publication LIKE :date_publication OR mail LIKE :mail');
            $req -> execute(array(
                "ID"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
                "auteur"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
                "titre_proposition"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
                "poste"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
                "champ"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
                "type_travail"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
                "contact"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
                "ville"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
                "pays"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
                "noms_auteur"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
                "prenoms_auteur"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
                "date_publication"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%',
                "mail"=>'%'.htmlspecialchars($_POST['dashAnnoncesSearch']).'%'
            ));
                         while($donnees_default1 = $req->fetch()){
                        if($donnees_default1==false AND $compteur==0){
                            echo $aucnu_resultat_ne_correspond_a[$lang];
                        }
                        ?>
                <div class='offres'><div class='image'><img src="photos/profils/<?php echo $donnees_default1['avatar_auteur']; ?>"></div><div class='infos'><span class='auteurPublicationOffre'><?php echo $donnees_default1['auteur'].' '; ?></span><span class='datePublicationOffre'><?php echo $donnees_default1['instant_de_publication']; ?></span><br><span class='titreOffre'><?php echo $objet[$lang]; ?><?php echo $donnees_default1['titre_proposition'] ?><br><span class='champActivite'><?php echo $champ_d_activite[$lang]; ?><?php echo $donnees_default1['champ']; ?></span></span><br><span class='ville'><?php echo $ville[$lang]; ?><?php echo $donnees_default1['ville']; ?></span><span class='pays'><?php echo $pays[$lang]; ?><?php echo $donnees_default1['pays']; ?></span><br><a href='element.php?nber=<?php echo $donnees_default1["ID"];?>'><?php echo $plus_d_infos[$lang]; ?></a></div>
                   <div><a href="dashboard.php?rubrique=annonces&amp;&amp;servdef=<?php echo $donnees_default1['ID']; ?>"><?php echo $supprimer_definitivement[$lang]; ?></a></div></div><br>
                        <?php
                   }
                    $req ->closeCursor();
        }
    }
}
}