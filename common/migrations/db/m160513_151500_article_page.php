<?php

use yii\db\Migration;

class m160513_151500_article_page extends Migration
{
    public function up()
    {
        $this->createTable('{{%article_page}}', [
            'article' => $this->integer()->notNull(),
            'page' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('', '{{%article_page}}', ['article', 'page']);
        $this->addForeignKey('fk_article', '{{%article_page}}', 'article', '{{%article}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_page', '{{%article_page}}', 'page', '{{%page}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%article_page}}');
    }
}
