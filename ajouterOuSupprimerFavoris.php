<?php
if(isset($_SESSION['offres_emploi_favoris']) AND isset($_SESSION['offres_services_favoris'])){ 
$emplois_favoris=explode(',',$_SESSION['offres_emploi_favoris']);
$services_favoris=explode(',',$_SESSION['offres_services_favoris']);
if(isset($_GET['favNbre']) OR isset($_GET['supFavNbre'])){
    if(isset($_GET['favNbre'])){
        if(in_array($_GET['favNbre'],$emplois_favoris)==false){
        $_SESSION['offres_emploi_favoris'].=htmlspecialchars($_GET['favNbre']).',';
        }
    }
    elseif(isset($_GET['supFavNbre'])){
           $_SESSION['offres_emploi_favoris']=str_replace($_GET['supFavNbre'],'0',$_SESSION['offres_emploi_favoris']);
    }
    $req = $bdd -> prepare('UPDATE inscrits SET offres_emploi_favoris=? WHERE nom_utilisateur=?');
    $req -> execute(array($_SESSION['offres_emploi_favoris'],$_SESSION['user']));
}
elseif(isset($_GET['favNber']) OR isset($_GET['supFavNber'])){
    if(isset($_GET['favNber'])){
        if(in_array($_GET['favNber'],$services_favoris)==false){
        $_SESSION['offres_services_favoris'].=htmlspecialchars($_GET['favNber']).',';
        }
    }
    elseif(isset($_GET['supFavNber'])){
           $_SESSION['offres_services_favoris']=str_replace($_GET['supFavNber'],'0',$_SESSION['offres_services_favoris']);
    }
        $req = $bdd -> prepare('UPDATE inscrits SET offres_services_favoris=? WHERE nom_utilisateur=?');
        $req -> execute(array($_SESSION['offres_services_favoris'],$_SESSION['user']));
}
}
?>