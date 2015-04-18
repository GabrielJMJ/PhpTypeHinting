<?php
/**
 * @author Gabriel Jacinto aka. GabrielJMJ <gamjj74@hotmail.com
 * @license MIT License
 */

function typeHintingErrorHandler($error_level, $error_message)
{
    if ($error_level !== E_RECOVERABLE_ERROR) {
        return false;
    }

    $regexp = '/^Argument ([0-9]) passed to ([a-zA-Z0-9._]+)\\(\\) must be an instance of ([a-zA-Z]+), ([a-zA-Z]+) given/';
    $match = preg_match($regexp, func_get_args()[1], $matches);

    if (!$match) {
        return false;
    }

    $error = [];

    list(,
        $error['argument_number'], 
        $error['function'], 
        $error['type'], 
        $error['passed_type']
    ) = $matches;

    $error['type'] = class_exists($error['type']) ? 'an instance of ' . $error['type'] : $error['type'];

    if ($error['type'] !== $error['passed_type']) {
        throw new InvalidArgumentException('Argument ' . $error['argument_number'] . ' passed to ' . $error['function'] . '() must be ' . $error['type'] . ' type, ' . $error['passed_type'] . ' given', $error_level);
    }

    return true;
}

set_error_handler('typeHintingErrorHandler');