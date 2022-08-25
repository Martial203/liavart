<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    html2pdf
</body>
</html>
<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
$content=ob_get_clean();

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML($content);
$html2pdf->output("abc.pdf");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <a href="#" download>download</a>
    <script type="text/javascript">var a = document.querySelector("a");
    a.onmouseout;</script>
</body>
</html>