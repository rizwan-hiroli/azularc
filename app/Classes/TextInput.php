<?php

namespace App\Classes;

class TextInput
{
    /**
     * output value.
     *
     * @var string
     */
    protected $output = '';

    /**
     * Function to append text.
     *
     * @param [type] $text
     * @return void
     */
    public function add($textInput)
    {
        $this->output .= $textInput;
    }

    /**
     * getting the final output.
     *
     * @return void
     */
    public function getValue()
    {
        return $this->output;
    }
}
