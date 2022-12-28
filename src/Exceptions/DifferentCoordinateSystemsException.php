<?php

namespace MagpieLib\GeoLoc\Exceptions;

use Magpie\Exceptions\SafetyCommonException;
use Throwable;

/**
 * Exceptions due to different coordinate systems
 */
class DifferentCoordinateSystemsException extends SafetyCommonException
{
    /**
     * Constructor
     * @param string|null $message
     * @param Throwable|null $previous
     */
    public function __construct(?string $message = null, ?Throwable $previous = null)
    {
        $message = $message ?? _l('Different coordinate systems');

        parent::__construct($message, $previous);
    }
}