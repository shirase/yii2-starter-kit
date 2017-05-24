<?php

use yii\db\Migration;

class m170524_201025_context_block extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%context_block}}', [
            'key' => $this->string(50),
            'body' => $this->text(),
        ], $tableOptions);

        $this->addPrimaryKey('key', '{{%context_block}}', 'key');
    }

    public function down()
    {
        $this->dropTable('{{%context_block}}');
    }
}
