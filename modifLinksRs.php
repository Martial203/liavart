<?php
if(isset($_SESSION['dash']) AND $_SESSION['dash']=="auth"){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Liens réseaux sociaux</title>
    </head>
    <body>
        <form method="post" action="#">
            <label for="reseau">Réseau social : </label>
            <select name="reseau" id="reseau" required>
                <option value="facebook">Facebook</option>
                <option value="twitter">Twitter</option>
                <option value="telegram">Telegram</option>
                <option value="instagram">Instagram</option>
                <option value="whatsapp">Whatsapp</option>
            </select><br>
            <label for="langue">langue : </label>
            <select name="langue" id="langue" required>
                <option value="fr">Francais</option>
                <option value="en">Anglais</option>
                <option value="zh-Hant">Chinois</option>
                <option value="de">Allemand</option>
                <option value="ja">Japonais</option>
                <option value="hi">Hindi</option>
                <option value="bn">Bengali</option>
                <option value="pt">Portugais</option>
                <option value="ru">Russe</option>
                <option value="es">Espagnol</option>
                <option value="ar">Arabe</option>
            </select><br>
            <label for="lien">Lien : </label> <input type="text" name="lien" id="lien" required><br>
            <input type="submit" value="soumettre">
        </form>
        
        <?php
            if(isset($_POST['reseau']) AND isset($_POST['langue']) AND isset($_POST['lien'])){
                try{
                    $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                   }
                catch(Exception $e){
                    die ('Erreur : '.$e->getMessage());
                }

                $reqLink = $bdd->prepare("UPDATE links_rs SET :langue=:lien WHERE reseau=:reseau");
                $reqLink->execute(array(
                    "langue"=>$_POST['langue'],
                    "lien"=>$_POST['lien'],
                    "reseau"=>$_POST['reseau']
                ));
        ?>
        <script type="text/javascript">alert("Mise à jour effectuée avec succès !");</script>
        <?php
        }
    ?>
    </body>
    </html>
    <?php
}
?>