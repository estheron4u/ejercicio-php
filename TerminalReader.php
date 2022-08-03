<?php

class TerminalReader
{
    public function readTerminal(string $prompt = ''): string
    {
        echo $prompt;
        return preg_replace("/\n/", "", fgets(STDIN));
    }
}
