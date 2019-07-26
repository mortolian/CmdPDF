<?php

include_once 'src/cmdpdf.class.php';

$title = "TAX_SOMETYHING.pdf";

$mpdf = new cmdPDF();
$mpdf->setFileName($title);
$mpdf->setOptions([
    '--collate',
    '--page-size A4'
]);
$mpdf->url2pdf('https://discover.sabinet.co.za/webx/access/netlaw/28_2011_tax_administration_act.htm');