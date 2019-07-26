<?php

include_once 'src/wkhtmltopdf.php';

$mpdf = new cmdPDF();
$mpdf->setFileName('test.pdf');
$mpdf->setOptions([
    '--collate',
    '--page-size A4'
]);
$mpdf->url2pdf('https://www.google.com');