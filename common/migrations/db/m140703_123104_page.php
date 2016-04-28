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
            'name' => $this->string(100)->notNull(),
            'title' => $this->string(255),
            'body' => $this->text(),
            'view_id' => $this->integer(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'pid' => $this->integer(),
            'pos' => $this->integer(),
            'bpath' => 'BLOB',
        ], $tableOptions);

        $this->createIndex('slug', '{{%page}}', array('slug'), true);
        $this->createIndex('pos', '{{%page}}', array('pos'), true);
        $this->createIndex('pid_pos', '{{%page}}', array('pid', 'pos'), true);
        $this->createIndex('bpath', '{{%page}}', array('bpath(100)'), true);

        $this->createTable('{{%page_view}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'plugin' => $this->string(100),
        ], $tableOptions);
        $this->addForeignKey('fk_view', '{{%page}}', 'view_id', '{{%page_view}}', 'id');

        $this->createTable('{{%page_view_link}}', [
            'id' => $this->primaryKey(),
            'link' => $this->string(255),
        ], $tableOptions);
        $this->addForeignKey('fk_page', '{{%page_view_link}}', 'id', '{{%page}}', 'id');
        $this->insert('{{%page_view}}', ['name'=>'Ссылка', 'plugin'=>'common\plugins\page_view\link\Plugin']);
    }

    public function down()
    {
        $this->dropTable('{{%page}}');
    }
}
