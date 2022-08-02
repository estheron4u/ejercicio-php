<?php

class TerminalReader
{
    /**
     * @param string $prompt
     * @return string
     */ //TODO PHPDoc is redundant
    public function readTerminal(string $prompt = ''): string
    {
        echo $prompt;
        return preg_replace("/\n/", "", fgets(STDIN));
    }
}
