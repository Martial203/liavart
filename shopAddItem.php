<?php 
if(isset($_SESSION['dash']) AND $_SESSION['dash']=="auth"){
if(isset($_GET['rubrique']) AND $_GET['rubrique']=="nouvelArticle"){ ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="height=device-height, initial-scale=1.0">
        <title>Ajouter un nouvel article sur le shop</title>
    </head>
    <body>
        <form method="post" action="shopItemBack.php?wtd=add">
            <label for="nomItem">Nom de l'article : </label>
            <input type="text" name="nomItem" id="nomItem" required><br>
            <label for="categArticle">Catégorie : </label>
            <select name="categArticle" id="categArticle" required>
                <option value="Ménager">Ménager</option>
                <option value="Livres">Livre</option>
                <option value="High-tech">High-tech</option>
                <option value="Informatique">Informatique</option>
                <option value="Vêtements et mode">Vêtements et mode</option>
                <option value="Logiciel">Logiciel</option>
                <option value="Autres">Autres</option>
            </select><br>
            <label for="langueContenu">Langue du contenu : </label>
            <select name="langueContenu" id="langueContenu" required>
                <option value="fr">Fr</option>
                <option value="en">En</option>
                <option value="zh-Hant">Zh-Hant</option>
                <option value="de">De</option>
                <option value="ja">Ja</option>
                <option value="hi">Hi</option>
                <option value="bn">Bn</option>
                <option value="pt">Pt</option>
                <option value="ru">Ru</option>
                <option value="es">Es</option>
                <option value="ar">Ar</option>
            </select><br>
            <label for="contenuAnnonce">Contenu : </label>
            <textarea name="contenuAnnonce" id="contenuAnnonce" required></textarea><br>
            <label for="link">Lien : </label><input type="text" name="link" id="link"><br><br>
            <input type="submit" value="Soumettre">
            <input type="reset" value="Réinitialiser">
        </form>
    </body>
    
</html>
    
<?php 
}
    elseif(isset($_GET['rubrique']) AND $_GET['rubrique']=="suppArticle"){ ?> 
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Supprimer un article du shop</title>
    </head>
    <body>
        <form method="post" action="#">
            <label for="nomArticle">Nom de l'article à supprimer : </label>
            <input type="text" name="nomArticle" id="nomArticle" required><br><br>
            <input type="submit" value="Valider">
            <input type="reset" value="Réinitialiser">
        </form>
    </body>
    </html>
    <?php
        if(isset($_POST['nomArticle'])){
            try{
                $bdd = new PDO('mysql:host=localhost; dbname=liavart; charset=utf8','root','');
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           }
            catch(Exception $e){
                die ('Erreur : '.$e->getMessage());
            }
            
            $req = $bdd->prepare("SELECT * FROM lishop WHERE nom_article LIKE ?");
            $req->execute(array('%'.$_POST['nomArticle'].'%'));
            while($donnees = $req->fetch()){
                ?>
                <div class="content"><?php echo $donnees['contenu']; ?></div>
                <div><a href="shopItemBack.php?wtd=sup&amp;no=<?php echo $donnees['ID']; ?>">Supprimer du shop</a></div>
                <?php   
            }
        }
    }
}
    ?>