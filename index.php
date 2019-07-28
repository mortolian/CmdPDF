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
