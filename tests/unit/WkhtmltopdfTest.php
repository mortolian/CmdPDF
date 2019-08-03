<?php

namespace CmdPdfTest;

use CmdPdf\Wkhtmltopdf;
use PHPUnit\Framework\TestCase;

class WkhtmltopdfTest extends TestCase
{
    /**
     * @test
     */
    public function test_set_get_file_path()
    {
        $file_path = './test.pdf';
        $pdf = new Wkhtmltopdf();
        $pdf->setFilePath($file_path);
        $get_path = $pdf->getFilePath();

        $this->assertTrue($get_path == $file_path);
    }

    /**
     * @test
     */
    public function test_set_options()
    {
        $pdf = new Wkhtmltopdf();
        $pdf->setOptions(['-option1', '-option2']);
        $options_result = $pdf->getOptions();
        $this->assertTrue('-option1 -option2' == $options_result);
    }

    /**
     * @test
     */
    public function test_delete_temp_files()
    {
        $file_path = './test.pdf';
        $cache_path = __dir__ . '/../../cache/';

        $pdf = new Wkhtmltopdf();
        $pdf->setFilePath($file_path);
        $pdf->htmlString2pdf('<h1>Created by UNIT Test</h1>');
        unset($pdf);
        unlink($file_path);

        $files = scandir($cache_path);

        $count = 0;
        foreach ($files as $file) {
            if (strpos($file, '.html')) {
                $count++;
            }
        }

        $this->assertTrue($count == 0);
    }

    /**
     * @test
     */
    public function test_create_pdf_from_string()
    {
        $file_path = './test.pdf';

        $pdf = new Wkhtmltopdf();
        $pdf->setFilePath($file_path);
        $result = $pdf->htmlString2pdf('<h1>Created by UNIT Test</h1>');

        $this->assertTrue($result == 0);
        $this->assertTrue(file_exists($file_path));

        unset($pdf);
        unlink($file_path);
    }

    /**
     * @test
     */
    public function test_create_pdf_from_url()
    {
        $file_path = './test.pdf';
        $site_url = 'https://www.google.com';

        $pdf = new Wkhtmltopdf();
        $pdf->setFilePath($file_path);
        $result = $pdf->url2pdf($site_url);

        $this->assertTrue($result == 0);
        $this->assertTrue(file_exists($file_path));

        unset($pdf);
        unlink($file_path);
    }
}