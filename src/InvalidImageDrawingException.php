<?php

namespace Ochi51\SeparatorExcel;

use Exception;

/**
 * @author ochi51 <ochiai07@gmail.com>
 */
final class InvalidImageDrawingException extends Exception
{

    /**
     * InvalidImageDrawingException constructor.
     */
    public function __construct()
    {
        parent::__construct('The drawing is not images.');
    }
}
