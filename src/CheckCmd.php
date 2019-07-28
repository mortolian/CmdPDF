<?php

namespace CmdPDF;

/**
 * Class CheckCmd
 *
 * This is a very simple class that will concern itself with checking if a specific command exists
 * on the opperating system.
 *
 * @todo
 * - L - Do we have to check that the command exists every time? Can we cache the result for a specific time?
 * - H - Can we check the version of a command?
 *
 * @package CmdPDF
 * @author Gideon Schoonbee <project@mortolio.com>
 * @version 0.1.0
 * @license MIT
 */

class CheckCmd
{
    private $shell_command;

    /**
     * CheckCMD constructor.
     * @param String $shell_command
     */
    public function __construct(String $shell_command)
    {
        // check that the class was constructed with the shell command which should be checked.
        if (!empty($shell_command)) {
            $this->shell_command;
        }
    }

    /**
     * @return bool
     */
    public function check()
    {
        if (empty($this->shell_command)) {
            return false;
        }

        $check = shell_exec('where ' . $this->shell_command);

        var_dump($check);

        if (!empty($check)) {
            return true;
        }

        return false;
    }
}
