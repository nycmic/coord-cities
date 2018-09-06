<?php

/**
 * Created by PhpStorm.
 * User: itinium
 * Date: 05.09.18
 * Time: 19:10
 */

namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use app\models\Distance;

/**
 * Class DistanceBehavior
 * @package app\behaviors
 */
class DistanceBehavior extends Behavior
{
	const EARTH_RADIUS_KM = 6372;

	private $arrayDestinations = [];
    private $batchRows = [];
	private $initiatorPlace;

    const EVENT_CALCULATE_FROM = 'eventCalculateFrom';
	const EVENT_CALCULATE_TO = 'eventCalculateTo';

	/**
	 * @inheritdoc
	 */
	public function events()
	{
		return [
			self::EVENT_CALCULATE_FROM => 'calculateFrom',
			self::EVENT_CALCULATE_TO   => 'calculateTo'
			];
	}

    /**
     * @param $toPlace
     *
     * @return int
     */
    public function calcDistance($toPlace)
    {
        return self::calcDistanceByCoordinates($this->initiatorPlace['lat'], $this->initiatorPlace['lng'], $toPlace['lat'],
            $toPlace['lng']);
    }

    /**
     * @return int
     * @throws \yii\db\Exception
     */
    public function batchInsert()
    {
        return Yii::$app->db->createCommand()->batchInsert(Distance::tableName(), ['from_id', 'to_id', 'distance'],
            $this->batchRows)->execute();
    }

    /**
     * @throws \yii\db\Exception
     */
    public function calculateTo()
    {
        $this->initiatorPlace = $this->owner->getAttributes();
        $this->arrayDestinations = $this->owner::find()->where(['is_calculated' => 1])->asArray()->all();
        foreach ($this->arrayDestinations as $key => $fromPlace){
            $this->batchRows[$key]['from_id'] = $fromPlace['id'];
            $this->batchRows[$key]['to_id'] = $this->initiatorPlace['id'];
            $this->batchRows[$key]['distance'] = self::calcDistance($fromPlace);
        }

        $this->batchInsert();
    }

    /**
     * @throws \yii\db\Exception
     */
    public function calculateFrom()
    {
        $this->initiatorPlace = $this->owner->getAttributes();
        $this->arrayDestinations = $this->owner::find()->asArray()->all();
        if ( ! $this->owner->is_calculated) {
            foreach ($this->arrayDestinations as $key => $toPlace) {
                if ($this->initiatorPlace['id'] == $toPlace['id']) {
                    continue;
                }
                $this->batchRows[$key]['from_id']  = $this->initiatorPlace['id'];
                $this->batchRows[$key]['to_id']    = $toPlace['id'];
                $this->batchRows[$key]['distance'] = self::calcDistance($toPlace);
            }

            if ($this->batchInsert()) {
                $this->owner->is_calculated = 1;

                $this->owner->save();
            }
        }
    }

   	/**
	 * Calculate distance within two points
	 * @param float $fromLat
	 * @param float $fromLng
	 * @param float $toLat
	 * @param float $toLng
	 *
	 * @return int
	 */
	private static function calcDistanceByCoordinates($fromLat, $fromLng, $toLat, $toLng)
	{

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
		$dist = $ad * self::EARTH_RADIUS_KM;

		return $dist;
	}

}