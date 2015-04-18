<?php
/**
 * Gabrieljmj\PhpTypeHinting
 *
 * @author Gabriel Jacinto aka. GabrielJMJ <gamjj74@hotmail.com>
 * @license MIT License
 */

namespace Gabrieljmj\PhpTypeHinting;

class TypeHinting
{
    /**
     * Regexp to indentify the parameters of the error message
     */
    const REGEXP = '/^Argument ([0-9]) passed to ([a-zA-Z0-9._]+)\\(\\) must be an instance of ([a-zA-Z._]+), ([a-zA-Z._]+) given/';

    /**
     * Initializes the type hinting handler
     */
    final public static function init()
    {
        set_error_handler(['\Gabrieljmj\PhpTypeHinting\TypeHinting', 'typeHintingErrorHandler']);
    }

    /**
     * The error handle to type hinting work
     *
     * @param integer $errno  Contains the level of the error raised
     * @param string  $errstr Contains the error message
     *
     * @throws \InvalidArgumentException
     *
     * @return boolean
     */
    public function typeHintingErrorHandler($errno, $errstr)
    {
        if ($errno !== E_RECOVERABLE_ERROR) {
            return false;
        }

        $match = preg_match(self::REGEXP, $errstr, $matches);

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

        if (class_exists($error['type'])) {
            return false;
        }

        if ($error['type'] !== $error['passed_type']) {
            throw new \InvalidArgumentException('Argument ' . $error['argument_number'] . ' passed to ' . $error['function'] . '() must be ' . $error['type'] . ' type, ' . $error['passed_type'] . ' given', $error_level);
        }

        return true;
    }
}