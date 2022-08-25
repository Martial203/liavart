<?php
if(isset($_SESSION['user'])){
?>
<h3>Portails</h3>
<?php
include("languageDefinition.php");
include("dictionnaireAside.php");
?>

<ul id="portails"><li><a href="contenus.php?rubrique=portail1"><?php echo $portail1[$lang]; ?></a></li> <li><a href="contenus.php?rubrique=portail2"><?php echo $portail2[$lang]; ?></a></li></ul>
<h3><a href="contenus.php?rubrique=mesOffres"><?php echo $mes_publications[$lang]; ?></a></h3>
<h3><a href="contenus.php?rubrique=favoris"><?php echo $mes_favoris[$lang]; ?></a></h3>
<h3><a href="contenus.php?rubrique=parametres"><?php echo $parametres[$lang]; ?></a></h3>
<h3><a href="contenus.php?rubrique=deconnexion"><?php echo $se_deconnecter[$lang]; ?></a></h3>
<style type="text/css">
    #portails{
        position: relative;
        bottom: 2ex;
    }
</style>
<?php
}
?>