<?php

namespace MagpieLib\GeoLoc\Configurations;

use Magpie\General\Traits\StaticClass;
use MagpieLib\GeoLoc\Objects\LatLon6;

/**
 * Base to describe coordinate system
 */
abstract class CoordinateSys
{
    use StaticClass;


    /**
     * Create a geolocation expressed in current given coordinate system
     * @param int $lat6
     * @param int $lon6
     * @return LatLon6
     */
    public static function createLatLon6(int $lat6, int $lon6) : LatLon6
    {
        return new LatLon6($lat6, $lon6, static::getCode());
    }


    /**
     * Current associated code
     * @return string
     */
    protected static abstract function getCode() : string;
}