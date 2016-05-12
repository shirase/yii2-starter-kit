<?php

use yii\db\Migration;

class m160512_194404_page_view extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%page_view}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'plugin' => $this->string(100),
        ], $tableOptions);
        $this->addForeignKey('fk_view', '{{%page}}', 'view_id', '{{%page_view}}', 'id');

        $this->createTable('{{%page_view_page}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer(),
            'canonical' => $this->smallInteger(1),
        ], $tableOptions);
        $this->addForeignKey('fk_page', '{{%page_view_page}}', 'id', '{{%page}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_page_page', '{{%page_view_page}}', 'page_id', '{{%page}}', 'id', 'RESTRICT', 'CASCADE');
        $this->insert('{{%page_view}}', ['name'=>'Ссылка на страницу', 'plugin'=>'common\plugins\page_view\page\Plugin']);

        $this->createTable('{{%page_view_link}}', [
            'id' => $this->primaryKey(),
            'link' => $this->string(255),
        ], $tableOptions);
        $this->addForeignKey('fk_page', '{{%page_view_link}}', 'id', '{{%page}}', 'id');
        $this->insert('{{%page_view}}', ['name'=>'Произвольная ссылка', 'plugin'=>'common\plugins\page_view\link\Plugin']);

        $this->createTable('{{%page_view_article}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer(),
            'canonical' => $this->smallInteger(1),
        ], $tableOptions);
        $this->addForeignKey('fk_page', '{{%page_view_article}}', 'id', '{{%page}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_article_category', '{{%page_view_article}}', 'category_id', '{{%article_category}}', 'id', 'RESTRICT', 'CASCADE');
        $this->insert('{{%page_view}}', ['name'=>'Статьи', 'plugin'=>'common\plugins\page_view\article\Plugin']);
    }

    public function down()
    {
        echo "m160512_194404_page_view cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
