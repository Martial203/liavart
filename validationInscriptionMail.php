<?php
if(isset($_SESSION['adresseMail'])){
include("languageDefinition.php");
include("dictionnaireValidationMail.php");

    $destinataire=$_SESSION['adresseMail'];
    $subject=$confirmation_d_inscription_sur[$lang];
    $contenu='<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="height=device-height, initial-scale=1.0">
    <title>'.$confirmation_d_inscription[$lang].'</title>
    <style type="text/css">
        body{
        }
        h2{
            border-bottom: solid;
            margin: auto;
            border-width: 2px;
            padding: 0.15em;
            background-color: mediumaquamarine;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        #contenuMail{
            border: solid;
            border-width: 2px;
            border-top-left-radius: 1.5ex;
            border-top-right-radius: 1.5ex;
            border-bottom-left-radius: 1.5ex;
            border-bottom-right-radius: 1.5ex;
            margin-top: 2em;
            margin-left: 10vw;
            margin-right: 10vw;
            min-width: 11.2em;
            
        }
        @media all and (max-width:982px){
            #contenuMail{
                margin-left: 5vw;
                margin-right: 5vw;
            }
        }
        #p3{
            text-align: center;
        }
        #p3 a{
            display: block;
            text-decoration: none;
            border-style: groove;
            border-width: 2px;
            border-radius: 1em;
            padding: 0.2em;
            margin-top: 2em;
            margin-left: 20%;
            margin-right: 20%;
            transition: background-color 400ms;
        }
        #p3 a:hover{
            background-color: mediumaquamarine;
        }
        h2, #p1, #p2, #p3{
            padding-left: 1em;
            padding-right: 1em;
        }
        bold{
            font-weight: bolder;
            font-size: 120%;
        }
        #p4{
            text-align: right;
            padding-right: 1em;
        }
        #p4 a{
            text-decoration: underline;
            font-style: italic;
            color: black;
        }
    </style>
</head>
<body>
    
    <div id="contenuMail">
    <h2>'.$confirmation_d_inscription_sur[$lang].'</h2>
    <p id="p1">'.$bienvenue_a_vous[$lang].' '.$_SESSION["userName"].' '.$sur[$lang].' <bold>Liavart</bold>, '.$votre_marche_virtuel[$lang].'</p>
    <p id="p2">'.$afin_de_finaliser_votre[$lang].'</p>
    <p id="p3"><a href="localhost/code/inscription3.php">'.$finaliser_mon_inscription[$lang].'</a></p>
    <p id="p4"><a href="montwitter" target="_blank">'.$twitter[$lang].'</a><a href="monFacebook" target="_blank">'.$facebook[$lang].'</a></p>
    </div>
</body>
</html>';
    $headers="From: Liavart <liavart21@gmail.com>\n";
    $headers.="MIME-Version: 1.0\n";
    $headers.="Content-type: text/html; charset=utf-8\n";
    $headers.="Content-transfer-Encoding: 8bit";
if(mail($destinataire, $subject, $contenu, $headers)){
?>
<p id="mailEnvoye"><?php echo $veuillez_confirmer_votre[$lang]; ?></p>
<p id="renvoiMail"><?php echo $mail_non_recu[$lang]; ?><a href="localhost/code/inscription2.php"><?php echo $renvoyer_le_mail[$lang]; ?></a></p>
<?php           
    }
else{
    ?>
    <p><?php echo $le_mail_n_a_pas_pu[$lang]; ?></p>
    <?php
}
}