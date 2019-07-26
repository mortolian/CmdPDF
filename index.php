<?php
/**
 * cmdPDF Example
 */

include_once 'src/wkhtmltopdf.php';

$pdf = new cmdPDF\Wkhtmltopdf();
$pdf->setFileName('test.pdf');
$pdf->url2pdf('http://www.google.com');