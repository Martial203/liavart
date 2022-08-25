<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>html2pdf test</title>
</head>
<body>
    <p>Hello world !</p>
</body>
</html>
<?php
$content = ob_get_clean();
require_once('C:\wamp64\www\Code\moduleSup\html2pdf-master\src\html2pdf.php');
try{
    $html2pdf = new HTML2PDF("P","A4","fr");
    $html2pdf->setDefaultFont("Arial");
    $html2pdf->writeHTML($content);
    $html2pdf->Output("votrePdf.pdf");
}
catch(HTML2PDF_exception $e){
    echo $e;
    exit;
}
?>