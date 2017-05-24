<?php

use yii\db\Schema;
use yii\db\Migration;

class m170524_203225_Relations extends Migration
{

    public function init()
    {
       $this->db = 'db';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_block_page_id',
            '{{%block}}','page_id',
            '{{%page}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_block_type_id',
            '{{%block}}','type_id',
            '{{%block_type}}','id',
            'RESTRICT','RESTRICT'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_block_page_id', '{{%block}}');
        $this->dropForeignKey('fk_block_type_id', '{{%block}}');
    }
}
