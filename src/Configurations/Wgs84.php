<?php

namespace MagpieLib\GeoLoc\Configurations;

use Magpie\General\Factories\Annotations\NamedString;

/**
 * WGS-84, World Geodetic System 1984
 */
class Wgs84 extends CoordinateSys
{
    /**
     * Current code
     */
    #[NamedString]
    public const CODE = 'wgs84';


    /**
     * @inheritDoc
     */
    protected static function getCode() : string
    {
        return static::CODE;
    }
}