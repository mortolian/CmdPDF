<?php
/**
 * CmdPDF Example
 */

require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload

use CmdPDF\Wkhtmltopdf;
use CmdPDF\StreamToBrowser;

$pdf_path = '/Users/gideon/Desktop/php.pdf';

// Test
$pdf2 = new Wkhtmltopdf();
$pdf2->setFilePath($pdf_path);
$pdf2->url2pdf('https://www.php.net/manual/en/doc.changelog.php');
die();
$stream = new StreamToBrowser($pdf_path, 'phpnet.pdf');
$stream->stream($stream::INLINE);