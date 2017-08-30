<?php

use yii\db\Migration;

class m170830_141911_seo extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%seo}}', [
            'key' => $this->string(100),
            'page_title' => $this->string(255),
            'page_description' => $this->text(),
            'page_keywords' => $this->text(),
            'title' => $this->string(255),
        ], $tableOptions);

        $this->addPrimaryKey('key', '{{%seo}}', 'key');
    }

    public function safeDown()
    {
        $this->dropTable('{{%seo}}');
    }
}
