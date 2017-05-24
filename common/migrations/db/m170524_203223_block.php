<?php

use yii\db\Schema;
use yii\db\Migration;

class m170524_203223_block extends Migration
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
            '{{%block}}',
            [
                'id'=> $this->primaryKey(11),
                'pos'=> $this->integer(11)->null()->defaultValue(null),
                'vis'=> $this->smallInteger(1)->notNull()->defaultValue(1),
                'page_id'=> $this->integer(11)->notNull(),
                'type_id'=> $this->integer(11)->notNull(),
                'title'=> $this->string(255)->notNull(),
                'body'=> $this->text()->null()->defaultValue(null),
            ],$tableOptions
        );
        $this->createIndex('page_id','{{%block}}',['page_id'],false);
        $this->createIndex('type_id','{{%block}}',['type_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('page_id', '{{%block}}');
        $this->dropIndex('type_id', '{{%block}}');
        $this->dropTable('{{%block}}');
    }
}
