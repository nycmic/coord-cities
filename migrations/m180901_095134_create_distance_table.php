<?php

use yii\db\Migration;

/**
 * Handles the creation of table `distances`.
 */
class m180901_095134_create_distance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('distance', [
            'id' => $this->primaryKey(),
            'from_id' => $this->integer()->notNull(),
            'to_id' => $this->integer()->notNull(),
            'distance' => $this->float(2),
        ]);

	    $this->addForeignKey(
		    'fk-distance-from_id-place-id',
		    'distance',
		    'from_id',
		    'place',
		    'id',
		    'CASCADE'
	    );

	    $this->addForeignKey(
		    'fk-distance-to_id-place-id',
		    'distance',
		    'to_id',
		    'place',
		    'id',
		    'CASCADE'
	    );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('distance');
    }
}
