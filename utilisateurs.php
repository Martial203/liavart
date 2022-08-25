<?php
if(isset($_SESSION['dash']) AND $_SESSION['dash']=="auth"){
?>
<form method="post" action="dashboard.php?rubrique=utilisateurs<?php if(isset($_GET['blo'])){echo '&amp;blo=blo';} ?>">
<input type='search' placeholder='rechercher' name='dashboardUserSearch'><button type="submit"><img src="photos/search.png" alt='search'></button>
</form>
<?php
if(isset($_GET['blo'])){
    if(isset($_GET['del'])){
        if(isset($_GET['confirm']) AND $_GET['confirm']=='yes'){
            $req = $bdd -> prepare("DELETE FROM inscrits WHERE id=?");
            $req -> execute(array($_GET['del']));
        }
        else{
            ?>
            <p>Voulez vous vraiment supprimer cet utilisateur ?</p>
            <p><a href="dashboard.php?rubrique=utilisateurs&amp;blo=blo&amp;del=<?php echo $_GET['del']; ?>&amp;confirm=yes">OUI</a><a href="dashboard.php?rubrique=utilisateurs&amp;blo=blo">NON</a></p>
            <?php
        }
    }
    elseif(isset($_GET['deblck'])){
        if(isset($_GET['confirm']) AND $_GET['confirm']=='yes'){
            $req = $bdd -> prepare("UPDATE inscrits SET bloque='' WHERE id=?");
            $req -> execute(array($_GET['deblck']));
        }
        else{
            ?>
            <p>Voulez vous vraiment débloquer cet utilisateur ?</p>
            <p><a href="dashboard.php?rubrique=utilisateurs&amp;blo=blo&amp;deblck=<?php echo $_GET['deblck']; ?>&amp;confirm=yes">OUI</a><a href="dashboard.php?rubrique=utilisateurs&amp;blo=blo">NON</a></p>
            <?php
        }
    }
    else{
        if(isset($_GET['dashboardUserSearch'])){
        $req = $bdd -> prepare('SELECT * FROM inscrits WHERE (bloque="TRUE") AND (id=:id OR noms=:noms OR prenoms=:prenoms OR sexe=:sexe OR pays_de_residence=:pays_de_residence OR ville_de_residence=:ville_de_residence OR adresse_mail=:adresse_mail OR nom_utilisateur=:nom_utilisateur OR site_entreprise=:site_entreprise)');
        $req -> execute(array(
            'id'=>$_POST['dashboardUserSearch'],
            'noms'=>$_POST['dashboardUserSearch'],
            'prenoms'=>$_POST['dashboardUserSearch'],
            'sexe'=>$_POST['dashboardUserSearch'],
            'pays_de_residence'=>$_POST['dashboardUserSearch'],
            'ville_de_residence'=>$_POST['dashboardUserSearch'],
            'adresse_mail'=>$_POST['dashboardUserSearch'],
            'nom_utilisateur'=>$_POST['dashboardUserSearch'],
            'site_entreprise'=>$_POST['dashboardUserSearch']
        ));
    }
       else{
            $req = $bdd -> query('SELECT * FROM inscrits WHERE bloque="TRUE"');
       }
    while($reponse=$req->fetch()){
            $compteur=1;
            ?>
            <div class="userInfos"><div class="profileImage"><img src="photos/profils/<?php echo $reponse['avatar']; ?>"></div><div class="infos">
            <table><tr>
            <td>id</td><td>Noms</td><td>Prenoms</td><td>Sexe</td><td>Pays de residence</td><td>Ville de residence</td><td>Adresse mail</td><td>nom d'utilisateur</td><td>Description du profil</td><td>Site entreprise</td><td>Pages entreprise</td><td></td>
            </tr>
            <tr><td><?php echo $reponse['id'] ;?></td><td><?php echo $reponse['noms'] ;?></td><td><?php echo $reponse['prenoms'] ;?></td><td><?php echo $reponse['sexe'] ;?></td><td><?php echo $reponse['pays_de_residence'] ;?></td><td><?php echo $reponse['ville_de_residence'] ;?></td><td><?php echo $reponse['adresse_mail'] ;?></td><td><?php echo $reponse['nom_utilisateur'] ;?></td><td><?php echo $reponse['description_du_profil'] ;?></td><td><?php echo $reponse['site_entreprise'] ;?></td><td><?php echo $reponse['pages_entreprises'] ;?></td><td><a href="dashboard.php?rubrique=utilisateurs&amp;blo=blo&amp;deblck=<?php echo $reponse['id'];?>">Débloquer</a></td><td><a href="dashboard.php?rubrique=utilsateurs&amp;blo=blo&amp;del=<?php echo $reponse['id'];?>">Supprimer</a></td></tr>
            </table>
            </div></div>
            <?php
        }
    if($reponse==false AND isset($compteur)==false){
                echo 'Aucun utilisateur bloqué !';
            }
        $req -> closeCursor();
       }
}
else{
    if(isset($_GET['blc'])){
        if(isset($_GET['confirm']) AND $_GET['confirm']=='yes'){
            $req = $bdd -> prepare("UPDATE inscrits SET bloque='TRUE' WHERE id=?");
            $req -> execute(array($_GET['blc']));
        }
        else{
            ?>
            <p>Voulez vous vraiment bloquer cet utilisateur ?</p>
            <p><a href="dashboard.php?rubrique=utilisateurs&amp;blc=<?php echo $_GET['blc']; ?>&amp;confirm=yes">OUI</a><a href="dashboard.php?rubrique=utilisateurs">NON</a></p>
            <?php
        }
    }
    elseif(isset($_GET['del'])){
        if(isset($_GET['confirm']) AND $_GET['confirm']=='yes'){
            $req = $bdd -> prepare("DELETE FROM inscrits WHERE id=?");
            $req -> execute(array($_GET['del']));
        }
        else{
            ?>
            <p>Voulez vous vraiment supprimer cet utilisateur ?</p>
            <p><a href="dashboard.php?rubrique=utilisateurs&amp;del=<?php echo $_GET['del']; ?>&amp;confirm=yes">OUI</a><a href="dashboard.php?rubrique=utilisateurs">NON</a></p>
            <?php
        }
    }
    elseif(isset($_POST['dashboardUserSearch'])){
        $req = $bdd -> prepare('SELECT * FROM inscrits WHERE id=:id OR noms=:noms OR prenoms=:prenoms OR sexe=:sexe OR pays_de_residence=:pays_de_residence OR ville_de_residence=:ville_de_residence OR adresse_mail=:adresse_mail OR nom_utilisateur=:nom_utilisateur OR site_entreprise=:site_entreprise OR bloque=:bloque');
        $req -> execute(array(
            'id'=>$_POST['dashboardUserSearch'],
            'noms'=>$_POST['dashboardUserSearch'],
            'prenoms'=>$_POST['dashboardUserSearch'],
            'sexe'=>$_POST['dashboardUserSearch'],
            'pays_de_residence'=>$_POST['dashboardUserSearch'],
            'ville_de_residence'=>$_POST['dashboardUserSearch'],
            'adresse_mail'=>$_POST['dashboardUserSearch'],
            'nom_utilisateur'=>$_POST['dashboardUserSearch'],
            'site_entreprise'=>$_POST['dashboardUserSearch'],
            'bloque'=>$_POST['dashboardUserSearch']
        ));
        while($reponse=$req->fetch()){
            $compteur=1;
            ?>
            <div class="userInfos"><div class="profileImage"><img src="photos/profils/<?php echo $reponse['avatar']; ?>"></div><div class="infos">
            <table><tr>
            <td>id</td><td>Noms</td><td>Prenoms</td><td>Sexe</td><td>Pays de residence</td><td>Ville de residence</td><td>Adresse mail</td><td>nom d'utilisateur</td><td>Description du profil</td><td>Site entreprise</td><td>Pages entreprise</td><td colspan="2">bloqué ?</td>
            </tr>
            <tr><td><?php echo $reponse['id'] ;?></td><td><?php echo $reponse['noms'] ;?></td><td><?php echo $reponse['prenoms'] ;?></td><td><?php echo $reponse['sexe'] ;?></td><td><?php echo $reponse['pays_de_residence'] ;?></td><td><?php echo $reponse['ville_de_residence'] ;?></td><td><?php echo $reponse['adresse_mail'] ;?></td><td><?php echo $reponse['nom_utilisateur'] ;?></td><td><?php echo $reponse['description_du_profil'] ;?></td><td><?php echo $reponse['site_entreprise'] ;?></td><td><?php echo $reponse['pages_entreprises'] ;?></td><td><?php echo $reponse['bloque'] ;?></td><td><a href="dashboard.php?rubrique=utilisateurs&amp;blc=<?php echo $reponse['id'];?>">Bloquer</a></td><td><a href="dashboard.php?rubrique=utilsateurs&amp;del=<?php echo $reponse['id'];?>">Supprimer</a></td></tr>
            </table>
            </div></div>
            <?php
        }
            if($reponse==false AND isset($compteur)==false){
                echo 'Aucun utilisateur ne correspond au mot clé saisi !';
            }
        $req -> closeCursor();
    }
}
}
?>