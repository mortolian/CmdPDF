<?php
/**
 * CmdPDF Example
 */

require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload

// Test 1
$pdf1 = new \CmdPDF\Wkhtmltopdf();
$pdf1->setFileName('google.pdf');
$pdf1->url2pdf('https://www.google.com');
