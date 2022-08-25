<?php
if(isset($lang)){
$changer_de_langue=array(
    "fr"=>"Changer de langue : ",
    "en"=>"Change language : ",
    "zh-Hant"=>"改變語言 ： ",
    "de"=>"Sprache ändern : ",
    "ja"=>"言語を変更 ： ",
    "hi"=>"भाषा बदलो : ",
    "bn"=>"ভাষা পরিবর্তন করুন : ",
    "pt"=>"Mudar idioma : ",
    "ru"=>"Изменить язык : ",
    "es"=>"Cambiar idioma : ",
    "ar"=>" : تغيير اللغة"
);
    
$retour_a_l_accueil=array(
    "fr"=>"Retour à la page d'accueil",
    "en"=>"Back to the homepage",
    "zh-Hant"=>"返回首頁",
    "de"=>"Zurück zur Startseite",
    "ja"=>"ホームページに戻る",
    "hi"=>"वापस होम पेज पर",
    "bn"=>"হোমপেজে ফিরে",
    "pt"=>"Voltar a página inicial",
    "ru"=>"Назад на главную страницу",
    "es"=>"Volver a la página de inicio",
    "ar"=>"رجوع إلى الصفحة الرئيسية"
);
if(isset($shop)){
?>
    <nav id="navRet"> <a href="accueil.php"> <img src="photos/Fleche.png" id="imgRet"><?php echo $retour_a_l_accueil[$lang]; ?></a></nav>
    <style type="text/css">
        #navRet{
            position: absolute;
            top: 2em;
            height: 1.5em;
            border: none;
        }
        #imgRet{
            width: 20px;
        }
    </style>
<?php
}
?>
<a href="accueil.php"><img id="LIAVART" alt="LIAVART" <?php if(isset($acc)){ ?> src="photos/LIAVART%20TEXT.png" <?php } elseif(isset($shop)){?> src="photos/liavartShop(png).png"<?php } else{ ?> src="photos/liavart(png).png"<?php } ?>></a><br>
       <form method="post" action="#" id="formChoixLangue" class="langChoice"><label><?php echo $changer_de_langue[$lang]; ?> </label><div><select name="lang">
<option value="fr" <?php if($lang=="fr"){echo "selected";} ?>>Francais</option>
<option value="en" <?php if($lang=="en"){echo "selected";} ?>>English</option>
<option value="zh-Hant" <?php if($lang=="zh-Hant"){echo "selected";} ?>>中國人</option>
<option value="ja" <?php if($lang=="ja"){echo "selected";} ?>>日本語</option>
<option value="de" <?php if($lang=="de"){echo "selected";} ?>>Deutsch</option>
<option value="es" <?php if($lang=="es"){echo "selected";} ?>>Español</option>
<option value="hi" <?php if($lang=="hi"){echo "selected";} ?>>हिंदी</option>
<option value="bn" <?php if($lang=="bn"){echo "selected";} ?>>বাংলা</option>
<option value="pt" <?php if($lang=="pt"){echo "selected";} ?>>Português</option>
<option value="ru" <?php if($lang=="ru"){echo "selected";} ?>>Pусский</option>
<!--<option value="ar">عربي</option>-->
</select>
<button type="submit"><img src="photos/tickValidation.png"></button></div></form>
<style type="text/css">
    body{
        margin:auto;
    }
    header, #header{
        /*background-image: url(photos/ciel_nuageux.jpg);*/
        background-color: aqua;
        padding: 0em;
        text-align: center;
        font-size: 15px;
        width: 100%;
    }
    #LIAVART{
        width: 250px;
        margin: 0em;
    }
    #formChoixLangue, #formChoixLangue1{
        font-size: 13px;
        text-align: left;
        padding-left: 5px;
        position: absolute;
        right: 1%;
        line-height: 18px;
    }
    #formChoixLangue label, #formChoixLangue1 label{
        display: block;
    }
    #formChoixLangue select, #formChoixLangue1 select{
        height: 1.5em;
    }
    #formChoixLangue button, #formChoixLangue1 button{
        height: 1.5em;
    }
    #formChoixLangue button img, #formChoixLangue1 button img{
        height: 100%;
        width: 100%;
    }
</style>
<?php
}
?>