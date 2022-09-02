<?php

namespace SimpleCli;

class Printer
{
    /**
     * Print the message given
     * @param $message
     * @return void
     */
    public function out($message)
    {
        echo $message;
    }

    /**
     * Print end of line
     * @return void
     */
    public function newline()
    {
        $this->out("\n");
    }

    /**
     * Print the message given with spaces
     * @param $message
     * @return void
     */
    public function display($message)
    {
        $this->newline();
        $this->out($message);
        $this->newline();
        $this->newline();
    }
}