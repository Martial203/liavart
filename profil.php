<?php
if(isset($_GET['todo'])){
include("languageDefinition.php");
include("dictionnaireAfficherContenus.php");
include("dictionnaireProfil.php");
include("dictionnaireInscription.php");
include("dictionnaireModifPassword.php");
    if($_GET['todo']=='profil'){
        if(isset($_FILES['modifProfil']) AND $_FILES['modifProfil']['error']==0){
            if($_FILES['modifProfil']['size']<=2097152){
                $infosImage=pathinfo($_FILES['modifProfil']['name']);
                $extensionImage=$infosImage['extension'];
                $extensionsAutorisees=array('jpg', 'jpeg', 'png', 'gif');
                if(in_array($extensionImage, $extensionsAutorisees)){
                    $_SESSION['avatar']=$_SESSION['user'];
                    move_uploaded_file($_FILES['modifProfil']['tmp_name'], 'photos/profils/'.$_SESSION['avatar']);
                }
                else{
                    ?><script type="text/javascript">alert("<?php echo $le_type_de_fichier_ne[$lang]; ?>");</script><?php
                }
            }
            else{
                ?><script type="text/javascript">alert("<?php echo $la_taille_de_votre_fichier[$lang]; ?>");</script> <?php
            }
            
        }
        ?><h2 id="modifierprofil_intro"><?php echo $logo_image_de_profil[$lang]; ?></h2>
            <form method="post" action="contenus.php?rubrique=parametres&amp;todo=profil" enctype="multipart/form-data">
                <img src="photos/profils/<?php echo $_SESSION['avatar'] ;?>"><br><br>
                <input type="file" name="modifProfil" id="modifProfil" accept="image/jpeg, image/png, image/gif"><br><br>
                <input type="submit" value="<?php echo $appliquer_le_changement[$lang]; ?>">
                <p id="modifSoumission"><a href=contenus.php?rubrique=parametres&amp;ok=prof><?php echo $terminer[$lang]; ?></a></p>
            </form>
            
            
        <?php
    }
    elseif($_GET['todo']=='password'){
        
        if(isset($_POST['nouveauPass']) AND isset($_POST['actuelPass']) AND isset($_POST['confirmPass'])){
            if (password_verify($_POST['actuelPass'], $_SESSION['mot_de_passe'])){
                if($_POST['nouveauPass']==$_POST['confirmPass']){
                    $_SESSION['mot_de_passe']=password_hash($_POST['nouveauPass'], PASSWORD_DEFAULT);
                
                $req = $bdd -> prepare('UPDATE inscrits SET mot_de_passe=? WHERE nom_utilisateur=?');
                $req -> execute(array($_SESSION['mot_de_passe'], $_SESSION['user']));
                    $_SESSION['passMessage']=$veuillez_fournir_les_informations[$lang];
                    ?>
                    <?php
                        header('location:contenus.php?rubrique=parametres&rslt=password');
                    }
                else{
                    $_SESSION['passMessage']=$la_confirmation_du_nouveau[$lang];
                }
           }
            else{
                echo "2'";
                $_SESSION['passMessage']=$mot_de_passe_incorrect[$lang];
            }
            
        }
        else{
            $_SESSION['passMessage']=$veuillez_fournir_les_informations[$lang];
        }
        
        
        ?>
            <h2 id='passwordTitre'><?php echo $modifyMyPassword[$lang]; ?></h2>
            <p id='passwordIntro'><?php echo $_SESSION['passMessage'] ;?></p>
            <form id="passwordForm" method="post" action="contenus.php?rubrique=parametres&amp;todo=password"><table>
                <tr><td class="colM1" ><label for='actuelPass'><?php echo $currentPassword[$lang]; ?>:</label></td><td class="colM2"><input type='password' id='actuelPass' name='actuelPass' required></td></tr>
                <tr><td class="colM1" ><label for='nouveauPass'><?php echo $newPassword[$lang]; ?>:</label></td><td class="colM2"><input type='password' id='nouveauPass' name='nouveauPass' minlength="5" required maxlength="30"></td></tr>
                <tr><td class="colM1" ><label for='confirmPass'><?php echo $newPasswordConfirm[$lang]; ?>:</label></td><td class="colM2"><input type='password' id='confirmPass' name='confirmPass' minlength="5" maxlength="30" required></td></tr>
                <tr><td class="colM1" colspan="2" id="tdSubmit"><input type="submit" value='<?php echo $valider[$lang]; ?>' id='passwordModifValid'></td></tr>
                </table>
            </form>
        <?php
    }
    
elseif($_GET['todo']=='rest'){
    $_SESSION['rest_noms']=$_SESSION['noms'];
    $_SESSION['rest_prenoms']=$_SESSION['prenoms'];
    $_SESSION['rest_sexe']=$_SESSION['sexe'];
    $_SESSION['rest_pays_de_residence']=$_SESSION['pays_de_residence'];
    $_SESSION['rest_ville_de_residence']=$_SESSION['ville_de_residence'];
    $_SESSION['rest_adresse_mail']=$_SESSION['adresse_mail'];
    $_SESSION['rest_user']=$_SESSION['user'];
    $_SESSION['rest_description_du_profil']=$_SESSION['description_du_profil'];
    $_SESSION['rest_site_entreprise']=$_SESSION['site_entreprise'];
    $_SESSION['rest_pages_entreprises']=$_SESSION['pages_entreprises'];
    
    ?>
    <h2 id="restH2"><?php echo $modifier_mes_informations[$lang]; ?></h2>
    <p id="restIntro"><?php echo $vous_pouvez_ici[$lang]; ?></p>
<form method="post" action="contenus.php?rubrique=parametres&amp;ok=rest">
    <table>
        <tr><td class="restCol1"><label for="nom"><?php echo $noms[$lang]; ?></label></td><td><input class="input" required type="text" name="noms" value="<?php echo $_SESSION['rest_noms'] ;?>"></td></tr>
        <tr><td class="restCol1"><label for="prenom"><?php echo $prenoms[$lang]; ?> </label></td><td><input class="input" required type="text" name="prenoms" value="<?php echo $_SESSION['rest_prenoms'] ;?>"></td></tr>
        <tr><td class="restCol1"><label for="sexe"><?php echo $sexe[$lang]; ?></label></td> <td><?php echo $m[$lang]; ?><input type="radio" name="sexe" value="masculin" <?php if($_SESSION['rest_sexe']=="masculin"){echo 'checked';}?>><?php echo $f[$lang]; ?><input type="radio" name="sexe" <?php if($_SESSION['rest_sexe']=="feminin"){echo 'checked';}?>></td></tr>
        <tr><td class="restCol1"><label for="paysDeResidence"><?php echo $pays_de_residence[$lang]; ?></label></td><td>
        <select class="input" required name="paysDeResidence" value="<?php echo $_SESSION['rest_pays_de_residence'] ;?>">
            <option></option>
            <?php
                            switch($lang){
                                case "fr":
                                    include("listeDesPaysFr.html");
                            break;
                                case "en":
                                    include("listeDesPaysEn.html");
                            break;
                                case "zh-Hant":
                                    include("listeDesPaysZr.html");
                            break;
                                case "ja":
                                    include("listeDesPaysJa.html");
                            break;
                                case "de":
                                    include("listeDesPaysDe.html");
                            break;
                                case "es":
                                    include("listeDesPaysEs.html");
                            break;
                                case "pt":
                                    include("listeDesPaysPt.html");
                            break;
                                case "ru":
                                    include("listeDesPaysRu.html");
                            break;
                                case "hi":
                                    include("listeDesPaysHi.html");
                            break;
                                case "bn":
                                    include("listeDesPaysBn.html");
                            break;
                                default:
                                    include("listeDesPaysEn.html");
                            }
                        ?>
        </select></td></tr>
        <tr><td class="restCol1"><label for="villeDeResidence"><?php echo $ville_de_residence[$lang]; ?></label></td><td><input class="input" type="text" name="villeDeResidence" value="<?php echo $_SESSION['rest_ville_de_residence'] ;?>"></td></tr>
        <tr><td class="restCol1"><label for="adresseMail"><?php echo $adresse_mail[$lang]; ?></label></td><td><input class="input" type="email" required name="adresseMail" pattern="^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$" value="<?php echo $_SESSION['rest_adresse_mail'] ;?>"></td></tr>
        <tr><td class="restCol1"><label for="userName"><?php echo $nom_utilisateur[$lang]; ?></label></td><td><input class="input" type="text" required name="userName" value="<?php echo $_SESSION['rest_user'] ;?>"></td></tr>
        <tr title="<?php echo $entrer_le_mot_de_passe_pour[$lang]; ?>"><td class="restCol1"><label for="password"><?php echo $mot_de_passe[$lang]; ?></label></td><td><input class="input" type="password" required name="password" placeholder="<?php echo $entrer_le_mot_de_passe_pour[$lang]; ?>"></td></tr>
        <tr><td class="restCol1" colspan="2"><label for="description">Description de votre profil : </label> <br><textarea name="description" id="description" placeholder="<?php echo $description_qui_paraitra[$lang]; ?>"><?php echo $_SESSION['rest_description_du_profil'] ;?></textarea></td></tr>
        <tr><td class="restCol1"><label for="siteInternet"><?php echo $site_internet[$lang]; ?></label></td><td><input type="text" placeholder="www.exemple.com" title="www.exemple.com" pattern="^w{3}\.[a-z0-9][a-z0-9\.\-]{1,}[a-z0-9]\.[a-z]{2,6}" name="siteInternet" id="siteInternet" value="<?php echo $_SESSION['rest_site_entreprise'] ;?>"></td></tr>
        <tr><td class="restCol1"><label for="pagesEntreprises"><?php echo $pages_de_l_entreprise[$lang]; ?></label></td><td><textarea name="pagesEntreprises" id="pagesEntreprises"><?php echo $_SESSION['rest_pages_entreprises'] ;?></textarea></td></tr>
    </table>
    <p id="restSubmitP"><input type="submit" value="<?php echo $valider[$lang]; ?>"></p>
    
</form>
    
    <?php
}
}
?>