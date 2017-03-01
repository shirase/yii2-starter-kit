<?php

use yii\db\Migration;

class m170301_084534_uri extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%uri}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'redirect_id' => $this->integer(),
            'canonical_id' => $this->integer(),
            'route' => $this->string(1000),
            'uri' => $this->string(1000),
        ], $tableOptions);

        $this->addForeignKey('fk_parent', '{{%uri}}', 'parent_id', '{{%uri}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_redirect', '{{%uri}}', 'redirect_id', '{{%uri}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%page_uri}}', [
            'page_id' => $this->integer()->notNull(),
            'uri_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('', '{{%page_uri}}', ['page_id', 'uri_id']);
        $this->addForeignKey('fk_page_uri_page', '{{%page_uri}}', 'page_id', '{{%page}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_page_uri_uri', '{{%page_uri}}', 'uri_id', '{{%uri}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%article_uri}}', [
            'article_id' => $this->integer()->notNull(),
            'uri_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('', '{{%article_uri}}', ['article_id', 'uri_id']);
        $this->addForeignKey('fk_article_uri_article', '{{%article_uri}}', 'article_id', '{{%article}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_article_uri_uri', '{{%article_uri}}', 'uri_id', '{{%uri}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%page_uri}}');
        $this->dropTable('{{%article_uri}}');
        $this->dropTable('{{%uri}}');
        return true;
    }
}
