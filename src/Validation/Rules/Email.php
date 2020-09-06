<?php

namespace Bow\Validation\Rules;

use Bow\Support\Str;

trait Email
{
    /**
     * Compile Email Rule
     *
     * [email] Check that the content of the field is an email
     *
     * @param string $key
     * @param string $masque
     * @return array
     */
    protected function compileEmail($key, $masque)
    {
        if (!preg_match("/^email$/", $masque, $match)) {
            return;
        }

        if (Str::isMail($this->inputs[$key])) {
            return;
        }

        $this->last_message = $this->lexical('email', $key);

        $this->fails = true;

        return [
            "masque" => $masque,
            "message" => $this->last_message
        ];
    }

}
