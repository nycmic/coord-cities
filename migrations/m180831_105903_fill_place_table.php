<?php

use yii\db\Migration;

/**
 * Class m180831_105903_fill_place_table
 */
class m180831_105903_fill_place_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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
        echo "m180831_105903_fill_place_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180831_105903_fill_place_table cannot be reverted.\n";

        return false;
    }
    */
}
