<?php

namespace CmdPdfTest;

use CmdPdf\Wkhtmltopdf;
use PHPUnit\Framework\TestCase;

class WkhtmltopdfTest extends TestCase
{
    /**
     * @test
     */
    public function testConstructor()
    {
        $pdf = new Wkhtmltopdf('https://www.google.com');
        $this->assertInstanceOf(Wkhtmltopdf::class, $pdf);
    }

    /**
     * @test
     */
    public function testSetAndGetOptions() {
        $pdf = new Wkhtmltopdf('https://www.google.com');
        $pdf->setOptions(array('--footer-right "Page [page] of [topage]"','--footer-left "Unit Test"'));
        $this->assertEquals('--footer-right "Page [page] of [topage]" --footer-left "Unit Test"', $pdf->getOptions());
    }
}