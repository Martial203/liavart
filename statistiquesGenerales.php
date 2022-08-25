<?php
if(isset($_SESSION['dash']) AND $_SESSION['dash']=="auth"){
//select replace(connexions.nom_utilisateur,'(d)','') as nouveau_nom_utilisateur, inscrits.nom_utilisateur, inscrits.pays_de_residence, inscrits.ville_de_residence from connexions, inscrits WHERE replace(connexions.nom_utilisateur,'(d)','')=inscrits.nom_utilisateur;
    $req = $bdd -> query('SELECT COUNT(nom_utilisateur) as nbre_users FROM inscrits GROUP BY sexe ORDER BY sexe desc');
    $nbreMasculins=$req->fetch()['nbre_users'];
    $nbreFeminins=$req->fetch()['nbre_users'];
    $nbreNonDeclares=$req->fetch()['nbre_users'];
    $req -> closeCursor();

    $req = $bdd ->query('SELECT COUNT(auteur) as nbre_emplois FROM offres_emploi');
    $nbreEmplois=$req->fetch()['nbre_emplois'];
    $req ->closeCursor();

    $req = $bdd ->query('SELECT COUNT(auteur) as nbre_services FROM offres_services');
    $nbreServices=$req->fetch()['nbre_services'];
    $req ->closeCursor();

    $req = $bdd -> query('SELECT COUNT(*) as nbre_total_visites FROM visites');
    $nbreTotalVisites= $req->fetch()['nbre_total_visites'];
    $req ->closeCursor();

    $req =$bdd -> query('SELECT COUNT(DISTINCT nom_utilisateur) as nbre_en_ligne FROM connexions WHERE nom_utilisateur NOT LIKE \'%(d)\' AND instant_de_connexion>=DATE_SUB(NOW(), INTERVAL 10 HOUR)');
    $nbreUsersOnline = $req -> fetch()['nbre_en_ligne'];
    $req -> closeCursor();

    $req = $bdd -> query('SELECT DAY(NOW())-DAY(instant_de_connexion) as quand, COUNT(DISTINCT nom_utilisateur) as connectes, COUNT(nom_utilisateur) as connexions FROM connexions WHERE DATE(NOW())-DATE(instant_de_connexion) IN (0,1) GROUP BY quand ORDER BY quand');
    $reponse1 = $req -> fetch();
    $nbreConnectesAujourdhui = ($reponse1['connectes']=="")?0:$reponse1['connectes'];
    $nbreConnexionsAjourdhui = ($reponse1['connexions']=="")?0:$reponse1['connexions'];
    $reponse2 = $req -> fetch();
    $nbreConnectesHier = ($reponse2['connectes']=="")?0:$reponse2['connectes'];
    $nbreConnexionsHier = ($reponse2['connexions']=="")?0:$reponse2['connexions'];
    $req -> closeCursor();

    $req = $bdd -> query('SELECT MONTH(NOW())-MONTH(instant_de_connexion) as quand, COUNT(nom_utilisateur) as connexions FROM connexions WHERE YEAR(NOW())=YEAR(instant_de_connexion) GROUP BY quand ORDER BY quand');
    $reponse1 = $req -> fetch();
    $nbreConnexionsCeMois = ($reponse1['connexions']=="")?0:$reponse1['connexions'];
    $reponse2 = $req -> fetch();
    $nbreConnexionsMoisDernier = ($reponse2['connexions']=="")?0:$reponse2['connexions'];
    $req -> closeCursor();

    $req = $bdd -> query('SELECT MONTH(NOW())-MONTH(heure) as quand, COUNT(heure) as visites FROM visites WHERE YEAR(NOW())=YEAR(heure) GROUP BY quand ORDER BY quand');
    $reponse1 = $req -> fetch();
    $nbreVisitesCeMois = ($reponse1['visites']=="")?0:$reponse1['visites'];
    $reponse2 = $req -> fetch();
    $nbreVisitesMoisDernier = ($reponse2['visites']=="")?0:$reponse2['visites'];
    $req -> closeCursor();

    $req = $bdd -> query('SELECT DAY(NOW())-DAY(heure) as quand, COUNT(heure) as visites FROM visites WHERE DATE(NOW())-DATE(heure) IN (0,1) GROUP BY quand ORDER BY quand');
    $reponse1 = $req -> fetch();
    $nbreVisitesAujourdhui = ($reponse1['visites']=="")?0:$reponse1['visites'];
    $reponse2 = $req -> fetch();
    $nbreVisitesHier = ($reponse2['visites']=="")?0:$reponse2['visites'];
    $req -> closeCursor();

    $req = $bdd -> query('SELECT YEAR(NOW())-YEAR(instant_de_connexion) as quand, COUNT(instant_de_connexion) as connexions FROM connexions WHERE YEAR(NOW())-YEAR(instant_de_connexion) IN (0,1) GROUP BY quand ORDER BY quand');
    $reponse1 = $req -> fetch();
    $nbreConnexionsCetAn = ($reponse1['connexions']=="")?0:$reponse1['connexions'];
    $reponse2 = $req -> fetch();
    $nbreConnexionsAnDernier = ($reponse2['connexions']=="")?0:$reponse2['connexions'];
    $req -> closeCursor();

    $req = $bdd -> query('SELECT YEAR(NOW())-YEAR(heure) as quand, COUNT(heure) as visites FROM visites WHERE YEAR(NOW())-YEAR(heure) IN (0,1) GROUP BY quand ORDER BY quand');
    $reponse1 = $req -> fetch();
    $nbreVisitesCetAn = ($reponse1['visites']=="")?0:$reponse1['visites'];
    $reponse2 = $req -> fetch();
    $nbreVisitesAnDernier = ($reponse2['visites']=="")?0:$reponse2['visites'];
    $req -> closeCursor();

    $req = $bdd-> query('select max(pays_de_residence) as paysMax, count(*)/(SELECT count(*) FROM inscrits)*100 as pourcentagePaysMax FROM inscrits Where pays_de_residence=(SELECT max(pays_de_residence) FROM inscrits)');
    $reponse = $req->fetch();
    $paysMax = $reponse['paysMax'];
    $pourcentagePaysMax = $reponse['pourcentagePaysMax'];
    $req -> closeCursor();

    $req = $bdd-> query('select max(ville_de_residence) as villeMax, count(*)/(SELECT count(*) FROM inscrits)*100 as pourcentageVilleMax FROM inscrits Where ville_de_residence=(SELECT max(ville_de_residence) FROM inscrits)');
    $reponse = $req->fetch();
    $villeMax = $reponse['villeMax'];
    $pourcentageVilleMax = $reponse['pourcentageVilleMax'];
    $req -> closeCursor();

    $req = $bdd->query("select max(pays_de_residence) paysMax, count(pays_de_residence)/(select count(pays_de_residence) from inscrits, connexions where replace(connexions.nom_utilisateur,'(d)','')=replace(inscrits.nom_utilisateur,'(d)',''))*100 as pourcentagePays from inscrits, connexions WHERE replace(connexions.nom_utilisateur,'(d)','')=replace(inscrits.nom_utilisateur,'(d)','')");
    $reponse = $req->fetch();
    $paysPlusConnecte = $reponse['paysMax'];
    $pourcentagePaysConnecte = $reponse['pourcentagePays'];
    $req -> closeCursor();

    $req = $bdd->query("select max(ville_de_residence) villeMax, count(ville_de_residence)/(select count(ville_de_residence) from inscrits, connexions where replace(connexions.nom_utilisateur,'(d)','')=replace(inscrits.nom_utilisateur,'(d)',''))*100 as pourcentageVille from inscrits, connexions WHERE replace(connexions.nom_utilisateur,'(d)','')=replace(inscrits.nom_utilisateur,'(d)','')");
    $reponse = $req->fetch();
    $villePlusConnecte = $reponse['villeMax'];
    $pourcentageVilleConnecte = $reponse['pourcentageVille'];
    $req -> closeCursor();
?>
<p>Recapitulatifs générales de l'utilisation du site.</p>
<table>
    <tr><td>Nombre d'utilisateurs en ligne :</td><td><?php echo $nbreUsersOnline ; ?></td></tr>
    <tr><td>Nombre de connexions aujourd'hui :</td><td><?php echo $nbreConnexionsAjourdhui ; ?></td></tr>
    <tr><td>Nombre de connectés hier :</td><td><?php echo $nbreConnectesHier ; ?></td></tr>
    <tr><td>Nombre de connexions ce mois :</td><td><?php echo $nbreConnexionsCeMois ; ; ?></td></tr>
    <tr><td>Nombre de connexions le mois dernier :</td><td><?php echo $nbreConnexionsMoisDernier ; ?></td></tr>
    <tr><td>Nombre de connexions cette année :</td><td><?php echo $nbreConnexionsCetAn ; ?></td></tr>
    <tr><td>Nombre de connexions l'an dernier :</td><td><?php echo $nbreConnexionsAnDernier ; ?></td></tr>
    <tr><td>Nombre de visites sur le site aujourd'hui :</td><td><?php echo $nbreVisitesAujourdhui ; ?></td></tr>
    <tr><td>Nombre de visites sur le site hier :</td><td><?php echo $nbreVisitesHier ; ?></td></tr>
    <tr><td>Nombre de visites sur le site ce mois :</td><td><?php echo $nbreVisitesCeMois ?></td></tr>
    <tr><td>Nombre de visites sur le site le mois dernier :</td><td><?php echo $nbreVisitesMoisDernier ?></td></tr>
    <tr><td>Nombre de visites sur le site cette année :</td><td><?php echo $nbreVisitesCetAn ; ?></td></tr>
    <tr><td>Nombre de visites sur le site l'an dernier :</td><td><?php  echo $nbreVisitesAnDernier ; ?></td></tr>
    <tr><td>Nombre de visites sur le site depuis mise en place :</td><td><?php echo $nbreTotalVisites ; ?></td></tr>
    <tr><td>Pays le plus connecté :</td><td><?php echo $paysPlusConnecte.'('.$pourcentagePaysConnecte.'%)'; ?></td></tr>
    <tr><td>Ville la plus connectée :</td><td><?php echo $villePlusConnecte.'('.$pourcentageVilleConnecte.'%)'; ?></td></tr>
    <tr><td>Nombre total d'annonces :</td><td><?php echo ($nbreEmplois+$nbreServices) ; ?></td></tr>
    <tr><td>offres emploi/demandes de services :</td><td><?php echo $nbreEmplois ; ?></td></tr>
    <tr><td>demandes emploi/propositions de services :</td><td><?php echo $nbreServices ; ?></td></tr>
    <tr><td>Nombre total d'utilisateurs :</td><td><?php echo ($nbreMasculins+$nbreFeminins+$nbreNonDeclares) ; ?></td></tr>
    <tr><td>Masculins :</td><td><?php echo $nbreMasculins ; ?></td></tr>
    <tr><td>Feminins :</td><td><?php echo $nbreFeminins ; ?></td></tr>
    <tr><td>Non-déclarés :</td><td><?php echo $nbreNonDeclares ; ?></td></tr>
    <tr><td>Nationalité la plus inscrite :</td><td><?php echo $paysMax.'('.$pourcentagePaysMax.'%)' ; ?></td></tr>
    <tr><td>Ville la plus inscrite :</td><td><?php echo $villeMax.'('.$pourcentageVilleMax.'%)'; ?></td></tr>
</table>
<?php
}
?>