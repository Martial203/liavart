<?php
if(isset($_SESSION['dash']) AND $_SESSION['dash']=="auth"){
if(isset($_POST['message']) AND isset($_POST['receivers']) AND isset($_POST['subject'])){
    
    try{
        $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
    catch(Exception $e){
        die ('Erreur : '.$e->getMessage());
    }
    
    $subject=$_POST['subject'];
    $contenu=$_POST['message'];
    $headers="From: Liavart <liavart21@gmail.com>\n";
    $headers.="MIME-Version: 1.0\n";
    $headers.="Content-type: text/html; charset=utf-8\n";
    $headers.="Content-transfer-Encoding: 8bit";
    $compteurSucces=0;
    $compteurFail=0;
    
    $reqReceivers = $bdd->prepare('SELECT * FROM inscrits WHERE lang=? AND bloque!="YES"');
    $reqReceivers->execute(array($_POST['receivers']));
    
    while($repReceivers = $reqReceivers->fetch()){
        if(mail($repReceivers['adresse_mail'], $subject, $contenu, $headers)){
            $compteurSucces++;
        }
        else{
            $compteurFail++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mail aux inscrits</title>
</head>
<body>
    <form method="post" action="#">
        <label for="receivers">Destinataires : </label><select name="receivers" id="receivers" required>
            <option value="fr">All Fr</option>
            <option value="en">All En</option>
            <option value="zh-Hant">All Zh-Hant</option>
            <option value="de">All De</option>
            <option value="ja">All Ja</option>
            <option value="hi">All Hi</option>
            <option value="bn">All Bn</option>
            <option value="pt">All Pt</option>
            <option value="ru">All Ru</option>
            <option value="es">All Es</option>
            <option value="ar">All Ar</option>
        </select><br><br>
        <label for="subject">Subject : </label><input type="text" name="subject" id="subject" required><br><br>
        <label for="message">Contenu : </label><textarea name="message" id="message" required></textarea><br><br><br>
        <input type="submit" value="Envoyer"> <input type="reset" value="Réinitialiser">
    </form>
    
<?php
    if(isset($compteurSucces) AND isset($compteurFail)){
        ?>
        <script type="text/javascript"> alert('Nombre total de mails envoyés : <?php echo $compteurSucces+$compteurFail; ?>;  \n Nombre d\'envois réussis : <?php echo $compteurSucces; ?>;  \n Nombre d\'envois échoués : <?php echo $compteurFail; ?>;'); </script>
        
        <?php
    }
?>
</body>
</html>
<?php
}
?>