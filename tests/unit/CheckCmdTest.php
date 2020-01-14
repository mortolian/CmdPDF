<?php

namespace CmdPdfTest;

use CmdPdf\CheckCmd;
use PHPUnit\Framework\TestCase;

class CheckCmdTest extends TestCase
{
    /**
     * @test
     */
    public function check_a_shell_command()
    {
        $chk_cmd = new CheckCmd('php');
        $this->assertTrue($chk_cmd->check());
    }
}