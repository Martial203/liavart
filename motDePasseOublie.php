<?php
session_start();

if(isset($_SESSION['code']) AND isset($_SESSION['mailOublie'])){
include("languageDefinition.php");
include("dictionnaireMotDePasseOublie.php");

if(isset($_POST['code'])==false OR isset($_GET['rs'])==true){
    $contenu=$code_d_identification_L[$lang].' '.$_SESSION['code'];
    $headers="From: Liavart <liavart21@gmail.com>\n";
    $headers="MIME-Version: 1.0\n";
    $headers.="Content-type: text/html; charset=utf-8\n";
    $headers.="Content-transfer-Encoding: 8bit";
    mail($_SESSION['mailOublie'], $confirmation_identite[$lang], $contenu, $headers);
}
if(isset($_POST['code'])){
    if($_POST['code']==$_SESSION['code']){
        header('location: nouveauMotDePasse.php');
    }
    else{
        ?>
        <script type="text/javascript">alert("<?php echo $le_code_que_vous[$lang]; ?>");</script>
        <?php
    }
}
?>
   
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta lang="<?php echo $lang; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="height=device-height, initial-scale=1.0">
        <title><?php echo $verification_compte[$lang]; ?></title>
        <link rel="stylesheet" href="motDePasseOublie.css">
        <link rel="icon" href="photos/iconeLiavart.png" type="image/x-icon">
    </head>
    <body>
        <header><?php include("header.php") ?></header>
        <div><h1><div id="h1"><?php echo $mot_de_passe_oublie[$lang]; ?></div></h1></div>
       <p><?php echo $vous_recevrez_dans[$lang]; ?></p>
       <form method="post" action="motDePasseOublie.php">
            <input id="input1" type="number" name="code" placeholder="******" required><br>
            <a href="nouveauMotDePasse.php"><input id="submit" type="submit" value="<?php echo $valider[$lang]; ?>"></a>
       </form>
       <p><?php echo $message_non_recu[$lang]; ?><a href="motDePasseOublie.php?rs=1"><?php echo $renvoyer_le_message[$lang]; ?></a></p><br>
        <footer><?php include("footer.php") ?></footer>
    </body>
    </html>
    <?php
}