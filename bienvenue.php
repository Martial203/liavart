<!DOCTYPE html>
<?php
include("languageDefinition.php");
include("dictionnaireBienvenue.php");
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta lang="<?php echo $lang; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="height=device-height, initial-scale=1.0">
    <title><?php echo $bienvenue[$lang];?></title>
    <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
    <style type="text/css">
        @keyframes bienvenue{
    0%{
        transform: scale(1);
        background-color: azure;
    }
    50%{
        transform: scale(1.05);
        background-color: aqua;
    }
    100%{
        transform: scale(1);
        background-color: azure;
    }
}

        h1{
            flex: 1;
            text-align: center;
        }
        #bienvenue{
            display: flex;
            flex-direction: column;
            border: solid;
            box-shadow: 1px 2px 15px 5px; 
            margin-left: 30%;
            margin-right: 30%;
            margin-top: 2em;
            padding: 2em;
            font-size: 300%;
            animation-name: bienvenue;
            animation-duration: 2000ms;
            animation-iteration-count: infinite;
            animation-timing-function: ease-in-out;
            min-width: 5em;
        }
        @media all and (max-width:1279px){
            #bienvenue{
                margin-left: 20%;
                margin-right: 20%;
            }
            @media all and (max-width:1279px){
            #bienvenue{
                margin-left: 15%;
                margin-right: 15%;
                padding: 1em;
            }
        }
        }
        #accueil{
            padding: 2em;
            padding-top: 1.5em;
            padding-bottom: 0em;
        }
        body{
            font-size: 101%;
        }
        h2 a{
            text-decoration: none;
        }
        h2{
            text-align: center;
            font-size: 150%;
            padding-bottom: 0em;
            margin-bottom: 3em;
            margin-left: 20%;
            margin-right: 20%;
            transition: transform 500ms;
        }
        span{
            display: inline-block;
            border: solid;
            border-radius: 1em;
            background-color: skyblue;
            margin-top: 1em;
            padding-left: 1em;
            padding-right: 1em;
            border-style: groove;
            border-width: 2px;
            
            animation-name: bienvenue;
            animation-duration: 2000ms;
            animation-iteration-count: infinite;
            animation-timing-function: ease-in-out;
        }
        h2:hover{
            transform: scale(1.2);
        }
    </style>
</head>
<body>
    <header><?php include("header.php") ?></header>
    <div id=Bienvenu>
    <h1 id="bienvenue"><?php echo $bienvenu_une_fois_de_plus[$lang];?><bold>LIAVART</bold></h1><br><br>
    <h1 id="accueil"><?php echo $decouvrons[$lang];?></h1>
    </div>
    <h2><span><a href="contenus.php?bv=b&amp;rubrique=portail1"> <?php echo $Commencer[$lang];?></a></span></h2>
    <footer><?php include("footer.php") ?></footer>
</body>
</html>