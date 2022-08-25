<?php session_start(); 
include("languageDefinition.php");
include("dictionnaireInscription3.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta lang="<?php echo $lang; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="height=device-height, initial-scale=1.0">
    <title><?php echo $logo_image_de_profil[$lang]; ?></title>
    <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
</head>
<body>
 
  <?php
    if(isset($_FILES['photoDeProfil']) AND $_FILES['photoDeProfil']['error']==0){
        if($_FILES['photoDeProfil']['size']<=2097152){
            $infosImage=pathinfo($_FILES['photoDeProfil']['name']);
            $extensionImage=$infosImage['extension'];
            $extensionsAutorisees=array('jpg', 'jpeg', 'png', 'gif');
            if(in_array($extensionImage,$extensionsAutorisees)){
                $_SESSION['photoDeProfil']=$_SESSION['userName'];
                move_uploaded_file($_FILES['photoDeProfil']['tmp_name'],'photos/profils/'.$_SESSION['photoDeProfil']);
            }
            else{
                 ?><script type="text/javascript">alert("<?php echo $le_type_de_fichier[$lang]; ?>");</script><?php
            }
        }
        else{
            ?><script type="text/javascript">alert("<?php echo $la_taille_de_votre[$lang]; ?>");</script><?php
        }
        
    }
    else{
        $_SESSION['photoDeProfil']='sansProfil';
    }
    ?>
    
   <header><?php include('header.php') ?></header>
   <a href="inscription.php"><img src="photos/Fleche.png" id="fleche"> <?php echo $retour[$lang]; ?></a>
   <h1><?php echo $logo_image_de_profil[$lang]; ?></h1>
    <form method="post" action="inscription3.php" enctype="multipart/form-data" id="form">
        <img id="profil" src="photos/profils/<?php echo $_SESSION['photoDeProfil'];?>" alt="<?php echo $inserer_si_vous_en[$lang]; ?>"><br>
        <input type=file name="photoDeProfil" id="photoDeProfil" accept="image/jpeg, image/png, image/gif"><br>
        <input type="submit" value="<?php echo $verification_de_l_image[$lang]; ?>">
    <p id="soumission"><a href="soumission.php"><span><?php echo $valider[$lang]; ?></span></a></p>
    </form>
    <footer><?php include ('footer.php') ?></footer>
    
<style type="text/css">
    h1,#form{
        text-align: center;
    }
    h1{
        font-size: 220%;
    }
    #form{
        border: solid;
        padding: 2em;
        line-height: 2em;
        font-size: 130%;
        margin-left: 25%;
        margin-right: 25%;
        margin-bottom: 5em;
        margin-top: 3em;
        min-width: 19em;
    }
    #profil{
        width: 20em;
        height: 18em;
    }
    @media all and (max-width:933px){
        #form{
            margin-left: 15%;
            margin-right: 15%;
        }
        @media all and (max-width:722px){
            #form{
                margin-left: 8%;
                margin-right: 8%;
            }
            @media all and (max-width:602px){
                #form{
                    margin-left: 4%;
                    margin-right: 4%;
                    min-width: 14em;
                }
                #profil{
                    width: 15em;
                    height: 13em;
                }
                @media all and (max-width:428px){
                    #form{
                        margin-left: 3%;
                        margin-right: 3%;
                        min-width: 7em;
                        padding-left: 1em;
                        padding-right: 1em;
                    }
                    #profil{
                        width: 12em;
                        height: 10em;
                    }
                }
            }
        }
    }
    #fleche{
        width: 2em;
        margin-left: 1em;
    }
    #soumission a{
        text-decoration: none;
    }
    #soumission span{
        display: inline-block;
        border: solid darkgray;
        border-radius: 4em;
        border-width: 2px;
        background-color: gainsboro;
        padding-left: 1em;
        padding-right: 1em;
        transition: transform 400ms;
    }
    #soumission span:hover{
        transform: scale(1.2);
    }
</style>
</body>
</html>