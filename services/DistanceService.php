<?php

namespace app\services;

use app\models\Place;

/**
 * Class MapService helps work with coordinates
 * @package app\services
 */
class DistanceService {

const EARTH_RADIUS = 6372795;

	/**
	 * Calculate distance within two points
	 * @param float $fromLat
	 * @param float $fromLng
	 * @param float $toLat
	 * @param float $toLng
	 *
	 * @return int
	 */
	private static function calcDistanceByCoordinates($fromLat, $fromLng, $toLat, $toLng) {

		$lat1 = $fromLat * M_PI / 180;
		$lat2 = $toLat * M_PI / 180;
		$long1 = $fromLng * M_PI / 180;
		$long2 = $toLng * M_PI / 180;

		$cl1 = cos($lat1);
		$cl2 = cos($lat2);
		$sl1 = sin($lat1);
		$sl2 = sin($lat2);
		$delta = $long2 - $long1;
		$cdelta = cos($delta);
		$sdelta = sin($delta);

		$y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
		$x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

		$ad = atan2($y, $x);
		$dist = $ad * self::EARTH_RADIUS;

		return (int)$dist;
	}

	/**
	 * @param array|Place $from
	 * @param array|Place $to
	 *
	 * @return int
	 */
	public static function calcDistanceByPlaces($from, $to)
	{
		return self::calcDistanceByCoordinates($from['lat'], $from['lng'], $to['lat'], $to['lng']);
	}

}