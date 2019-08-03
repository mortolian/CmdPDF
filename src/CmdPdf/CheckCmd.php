<?php

namespace CmdPdf;

/**
 * Class CheckCmd
 *
 * This is a very simple class that will concern itself with checking if a specific command exists
 * on the operating system.
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
     * CheckCmd constructor.
     * @param String $shell_command
     * @throws \Exception
     */
    public function __construct(String $shell_command)
    {
        // check that the class was constructed with the shell command which should be checked.
        if (!empty($shell_command)) {
            $this->shell_command = $shell_command;
        } else {
            throw new \Exception("No command specified to check.");
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function check()
    {
        $check = shell_exec(sprintf('which %s 2>/dev/null', escapeshellcmd($this->shell_command)));

        if (!empty($check)) {
            return true;
        }

        throw new \Exception(sprintf("The %s command does not exist on this operating system. You will have to install it or add it to your PATHS.", $this->shell_command));
    }
}