<?php

use CmdPDF\CheckCmd;

class CheckCmdTest extends PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function check_a_shell_command()
    {
        $chk_cmd = new CheckCmd('ph');
        $this->assertTrue($chk_cmd->check());
    }
}