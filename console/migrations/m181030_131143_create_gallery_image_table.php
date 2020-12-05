<?php

use yii\db\Migration;

/**
 * Handles the creation of table `gallery_image`.
 * Has foreign keys to the tables:
 *
 */
class m181030_131143_create_gallery_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('gallery_image', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
            'ownerId' => $this->integer()->notNull(),
            'rank' => $this->integer()->notNull()->defaultValue(0),
            'name' => $this->string(),
            'description' => $this->text(),
            'rating' => $this->integer(),
            'voteCount' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('gallery_image');
    }
}
