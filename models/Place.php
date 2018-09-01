<?php

namespace app\models;

use Yii;
use app\services\DistanceService;

/**
 * This is the model class for table "place".
 *
 * @property int $id
 * @property string $address
 * @property string $lat
 * @property string $lng
 */
class Place extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'place';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'lat', 'lng'], 'required'],
            [['address', 'lat', 'lng'], 'string', 'max' => 255],
            [['address'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'lat' => 'Lat',
            'lng' => 'Lng',
        ];
    }

	/**
	 * Calculate the proximity and distance within origin place
	 * @return float|int
	 */
    public function prepareDistanceInKm()
    {
	    $fromPlace = self::findOne(['address'=>Yii::$app->request->get('SearchPlace')['id']]);
	    return DistanceService::calcDistance($fromPlace->lat, $fromPlace->lng, $this->lat, $this->lng) / 1000;
    }
}
