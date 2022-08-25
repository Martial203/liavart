<?php
//    $lang=isset($_POST['lang'])?$_POST['lang']:"en";
//    setcookie('lang', $lang, time()+3600*24*365, null, null, false, true);
//    $lang=$_COOKIE['lang'];


try{
    $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
catch(Exception $e){
    die ('Erreur : '.$e->getMessage());
}

if(isset($_POST['lang'])){
    $lang=$_POST['lang'];
    setcookie('lang', $lang, time()+3600*24*365, null, null, false, true);
    if(isset($_SESSION['user'])){
        $reqLang = $bdd->prepare('UPDATE inscrits SET lang=? WHERE nom_utilisateur=?');
        $reqLang -> execute(array($_COOKIE['lang'], $_SESSION['user']));
    }
}
elseif(isset($_COOKIE['lang'])){
    $lang=$_COOKIE['lang'];
    setcookie('lang', $lang, time()+3600*24*365, null, null, false, true);
    if(isset($_SESSION['user'])){
        $reqLang = $bdd->prepare('UPDATE inscrits SET lang=? WHERE nom_utilisateur=?');
        $reqLang -> execute(array($_COOKIE['lang'], $_SESSION['user']));
    }
}
else{
    if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
        $browserLanguages=explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        foreach($browserLanguages as $bLanguage){
            $Langage=strtolower(substr($bLanguage,0,2));
            if(in_array($Langage,array('en', 'zh-Hant', 'de', 'ja', 'hi', 'bn', 'pt', 'ru', 'es', 'ar'))){
                $lang=$Langage;
            }
            else{
                $lang="en";
            }
        }
    }
    else{
        $lang="en";
    }
}
?>