<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body>
   <?php
   
        echo '<form action="testReceptionImages.php" method="post" enctype="multipart/form-data">
        <input type="file" name="profil">
        <input type="submit">
        </form>';
        if (empty($_FILES['profil'])==false){
            $infos=pathinfo($_FILES['profil']['name']);
            $extension=$infos['extension'];
            $extensions_autorisees=array('jpg','jpeg','png','gif');
            if(in_array($extension,$extensions_autorisees)){
                move_uploaded_file($_FILES['profil']['tmp_name'],'photos/maPhoto');
                ?> <img src="photos/maPhoto" alt="oups !">
                <?php
            }
            else{
                echo 'Mauvaise extension';
            }
        }
    ?>
</body>
</html>