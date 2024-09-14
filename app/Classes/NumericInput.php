<?php

namespace App\Classes;

class NumericInput extends TextInput
{
    /**
     * Removing text input then append.
     *
     * @param [type] $text
     * @return void
     */
    public function add($text)
    {
        // Removing non-numeric values.
        $trimmedText = preg_replace('/\D/', '', $text);

        // Append input here
        $this->output .= $trimmedText;
    }
}
