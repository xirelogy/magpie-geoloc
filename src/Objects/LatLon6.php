<?php

namespace MagpieLib\GeoLoc\Objects;

use Magpie\Codecs\Concepts\PrettyFormattable;
use Magpie\General\Packs\PackContext;
use Magpie\General\Sugars\Quote;
use Magpie\Objects\CommonObject;
use Stringable;

/**
 * Location specified with specific latitude/longitude with 6 decimal place precision (factor)
 */
class LatLon6 extends CommonObject implements Stringable, PrettyFormattable
{
    /**
     * The effective scale factor
     */
    public const SCALE_FACTOR = 1000000;

    /**
     * @var int Latitude, with 6 decimal place precision (factor)
     */
    public int $lat6;
    /**
     * @var int Logitude, with 6 decimal place precision (factor)
     */
    public int $lon6;
    /**
     * @var string|null Associated coordinate system
     */
    public ?string $system;


    /**
     * Constructor
     * @param int $lat6
     * @param int $lon6
     * @param string|null $system
     */
    public function __construct(int $lat6, int $lon6, ?string $system = null)
    {
        $this->lat6 = $lat6;
        $this->lon6 = $lon6;
        $this->system = $system;
    }


    /**
     * @inheritDoc
     */
    protected function onPack(object $ret, PackContext $context) : void
    {
        parent::onPack($ret, $context);

        $ret->lat6 = $this->lat6;
        $ret->lon6 = $this->lon6;
        $ret->system = $this->system;
    }


    /**
     * @inheritDoc
     */
    public function prettyFormat() : string
    {
        $ret = Quote::square(implode(', ', [
            number_format($this->lat6 / static::SCALE_FACTOR, 6),
            number_format($this->lon6 / static::SCALE_FACTOR, 6),
        ]));
        if ($this->system !== null) $ret .= Quote::square($this->system);

        return $ret;
    }


    /**
     * @inheritDoc
     */
    public function __toString() : string
    {
        $formattedLat = number_format($this->lat6 / static::SCALE_FACTOR, 6);
        $formattedLon = number_format($this->lon6 / static::SCALE_FACTOR, 6);

        return "[$formattedLat, $formattedLon]";
    }


    /**
     * Create instance from float values
     * @param float $lat
     * @param float $lon
     * @param string|null $system
     * @return static
     */
    public static function fromFloats(float $lat, float $lon, ?string $system = null) : static
    {
        $lat6 = intval(floor($lat * static::SCALE_FACTOR));
        $lon6 = intval(floor($lon * static::SCALE_FACTOR));

        return new static($lat6, $lon6, $system);
    }
}