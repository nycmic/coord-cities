<?php

namespace app\services;

use Yii;

/**
 * Class MapService helps work with coordinates
 * @package app\services
 */
class DistanceService  {

const EARTH_RADIUS = 6372795;

	/**
	 * Calculate distance within two point
	 * @param $latA
	 * @param $lngA
	 * @param $latB
	 * @param $lngB
	 *
	 * @return float|int
	 */
	public static function calcDistance ($latA, $lngA, $latB, $lngB) {

		$lat1 = $latA * M_PI / 180;
		$lat2 = $latB * M_PI / 180;
		$long1 = $lngA * M_PI / 180;
		$long2 = $lngB * M_PI / 180;

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