<?php

use yii\db\Migration;

class m170525_135141_gallery extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%gallery}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string()->notNull(),
            'status' => $this->smallInteger()->defaultValue(1)
        ], $tableOptions);

        $this->createTable('{{%gallery_item}}', [
            'id' => $this->primaryKey(),
            'gallery_id' => $this->integer()->notNull(),
            'path'=>$this->string(1024),
            'url' => $this->string(1024),
            'title' => $this->string(1024),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'pos' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('fk_gallery', '{{%gallery_item}}', 'gallery_id', '{{%gallery}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('fk_gallery', '{{%gallery_item}}');
        $this->dropTable('{{%gallery_item}}');
        $this->dropTable('{{%gallery}}');
    }
}
