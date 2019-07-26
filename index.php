<?php
/**
 * CmdPDF Example
 */

require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload

use CmdPDF\Wkhtmltopdf;

$pdf1 = new Wkhtmltopdf();
$pdf1->setFileName('test.pdf');
$pdf1->url2pdf('http://www.google.com');

$test_html = file_get_contents('https://google.com');

$pdf2 = new Wkhtmltopdf();
$pdf2->setFileName('test2.pdf');
$pdf2->htmlString2pdf($test_html);