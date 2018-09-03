<?php

use yii\db\Migration;

/**
 * Handles the creation of table `places`.
 */
class m180831_101918_create_place_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    	$tableOptions = null;
	    if ($this->db->driverName === 'mysql') {
		    // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
		    $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
	    }

        $this->createTable('place', [
            'id' => $this->primaryKey(),
            'address' => $this->string()->notNull()->unique(),
            'lat' => $this->string()->notNull(),
            'lng' => $this->string()->notNull(),
	        'is_calculated' => $this->integer(1)->defaultValue(0),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('places');
    }
}
