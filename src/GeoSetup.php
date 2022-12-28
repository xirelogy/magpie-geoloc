<?php

namespace MagpieLib\GeoLoc;

use Magpie\General\Factories\NamedStringCodec;
use Magpie\General\Traits\StaticClass;
use Magpie\System\Concepts\SystemBootable;
use Magpie\System\Kernel\BootContext;
use Magpie\System\Kernel\BootRegistrar;

/**
 * Geolocation related setup
 */
class GeoSetup implements SystemBootable
{
    use StaticClass;


    /**
     * @inheritDoc
     */
    public static function systemBootRegister(BootRegistrar $registrar) : bool
    {
        return true;
    }


    /**
     * @inheritDoc
     */
    public static function systemBoot(BootContext $context) : void
    {
        NamedStringCodec::includeDirectory(__DIR__ . '/Configurations');
    }
}