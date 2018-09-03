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
	 * @param array $from
	 * @param array $to
	 *
	 * @return int
	 */
	public static function calcDistanceByPlaces(array $from, array $to)
	{
		return self::calcDistanceByCoordinates($from['lat'], $from['lng'], $to['lat'], $to['lng']);
	}

	/**
	 * Calculate the proximity within origin, walk in two direction within origin
	 * @param array $data
	 * @param $origin
	 *
	 * @return array
	 */
	public static function calcProximity(array $data, $origin)
	{
		$distances = [];
		foreach($data as $key => $value){
			$distances[$key]['id'] = $value['id'];
			$distances[$key]['distance'] = self::calcDistance($origin->lat, $origin->lng, $value['lat'], $value['lng']);
		}

		usort($distances, function ($a, $b){
			if ($a['distance'] == $b['distance']) {
				return 0;
			}
			return ($a['distance'] < $b['distance']) ? -1 : 1;
		});

		$ids = [];
		foreach($distances as $key=>$value){
				$ids[$key] = $value['id'];
		}
		array_shift($ids);

		return $ids;
	}

}