<?php

// Trim text for potential injection
class ProcessText
{

    public static function sanitize($input)
    {
        $input = trim($input);
        $input = htmlspecialchars($input);
        $input = stripslashes($input);
        return $input;
    }
}
