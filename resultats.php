<?php
if(isset($_GET['rslt'])){
include("languageDefinition.php");
include("dictionnaireResultats.php");
    switch ($_GET['rslt']){
        case "profil":
            $message=$votre_logo_image_de[$lang];
            break;
        case "password":
            $message=$votre_mot_de_passe_a_ete[$lang];
            break;
        case "rest":
            $message=$vos_informations_ont_ete[$lang];
            break;
        case "sup":
            $message=$suppression[$lang];
            break;
        default:
    }
?>
<script type="text/javascript">alert("<?php echo $message; ?>");</script>
<?php
}