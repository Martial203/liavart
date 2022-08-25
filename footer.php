<?php
    
    try{
        $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $e){
        die ('Erreur : '.$e->getMessage());
    }

$nous_suivre_sur=array(
    "fr"=>"Nous suivre sur :",
    "en"=>"Follow us on :",
    "zh-Hant"=>"跟著我們 ：",
    "de"=>"Folge uns auf :",
    "ja"=>"フォローしてください ：",
    "hi"=>"हमें फॉलो करें:",
    "bn"=>"আমাদেরকে অনুসরণ করুন :",
    "pt"=>"Siga-nos no :",
    "ru"=>"Следуйте за нами :",
    "es"=>"Siguenos en :",
    "ar"=>": تابعنا على"
);

$nous_envoyer_un_mail=array(
    "fr"=>"Nous envoyer un mail...",
    "en"=>"Send us a mail...",
    "zh-Hant"=>"給我們發電子郵件...",
    "de"=>"Schreiben Sie uns eine E-Mail...",
    "ja"=>"私達に電子メールを送り...",
    "hi"=>"हमें ईमेल करें...",
    "bn"=>"আমাদেরকে ইমেইল করুন...",
    "pt"=>"Envia-nos um email...",
    "ru"=>"Свяжитесь с нами по электронной почте...",
    "es"=>"Envíenos un correo electrónico...",
    "ar"=>"...ارسل لنا عبر البريد الإلكتروني"
);

if(isset($lang)){
    $reqRs = $bdd->query("SELECT * FROM links_rs");
    while($repRs = $reqRs->fetch()){
        if($repRs['reseau']=="facebook"){
            $faceLink=$repRs[$lang];
        }
        elseif($repRs['reseau']=="instagram"){
            $instaLink=$repRs[$lang];
        }
        elseif($repRs['reseau']=="telegram"){
            $teleLink=$repRs[$lang];
        }
        elseif($repRs['reseau']=="whatsapp"){
            $waLink=$repRs[$lang];
        }
        elseif($repRs['reseau']=="twitter"){
            $twiLink=$repRs[$lang];
        }
    }
?>
<div id="nousSuivre">
    <div><?php echo $nous_suivre_sur[$lang]; ?></div><div>
    <a href="<?php echo $faceLink; ?>"><img class="reseauSocial" alt="facebook" src="photos/facebook.png"></a> 
    <a href="<?php echo $twiLink; ?>"> <img class="reseauSocial" alt="twitter" src="photos/twitter.png"></a> 
    <a href="<?php echo $instaLink; ?>"><img alt="instagram" class="reseauSocial" src="photos/instagram.png"></a> 
    <a href="<?php echo $teleLink; ?>"><img alt="telegram" class="reseauSocial" src="photos/telegram.png"></a> 
    <a href="<?php echo $waLink; ?>"><img class="reseauSocial" alt="whatsapp" src="photos/whatsapp.png"></a></div>
</div>
<div id="nousContacter">
    <br><a href="mailto:liavart21@gmail.com"><?php echo $nous_envoyer_un_mail[$lang]; ?></a>
</div>
<style>
    footer, #footer{
        display: flex;
        padding-left: 1em;
        padding-right: 1em;
        padding-top: 1ex;
        padding-bottom: 1ex;
        flex-direction: row;
        background-color: aqua;
/*        position: fixed;*/
        bottom: 0em;
        height:7.4%;
/*
        position: fixed;
        top: 91vh;
        width: 100vw;
*/
        font-size: 15px;
    }
    #nousSuivre{
        flex: 2;
        text-align: left;
    }
    #nousContacter{
        flex: 1;
        text-align: center;
    }
    .reseauSocial{
        width: 2em;
        height: 2em;
    }
    @media all and (max-width:380px){
        footer{
            flex-direction: column;
        }
        #nousContacter{
            text-align: right;
        }
    }
</style>
<?php
}
?>