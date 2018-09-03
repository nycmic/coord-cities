<?php

namespace app\models;

use app\services\DistanceService;
use Yii;

/**
 * This is the model class for table "distance".
 *
 * @property int $id
 * @property int $from_id
 * @property int $to_id
 * @property string $distance
 */
class Distance extends \yii\db\ActiveRecord
{
	public $address;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'distance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_id', 'to_id'], 'required'],
            [['from_id', 'to_id'], 'integer'],
            [['distance'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_id' => 'From ID',
            'to_id' => 'To ID',
            'distance' => 'Distance',
        ];
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPlaceFrom()
	{
		return $this->hasOne(Place::className(),['id' => 'from_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPlaceTo()
	{
		return $this->hasOne(Place::className(),['id' => 'to_id']);
	}

}
