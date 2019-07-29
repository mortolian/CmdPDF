<?php

use CmdPDF\Wkhtmltopdf;
use PHPUnit\Framework\TestCase;

class WkhtmltopdfTest extends TestCase
{
    /** @test */
    public function test_delete_temp_files()
    {
        $file_path = './test.pdf';
        $cache_path = __dir__ . '/../../cache/';

        $pdf = new Wkhtmltopdf();
        $pdf->setFilePath($file_path);
        $pdf->htmlString2pdf('<h1>Created by UNIT Test</h1>');
        unset($pdf);
        unlink($file_path);

        // check if any html files are left in the cache dir
        $files = scandir($cache_path);

        $count = 0;

        foreach($files as $file) {
            if(strpos($file, '.html')) {
                $count++;
            }
        }

        $this->assertTrue($count == 0);
    }
}