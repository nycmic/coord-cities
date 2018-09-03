<?php

namespace app\models;

use Codeception\Lib\Di;
use Yii;
use app\services\DistanceService;

/**
 * This is the model class for table "place".
 *
 * @property int $id
 * @property string $address
 * @property string $lat
 * @property string $lng
 * @property mixed distances
 * @property int is_calculated
 */
class Place extends \yii\db\ActiveRecord
{
	public $distance;
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
	 * Get related model Distance
	 *
	 * @return \yii\db\ActiveQuery
	 */
    public function getDistances()
    {
    	return $this->hasOne(Distance::className(),['from_id' => 'id']);
    }

    public function getDistance()
    {
    	return $this->distances->distance;
    }

	/**
	 * @throws \yii\db\Exception
	 */
    public function createMultipleDistances()
    {
    	if(!$this->is_calculated){
    		$rows = [];
    		$fromPlace = $this->getAttributes();
    		foreach (self::find()->asArray()->all() as $key => $toPlace){
    			if($fromPlace['id'] == $toPlace['id']) continue;
    			$rows[$key]['from_id'] = $fromPlace['id'];
    			$rows[$key]['to_id'] = $toPlace['id'];
			    $rows[$key]['distance'] = (int)DistanceService::calcDistanceByPlaces($fromPlace, $toPlace)/1000;
		    }

		    if(Yii::$app->db->createCommand()->batchInsert(Distance::tableName(), ['from_id', 'to_id', 'distance'], $rows)->execute()) {
			    $this->is_calculated = 1;
			    return $this->save();
		    }
	    }
    }


	/**
	 * @throws \yii\db\Exception
	 */
	public function createSingleDistance()
	{
		$total = Distance::find()->select('from_id')->distinct()->all();

		$rows[] =[];

		foreach ($total as $key => $value){
			$rows[$key]['from_id'] = $value->placeFrom->id;
			$rows[$key]['to_id'] = $this->id;
			$rows[$key]['distance'] = DistanceService::calcDistanceByPlaces($value->placeFrom, $this);
		}

		Yii::$app->db->createCommand()->batchInsert(Distance::tableName(), ['from_id', 'to_id', 'distance'], $rows)->execute();
	}

}
