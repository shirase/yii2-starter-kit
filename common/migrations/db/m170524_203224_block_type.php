<?php

use yii\db\Schema;
use yii\db\Migration;

class m170524_203224_block_type extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%block_type}}',
            [
                'id'=> $this->primaryKey(11),
                'pos'=> $this->integer(11)->null()->defaultValue(null),
                'name'=> $this->string(100)->notNull(),
                'widget'=> $this->string(100)->notNull(),
                'widget_param'=> $this->text()->null()->defaultValue(null),
                'plugin'=> $this->string(100)->null()->defaultValue(null),
            ],$tableOptions
        );

        $this->batchInsert('{{%block_type}}',
            ["id", "pos", "name", "widget", "widget_param", "plugin"],
            [
                [
                    'id' => '1',
                    'pos' => '1',
                    'name' => 'Текстовый блок',
                    'widget' => 'frontend\\widgets\\ContentBlock',
                    'widget_param' => null,
                    'plugin' => null,
                ],
            ]
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%block_type}}');
    }
}
