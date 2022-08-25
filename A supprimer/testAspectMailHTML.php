<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta lang="<?php echo $lang; ?>">
    <title>Confirmation inscription</title>
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
    <h2>Confirmation inscription.</h2>
    <p id="p1">Bienvenue à vous <?php echo "pseudo" ; ?> sur <bold>Liavart</bold>, votre marché virtuel du travail.</p>
    <p id="p2">Afin de finaliser votre inscription et commencer à béneficier des differents services, cliquez sur le lien ci dessous !</p>
    <p id="p3"><a href="inscription3.php">Finaliser mon inscription</a></p>
    <p id="p4"><a href="montwitter" target="_blank">Twitter.</a><a href="monFacebook" target="_blank"> Facebook</a></p>
    </div>
</body>
</html>