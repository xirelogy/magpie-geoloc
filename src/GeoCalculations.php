<?php

namespace MagpieLib\GeoLoc;

use Magpie\Exceptions\SafetyCommonException;
use Magpie\General\Traits\StaticClass;
use MagpieLib\GeoLoc\Exceptions\DifferentCoordinateSystemsException;
use MagpieLib\GeoLoc\Objects\LatLon6;

/**
 * Geolocation related calculations
 */
class GeoCalculations
{
    use StaticClass;

    /**
     * Earth radius, in metres
     */
    private const EARTH_RADIUS_M = 6378137;


    /**
     * Get the middle point between two geolocations (naively)
     * @param LatLon6 $lhs
     * @param LatLon6 $rhs
     * @return LatLon6
     * @throws SafetyCommonException
     */
    public static function naiveMiddle(LatLon6 $lhs, LatLon6 $rhs) : LatLon6
    {
        if ($lhs->system !== $rhs->system) throw new DifferentCoordinateSystemsException();

        return new LatLon6(
            round(($lhs->lat6 + $rhs->lat6) / 2),
            round(($lhs->lon6 + $rhs->lon6) / 2),
            $lhs->system,
        );
    }


    /**
     * Calculate the distance between two geolocations
     * @param LatLon6 $lhs
     * @param LatLon6 $rhs
     * @return float Distance (in metres)
     * @throws SafetyCommonException
     */
    public static function distanceBetween(LatLon6 $lhs, LatLon6 $rhs) : float
    {
        if ($lhs->system !== $rhs->system) throw new DifferentCoordinateSystemsException();

        // Convert to radians
        $lat1 = $lhs->lat6 * pi() / LatLon6::SCALE_FACTOR / 180;
        $lon1 = $lhs->lon6 * pi() / LatLon6::SCALE_FACTOR / 180;
        $lat2 = $rhs->lat6 * pi() / LatLon6::SCALE_FACTOR / 180;
        $lon2 = $rhs->lon6 * pi() / LatLon6::SCALE_FACTOR / 180;

        // Calculate the difference
        $latDiff = $lat1 - $lat2;
        $lonDiff = $lon1 - $lon2;

        // And then the distance
        $dist = 2 * asin(sqrt(
            pow(sin($latDiff / 2), 2) +
            cos($lat1) * cos($lat2) * pow(sin($lonDiff / 2), 2)
        )) * static::EARTH_RADIUS_M;

        return round($dist, 3);
    }


    /**
     * Calculate the assumed boundaries by putting a radius from given center point
     * @param LatLon6 $geo The center point
     * @param float $distM Radius distance (in metres)
     * @return array<LatLon6>
     */
    public static function getBound(LatLon6 $geo, float $distM) : array
    {
        // Convert to radians
        $lat = $geo->lat6 * pi() / LatLon6::SCALE_FACTOR / 180;

        // Reverse project the difference in latitude/longitude
        $rawDist = $distM / static::EARTH_RADIUS_M / 2;
        $latDiff = 2 * asin(sqrt(pow(sin($rawDist), 2)));
        $lonDiff = 2 * asin(sqrt(pow(sin($rawDist), 2) / cos($lat) / cos($lat)));

        // Convert to lat6/lon6
        $latDiff6 = ceil($latDiff * 180 * LatLon6::SCALE_FACTOR / pi());
        $lonDiff6 = ceil($lonDiff * 180 * LatLon6::SCALE_FACTOR / pi());

        return [
            new LatLon6($geo->lat6 - $latDiff6, $geo->lon6 - $lonDiff6, $geo->system),
            new LatLon6($geo->lat6 + $latDiff6, $geo->lon6 + $lonDiff6, $geo->system),
        ];
    }
}