<?php
/**
 * CmdPDF Example
 */

require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload

use CmdPDF\Wkhtmltopdf;

// Test 1
$pdf1 = new Wkhtmltopdf();
$pdf1->setFileName('google.pdf');
$pdf1->url2pdf('https://www.google.com');

// Test 2
// $test_html = "<h1>Some test HTML</h1>";
// $pdf2 = new Wkhtmltopdf();
// $pdf2->setFileName('test2.pdf');
// $pdf2->htmlString2pdf($test_html);