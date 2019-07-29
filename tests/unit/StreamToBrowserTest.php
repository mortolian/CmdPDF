<?php

use CmdPDF\StreamToBrowser;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Error\Error;

class StreamToBrowserTest extends TestCase
{
    /**
     * @test
     */
    public function test_object_creation_bad_file_path()
    {
        $file_path = './test.pdf';
        $file_name = 'browserfile.pdf';

        $this->expectException('Error');

        new StreamToBrowser($file_path,$file_name);
    }

    /**
     * @test
     */
    public function test_object_creation_no_file_name()
    {
        $file_path = './test.pdf';

        $this->expectException('Error');

        new StreamToBrowser($file_path);
    }
}