<?php

use yii\db\Migration;

/**
 * Class m180901_095805_fill_distances_table
 */
class m180901_095805_fill_distance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//	    Yii::$app->db->createCommand('INSERT from_id, to_id distance SELECT * FROM place WHERE id=$id')->execute();
	    $places = require dirname(__FILE__) . '/data/areas.php';
	    foreach($places as $key=>&$place){
		    array_unshift($place, $key);
	    }
	    $this->batchInsert('place', ['address', 'lat', 'lng'], $places);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180901_095805_fill_distances_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180901_095805_fill_distances_table cannot be reverted.\n";

        return false;
    }
    */
}
