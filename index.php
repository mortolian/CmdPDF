<?php
/**
 * CmdPDF Example
 */

require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload

use CmdPDF\Wkhtmltopdf;
use CmdPDF\StreamToBrowser;

// Test 1
//$pdf1 = new Wkhtmltopdf();
//$pdf1->setFileName('string.pdf');
//$pdf1->htmlString2pdf('<h1>This is a test</h1>');

// Test 2
$pdf2 = new Wkhtmltopdf();
$pdf2->setFileName('phpnet.pdf');
$pdf2->url2pdf('https://www.php.net/manual/en/doc.changelog.php');

$stream = new StreamToBrowser(__DIR__. '/cache/'. 'phpnet.pdf', 'phpnet.pdf');
$stream->stream($stream::INLINE);