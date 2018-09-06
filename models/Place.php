<?php

namespace app\models;

use app\behaviors\DistanceBehavior;
use app\interfaces\CalculateEventInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "place".
 *
 * @property int    $id
 * @property string $address
 * @property string $lat
 * @property string $lng
 * @property mixed  distances
 * @property int    is_calculated
 */
class Place extends ActiveRecord implements CalculateEventInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'place';
    }

    /**
     * @return array|string
     */
    public function behaviors()
    {
        return [
            DistanceBehavior::className(),
        ];
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
            'id'      => 'ID',
            'address' => 'Address',
            'lat'     => 'Lat',
            'lng'     => 'Lng',
        ];
    }
}
