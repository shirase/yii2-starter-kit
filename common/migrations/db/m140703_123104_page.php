<?php

use yii\db\Schema;
use yii\db\Migration;

class m140703_123104_page extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(1024)->notNull(),
            'language' => $this->string(5)->notNull(),
            'name' => $this->string(255)->notNull(),
            'title' => $this->string(255),
            'body' => $this->text(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()->null(),
            'pid' => $this->integer(),
            'pos' => $this->integer(),
            'bpath' => 'BLOB',
        ], $tableOptions);

        $this->createIndex('slug', '{{%page}}', array('slug(100)'), true);
        $this->createIndex('pos', '{{%page}}', array('pos'), true);
        $this->createIndex('pid_pos', '{{%page}}', array('pid', 'pos'), true);
        $this->createIndex('bpath', '{{%page}}', array('bpath(100)'), true);
    }

    public function down()
    {
        $this->dropTable('{{%page}}');
    }
}
