<?php 
if(isset($_GET['page']) AND isset($lang) AND isset($donnees)){
?>
                <div id="header"><?php include("header.php") ?></div>
                <div id="nav"> <span class="navRetour"><a href="contenus.php?rubrique=<?php echo $rub; ?>&amp;pg=<?php echo $_GET['page']; ?>#<?php echo $_GET['nber']; ?>"> <img alt="<?php echo $donnees['auteur']; ?>" src="photos/Fleche.png"><?php echo $retour_aux_offres[$lang]; ?>.</a></span><span class="navSpan2Img"><a href="element.php?nber=<?php echo $_GET['nber']; ?>&amp;page=<?php echo $_GET['page']; ?>&amp;export=y"><img alt="Exporter en pdf" src="photos/iconeDownload.png" class="pdfExportIcon"></a></span></div>
                <div id="figure" id="figureProfil"><img src="photos/profils/<?php echo $donnees['avatar_auteur']; ?>"></div>
                <div id="main">
                    <h1 id="h12"><?php echo $donnees['titre_proposition']; ?></h1>
                    <p><?php echo $informations_sur_l_offre[$lang]; ?></p>
                    <form method="post" action="envoiProposition.php">
                        <fieldset id=fieldset1><legend><?php echo $infos_sur_nature_service[$lang]; ?></legend>
                          <label for="nomDuService"><?php echo $nom_poste[$lang]; ?></label><input type="text" name="nomDuService" id="poste" value="<?php echo $donnees['poste']; ?>" readonly><br>
                            <label for="champDactivite"><?php echo $champ_activite[$lang]; ?></label><input type="text" id="champ" value="<?php echo $donnees['champ']; ?>" readonly><br>
                            <label><?php echo $type_travail[$lang]; ?></label><span id="span"><span class="label"><?php echo $presentiel[$lang]; ?></span><input type="checkbox" <?php if(in_array($donnees['type_travail'],array("Présentiel","Présentiel et distant"))){echo "checked";}?> name="typeDeService_presentiel" value="presentiel" class="radio" readonly> <span id="virtuel"><span class="label"><?php echo $a_distance[$lang]; ?></span><input type="checkbox" <?php if(in_array($donnees['type_travail'],array("A distance","Présentiel et distant"))){echo "checked";}?> name="typeDeService_distance" class="radio" value="A distance" readonly></span></span><br>
                            <table id="tableAdditive" title="<?php echo $que_faites_vous_concretement[$lang]; ?>"><td><label for="missionsAAccomplir"><?php echo $missions[$lang]; ?></label></td><td id="col2"><textarea name="missionsAAccomplir" id="missionsAAccomplir" readonly><?php echo $donnees['missions']; ?></textarea></td></table>
                        </fieldset>
                         <fieldset><legend><?php echo $a_prop_de_moi[$lang]; ?></legend>
                           <table>
                            <tr title="<?php echo $qu_avez_vous_de_notable[$lang]; ?>"><td class="td21"><label for="monProfil"><?php echo $mon_profil[$lang]; ?></label></td><td class="td"><textarea name="monProfil" id="monProfil" readonly><?php echo $donnees['profil']; ?></textarea></td></tr>
                            <tr title="<?php echo $vos_competences_associees[$lang]; ?>"><td class="td21"><label for="mesCompetances"><?php echo $mes_competences[$lang]; ?></label></td><td class="td"><textarea name="mesCompetances" id="mesCompetances" readonly><?php echo $donnees['competences']; ?></textarea></td></tr>
                            </table>
                        </fieldset>
                        <fieldset><legend><?php echo $autres_inf[$lang]; ?></legend>
                            <table>
                                <tr title="<?php echo $a_quel_prix[$lang]; ?>"><td class="td41"><label for="prixDuService"><?php echo $prix_service[$lang]; ?></label></td><td class="td"><input type="number" name="prixDuService" class="input" id="salaire" readonly value="<?php echo $donnees['prix']; ?>"> <input type="text" id="monnaie" value="<?php echo $donnees['monnaie']; ?>" readonly></td></tr>
                                <tr title="<?php echo $adresse_mail[$lang]; ?>"><td class="td41"><label for="monContact"><?php echo $mon_contact[$lang]; ?></label></td><td class="td"><textarea id="monContact" name="monContact" readonly><?php echo $donnees['contact']; ?></textarea></td></tr>
                                <tr title="<?php echo $infos_sup[$lang]; ?>"><td class="td41"><label for="autresInformations"><?php echo $infos_sup[$lang]; ?></label></td><td class="td"><textarea name="autresInformations" readonly><?php echo $donnees['informations_supplementaires']; ?></textarea></td></tr>
                            </table>
                        </fieldset>
                        <fieldset id="lastFieldset">
                            <div id="auteur"><p><?php echo $auteur[$lang]; ?><?php echo $donnees['noms_auteur'].' '.$donnees['prenoms_auteur']; ?></p> <p><?php echo $donnees['description_auteur'];?></p></div>
                            <div id="contacterAuteur"> <a href="mailto:<?php echo $donnees['mail']; ?>" target='_blank'><?php echo $contacter_offreur[$lang]; ?></a></div>
                            <div id="suivreAuteur"><p><?php echo $site_internet_entreprise[$lang]; ?><a href="<?php echo $donnees2['site_entreprise'];?>" target='_blank'><?php echo $donnees2['site_entreprise'];?></a></p></div>
                        </fieldset>
                        <input type="hidden" name="hidden" value="P">
                        <p id="signaler"><a href="signaler.php?nber=<?php echo $_GET['nber'];?>"><?php echo $signaler_le_contenu[$lang]; ?></a></p>
                    </form>
                </div>
                <div id="footer"><?php include("footer.php") ?></div>
            <?php 
                    }
?>