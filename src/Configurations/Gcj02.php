<?php

namespace MagpieLib\GeoLoc\Configurations;

use Magpie\General\Factories\Annotations\NamedString;

/**
 * GCJ-02, Topographic map non-linear confidentiality algorithm used in China
 * (国测局-02)
 */
class Gcj02 extends CoordinateSys
{
    /**
     * Current code
     */
    #[NamedString]
    public const CODE = 'gcj02';


    /**
     * @inheritDoc
     */
    protected static function getCode() : string
    {
        return static::CODE;
    }
}